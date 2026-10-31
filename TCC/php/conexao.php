<?php
/**
 * Conexão com o banco de dados (MySQL).
 *
 * As credenciais podem ser definidas por variáveis de ambiente, o que facilita
 * rodar o projeto em outro computador/servidor sem editar este arquivo:
 *
 *   TCC_DB_HOST  (padrão: localhost)
 *   TCC_DB_PORT  (padrão: 3306)
 *   TCC_DB_USER  (padrão: root)
 *   TCC_DB_PASS  (padrão: vazio)
 *   TCC_DB_NAME  (padrão: tcc)
 *
 * Nos arquivos da API a conexão é feita manualmente (para devolver JSON em caso
 * de erro). Nas páginas PHP antigas, a variável $conn é criada automaticamente.
 */

function conectar(): mysqli
{
    $host = getenv('TCC_DB_HOST');
    $porta = getenv('TCC_DB_PORT');
    $usuario = getenv('TCC_DB_USER');
    $senha = getenv('TCC_DB_PASS');
    $banco = getenv('TCC_DB_NAME');

    $host = $host !== false && $host !== '' ? $host : 'localhost';
    $porta = $porta !== false && $porta !== '' ? (int) $porta : 3306;
    $usuario = $usuario !== false && $usuario !== '' ? $usuario : 'root';
    $senha = $senha !== false ? $senha : '';
    $banco = $banco !== false && $banco !== '' ? $banco : 'tcc';

    // A partir do PHP 8.1, o mysqli lança exceções por padrão. Deixamos isso
    // explícito para o mesmo comportamento funcionar em versões anteriores.
    if (function_exists('mysqli_report')) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }

    $conn = new mysqli($host, $usuario, $senha, $banco, $porta);
    $conn->set_charset('utf8mb4');

    return $conn;
}

// A API define esta constante para tratar o erro e responder em JSON.
if (!defined('TCC_SEM_CONEXAO_AUTOMATICA')) {
    try {
        $conn = conectar();
    } catch (Throwable $e) {
        http_response_code(500);
        die('Erro ao conectar ao banco de dados. Verifique se o MySQL está ligado e se as credenciais estão corretas.');
    }
}
