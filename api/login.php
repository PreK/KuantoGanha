<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../modules/dbconfig.php'; // Inclui o ficheiro de configuração da base de dados
header('Content-Type: application/json');

$pdo = getDbConnection();
$response = [
    "success" => false,
    "message" => ""
];

// Decode JSON from the request body
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); // convert JSON into array

$username = isset($input['username']) ? htmlspecialchars($input['username'], ENT_QUOTES, 'UTF-8') : '';
$password = isset($input['password']) ? htmlspecialchars($input['password'], ENT_QUOTES, 'UTF-8') : '';


// Validate username
if (empty($username)) {
    $response["message"] = 'Por favor, inserir utilizador.';
    echo json_encode($response);
    exit();
}

// Prepare SQL statement
$sql = "SELECT * FROM users WHERE username = :USERNAME LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":USERNAME", $username, PDO::PARAM_STR);
$stmt->execute();

// Check if user exists and password is correct
if ($stmt->rowCount() != 1) {
    $response["message"] = 'Utilizador não encontrado.';
} else {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!password_verify($password, $row['password'])) {
        $response["message"] = "Senha incorreta.";
    } else {
        $response["success"] = true;
        $response["message"] = "Login bem-sucedido";
        // You can add any additional data you want to return here, like user ID
    }
}

echo json_encode($response);