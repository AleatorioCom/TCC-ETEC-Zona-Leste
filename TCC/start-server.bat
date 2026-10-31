@echo off
setlocal

rem ------------------------------------------------------------------
rem Sementes Digitais - servidor local (PHP embutido + MySQL)
rem ------------------------------------------------------------------
rem Copie server.env.example.bat para server.env.bat se quiser trocar
rem usuario/senha/banco. Este arquivo e carregado antes de iniciar.
rem ------------------------------------------------------------------

if not defined TCC_DB_HOST set "TCC_DB_HOST=localhost"
if not defined TCC_DB_PORT set "TCC_DB_PORT=3306"
if not defined TCC_DB_USER set "TCC_DB_USER=root"
if not defined TCC_DB_NAME set "TCC_DB_NAME=TCC"

if exist "%~dp0server.env.bat" call "%~dp0server.env.bat"

cd /d "%~dp0"

set "PHP_EXE=php"
where php >nul 2>nul
if errorlevel 1 (
    if exist "C:\xampp\php\php.exe" (
        set "PHP_EXE=C:\xampp\php\php.exe"
    ) else (
        echo.
        echo PHP nao encontrado no PATH e o XAMPP nao foi localizado em C:\xampp.
        echo Instale o PHP ou use o Apache do XAMPP.
        pause
        exit /b 1
    )
)

echo.
echo ============================================================
echo  Sementes Digitais - servidor local
echo ============================================================
echo  Banco:  %TCC_DB_NAME% em %TCC_DB_HOST%:%TCC_DB_PORT%
echo  Web:    http://localhost:8080/app/
echo  API:    http://localhost:8080/api
echo.
echo  No celular use o IPv4 do computador (veja com ipconfig):
echo    http://SEU-IP:8080/app/
echo    API: http://SEU-IP:8080/api
echo.
echo  Mantenha esta janela aberta. Ctrl+C encerra o servidor.
echo ============================================================
echo.

"%PHP_EXE%" -d upload_max_filesize=8M -d post_max_size=12M -d max_file_uploads=10 -d display_errors=0 -d log_errors=1 -S 0.0.0.0:8080

if errorlevel 1 (
    echo.
    echo Nao foi possivel iniciar o PHP. Confira se ele esta no PATH.
    pause
)

endlocal
