<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbconfig.php'; // Substitua pelo caminho correto do seu arquivo de configuração do banco de dados

header('Content-Type: application/json');

$pdo = getDbConnection();

if (isset($_GET['requestType'])) {
    switch ($_GET['requestType']) {
        case 'chart':
            echo json_encode(getTopProfessionsData($pdo, $_GET['district'] ?? ''));
            break;
        case 'table':
            echo json_encode(getRecentProfessionsData($pdo));
            break;
        default:
            echo json_encode(["error" => "Tipo de solicitação inválido"]);
    }
}

function getTopProfessionsData($pdo, $district) {
    if ($district === 'all') {
        $district = '%';
    }
    try {
        $sql = "SELECT j.title, AVG(s.gross_amount) as averageSalary
                FROM jobs j
                JOIN user_jobs uj ON j.id = uj.job_id
                JOIN salaries s ON uj.id = s.user_job_id
                JOIN locations l ON uj.location_id = l.id
                WHERE (:district = '' OR l.district = :district)
                GROUP BY j.title
                ORDER BY averageSalary DESC
                LIMIT 5";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':district', $district);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao obter dados: " . $e->getMessage());
        return ["error" => "Erro ao obter dados do gráfico"];
    }
}

function getRecentProfessionsData($pdo) {
    try {
        $sql = "SELECT j.title, l.district, wm.description, uj.start_date, uj.end_date
                FROM user_jobs uj
                JOIN jobs j ON uj.job_id = j.id
                JOIN locations l ON uj.location_id = l.id
                JOIN work_modalities wm ON uj.modality_id = wm.id
                ORDER BY uj.start_date DESC
                LIMIT 20";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao obter dados: " . $e->getMessage());
        return ["error" => "Erro ao obter dados da tabela"];
    }
}
?>