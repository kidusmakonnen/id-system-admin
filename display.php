<?php
mysql_connect('localhost','idsystem','idsystem');
mysql_select_db('test');
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
<title>Add Personnel - ID System</title>
</head>
<body style='background-image:url("system_images/pattern.png");'>

<div id="main">
<div id="navigation_location">
<a href="index.php" >Home</a> > <a href="search.php">Search</a>  > Display
</div>
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
<td rowspan='5'><img src='employee_photos/$ROW[photo]' height='30%'></td>
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
<td>Hired Department: $ROW[department]</td>
</tr>
<tr>
<td>Hired Date: $ROW[hired_date]</td>
</tr>
</table>
EOT;
}
}
?>
<form action="edit.php" method="GET">
<input type="submit" value="Edit Employee Information"/>
<?php echo "<input type='hidden' value='" . $ROW['ID'] . "' name='employeeId'/>"; ?>
</form>
</div>
</body>
</html>
