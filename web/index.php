<?php

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

$sql = "select * from gender_result order by `tester accuracy` desc";
$result_gender = $conn->query($sql);

$sql = "select * from origin_result order by `tester accuracy` desc";
$result_origin = $conn->query($sql);

$sql = "select * from ethnic_group_result order by `tester accuracy` desc";
$result_ethnic_group = $conn->query($sql);

$sql = "select * from marital_status_result order by `tester accuracy` desc";
$result_marital_status = $conn->query($sql);
?>

<center>
<h2>Tugas Proyek Text Analytics Analitika Media Sosial</h2>
<h3>Demographics Prediction on Twitter Data</h3>
<p>Submission dibuka sampai Sabtu, 20 Juni 2020, pukul 22.00</p>
<hr>
<h4>Gender Prediction</h4>
<table width="1000">
	<tr>
		<td><strong>Ranking</strong></td>
		<td><strong>Group Name</strong></td>
		<td><strong>Tester Accuracy (%)</strong></td>
		<td><strong>Tester Precision (%)</strong></td>
		<td><strong>Tester Recall (%)</strong></td>
		<td><strong>Tester F1-Score (%)</strong></td>
	</tr>
<?php
	// output data of each row
	$i = 1;
	while($row = $result_gender->fetch_assoc()) {
		echo "<tr bgcolor=\"pink\">";
		echo "<td>".$i."</td>";
		echo "<td>".$row["Groupname"]."</td>";
		echo "<td>".($row["Tester Accuracy"])."</td>";
		echo "<td>".($row["Tester Precision"])."</td>";
		echo "<td>".($row["Tester Recall"])."</td>";
		echo "<td>".($row["Tester F1-Score"])."</td>";
		echo "</tr>";
		$i++;
	}
?>
</table>

<br>
Submit your test result here: <br>
(*upload file berekstensi csv dengan delimiter koma berisi id dan hasil prediksi <strong>tanpa header</strong>)
<table width="1000">
	<form action="upload_gender.php" method="post" enctype="multipart/form-data">
		<tr>
			<td width="20%">Select file</td>
			<td width="80%"><input type="file" name="file" id="file" /></td>
		</tr>
		<tr>
			<td width="20%">Upload key</td>
			<td><input type="text" name="uploadkey" /></td>
		</tr>
		<tr>
			<td>Submit</td>
			<td><input type="submit" name="submit" /></td>
		</tr>
	</form>
</table>
<hr>
<h4>Origin Prediction</h4>
<table width="1000">
	<tr>
		<td><strong>Ranking</strong></td>
		<td><strong>Group Name</strong></td>
		<td><strong>Tester Accuracy (%)</strong></td>
		<td><strong>Tester Precision (%)</strong></td>
		<td><strong>Tester Recall (%)</strong></td>
		<td><strong>Tester F1-Score (%)</strong></td>
	</tr>
<?php
	// output data of each row
	$i = 1;
	while($row = $result_origin->fetch_assoc()) {
		echo "<tr bgcolor=\"yellow\">";
		echo "<td>".$i."</td>";
		echo "<td>".$row["Groupname"]."</td>";
		echo "<td>".($row["Tester Accuracy"])."</td>";
		echo "<td>".($row["Tester Precision"])."</td>";
		echo "<td>".($row["Tester Recall"])."</td>";
		echo "<td>".($row["Tester F1-Score"])."</td>";
		echo "</tr>";
		$i++;
	}
?>
</table>

<br>
Submit your test result here: <br>
(*upload file berekstensi csv dengan delimiter koma berisi id dan hasil prediksi <strong>tanpa header</strong>)
<table width="1000">
	<form action="upload_origin.php" method="post" enctype="multipart/form-data">
		<tr>
			<td width="20%">Select file</td>
			<td width="80%"><input type="file" name="file" id="file" /></td>
		</tr>
		<tr>
			<td width="20%">Upload key</td>
			<td><input type="text" name="uploadkey" /></td>
		</tr>
		<tr>
			<td>Submit</td>
			<td><input type="submit" name="submit" /></td>
		</tr>
	</form>
</table>
<hr>
<h4>Ethnic Group Prediction</h4>
<table width="1000">
	<tr>
		<td><strong>Ranking</strong></td>
		<td><strong>Group Name</strong></td>
		<td><strong>Tester Accuracy (%)</strong></td>
		<td><strong>Tester Precision (%)</strong></td>
		<td><strong>Tester Recall (%)</strong></td>
		<td><strong>Tester F1-Score (%)</strong></td>
	</tr>
<?php
	// output data of each row
	$i = 1;
	while($row = $result_ethnic_group->fetch_assoc()) {
		echo "<tr bgcolor=\"lightgreen\">";
		echo "<td>".$i."</td>";
		echo "<td>".$row["Groupname"]."</td>";
		echo "<td>".($row["Tester Accuracy"])."</td>";
		echo "<td>".($row["Tester Precision"])."</td>";
		echo "<td>".($row["Tester Recall"])."</td>";
		echo "<td>".($row["Tester F1-Score"])."</td>";
		echo "</tr>";
		$i++;
	}
?>
</table>

<br>
Submit your test result here: <br>
(*upload file berekstensi csv dengan delimiter koma berisi id dan hasil prediksi <strong>tanpa header</strong>)
<table width="1000">
	<form action="upload_ethnic_group.php" method="post" enctype="multipart/form-data">
		<tr>
			<td width="20%">Select file</td>
			<td width="80%"><input type="file" name="file" id="file" /></td>
		</tr>
		<tr>
			<td width="20%">Upload key</td>
			<td><input type="text" name="uploadkey" /></td>
		</tr>
		<tr>
			<td>Submit</td>
			<td><input type="submit" name="submit" /></td>
		</tr>
	</form>
</table>
<hr>
<h4>Marital Status Prediction</h4>
<table width="1000">
	<tr>
		<td><strong>Ranking</strong></td>
		<td><strong>Group Name</strong></td>
		<td><strong>Tester Accuracy (%)</strong></td>
		<td><strong>Tester Precision (%)</strong></td>
		<td><strong>Tester Recall (%)</strong></td>
		<td><strong>Tester F1-Score (%)</strong></td>
	</tr>
<?php
	// output data of each row
	$i = 1;
	while($row = $result_marital_status->fetch_assoc()) {
		echo "<tr bgcolor=\"lightblue\">";
		echo "<td>".$i."</td>";
		echo "<td>".$row["Groupname"]."</td>";
		echo "<td>".($row["Tester Accuracy"])."</td>";
		echo "<td>".($row["Tester Precision"])."</td>";
		echo "<td>".($row["Tester Recall"])."</td>";
		echo "<td>".($row["Tester F1-Score"])."</td>";
		echo "</tr>";
		$i++;
	}
?>
</table>

<br>
Submit your test result here: <br>
(*upload file berekstensi csv dengan delimiter koma berisi id dan hasil prediksi <strong>tanpa header</strong>)
<table width="1000">
	<form action="upload_marital_status.php" method="post" enctype="multipart/form-data">
		<tr>
			<td width="20%">Select file</td>
			<td width="80%"><input type="file" name="file" id="file" /></td>
		</tr>
		<tr>
			<td width="20%">Upload key</td>
			<td><input type="text" name="uploadkey" /></td>
		</tr>
		<tr>
			<td>Submit</td>
			<td><input type="submit" name="submit" /></td>
		</tr>
	</form>
</table>
<hr>
</center>
<?php

$conn->close();

?>