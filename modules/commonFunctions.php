<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/dbconfig.php';

function getJobs(): bool|array
{
    $pdo = getDbConnection();
    $sql = "SELECT id, title FROM jobs ORDER BY title";
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

function getTopProfessionsData($district): array|bool
{
    $pdo = getDbConnection();
    try {
        // Modifique a consulta SQL para lidar com o caso "all"
        $sql = $district === 'all' ?
            "SELECT j.title, AVG(s.gross_amount) as averageSalary
             FROM jobs j
             JOIN user_jobs uj ON j.id = uj.job_id
             JOIN salaries s ON uj.id = s.user_job_id
             GROUP BY j.title
             ORDER BY averageSalary DESC
             LIMIT 5" :
            "SELECT j.title, AVG(s.gross_amount) as averageSalary
             FROM jobs j
             JOIN user_jobs uj ON j.id = uj.job_id
             JOIN salaries s ON uj.id = s.user_job_id
             JOIN locations l ON uj.location_id = l.id
             WHERE l.district = :district
             GROUP BY j.title
             ORDER BY averageSalary DESC
             LIMIT 5";

        $stmt = $pdo->prepare($sql);

        // Apenas ligar o parâmetro se não for "all"
        if ($district !== 'all') {
            $stmt->bindParam(':district', $district);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao obter dados: " . $e->getMessage());
        return ["error" => "Erro ao obter dados do gráfico"];
    }
}

function getRecentProfessionsData(): array|bool
{
    $pdo = getDbConnection();
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