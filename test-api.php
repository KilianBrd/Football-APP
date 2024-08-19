<?php
$url = "https://api.football-data.org/v4/teams/523/matches/";
$apiKey = "61699dfffd574937b59a393d04847b66";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-Auth-Token: $apiKey"
]);

$response = curl_exec($ch);
curl_close($ch);

$parse = json_decode($response, true); // 'true' pour obtenir un tableau associatif

echo "<pre>";  // Pour un formatage plus lisible
print_r($parse);
echo "</pre>";
