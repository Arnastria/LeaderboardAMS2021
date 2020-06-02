<?php
if ( isset($_POST["submit"]) and isset($_POST["uploadkey"])) {
	if ( isset($_FILES["file"])) {
		//if there was an error uploading the file
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		} else {
			// get uploadKey
			$uploadKey = $_POST["uploadkey"];
			
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
			$getdata = "SELECT GroupName from origin_result where UploadKey = $uploadKey";
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
			while ( ($read_line = fgetcsv($fp,1000,",")) !== false) {
				$id_pred[$i] = $read_line[0];
				$y_pred[$i] = $read_line[1];	
				$gabungan[$i] = $id_pred[$i] . "," . $y_pred[$i];
				array_push($content, $gabungan[$i]);
				
				$i++;
			}
			
			fclose($fp);
			
			#echo "count y_pred " . count($y_pred) . "<br>";
			//load gold standard data
			$fp = fopen('temp_x2z/origin_gold_standar_tester.csv', 'r');
			$y_gold = array();
			$i = 0;
			while ( ($line = fgetcsv($fp,1000,",")) !== false) {
				$id_gold[$i] = $line[0];
				$y_gold[$i] = $line[1];	
				$i++;
			}
			fclose($fp);
			
			//compute the metrices
			$num_true = 0;
			$tp = 0;
			$tn = 0;
			$fp = 0;
			$fn = 0;
			$i = 0;
			
			while ( ($i < count($y_gold)) and ($i < count($y_pred))) {
				
				#echo "<br> asli ke - " .$i . "---" . $y_gold[$i]. "--" . $y_pred[$i] ." num true : " ;
				if (($y_gold[$i] == $y_pred[$i]) and (($y_gold[$i]) !== '-')) {
					// calculate TP 
					if ($y_gold[$i] == 1) {
						$tp++;
					}
					else {
						$tn++;
					}
					$num_true++;
				}
				elseif (($y_gold[$i] != $y_pred[$i]) and (($y_gold[$i]) !== '-')) {
					//calculate FP
					if ($y_gold[$i] == 0) {
						$fp++;
					}
					else {
						$fn++;
					}
				}
				$i++;
				
			}
			
			#jumlah y_gold yang tidak null
			
			$counts = array_count_values($y_gold);
			$counts_sum = array_sum($counts);
			// $empty_gold = $counts['-'];
			$empty_gold = 0;
			$count_y_gold = $counts_sum - $empty_gold;
			$num_false = $count_y_gold - $num_true;
			
			// echo " Total Kosong ". $empty_gold;
			// echo " Total Gold Standar " . $count_y_gold;
	
			echo "<br>";
			echo "Confusion Matrix:<br>";
			echo "<table width=\"600\">";
			echo "<tr bgcolor=\"peachpuff\">";
			echo "<td></td>";
			echo "<td><strong>Positive Prediction</strong></td>";
			echo "<td><strong>Negative Prediction</strong></td>";
			echo "</tr>";
			echo "<tr bgcolor=\"peachpuff\">";
			echo "<td><strong>Positive Class</strong></td>";
			echo "<td>".$tp."</td>";
			echo "<td>".$fn."</td>";
			echo "</tr>";
			echo "<tr bgcolor=\"peachpuff\">";
			echo "<td><strong>Negative Class</strong></td>";
			echo "<td>".$fp."</td>";
			echo "<td>".$tn."</td>";
			echo "</tr>";
			echo "</table>";

			// echo "Total Benar " .$num_true . "<br>";
			// echo "TP " .$tp . "<br>";
			// echo "TN " .$tn . "<br>";
			// echo "<br>";
			// echo "Total Salah " . $num_false . "<br>";
			// echo "FP " .$fp . "<br>";
			// echo "FN " .$fn . "<br>";

			// update info di basis data
			$accuracy = ($num_true/$count_y_gold)*100;
			if (($tp + $fp) != 0) {
				$precision = ($tp/($tp + $fp))*100;
			}
			else {
				$precision = 0;	
			}
				
			if (($tp + $fn) != 0) {
				$recall = ($tp/($tp + $fn))*100;
			}
			else {
				$recall = 0;	
			}

			if (($recall != 0) and ($precision != 0)) {
				$f1_score = 2/((1/$recall) + (1/$precision));
			}
			else {
				$f1_score = 0;
			}
			
			$sql = "UPDATE origin_result SET `tester accuracy` = $accuracy, `tester precision` = $precision, `tester recall` = $recall, `tester f1-score` = $f1_score WHERE Uploadkey='$uploadKey'";

			if ($conn->query($sql) === TRUE) {
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
				$sql = "INSERT INTO origin_submission_logs(UploadKey, GroupName, filename, mime, size, updated, data, TesterAccuracy, TesterPrecision, TesterRecall, TesterF1Score) VALUES 
						('$uploadKey', '$namagrup', '$name', '$mime', '$size', '$sekarang','$string_input', '$accuracy', '$precision', '$recall', '$f1_score')";

				if ($conn->query($sql) === TRUE) {
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