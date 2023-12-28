<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/dbconfig.php';

header('Content-Type: application/json');

$response = array("error" => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $title = isset($data["title"]) ? trim($data["title"]) : "";
    $startDate = isset($data["start_date"]) ? trim($data["start_date"]) : "";

    if (empty($title)) {
        $response['error']['title'] = "Please enter a job title.";
    }

    if (empty($startDate)) {
        $response['error']['start_date'] = "Please enter a start date.";
    }

    if (empty($response['error'])) {
        $pdo = getDbConnection();
        $sql = "INSERT INTO jobs (title, start_date) VALUES (:title, :start_date)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->bindParam(":start_date", $startDate, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $response["message"] = "Job added successfully";
            } else {
                $response["error"] = true;
                $response["message"] = "Error in adding job";
            }
            unset($stmt);
        }
        unset($pdo);
    }
}

echo json_encode($response);
?>