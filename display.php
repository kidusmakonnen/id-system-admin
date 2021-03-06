<?php
include("db_conf/db_conf.php");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
<title>Display Personnel - ID System</title>
</head>
<body style='background-image:url("system_images/pattern.png");'>

<div id="main">
<div id="navigation_location">
<a href="index.php" >Home</a> > <a href="search.php">Search</a>  > Display
</div>
<?php

if (isset($_POST['delete'])) {
    $SQL = "DELETE FROM employees_has_premises WHERE `Employees_ID Number`='" . $_POST['employeeId'] . "'";
    if (mysql_query($SQL)) {
        $SQL = "DELETE FROM employees WHERE ID='" . $_POST['employeeId'] . "'";
        if (mysql_query($SQL)) {
            header("Location: index.php");
            }
        }
}

?>


<?php

if (isset($_GET['employeeId'])) {
    $id = $_GET['employeeId'];
    $SQL = "SELECT * FROM employees WHERE ID='" . $id . "'";
    $RESULT = mysql_query($SQL);
    if (!$RESULT || mysql_num_rows($RESULT) == 0) {
        echo "<h1>Employee record not found!</h1>";
        exit;
        }
    else {
    $ROW = mysql_fetch_array($RESULT);
    echo "<h1>Employee Information of " . $ROW['first_name'] . " " . $ROW['last_name'] . "</h1>";    
echo <<< EOT
<table class='info_section'>
<tr>
<td>First Name: $ROW[first_name]</td>
<td style='height:200px' rowspan='5'><img src='employee_photos/$ROW[photo]' style='max-height:100%; max-width:100%'></td>
</tr>
<tr>
<td>Last Name: $ROW[last_name]</td>
</tr>
<tr>
<td>Birth Place: $ROW[birth_place]</td>
</tr>
<tr>
<td>Birth Date: $ROW[birth_date]</td>
</tr>
<tr>
<td>Gender: $ROW[gender]</td>
</tr>
<tr>
<td>Home Phone: $ROW[home_phone]</td>
</tr>
<tr>
<td>Mobile Phone: $ROW[mobile_phone]</td>
</tr>
<tr>
<td>Email: $ROW[email]</td>
</tr>
<tr>
<td>Profession: $ROW[profession]</td>
</tr>

<tr>
EOT;

echo "<td>Hired Department: " . departmentIdToName($ROW['department']) . "</td>";
echo <<< EOT
</tr>
</tr>
<tr>
<td>Hired Date: $ROW[hired_date]</td>
</tr>
</table>
EOT;
}
}
function departmentIdToName($dept_id) {
    $SQL = "SELECT * FROM departments WHERE ID='" . $dept_id . "'";
    $ROW = mysql_fetch_array(mysql_query($SQL));
    return $ROW['Name'];
    }
?>
<form action="edit.php" method="GET">
<input type="submit" value="Edit Employee Information"/>
<?php echo "<input type='hidden' value='" . $ROW['ID'] . "' name='employeeId'/>"; ?>
</form>
<form action="" method="POST">
<?php echo "<input type='hidden' value='" . $ROW['ID'] . "' name='employeeId'/>"; ?>
<input type="submit" value="Delete Employee Information" name="delete"/>
</form>
<form action="reprint_id.php" method="POST">
<?php echo "<input type='hidden' value='" . $ROW['ID'] . "' name='employeeId'/>"; ?>
<input type="submit" value="Re-print ID Card" />
</form>

</div>
</body>
</html>
