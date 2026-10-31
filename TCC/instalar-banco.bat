@echo off
setlocal EnableExtensions

cd /d "%~dp0"

set "DB_HOST=127.0.0.1"
set "DB_PORT=3306"
if not "%~1"=="" set "DB_PORT=%~1"
set "DB_USER=root"
set "DB_NAME=TCC"

echo ============================================================
echo  Sementes Digitais - instalador do banco de dados
echo ============================================================
echo.
echo Este programa cria o banco e coloca as plantas de exemplo.
echo O MySQL precisa estar LIGADO.
echo.

rem Procura o mysql.exe no PATH, no MySQL instalado ou no XAMPP.
set "MYSQL="
for /f "delims=" %%A in ('where mysql 2^>nul') do if not defined MYSQL set "MYSQL=%%A"
if not defined MYSQL (
    for /d %%D in ("C:\Program Files\MySQL\MySQL Server *") do (
        if exist "%%~fD\bin\mysql.exe" set "MYSQL=%%~fD\bin\mysql.exe"
    )
)
if not defined MYSQL if exist "C:\xampp\mysql\bin\mysql.exe" set "MYSQL=C:\xampp\mysql\bin\mysql.exe"
if not defined MYSQL if exist "C:\laragon\bin\mysql" (
    for /d %%D in ("C:\laragon\bin\mysql\mysql-*") do (
        if exist "%%~fD\bin\mysql.exe" set "MYSQL=%%~fD\bin\mysql.exe"
    )
)

if not defined MYSQL (
    echo [ERRO] Nao encontrei o MySQL neste computador.
    echo.
    echo Instale o MySQL ou o XAMPP e rode este arquivo de novo.
    echo.
    pause
    exit /b 1
)

echo MySQL encontrado:
echo   %MYSQL%
echo.

set /p "DB_PASS=Digite a senha do MySQL (se nao tiver, aperte Enter): "
echo.

rem O cliente do MySQL le a senha desta variavel. Isso evita problemas
rem com caracteres especiais na senha.
set "MYSQL_PWD=%DB_PASS%"

echo Testando a conexao...
"%MYSQL%" -h %DB_HOST% -P %DB_PORT% -u %DB_USER% --default-character-set=utf8mb4 -e "SELECT 1;" >nul 2>nul
if errorlevel 1 (
    set "MYSQL_PWD="
    echo.
    echo [ERRO] Nao consegui entrar no MySQL.
    echo Confira:
    echo   1. O MySQL esta ligado?
    echo   2. A senha esta correta?
    echo   3. O MySQL esta na porta %DB_PORT%?
    echo.
    echo Dica: se usa XAMPP, abra o painel e clique em Start no MySQL.
    echo.
    pause
    exit /b 1
)
echo Conexao OK.
echo.

set "CHECK=%TEMP%\tcc-check-%RANDOM%.txt"
"%MYSQL%" -h %DB_HOST% -P %DB_PORT% -u %DB_USER% -N -B -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='%DB_NAME%' AND table_name='flora';" > "%CHECK%" 2>nul
set "TEM_TABELA="
set /p "TEM_TABELA="<"%CHECK%"
del "%CHECK%" >nul 2>nul
if not defined TEM_TABELA goto ERRO_SQL

set "BASE=%~dp0"
set "BASE=%BASE:\=/%"

if "%TEM_TABELA%"=="0" (
    echo Criando o banco %DB_NAME%...
    "%MYSQL%" -h %DB_HOST% -P %DB_PORT% -u %DB_USER% --default-character-set=utf8mb4 -e "CREATE DATABASE IF NOT EXISTS %DB_NAME% CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    "%MYSQL%" -h %DB_HOST% -P %DB_PORT% -u %DB_USER% --default-character-set=utf8mb4 -e "source %BASE%bd/Sementes Digitais.sql"
    if errorlevel 1 goto ERRO_SQL
    echo Banco criado.
) else (
    echo O banco ja existe. Atualizando as tabelas novas...
    "%MYSQL%" -h %DB_HOST% -P %DB_PORT% -u %DB_USER% --default-character-set=utf8mb4 -e "source %BASE%bd/migration_app.sql"
    if errorlevel 1 goto ERRO_SQL
)

"%MYSQL%" -h %DB_HOST% -P %DB_PORT% -u %DB_USER% -N -B -e "SELECT COUNT(*) FROM %DB_NAME%.flora;" > "%CHECK%" 2>nul
set "TEM_PLANTAS="
set /p "TEM_PLANTAS="<"%CHECK%"
del "%CHECK%" >nul 2>nul

if "%TEM_PLANTAS%"=="0" (
    echo Colocando as plantas de exemplo...
    "%MYSQL%" -h %DB_HOST% -P %DB_PORT% -u %DB_USER% --default-character-set=utf8mb4 -e "source %BASE%bd/seed_demo.sql"
    if errorlevel 1 goto ERRO_SQL
)

set "MYSQL_PWD="

(
    echo @echo off
    echo set "TCC_DB_HOST=%DB_HOST%"
    echo set "TCC_DB_PORT=%DB_PORT%"
    echo set "TCC_DB_USER=%DB_USER%"
    echo set "TCC_DB_PASS=%DB_PASS%"
    echo set "TCC_DB_NAME=%DB_NAME%"
) > server.env.bat

echo.
echo ============================================================
echo  BANCO PRONTO!
echo ============================================================
echo.
echo Agora abra o arquivo start-server.bat.
echo.
pause
exit /b 0

:ERRO_SQL
set "MYSQL_PWD="
echo.
echo [ERRO] Deu erro ao importar o banco.
echo Veja a mensagem acima.
echo.
pause
exit /b 1
