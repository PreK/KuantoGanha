<?php
require_once '../modules/dbconfig.php'; // Inclui o ficheiro de configuração da base de dados

header('Content-Type: application/json'); // Define o cabeçalho da resposta como JSON

ini_set('display_errors', 0); // Não exibir erros na saída
error_reporting(E_ALL);       // Reportar todos os erros

// Inicializa a resposta como um array
$response = array("error" => false);

// Processa os dados do formulário quando a solicitação POST é recebida
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados em formato JSON
    $data = json_decode(file_get_contents("php://input"), true);
    if (!is_array($data)) {
        // Trate o erro apropriadamente
        $response["error"] = true;
        $response["message"] = "Invalid input format";
        echo json_encode($response);
        exit;
    }
    // Atribui os dados recebidos às variáveis
    $username = isset($data["username"]) ? trim($data["username"]) : "";
    $email = isset($data["email"]) ? trim($data["email"]) : "";
    $password = isset($data["password"]) ? trim($data["password"]) : "";
    $confirm_password = isset($data["confirm_password"]) ? trim($data["confirm_password"]) : "";

    $pdo = getDbConnection();

    // Verifica se o email já existe
    $sql = "SELECT uid FROM users WHERE email = :email";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $response['errors']['email'] = "This email is already taken.";
        }
        unset($stmt); // Fecha a declaração
    }

    // Validação do nome de utilizador
    if (empty($username)) {
        $response['error']['username'] = "Please enter a username.";
    } else {
        // Prepara uma declaração de seleção
        $sql = "SELECT uid FROM users WHERE username = :username";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);

            // Tenta executar
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $response['error']['username'] = "This username is already taken.";
                }
            } else {
                $response["error"] = true;
                $response["message"] = "Oops! Something went wrong. Please try again later.";
            }

            unset($stmt); // Fecha a declaração
        }
    }

    // Validação do email
    if (empty($email)) {
        $response['error']['email'] = "Please enter an email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error']['email'] = "Invalid email format.";
    }

    // Validação da password
    if (empty($password)) {
        $response['error']['password'] = "Please enter a password.";
    } elseif (strlen($password) < 6) {
        $response['error']['password'] = "Password must have at least 6 characters.";
    }

    // Validação da confirmação da password
    if (empty($confirm_password)) {
        $response['error']['confirm_password'] = "Please confirm the password.";
    } elseif ($password != $confirm_password) {
        $response['error']['confirm_password'] = "Password did not match.";
    }

    // Verifica se há erros antes de inserir na base de dados
    if (empty($response['error'])) {
        // Prepara uma declaração de inserção
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);

            // Executa a declaração
            if ($stmt->execute()) {
                $response["message"] = "User registered successfully";
            } else {
                $response["error"] = true;
                $response["message"] = "Error in registration";
            }

            unset($stmt); // Fecha a declaração
        }
    }

    unset($pdo); // Fecha a conexão
}

// Retorna a resposta em formato JSON
echo json_encode($response);

?>