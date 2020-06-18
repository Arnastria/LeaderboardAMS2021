<?php
require_once __DIR__ . '/vendor/autoload.php';
use Phpml\Metric\ClassificationReport;
use Phpml\Metric\Accuracy;

if ( isset($_POST["submit"]) and isset($_POST["uploadkey"])) {
	if ( isset($_FILES["file"])) {
		//if there was an error uploading the file
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		} else {
			// get uploadKey
			$uploadKey = $_POST["uploadkey"];

			// upload type
			$type = $_GET['type'];
			
			// db definition
			$host = 's3lkt7lynu0uthj8.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
			$username = 'uhtbugxx9ty6dufh';
			$password = 'wtqo9g6jixlfm7ov';
			$dbname = 'clgr9wl4akcxw07o';

			// Create connection
			$conn = new mysqli($host, $username, $password, $dbname);

			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			//get groupname for giving filename
			$table = $type . '_result';
			$getdata = "SELECT GroupName from $table where UploadKey = $uploadKey";
			$result_get = $conn->query($getdata);
			$namagrup = '';
			if ($result_get) {
			
				while($row = $result_get->fetch_assoc())
				{
					$namagrup = $row['GroupName'];
				}
				
			}

			//Print file details
			$file = $namagrup."-".$_FILES['file']['name'];
			$file_loc = $_FILES['file']['tmp_name'];
			$folder="uploads/";
			$name = $_FILES['file']['name'];
			$mime = $_FILES['file']['type'];
			$data = $_FILES['file']['tmp_name'];
			$size = $_FILES['file']['size'];
			
			echo "<h2>.:Informasi:.</h2>";
			echo "Uploaded File: " . $name . "<br />";
			echo "Type: " . $mime . "<br />";
			echo "Size: " . ($size / 1024) . " KB<br />";
			
			$fp = fopen($data, 'r');
			$y_pred = array();
			$i = 0;
			
			$content = []; //variable content to store the value of uploaded docs
			while (($read_line = fgetcsv($fp,1000,",")) != false) {
				$id_pred[$i] = $read_line[0];
				$y_pred[$i] = $read_line[1];	
				$gabungan[$i] = $id_pred[$i] . "," . $y_pred[$i];
				array_push($content, $gabungan[$i]);
				
				$i++;
			}
			
			fclose($fp);
			
			//load gold standard data
			$file_gold = 'temp_x2z/' . $type . '_gold_standar.csv';
			$fp = fopen($file_gold, 'r');
			$y_gold = array();
			$i = 0;
			$classes = array();
			while (($line = fgetcsv($fp,1000,",")) != false) {
				$id_gold[$i] = $line[0];
				$y_gold[$i] = $line[1];
				if (!in_array($line[1], $classes) and $line[1] != '-') {
					array_push($classes, $line[1]);
				}	
				$i++;
			}
			fclose($fp);

			$con_matrix = array();
			for ($i = 0; $i < count($classes); $i++) {
				$con_matrix[$i] = array();
				for ($j = 0; $j < count($classes); $j++) {
					$con_matrix[$i][$j] = 0;
				}
			}

			// modified
			$i = 0;
			$y_gold_clean = array();
			$y_pred_clean = array();
			while (($i < count($y_gold)) and ($i < count($y_pred))) {
				if (($y_gold[$i]) != '-') {
					 $con_matrix[array_search($y_gold[$i], $classes)][array_search($y_pred[$i], $classes)] += 1;
					 array_push($y_gold_clean, $y_gold[$i]);
					 array_push($y_pred_clean, $y_pred[$i]);
				}
				$i++;
			}
			
			echo "<br>";
			echo "Confusion Matrix:<br>";
			echo "<table width=\"1000\">";
			echo "<tr bgcolor=\"peachpuff\">";
			echo "<td></td>";
			foreach ($classes as $class) {
				echo "<td><strong>Prediction $class</strong></td>";
			}
			echo "</tr>";
			for ($i = 0; $i < count($classes); $i++) {
				echo "<tr bgcolor=\"peachpuff\">";
				for ($j = 0; $j < count($classes); $j++) {
					if ($j == 0) {
						$class = $classes[$i];
						echo "<td><strong>Actual $class</strong></td>";
					}
					echo "<td>".$con_matrix[$i][$j]."</td>";
				}
				echo "</tr>";
			}
			echo "</table>";

			$report = new ClassificationReport($y_gold_clean, $y_pred_clean, 1);
			$average = $report->getAverage();
			$precision = $average['precision'];
			$recall = $average['recall'];
			$f1_score = $average['f1score'];
			$accuracy = Accuracy::score($y_gold_clean, $y_pred_clean);
			
			// update info di basis data
			$table = $type . '_result';
			$sql = "UPDATE $table SET `complete set accuracy` = $accuracy, `complete set precision` = $precision, `complete set recall` = $recall, `complete set f1-score` = $f1_score WHERE Uploadkey='$uploadKey'";

			if ($conn->query($sql) == TRUE) {
				//echo "Record updated successfully";
			} else {
				die("Error updating record: " . $conn->error);
			}
	
			echo "<br><strong>Accuracy</strong>: " . $accuracy . "<br>";
			echo "<strong>Precision</strong>: " . $precision . "<br>";
			echo "<strong>Recall</strong>: " . $recall . "<br>";
			echo "<strong>F1-score</strong>: " . $f1_score;
			echo "<br><br>*jika terjadi error terkait 'mysql', coba unggah sekali lagi.";
			echo "<br><br><a href='index.php'>See Current Rankings</a><br>";
				
			
			// ------------- keperluan save submission -------------------
			// make file name in lower case -- untuk keperluan save hasil submission di folder
			$new_file_name = strtolower($file);
			$final_file = str_replace(' ','-',$new_file_name);
			$string_input = implode('\n', $content);
			
			// jika berhasil di pindah ke folder uploads
			if(move_uploaded_file($file_loc,$folder.$final_file))
			{
			
				// update table submission untuk simpan filename yang disubmit oleh grup
				$sekarang = date("Y-m-d H:i:s");
				$table = $type . '_submission_logs';
				$sql = "INSERT INTO $table(UploadKey, GroupName, filename, mime, size, updated, data, Accuracy, Precision_C, Recall, F1Score) VALUES 
						('$uploadKey', '$namagrup', '$name', '$mime', '$size', '$sekarang','$string_input', '$accuracy', '$precision', '$recall', '$f1_score')";

				if ($conn->query($sql) == TRUE) {
					// echo "Submission saved successfully";
				} else {
					die("Error submiting record: " . $conn->error);
				}

			}	
			$conn->close();
        }
	} 
}
?>