<?php
require_once('..\\lib\\getid3\\getid3.php');

$url = 'http://localhost:15000';
$data = 'ChemicalWarfare.mp3';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

class Song{
	public $title;
	public $artist;
	public $album;
	public $albumArt;
	public $length;
	public $nowPlaying;
	public $media;
}

function getData($path, $mediaSource){
	$getID3 = new getID3;
	$song = new Song;
	if($mediaSource == "file"){
		$file = $getID3->analyze("..\\music\\" . $path);
        getid3_lib::CopyTagsToComments($file);
		$song->title = $file['comments']['title'][0];
		$song->artist = $file['comments']['artist'][0];
		$song->album = $file['comments']['album'][0];
		$song->length = $file['playtime_seconds'];
		$song->albumArt = $file['id3v2']['APIC'][0]['data'];
		echo $song->albumArt;
	}
	else
		return false;
	return $song;
}

$result = curl_exec($ch);
$decoded = json_decode($result);

curl_close($ch);
$queue = array();
$i = 0;
foreach($decoded[1] as $song){
	$queue[$i] = getData($song[1][1], $song[0][0]);
	$i = $i + 1;
}
$np = getData($decoded[0][1], $decoded[0][0]);
$np->nowPlaying = true;

echo json_encode( array(0 => $np, 1 => $queue, $decoded[2]), JSON_PRETTY_PRINT);

?>