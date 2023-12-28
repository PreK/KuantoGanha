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

?>