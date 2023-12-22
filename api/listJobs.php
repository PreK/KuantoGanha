<?php
require_once '../modules/dbconfig.php';

header('Content-Type: application/json');

$response = array("error" => false);

$pdo = getDbConnection();
$sql = "SELECT * FROM jobs";
try {
    $stmt = $pdo->query($sql);
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response['jobs'] = $jobs;
} catch (PDOException $e) {
    $response['error'] = true;
    $response['message'] = "Error in fetching jobs: " . $e->getMessage();
}

echo json_encode($response);
?><?php
