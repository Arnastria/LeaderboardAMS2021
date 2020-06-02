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
			$getdata = "SELECT GroupName from marital_status_result where UploadKey = $uploadKey";
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
			$fp = fopen('temp_x2z/marital_status_gold_standar_tester.csv', 'r');
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
			$t4 = 0;
			$t3 = 0;
			$t2 = 0;
			$t1 = 0;
			$t0 = 0;
			$f43 = 0;
			$f42 = 0;
			$f41 = 0;
			$f40 = 0;
			$f34 = 0;
			$f32 = 0;
			$f31 = 0;
			$f30 = 0;
			$f24 = 0;
			$f23 = 0;
			$f21 = 0;
			$f20 = 0;
			$f14 = 0;
			$f13 = 0;
			$f12 = 0;
			$f10 = 0;
			$f04 = 0;
			$f03 = 0;
			$f02 = 0;
			$f01 = 0;
			$i = 0;
			
			while ( ($i < count($y_gold)) and ($i < count($y_pred))) {
				
				#echo "<br> asli ke - " .$i . "---" . $y_gold[$i]. "--" . $y_pred[$i] ." num true : " ;
				if (($y_gold[$i] == $y_pred[$i]) and (($y_gold[$i]) !== '-')) {
					// calculate TP 
					if ($y_gold[$i] == 4) {
						$t4++;
					}
					elseif ($y_gold[$i] == 3) {
						$t3++;
					}
					elseif ($y_gold[$i] == 2) {
						$t2++;
					}
					elseif ($y_gold[$i] == 1) {
						$t1++;
					}
					else {
						$t0++;
					}
					$num_true++;
				}
				elseif (($y_gold[$i] != $y_pred[$i]) and (($y_gold[$i]) !== '-')) {
					//calculate FP
					if ($y_gold[$i] == 4) {
						if ($y_pred[$i] == 3) {
							$f43++;	
						}
						elseif ($y_pred[$i] == 2) {
							$f42++;	
						}
						elseif ($y_pred[$i] == 1) {
							$f41++;	
						}
						else {
							$f40++;	
						}	
					}
					elseif ($y_gold[$i] == 3) {
						if ($y_pred[$i] == 4) {
							$f34++;	
						}
						elseif ($y_pred[$i] == 2) {
							$f32++;	
						}
						elseif ($y_pred[$i] == 1) {
							$f31++;	
						}
						else {
							$f30++;	
						}
					}
					elseif ($y_gold[$i] == 2) {
						if ($y_pred[$i] == 4) {
							$f24++;	
						}
						elseif ($y_pred[$i] == 3) {
							$f23++;	
						}
						elseif ($y_pred[$i] == 1) {
							$f21++;	
						}
						else {
							$f20++;	
						}
					}
					elseif ($y_gold[$i] == 1) {
						if ($y_pred[$i] == 4) {
							$f14++;	
						}
						elseif ($y_pred[$i] == 3) {
							$f13++;	
						}
						elseif ($y_pred[$i] == 2) {
							$f12++;	
						}
						else {
							$f10++;	
						}
					}
					else {
						if ($y_pred[$i] == 4) {
							$f04++;	
						}
						elseif ($y_pred[$i] == 3) {
							$f03++;	
						}
						elseif ($y_pred[$i] == 2) {
							$f02++;	
						}
						else {
							$f01++;	
						}
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
			echo "<td><strong>Prediction 0</strong></td>";
			echo "<td><strong>Prediction 1</strong></td>";
			echo "<td><strong>Prediction 2</strong></td>";
			echo "<td><strong>Prediction 3</strong></td>";
			echo "<td><strong>Prediction 4</strong></td>";
			echo "</tr>";
			echo "<tr bgcolor=\"peachpuff\">";
			echo "<td><strong> Actual 0</strong></td>";
			echo "<td>".$t0."</td>";
			echo "<td>".$f01."</td>";
			echo "<td>".$f02."</td>";
			echo "<td>".$f03."</td>";
			echo "<td>".$f04."</td>";
			echo "</tr>";
			echo "<tr bgcolor=\"peachpuff\">";
			echo "<td><strong>Actual 1</strong></td>";
			echo "<td>".$f10."</td>";
			echo "<td>".$t1."</td>";
			echo "<td>".$f12."</td>";
			echo "<td>".$f13."</td>";
			echo "<td>".$f14."</td>";
			echo "</tr>";
			echo "<tr bgcolor=\"peachpuff\">";
			echo "<td><strong>Actual 2</strong></td>";
			echo "<td>".$f20."</td>";
			echo "<td>".$f21."</td>";
			echo "<td>".$t2."</td>";
			echo "<td>".$f23."</td>";
			echo "<td>".$f24."</td>";
			echo "</tr>";
			echo "<tr bgcolor=\"peachpuff\">";
			echo "<td><strong>Actual 3</strong></td>";
			echo "<td>".$f30."</td>";
			echo "<td>".$f31."</td>";
			echo "<td>".$f32."</td>";
			echo "<td>".$t3."</td>";
			echo "<td>".$f34."</td>";
			echo "</tr>";
			echo "<tr bgcolor=\"peachpuff\">";
			echo "<td><strong>Actual 4</strong></td>";
			echo "<td>".$f40."</td>";
			echo "<td>".$f41."</td>";
			echo "<td>".$f42."</td>";
			echo "<td>".$f43."</td>";
			echo "<td>".$t4."</td>";
			echo "</tr>";
			echo "</table>";

			// echo "Total Benar " .$num_true . "<br>";
			// echo "TP " .$tp . "<br>";
			// echo "TN " .$tn . "<br>";
			// echo "<br>";
			// echo "Total Salah " . $num_false . "<br>";
			// echo "FP " .$fp . "<br>";
			// echo "FN " .$fn . "<br>";


			$accuracy = ($num_true/$count_y_gold)*100;
			$fp0 = $f01 + $f02 + $f03 + $f04;
			$fp1 = $f10 + $f12 + $f13 + $f14;
			$fp2 = $f20 + $f21 + $f23 + $f24;
			$fp3 = $f30 + $f31 + $f32 + $f34;
			$fp4 = $f40 + $f41 + $f42 + $f43;
			if (($t0+$t1+$t2+$t3+$t4) + ($fp0+$fp1+$fp2+$fp3+$fp4) != 0) {
				$precision = (($t0+$t1+$t2+$t3+$t4)/(($t0+$t1+$t2+$t3+$t4) + ($fp0+$fp1+$fp2+$fp3+$fp4)))*100;
			}
			else {
				$precision = 0;	
			}
			
			$fn0 = $f10 + $f20 + $f30 + $f40;
			$fn1 = $f01 + $f21 + $f31 + $f41;
			$fn2 = $f02 + $f12 + $f32 + $f42;
			$fn3 = $f03 + $f13 + $f23 + $f43;
			$fn4 = $f04 + $f14 + $f24 + $f34;	
			if ((($t0+$t1+$t2+$t3+$t4) + ($fn0+$fn1+$fn2+$fn3+$fn4)) != 0) {
				$recall = (($t0+$t1+$t2+$t3+$t4)/(($t0+$t1+$t2+$t3+$t4) + ($fn0+$fn1+$fn2+$fn3+$fn4)))*100;
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

			// update info di basis data
			$sql = "UPDATE marital_status_result SET `tester accuracy` = $accuracy, `tester precision` = $precision, `tester recall` = $recall, `tester f1-score` = $f1_score WHERE Uploadkey='$uploadKey'";

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
				$sql = "INSERT INTO marital_status_submission_logs(UploadKey, GroupName, filename, mime, size, updated, data, TesterAccuracy, TesterPrecision, TesterRecall, TesterF1Score) VALUES 
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