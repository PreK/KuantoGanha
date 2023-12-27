<?php

session_start();
require_once 'dbconfig.php'; // Substitua pelo seu arquivo de configuração de banco de dados


function getUserData($userId) {
    $pdo = getDbConnection();
    $sql = "SELECT * FROM users WHERE uid = :uid";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":uid", $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    return null;
}

function getAcademicData($userId) {
    $pdo = getDbConnection();
    $sql = "SELECT * FROM academic_data WHERE user_id = :user_id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    return [];
}

function getJobData($userId) {
    $pdo = getDbConnection();
    $sql = "SELECT j.title, s.gross_amount FROM jobs j
            JOIN user_jobs uj ON j.id = uj.job_id
            JOIN salaries s ON uj.user_id = s.user_id
            WHERE uj.user_id = :user_id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    return [];
}

?>