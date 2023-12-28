<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/commonFunctions.php';

header('Content-Type: application/json');

try {
    $districts = getDistricts();
    echo json_encode([
        'success' => true,
        'data' => $districts
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao buscar distritos: ' . $e->getMessage()
    ]);
}
