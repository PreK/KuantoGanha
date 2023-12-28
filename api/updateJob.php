<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/dbconfig.php';

header('Content-Type: application/json');

$response = array("error" => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $jobId = isset($data["job_id"]) ? $data["job_id"] : 0;
    $title = isset($data["title"]) ? trim($data["title"]) : "";
    $startDate = isset($data["start_date"]) ? trim($data["start_date"]) : "";

    if (empty($title)) {
        $response['error']['title'] = "Please enter a job title.";
    }

    if (empty($response['error'])) {
        $pdo = getDbConnection();
        $sql = "UPDATE jobs SET title = :title, start_date = :start_date WHERE id = :job_id";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->bindParam(":start_date", $startDate, PDO::PARAM_STR);
            $stmt->bindParam(":job_id", $jobId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $response["message"] = "Job updated successfully";
            } else {
                $response["error"] = true;
                $response["message"] = "Error in updating job";
            }
            unset($stmt);
        }
        unset($pdo);
    }
}

echo json_encode($response);
?>