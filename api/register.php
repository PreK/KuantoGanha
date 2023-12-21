<?php
require_once '../modules/dbconfig.php'; // Inclui o ficheiro de configuração da base de dados

header('Content-Type: application/json'); // Define o cabeçalho da resposta como JSON

// Inicializa a resposta como um array
$response = array("errors" => false);

// Processa os dados do formulário quando a solicitação POST é recebida
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados em formato JSON
    $data = json_decode(file_get_contents("php://input"), true);

    // Atribui os dados recebidos às variáveis
    $username = trim($data["username"]);
    $email = trim($data["email"]);
    $password = trim($data["password"]);
    $confirm_password = trim($data["confirm_password"]);

    // Validação do nome de utilizador
    if (empty($username)) {
        $response['errors']['username'] = "Please enter a username.";
    } else {
        // Prepara uma declaração de seleção
        $sql = "SELECT uid FROM users WHERE username = :username";
        $pdo = getDbConnection();
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);

            // Tenta executar
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $response['errors']['username'] = "This username is already taken.";
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
        $response['errors']['email'] = "Please enter an email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['errors']['email'] = "Invalid email format.";
    }

    // Validação da password
    if (empty($password)) {
        $response['errors']['password'] = "Please enter a password.";
    } elseif (strlen($password) < 6) {
        $response['errors']['password'] = "Password must have at least 6 characters.";
    }

    // Validação da confirmação da password
    if (empty($confirm_password)) {
        $response['errors']['confirm_password'] = "Please confirm the password.";
    } elseif ($password != $confirm_password) {
        $response['errors']['confirm_password'] = "Password did not match.";
    }

    // Verifica se há erros antes de inserir na base de dados
    if (empty($response['errors'])) {
        // Prepara uma declaração de inserção
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $pdo = getDbConnection();
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