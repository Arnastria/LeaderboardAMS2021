<?php
if ( isset($_POST["submit"]) and isset($_POST["uploadkey"])) {
	if ( isset($_FILES["file"])) {
		//if there was an error uploading the file
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		} else {
			//Print file details
			echo "<h2>.:Informasi:.</h2>";
			echo "Uploaded File: " . $_FILES["file"]["name"] . "<br />";
			echo "Type: " . $_FILES["file"]["type"] . "<br />";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " KB<br />";
			//echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

			if (($_FILES["file"]["size"] / 1024) > 1000.) {
				die("Failed! Maximum file size is 1MB.");
			}

			//if file already exists
			if (file_exists("upload/" . $_FILES["file"]["name"])) {
				echo $_FILES["file"]["name"] . " already exists. ";
			} else {
				//Store file in directory "upload" with the name of "uploaded_file.txt"
				//$storagename = "uploaded_file.txt";
				//move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);
				//echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";

				//directly processed, before saved
				$fp = fopen($_FILES['file']['tmp_name'], 'r');
				$y_pred = array();
				$i = 0;
				while ( ($line = fgetcsv($fp,1000,",")) !== false) {
					
					#if ($i == 1) { continue; }
					
					$id_pred[$i] = $line[0];
					$y_pred[$i] = $line[1];	
					$i++;
				}
				fclose($fp);
				
				#echo "count y_pred " . count($y_pred) . "<br>";
				//load gold standard data
				$fp = fopen('temp_x2z/gold_standar.csv', 'r');
				$y_gold = array();
				$i = 0;
				while ( ($line = fgetcsv($fp,1000,",")) !== false) {
					
					
					$id_gold[$i] = $line[0];
					$y_gold[$i] = $line[1];	
					$i++;
				}
				fclose($fp);
				#echo "count y_gold " . count($y_gold) . "<br>";
				
				
				
				//compute the accuracy score
				
				
				$num_true = 0;
				$i = 0;
				
				
				while ( ($i < count($y_gold)) and ($i < count($y_pred))) {
					
					#echo "<br> asli ke - " .$i . "---" . $y_gold[$i]. "--" . $y_pred[$i] ." num true : " ;
					if (($y_gold[$i] == $y_pred[$i]) and (($y_gold[$i]) !== '-')) {
						#echo $num_true . " <br>";
						$num_true++;
					}
					$i++;
					
				}
				
				#jumlah y_gold yang tidak null
				
				#$count_y_gold = array_count_values($y_gold);
				
				
				#echo " Total Kosong ". $empty_gold;
				#echo " Total Gold Standar " . $count_y_gold;
		
				echo "Total Benar " .$num_true . "<br>";
				
				//update info di basis data
				$uploadKey = $_POST["uploadkey"];
				$accuracy = $num_true/10;

				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "anamedsos";

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);

				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$sql = "UPDATE result SET accuracy=$accuracy WHERE Uploadkey='$uploadKey'";

				if ($conn->query($sql) === TRUE) {
					//echo "Record updated successfully";
				} else {
					die("Error updating record: " . $conn->error);
				}

				$conn->close();

				echo "<strong>Accuracy: " . $accuracy . "</strong>";
				echo "<br/><br/>*jika terjadi error terkait 'mysql', coba unggah sekali lagi.";
				echo "<br/><br/><a href='index.php'>See Current Rankings</a>";
				
            }
        }
	} else {
		echo "No file selected <br />";
	}
}
?>