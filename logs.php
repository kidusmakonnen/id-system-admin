<?php
include("db_conf/db_conf.php");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
<title>Logs</title>
</head>
<body>
<div id="main_content">
<div id="navigation_location">
<a href="index.php">Home</a>
</div>

<h3>ID System Entry Access Log</h3>

<table id="logs" border=1>
<tr>
    <th>Log No.</th>
    <th>Employee Name</th>
    <th>Premises</th>
    <th>Access Date</th>
    <th>Entry Access</th>
</tr>
<?php
$SQL = "SELECT * FROM logs ORDER BY AccessDate ASC";
$RESULT = mysql_query($SQL);
while ($ROW = mysql_fetch_array($RESULT)) {
    echo "<tr><td>" . $ROW['ID'] . "</td>";
    echo "<td>" . employeeNameFromId($ROW['EmployeeID']) . "</td>";
    echo "<td>" . premisesNameFromId($ROW['PremisesID']) . "</td>";
    echo "<td>" . $ROW['AccessDate'] . "</td>";
    echo "<td>" . styledEntryAccess($ROW['EntryAccess']) . "</td></tr>";
    }
    
    
function employeeNameFromId($id) {
    $ROW = mysql_fetch_array(mysql_query("SELECT * FROM employees WHERE ID='" . $id . "'"));
    $full_name = $ROW['first_name'] . " " . $ROW['last_name'];
    if (trim($full_name) == "") {
        return "<span style='color:#999;'><strike>Employee Info Deleted</strike></span>";
    } else {
        return "<a href='display.php?employeeId=" . $id . "'>" . $full_name . "</a>";
    }
}
    
function premisesNameFromId($id) {
    $ROW = mysql_fetch_array(mysql_query("SELECT * FROM premises WHERE ID='" . $id . "'"));
    return $ROW['Name'];
    }
    
function styledEntryAccess($x) {
    if ($x == 0) {
        return "<span style='color:red; font-weight:bold;'>Access Denied</span>";
    } else {
        return "<span style='color:green;font-weight:bold;'>Access Granted</span>";
        }
}
?>
</table>
</div>
</body>
</html>