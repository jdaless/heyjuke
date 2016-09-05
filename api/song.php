<?php
require_once('..\\lib\\getid3\\getid3.php');

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
		#$song->albumArt = $file['id3v2']['APIC'][0]['data'];
	}
	else
		return false;
	return $song;
}

?>