<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anamedsos";

// Connect to the database
$dbLink = new mysqli($servername, $username, $password, $dbname);
if(mysqli_connect_errno()) {
    die("MySQL connection failed: ". mysqli_connect_error());
}
 
// Query for a list of all existing files
$sql = 'SELECT GroupName, UploadKey, filename, mime, size, data, updated, TesterAccuracy, TesterPrecision, TesterRecall, TesterF1Score FROM gender_submission_logs ORDER BY GroupName, updated DESC';
$result = $dbLink->query($sql);
 
// Check if it was successfull
if($result) {
    // Make sure there are some files in there
    if($result->num_rows == 0) {
        echo '<p>There are no files in the database</p>';
    }
    else {
        // Print the top of a table		
        echo '<table width="100%" border="1">
                <tr>
                    <td><b>Group Name</b></td>
					<td><b>FileName</b></td>
                    <td><b>Mime</b></td>
                    <td><b>Size (bytes)</b></td>
                    <td><b>Created</b></td>
					<td><b>Accuracy<b></td>
					<td><b>Precision<b></td>
					<td><b>Recall<b></td>
                    <td><b>F1-Score</b></td>
                </tr>';
 
        // Print each file
        while($row = $result->fetch_assoc()) {
			$groupName = $row['GroupName'];
			$waktu = $row['updated'];
            echo "
                <tr>
					<td>{$row['GroupName']}</td>
                    <td>{$row['filename']}</td>
                    <td>{$row['mime']}</td>
                    <td>{$row['size']}</td>
                    <td>{$row['updated']}</td>
					<td>{$row['TesterAccuracy']}</td>
					<td>{$row['TesterPrecision']}</td>
					<td>{$row['TesterRecall']}</td>
					<td>{$row['TesterF1Score']}</td>
					<td>
					<a href='download_gender.php?id=$groupName&updated=$waktu'>
					Download
					</a>
					</td>
                    
                </tr>";
        }
 
        // Close table
        echo '</table>';
    }
 
    // Free the result
    $result->free();
}
else
{
    echo 'Error! SQL query failed:';
    echo "<pre>{$dbLink->error}</pre>";
}
 
// Close the mysql connection
$dbLink->close();
?>