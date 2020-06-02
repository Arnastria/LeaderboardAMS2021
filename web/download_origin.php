<?php

if ( isset($_GET['id'])) {
	#echo "Informasi ";
	$id = $_GET['id'];
	$waktu = $_GET['updated'];
	
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'anamedsos';

	$connection =  mysqli_connect($host, $username, $password, $dbname) or die('Database Connection Failed');
	mysqli_set_charset($connection,'utf-8');

	$query = "SELECT * FROM origin_submission_logs WHERE GroupName = '$id' AND updated='$waktu'";
	$result = mysqli_query($connection,$query) 
		   or die('Error, query failed');
	list($UploadKey, $GroupName, $filename, $mime, $size, $updated, $data, $TesterAccuracy, $TesterPrecision, $TesterRecall, $TesterF1Score ) = mysqli_fetch_array($result);

	mysqli_close($connection);

	$path = 'downloads/';
	$out = fopen($path . $filename, 'w+') or die('Unable to open file!');
	fwrite($out, $data);
	fclose($out);

	header("Content-Length: $size");
	header("Content-Type: $mime");
	header("Content-Disposition: attachment; filename=$filename");

	// ob_clean();
	// flush();
	readfile($path . $filename);
	// exit();
}

?>