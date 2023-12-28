<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
/**
 * Database Configuration File
 *
 * This file contains the settings for database connection and provides
 * a function to establish a connection with the database using PDO.
 */


define('DB_SERVER', getenv('DB_SERVER') ?: '127.0.0.1');
define('DB_USERNAME', getenv('DB_USERNAME') ?: 'postgres');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '00321000');
define('DB_DATABASE', getenv('DB_DATABASE') ?: 'postgres');

/**
 * Establishes a connection to the database and returns a PDO object.
 * Exits on failure with an error message.
 *
 * @return PDO The database connection object
 */

function getDbConnection() {
    $dsn = "pgsql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE;
    try {
        $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        // Em produção, considere logar este erro em vez de mostrá-lo diretamente
        error_log("Erro de Ligação: " . $e->getMessage());
        // Mensagem genérica para o usuário
        die("Não foi possível conectar ao banco de dados.");
    }
    return $pdo;
}
?>