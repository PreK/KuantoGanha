<?php
require_once '../modules/dbconfig.php';

header('Content-Type: application/json');

$response = array("error" => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $jobId = isset($data["job_id"]) ? $data["job_id"] : 0;

    $pdo = getDbConnection();
    $sql = "DELETE FROM jobs WHERE id = :job_id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":job_id", $jobId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response["message"] = "Job deleted successfully";
        } else {
            $response["error"] = true;
            $response["message"] = "Error in deleting job";
        }
        unset($stmt);
    }
    unset($pdo);
}

echo json_encode($response);
?>