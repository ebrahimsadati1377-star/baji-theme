<?php
header('Content-Type: application/json; charset=utf-8');
$root = dirname(__FILE__, 4) . '/wp-load.php';
if (!is_file($root)) {
    http_response_code(500);
    echo json_encode(['ok'=>false,'stage'=>'bootstrap']);
    exit;
}
require_once $root;
$key = (string) get_option('custom_otp_apikey', '');
if ($key === '') {
    echo json_encode(['ok'=>false,'stage'=>'config','configured'=>false]);
    exit;
}
$response = wp_remote_get('https://edge.ippanel.com/v1/api/send/banks/provinces', [
    'timeout' => 12,
    'headers' => [
        'Accept' => 'application/json',
        'Authorization' => $key,
    ],
]);
if (is_wp_error($response)) {
    echo json_encode(['ok'=>false,'stage'=>'transport','error_code'=>$response->get_error_code()]);
    exit;
}
$status = (int) wp_remote_retrieve_response_code($response);
echo json_encode(['ok'=>$status >= 200 && $status < 300,'stage'=>'provider','http'=>$status]);
