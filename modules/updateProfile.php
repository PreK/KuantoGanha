<?php
include 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $newEmail = $_POST['email'];
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("UPDATE users SET email = ?, password = ? WHERE uid = ?");
        $stmt->execute([$newEmail, $newPassword, $userId]);
        echo "Perfil atualizado com sucesso.";
    } catch(PDOException $e) {
        echo "Erro ao atualizar perfil: " . $e->getMessage();
    }
}
?>