<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/commonFunctions.php';

header('Content-Type: application/json');

if (isset($_GET['requestType'])) {
    echo match ($_GET['requestType']) {
        'chart' => json_encode(getTopProfessionsData($_GET['district'] ?? '')),
        'table' => json_encode(getRecentProfessionsData()),
        'districts' => json_encode(getDistricts()),
        default => json_encode(["error" => "Tipo de solicitação inválido"]),
    };
}
?>