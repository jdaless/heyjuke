<?php
$url = 'http://localhost:15000';
$data = 'ChemicalWarfare.mp3';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);
curl_close($ch);
if ($result === FALSE) { /* Handle error */ }

echo 'Result: ';
var_dump($result);
?>