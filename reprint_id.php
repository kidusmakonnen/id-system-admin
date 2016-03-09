<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="navigation_location">
<a href="index.php">Home</a>
</div>
<?php
mysql_connect('localhost','idsystem','idsystem');
mysql_select_db('test');

if (isset($_POST['employeeId'])) {
    $id = $_POST['employeeId'];
    $SQL = "SELECT * FROM employees WHERE ID='" . $id . "'";
    $ROW = mysql_fetch_array(mysql_query($SQL));
    
    createID($id, $ROW);
    
   }

function createID($id, $ROW) {
	echo "<table id='id_card'>";
	echo "<tr>";
	echo "<td><b>Name</b></td><td><b>Department</b></td>"; 
    echo "<td rowspan='4'>";
    generateQR($id);
    echo "<img src='tmp_qr/tmp.png' />";
    echo "</td></tr>";
	echo "<tr>"; 
    echo "<td>" . $ROW['first_name'] . " " . $ROW['last_name'] . "</td>";
	echo "<td>" . departmentIdToName($ROW['department']) . "</td></tr>";
	echo "<tr>"; 
    echo "<td><b>Gender</b></td><td><b>Hired Date</b></td></tr>";
	echo "<tr><td>" . $ROW['gender'] . "</td><td>" . $ROW['hired_date'] . "</td></tr>";
    
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
</body>
</html>