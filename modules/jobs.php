<?php
session_start();
require_once 'dbconfig.php';

// Verificar se o usuário é administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php'); // Redirecionar para a página de login se não for admin
    exit;
}

$pdo = getDbConnection();

// Lógica para adicionar um novo emprego
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_job'])) {
    $title = trim($_POST['job_title']);
    if (!empty($title)) {
        $sql = "INSERT INTO jobs (title) VALUES (:title)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->execute();
            // Mensagem de sucesso ou redirecionamento pode ser adicionado aqui
        }
    }
}

// Lógica para remover um emprego
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_job'])) {
    $jobId = trim($_POST['job_id']);
    $sql = "DELETE FROM jobs WHERE id = :job_id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":job_id", $jobId, PDO::PARAM_INT);
        $stmt->execute();
        // Mensagem de sucesso ou redirecionamento pode ser adicionado aqui
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Administração de Empregos</title>
    <!-- Aqui podem ser adicionados links para CSS, Bootstrap, etc. -->
</head>
<body>
<div class="container">
    <h2>Administração de Empregos</h2>

    <!-- Formulário para adicionar um novo emprego -->
    <form method="post">
        <input type="text" name="job_title" placeholder="Título do Emprego">
        <button type="submit" name="add_job">Adicionar Emprego</button>
    </form>

    <!-- Tabela para listar e remover empregos -->
    <table>
        <thead>
        <tr>
            <th>Título</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM jobs";
        foreach ($pdo->query($sql) as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>
                            <form method='post'>
                                <input type='hidden' name='job_id' value='" . $row['id'] . "'>
                                <button type='submit' name='remove_job'>Remover</button>
                            </form>
                          </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
