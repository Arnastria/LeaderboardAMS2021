<?php

$type = $_GET['type'];
$id = $_GET['id'];
$waktu = $_GET['updated'];

$host = 's3lkt7lynu0uthj8.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
$username = 'uhtbugxx9ty6dufh';
$password = 'wtqo9g6jixlfm7ov';
$dbname = 'clgr9wl4akcxw07o';

$connection =  mysqli_connect($host, $username, $password, $dbname) or die('Database Connection Failed');
mysqli_set_charset($connection,'utf-8');

$table = $type . '_submission_logs';
$query = "SELECT * FROM $table WHERE GroupName = '$id' AND updated='$waktu'";
$result = mysqli_query($connection,$query) 
	   or die('Error, query failed');
list($UploadKey, $GroupName, $filename, $mime, $size, $updated, $data, $Accuracy, $Precision, $Recall, $F1Score ) = mysqli_fetch_array($result);

$regex = '/\d+\,.*/';
preg_match_all($regex, $data, $matches);
foreach($matches[0] as $idx=>$piece) {
	echo $piece.'<br>';
}

mysqli_close($connection);

?>