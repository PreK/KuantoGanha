<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbconfig.php'; // Conexão com o banco de dados

// Verificar se o usuário está logado
$userId = $_SESSION['uid'] ?? null;
if (!$userId) {
    // Redirecionar para a página de login ou mostrar uma mensagem de erro
    echo "Utilizador não está logado.";
    exit;
}

// Buscar empregos para o dropdown
$jobs = getJobs();
$districts = getDistricts();
$modalities = getModalities();

// Processar o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["PHP_SELF"]) {
    // Recolha e validação dos dados do formulário
    $jobId = $_POST['job_id'];
    $locationId = $_POST['location_id'];
    $modalityId = $_POST['modality_id'];
    $startDate = $_POST['start_date'];
    $endDate = !empty($_POST['end_date']) ? $_POST['end_date'] : null;

    if ($jobId && $locationId && $modalityId && $startDate) {
        $result = insertUserJob($userId, $jobId, $locationId, $modalityId, $startDate, $endDate);

        if ($result) {
            echo "success";
            exit;
        } else {
            echo "Erro ao associar emprego";
            exit;
        }
    } else {
        echo "Por favor, preencha todos os campos obrigatórios.";
        exit;
    }

}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_job_id'])) {
    $removeJobId = $_POST['remove_job_id'];
    if (removeUserJob($removeJobId, $userId)) {
        echo "Profissão removida com sucesso.";
    } else {
        echo "Erro ao remover a profissão.";
    }
}

function removeUserJob($jobId, $userId): bool
{
    $pdo = getDbConnection();
    $sql = "DELETE FROM user_jobs WHERE id = :job_id AND user_id = :user_id";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    return false;
}
function getUserJobs($userId): bool|array
{
    $pdo = getDbConnection();
    $sql = "SELECT uj.id as user_job_id, j.title, l.district, wm.description, uj.start_date, uj.end_date 
        FROM user_jobs uj
        INNER JOIN jobs j ON uj.job_id = j.id
        INNER JOIN locations l ON uj.location_id = l.id
        INNER JOIN work_modalities wm ON uj.modality_id = wm.id
        WHERE uj.user_id = :user_id";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    return [];
}
function getJobs(): bool|array
{
    $pdo = getDbConnection();
    $sql = "SELECT id, title FROM jobs";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDistricts(): bool|array
{
    $pdo = getDbConnection();
    $sql = "SELECT id, district FROM locations";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getModalities(): bool|array
{
    $pdo = getDbConnection();
    $sql = "SELECT id, description FROM work_modalities";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertUserJob($userId, $jobId, $locationId, $modalityId, $startDate, $endDate): bool
{
    $pdo = getDbConnection();

    $sql = "INSERT INTO user_jobs (user_id, job_id, location_id, modality_id, start_date, end_date) 
            VALUES (:user_id, :job_id, :location_id, :modality_id, :start_date, :end_date)";

    if ($stmt = $pdo->prepare($sql)) {
        // Vincular parâmetros
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
        $stmt->bindParam(':location_id', $locationId, PDO::PARAM_INT);
        $stmt->bindParam(':modality_id', $modalityId, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $startDate);
        if ($endDate !== null) {
            $stmt->bindParam(':end_date', $endDate);
        } else {
            $stmt->bindValue(':end_date', null, PDO::PARAM_NULL);
        }

        // Executar a declaração
        if ($stmt->execute()) {
            return true; // Sucesso
        } else {
            return false; // Falha
        }
    }
    return false; // Falha na preparação da declaração
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Associar Emprego ao Utilizador</title>

</head>
<body>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="form-container">
        <h2>Associar Emprego ao Utilizador</h2>
        <p>Selecione as informações do emprego para associar ao seu perfil.</p>
        <form class="userJobsForm" id="userJobsForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="job_id">Emprego:</label>
                <select name="job_id" id="job_id" class="form-control">
                    <?php foreach ($jobs as $job): ?>
                        <option value="<?php echo $job['id']; ?>"><?php echo htmlspecialchars($job['title']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="location_id">Localização:</label>
                <select name="location_id" id="location_id" class="form-control">
                    <?php foreach ($districts as $district): ?>
                        <option value="<?php echo $district['id']; ?>"><?php echo htmlspecialchars($district['district']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="modality_id">Modalidade:</label>
                <select name="modality_id" id="modality_id" class="form-control">
                    <?php foreach ($modalities as $modality): ?>
                        <option value="<?php echo $modality['id']; ?>"><?php echo htmlspecialchars($modality['description']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="start_date">Data de Início:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="end_date">Data de Término (opcional):</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Associar Emprego">
            </div>
        </form>
    </div>
    <div class="user-jobs-container">
        <h3>Profissões Associadas</h3>
        <table class="table">
            <thead>
            <tr>
                <th>Emprego</th>
                <th>Localização</th>
                <th>Modalidade</th>
                <th>Data de Início</th>
                <th>Data de Término</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $userJobs = getUserJobs($userId);
            echo '<pre>';
            print_r($userJobs);
            echo '</pre>';
            foreach ($userJobs as $userJob): ?>
                <tr>
                    <td><?php echo htmlspecialchars($userJob['title']); ?></td>
                    <td><?php echo htmlspecialchars($userJob['district']); ?></td>
                    <td><?php echo htmlspecialchars($userJob['description']); ?></td>
                    <td><?php echo htmlspecialchars($userJob['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($userJob['end_date']); ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="remove_job_id" value="<?php echo $userJob['user_job_id']; ?>">
                            <input type="submit" value="Remover">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
