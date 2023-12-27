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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolha e validação dos dados do formulário
    $jobId = $_POST['job_id'];
    $locationId = $_POST['location_id']; // Supondo que você tenha este campo no formulário
    $modalityId = $_POST['modality_id']; // Supondo que você tenha este campo no formulário
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    $result = insertUserJob($userId, $_POST['job_id'], $_POST['location_id'],
        $_POST['modality_id'], $_POST['start_date'], $_POST['end_date']);

    if ($result) {
        echo "Emprego associado com sucesso.";
    } else {
        echo "Erro ao associar emprego.";
    }

}

function getJobs() {
    $pdo = getDbConnection();
    $sql = "SELECT id, title FROM jobs";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDistricts() {
    $pdo = getDbConnection();
    $sql = "SELECT id, district FROM locations";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getModalities() {
    $pdo = getDbConnection();
    $sql = "SELECT id, description FROM work_modalities";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertUserJob($userId, $jobId, $locationId, $modalityId, $startDate, $endDate) {
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
        $stmt->bindParam(':end_date', $endDate);

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
    <title>Associar Emprego ao Usuário</title>
    <!-- Seus estilos e scripts aqui -->
</head>
<body>
<h2>Associar Emprego ao Usuário</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="job_id">Emprego:</label>
    <select name="job_id" id="job_id">
        <?php foreach ($jobs as $job): ?>
            <option value="<?php echo $job['id']; ?>"><?php echo htmlspecialchars($job['title']); ?></option>
        <?php endforeach; ?>
    </select><br/>

    <!-- Supondo que você tenha uma lista de localizações e modalidades -->
    <label for="location_id">Localização:</label>
    <select name="location_id" id="location_id">
        <?php foreach ($districts as $district): ?>
            <option value="<?php echo $district['id']; ?>"><?php echo htmlspecialchars($district['title']); ?></option>
        <?php endforeach; ?>
    </select><br/>

    <label for="modality_id">Modalidade:</label>
    <select name="modality_id" id="modality_id">
        <?php foreach ($modalities as $modality): ?>
            <option value="<?php echo $modality['id']; ?>"><?php echo htmlspecialchars($modality['title']); ?></option>
        <?php endforeach; ?>
    </select><br/>

    <label for="start_date">Data de Início:</label>
    <input type="date" name="start_date" id="start_date"><br/>

    <label for="end_date">Data de Término (opcional):</label>
    <input type="date" name="end_date" id="end_date"><br/>

    <input type="submit" value="Associar Emprego">
</form>

</body>
</html>