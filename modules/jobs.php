<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbconfig.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$pdo = getDbConnection();
$job_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            if (empty(trim($_POST["job_title"]))) {
                echo "Por favor, insira o título do emprego.";
            } else {
                $sql = "INSERT INTO jobs (title) VALUES (:title)";
                if ($stmt = $pdo->prepare($sql)) {
                    $stmt->bindParam(":title", $param_title, PDO::PARAM_STR);
                    $param_title = trim($_POST["job_title"]);
                    if ($stmt->execute()) {
                        echo "success";
                    } else {
                        echo "Erro ao adicionar o emprego.";
                    }
                    unset($stmt);
                }
            }
        } elseif ($_POST['action'] === 'remove') {
            if (!empty(trim($_POST["job_id"]))) {
                $sql = "DELETE FROM jobs WHERE id = :job_id";
                if ($stmt = $pdo->prepare($sql)) {
                    $stmt->bindParam(":job_id", $param_job_id, PDO::PARAM_INT);
                    $param_job_id = trim($_POST["job_id"]);
                    if ($stmt->execute()) {
                        echo "success";
                    } else {
                        echo "Erro ao remover o emprego.";
                    }
                    unset($stmt);
                }
            }
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Profissões</title>

</head>
<body>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="jobs-form">
        <h2>Gestão de Profissões</h2>
        <form class="jobs-form" id="addJobForm" method="post">
            <div class="mb-3">
                <label class="form-label">Título do Emprego</label>
                <input type="text" name="job_title" class="form-control">
                <span class="text-danger"><?php echo $job_err; ?></span>
            </div>
            <div>
                <input type="submit" class="btn btn-primary" value="Adicionar Profissão">
            </div>
        </form>
    </div>
    <div class="jobs-list">
        <table>
            <tr>
                <th>Profissão</th>
                <th>Apagar</th>
            </tr>
            <?php
            require_once 'commonFunctions.php';
            $job = getJobs();
            foreach ($job as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>
                        <form class='job-list' method='post'>
                            <input type='hidden' name='job_id' value='" . $row['id'] . "'>
                            <button type='submit' class='btn btn-danger'>Remover</button>
                        </form>
                    </td>";
                echo "</tr>";
            }
            unset($pdo);
            ?>
        </table>
    </div>
</main>
</body>
</html>
