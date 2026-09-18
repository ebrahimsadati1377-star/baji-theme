<?php
header('Content-Type: application/json; charset=utf-8');
$ch = curl_init('https://edge.ippanel.com/v1/api/send/banks/provinces');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT => 12,
    CURLOPT_HTTPHEADER => ['Accept: application/json'],
]);
curl_exec($ch);
$status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
$errno = curl_errno($ch);
curl_close($ch);
echo json_encode([
    'ok' => $status >= 200 && $status < 500 && $status !== 0,
    'http' => $status,
    'curl_errno' => $errno,
]);
