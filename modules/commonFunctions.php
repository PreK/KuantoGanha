<?php

require_once 'dbconfig.php'; // Conexão com o banco de dados

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

?>