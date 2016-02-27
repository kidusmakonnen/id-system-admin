<html>
<head>
<title>Print ID</title>
</head>
<body>

<?php
foreach($_POST as $name => $value) {
	echo "Name: " . $name . " Value: " . $value . "<br />";
}
uploadPhoto();
function uploadPhoto() {
	mysql_connect('localhost', 'idsystem', 'idsystem');
	mysql_select_db('test');

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
?>



</body>
</html>
