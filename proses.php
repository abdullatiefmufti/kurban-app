<?php
// Ganti dengan URL Deploy GAS Anda
$webAppUrl = "PASTE_URL_DEPLOY_GAS_DI_SINI";

$input = file_get_contents('php://input');

$ch = curl_init($webAppUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Wajib untuk GAS redirect
curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);
curl_close($ch);

echo $response;