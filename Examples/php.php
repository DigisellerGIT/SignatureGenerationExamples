<?php
function getToken($sellerId, $apiKey) {
    $url = 'https://api.digiseller.ru/api/apilogin';
    $timeStamp = time();
    $data = [
        'seller_id' => $sellerId,
        'timestamp' => $timeStamp,
        'sign' => hash('sha256', $apiKey . $timeStamp),
    ];
    $payload = json_encode($data);
    $headers = ['Content-Type: application/json', 'Accept: application/json'];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // curl_setopt($ch, CURLOPT_HEADER, false);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [
        'status' => $httpCode, 
        'data' => json_decode($contents, true)
    ];
}

$sellerId = '12126';
$apiKey = 'E2AF00CBE6A24E06B1C1952E239A4B61';
$res = getToken($sellerId, $apiKey);
print_r($res);