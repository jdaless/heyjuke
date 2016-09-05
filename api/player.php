<?php
require_once('song.php');

$url = 'http://localhost:15000';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);
$decoded = json_decode($result);

curl_close($ch);
$queue = array();
$i = 0;
foreach($decoded[1] as $song){
	$queue[$i] = getData($song[1], $song[0]);
	$i = $i + 1;
}
$np = getData($decoded[0][1], $decoded[0][0]);
if($np){
	$np->nowPlaying = true;
}

echo json_encode( array(0 => $np, 1 => $queue, 2 => $decoded[2]), JSON_PRETTY_PRINT);

?>