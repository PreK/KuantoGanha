<?php
session_start();

require_once 'dbconfig.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar se o usuário é administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$pdo = getDbConnection();
$job_err = "";

// Processamento de dados do formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Adicionar emprego
    if (isset($_POST["add_job"])) {
        if (empty(trim($_POST["job_title"]))) {
            $job_err = "Por favor, insira o título do emprego.";
        } else {
            $sql = "INSERT INTO jobs (title) VALUES (:title)";
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":title", $param_title, PDO::PARAM_STR);
                $param_title = trim($_POST["job_title"]);
                $stmt->execute();
                unset($stmt);
                echo "success";
                exit;
            }
        }
    }

    // Remover emprego
    if (isset($_POST["remove_job"]) && !empty(trim($_POST["job_id"]))) {
        $sql = "DELETE FROM jobs WHERE id = :job_id";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":job_id", $param_job_id, PDO::PARAM_INT);
            $param_job_id = trim($_POST["job_id"]);
            $stmt->execute();
            unset($stmt);
            echo "success";
            exit;
        }
    }
}
unset($pdo);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="jobs-form">
        <h2>Gestão de Profissões</h2>
        <form class="jobs-form" id="addJobForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Título do Emprego</label>
                <input type="text" name="job_title" class="form-control">
                <span class="text-danger"><?php echo $job_err; ?></span>
            </div>
            <div>
                <input type="submit" name="add_job" class="btn btn-primary" value="Adicionar Profissão">
            </div>
        </form>

        <!-- Lista de empregos com opção de remoção -->
        <table>
            <tr>
                <th>Profissão</th>
                <th>Apagar</th>
            </tr>
            <?php
            $pdo = getDbConnection();
            $sql = "SELECT * FROM jobs";
            foreach ($pdo->query($sql) as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>
            <form class='job-list' method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
                <input type='hidden' name='job_id' value='" . $row['id'] . "'>
                <button type='submit' name='remove_job' class='btn btn-danger'>Remover</button>
            </form>
          </td>";
                echo "</tr>";
            }
            unset($pdo);
            ?>
        </table>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById("jobsLink").classList.add("active");
    });
</script>

