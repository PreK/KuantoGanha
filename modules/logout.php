<?php
// Start the session
session_start();

// Destroy the session
session_destroy();

// Imprime mensagem de sucesso e redireciona para a página de login
echo "Logout realizado com sucesso!";
header("Location: login.php");
exit;
?>