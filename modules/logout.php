<?php
session_start();
session_destroy();

echo "<p>Logout realizado com sucesso!</p>";
echo "<button onclick='window.location.href=\"index.php\"'>Voltar à página inicial</button>";
?>