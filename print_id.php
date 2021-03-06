<?php
include("db_conf/db_conf.php");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
<title>Print ID</title>
</head>
<body>

<?php

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
$SQL .= "'" . getNewImageFileName($EMPLOYEE_ID) . "'";
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

function getNewImageFileName($id) {
	return $id . '_' . basename($_FILES['image']['name']);
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
	echo "<table id='id_card'>";
	echo "<tr>";
	echo "<td><b>Name</b></td><td><b>Department</b></td>"; 
    echo "<td rowspan='4'>";
    generateQR($id);
    echo "<img src='tmp_qr/tmp.png' />";
    echo "</td></tr>";
	echo "<tr>"; 
    echo "<td>" . $_POST['first_name'] . " " . $_POST['last_name'] . "</td>";
	echo "<td>" . departmentIdToName($_POST['department']) . "</td></tr>";
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
    
    
function departmentIdToName($dept_id) {
    $SQL = "SELECT * FROM departments WHERE ID='" . $dept_id . "'";
    $ROW = mysql_fetch_array(mysql_query($SQL));
    return $ROW['Name'];
    }

?>
<div>
<br /> <br />
<form method="GET" action="add.php"/>
<input type="submit" value="Add Another Employee"/>
</form>
<form method="GET" action="index.php"/>
<input type="submit" value="Go Home" />
</form>
</div>


</body>
</html>
