<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/dbconfig.php';
header('Content-Type: application/json');

$pdo = getDbConnection();
$response = [
    "success" => false,
    "message" => ""
];

// descodificar o JSON para um array
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

$username = isset($input['username']) ? htmlspecialchars($input['username'], ENT_QUOTES, 'UTF-8') : '';
$password = isset($input['password']) ? htmlspecialchars($input['password'], ENT_QUOTES, 'UTF-8') : '';


// validar o utilizador
if (empty($username)) {
    $response["message"] = 'Por favor, inserir utilizador.';
    echo json_encode($response);
    exit();
}

// preparar o sql
$sql = "SELECT * FROM users WHERE username = :USERNAME LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":USERNAME", $username, PDO::PARAM_STR);
$stmt->execute();

    // Testar se o utilizador existe e verificar se a password é correcta
if ($stmt->rowCount() != 1) {
    $response["message"] = 'Utilizador não encontrado.';
} else {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!password_verify($password, $row['password'])) {
        $response["message"] = "Senha incorreta.";
    } else {
        $response["success"] = true;
        $response["message"] = "Login bem-sucedido";
    }
}

echo json_encode($response);