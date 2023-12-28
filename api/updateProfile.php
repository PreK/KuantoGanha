<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/dbconfig.php';

header('Content-Type: application/json');

$response = array("error" => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $email = isset($data["email"]) ? trim($data["email"]) : "";
    $password = isset($data["password"]) ? password_hash(trim($data["password"]), PASSWORD_DEFAULT) : "";
    $userId = isset($data["user_id"]) ? $data["user_id"] : 0;

    if (empty($email)) {
        $response['error']['email'] = "Please enter an email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error']['email'] = "Invalid email format.";
    }

    if (empty($password)) {
        $response['error']['password'] = "Please enter a password.";
    }

    if (empty($response['error'])) {
        $pdo = getDbConnection();
        $sql = "UPDATE users SET email = :email, password = :password WHERE uid = :uid";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->bindParam(":uid", $userId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $response["message"] = "Profile updated successfully";
            } else {
                $response["error"] = true;
                $response["message"] = "Error in updating profile";
            }
            unset($stmt);
        }
        unset($pdo);
    }
}

echo json_encode($response);
?>