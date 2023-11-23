<?php

header('Content-Type: application/json');
require_once '../dbconfig.php';

$pdo = getDbConnection();
$response = [
    "success" => false,
    "message" => ""
];

$username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

// Validate username
if (empty($username)) {
    $response["message"] = 'Por favor, insira o seu nome de utilizador.';
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
    $response["message"] = 'Nome de utilizador não encontrado.';
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