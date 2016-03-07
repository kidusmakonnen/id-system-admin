<html>
<head>
<title>Print ID</title>
</head>
<body>

<?php

$conn = mysql_connect('localhost', 'idsystem', 'idsystem');
mysql_select_db('test');

$SQL = "INSERT INTO employees values (";

$RESULT = mysql_query("SELECT ID FROM EMPLOYEES ORDER BY ID DESC LIMIT 0, 1");
if ($RESULT) {
    $EMPLOYEE = mysql_fetch_array($RESULT);
    $EMPLOYEE_ID = $EMPLOYEE['ID'] + 1;
} else {
    $EMPLOYEE_ID = 0;
}

$SQL .= $EMPLOYEE_ID . ",";
foreach($_POST as $name => $value) {
	if (!is_array($value)) {
		$SQL .= "'" . $value . "',";
	} else {
	}
}
$SQL .= "'" . getNewImageFileName() . "'";
$SQL .= ");";

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
        mysql_query($SQL);    
    }
    
}

function premisesIdFromName($name) {
    $SQL = "SELECT * FROM premises WHERE Name='" . $name . "'";
    $PREMISES = mysql_fetch_array(mysql_query($SQL));
    return $PREMISES['ID'];
    }
    

function createID($id) {
	echo "<table>";
	echo "<tr>";
	echo "<td><b>Name</b></td><td><b>Department</b></td>"; 
    echo "<td rowspan='4'>";
    echo "<img src='tmp_qr/tmp.png' />";
    echo "</td></tr>";
	echo "<tr>"; 
    echo "<td>" . $_POST['first_name'] . " " . $_POST['last_name'] . "</td>";
	echo "<td>" . $_POST['department'] . "</td></tr>";
	echo "<tr>"; 
    echo "<td><b>Gender</b></td><td><b>Hired Date</b></td></tr>";
	echo "<tr><td>" . $_POST['gender'] . "</td><td>" . $_POST['hired_date'] . "</td></tr>";
    
	echo "</table>";
}

function generateQR($id) {
    $id_to_encode = $id . '_' . md5('IDS_' . $id);
    include($_SERVER['DOCUMENT_ROOT'] . '/phpqrcode/qrlib.php');
    QRcode::png($id_to_encode, 'tmp_qr/tmp.png', 'QR_ECLEVEL_H', 4, 2 );
    }

?>



</body>
</html>
