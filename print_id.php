<html>
<head>
<title>Print ID</title>
</head>
<body>

<?php

$conn = mysql_connect('localhost', 'idsystem', 'idsystem');
mysql_select_db('test');

$SQL = "INSERT INTO employees values (";

$EMPLOYEE = mysql_fetch_array(mysql_query("SELECT ID FROM EMPLOYEES ORDER BY ID DESC LIMIT 0, 1"));
$EMPLOYEE_ID = $EMPLOYEE['ID'] + 1;

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
} else {
	echo "<h1>Something went wrong :(</h1>";
}

uploadPhoto($EMPLOYEE_ID);
function uploadPhoto($id) {
	
	$target_dir = "employee_photos/";
	$target_file = $target_dir . $id . "_" . basename($_FILES['image']['name']);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
		createID($id);
	} else {
		echo "<h1>Nope :(</h1>";
	}
}

function getNewImageFileName() {
	return basename($_FILES['image']['name']);
}

if (isset($_POST['premises'])) {
    $premises = $_POST['premises'];
    
    foreach ($premises as $i) {
        $SQL = "INSERT INTO employees_has_premises VALUES ('";
        $SQL .= $EMPLOYEE_ID . "', '" . premisesIdFromName($i) . "')";
        //echo $SQL;
        mysql_query($SQL);    
    }
    
}

function premisesIdFromName($name) {
    $SQL = "SELECT * FROM premises WHERE Name='" . $name . "'";
    echo $SQL;
    $PREMISES = mysql_fetch_array(mysql_query($SQL));
    return $PREMISES['ID'];
    }
    

function createID($id) {
	echo "<table>";
	echo "<tr><td>";
	echo "Name</td><td> Department </td></tr>"; 
	echo "<tr><td>" . $_POST['first_name'] . " " . $_POST['last_name'] . "</td>";
	echo "<td>" . $_POST['department'] . "</td></tr>";
	echo "<tr><td>Gender</td><td>Hired Date</td></tr>";
	echo "<tr><td>" . $_POST['gender'] . "</td><td>" . $_POST['hired_date'] . "</td></tr>";
	echo "<tr><td></td><td>"; 
	echo '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='. $id . '_' . md5('IDS_' . $id) . '" />';
	echo "</td></tr></table>";
}
?>



</body>
</html>
