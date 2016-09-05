<?php
require_once('song.php');

$library = glob("..\\music\\*.*");
$songs = array();
foreach ($library as $song) {
	array_push($songs, getData($song, "file"));
}

if(isset($_GET['id'])){
	$url = 'http://localhost:15000';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "add=" . $library[$_GET['id']]);


	$result = curl_exec($ch);

	curl_close($ch);
}
else{
	echo json_encode($songs, JSON_PRETTY_PRINT);
}
?>