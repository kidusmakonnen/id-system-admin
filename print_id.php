<html>
<head>
<title>Print ID</title>
</head>
<body>

<?php

$conn = mysql_connect('localhost', 'idsystem', 'idsystem');
mysql_select_db('test');

$SQL = "INSERT INTO employees values (";

$EMPLOYEE_ID = mysql_num_rows(mysql_query("select * from employees")) + 1;
$SQL .= $EMPLOYEE_ID . ",";
foreach($_POST as $name => $value) {
	if (!is_array($value)) {
		$SQL .= "'" . $value . "',";
	} else {
	}
}
$SQL .= "'" . getNewImageFileName() . "'";
$SQL .= ");";
echo $SQL;

if (mysql_query($SQL)) {
	echo "<h1>Successfully Added</h1>";
	echo '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='. $EMPLOYEE_ID . '_' . md5('IDS_' . $EMPLOYEE_ID) . '" />';
} else {
	echo "<h1>Something went wrong :(</h1>";
}

uploadPhoto();
function uploadPhoto() {
	$SQL = "SELECT * FROM employees";
	$RESULT = mysql_query($SQL);

	$ROWS = mysql_num_rows($RESULT);

	$target_dir = "employee_photos/";
	$target_file = $target_dir . $ROWS . "_" . basename($_FILES['image']['name']);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
		echo "<h1>It worked :D</h1>";
	} else {
		echo "<h1>Nope :(</h1>";
	}
}

function getNewImageFileName() {
	return basename($_FILES['image']['name']);
}

function createID() {
	echo "<table>";
	echo "<tr><td>";
	echo "Name</td><td> Department </td></tr>"; 
	echo "<tr><td>" . $_POST['first_name'] . " " . $_POST['last_name'] . "</td>";
	echo "<td>" . $_POST['department'] . "</td></tr>";
	echo "<tr><td>Gender</td><td>Hired Date</td></tr>";
	echo "<tr><td>" . $_POST['gender'] . "</td><td>" . $_POST['hired_date'] . "</td></tr>";
	echo "<tr><td></td><td>"; 
	echo '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='. $EMPLOYEE_ID . '_' . md5('IDS_' . $EMPLOYEE_ID) . '" />';
	echo "</td></tr></table>";
?>



</body>
</html>
