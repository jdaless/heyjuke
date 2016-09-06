<?php
require_once('song.php');

$target_dir = "..\\music\\";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$check = 0;
$check = $check + (1 * (strpos($_FILES["file"]["type"], "audio/mp3") === FALSE));
$check = $check + (2 * ($_FILES["file"]["size"] > (300000000)));
$check = $check + (4 * (file_exists($target_file)));

if($check == 0){
	$check = $check + (8 * !move_uploaded_file($_FILES["file"]["tmp_name"], $target_file));
}

echo $check;
?>