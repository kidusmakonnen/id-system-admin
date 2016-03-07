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
<?php
    if (isset($_GET['employeeId'])) {
        $SQL = "SELECT * FROM employees WHERE ID='" . $_GET['employeeId'] . "'";
        $ROW = mysql_fetch_array(mysql_query($SQL));
echo <<< EOT
<form action='print_id.php' method='POST' enctype='multipart/form-data'>
<div id='main_controls'>
	<div id='navigation_location'>
	</div>
	<div id='form_controls'>
        <h2>Add Personnel</h2>
		<div class='form_snippet'>
			<fieldset>
				<legend>Personal Info</legend>
				<table>
					<tr>
						<td>First Name</td>
						<td><input type='text' size='30' name='first_name' value=$ROW[first_name] /></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input type='text' size='30' name='last_name' value=$ROW[last_name] /></td>
					</tr>
					<tr>
						<td>Birth Place</td>
						<td><input type='text' size='30' name='birth_place' value=$ROW[birth_place] /></td>
					</tr>
					<tr>
						<td>Birth Date</td>
						<td><input type='date' size='10' placeholder='MM/DD/YYYY' name='birth_date' value=$ROW[birth_date] /></td>
					</tr>
					<tr>
						<td>Sex</td>
						<td><input type='radio' name='gender' value='m' checked='checked' />Male 
						    <input type='radio' name='gender' value='f' />Female
						</td>
				</table>
			</fieldset>
		</div>
		<div class='form_snippet'>
			<fieldset>
				<legend>Contact Info</legend>
				<table>
					<tr>
						<td>Home Phone</td>
						<td><input type='text' size='10' name='home_phone' value=$ROW[home_phone] /></td>
					</tr>
					<tr>
						<td>Mobile Phone</td>
						<td><input type='text' size='10' name='mobile_phone' value=$ROW[mobile_phone]/></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type='email' size='30' name='email' value=$ROW[email] /></td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class='form_snippet'>
			<fieldset>
				<legend>Professional Info</legend>
				<table>
					<tr>
						<td>Profession</td>
						<td><input type='text' size='30' name='profession' value=$ROW[profession] /></td>
					</tr>
					<tr>
						<td>Experience</td>
						<td>
							<input type='number' name='experience' min='0' value='0'  />
							<select>
								<option>Year(s)</option>
								<option>Month(s)</option>
								<option>Day(s)</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Hired Department</td>
						<td>
                            <select name='department' >
EOT;
                            
                                $DEPT_SQL = "SELECT * FROM departments";
                                $DEPT_RESULT = mysql_query($DEPT_SQL);
                                while ($DEPT_ROW = mysql_fetch_array($DEPT_RESULT)) {
                                    if ($DEPT_ROW['ID'] == $ROW['department']) {
                                        echo "<option value='" . $DEPT_ROW['ID'] . "' selected>" . $DEPT_ROW['Name'] . "</option>";
                                        } else {
                                        echo "<option value='" . $DEPT_ROW['ID'] . "'>" . $DEPT_ROW['Name'] . "</option>";
                                    }
                                    }
                            
echo <<< EOT
						</td>
					</tr>
					<tr>
						<td>Hired Date</td>
						<td>
							<input type='date' size='10' name='hired_date' placeholder='MM/DD/YYY'  value='$ROW[hired_date]'/>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div clas='form_snippet'>
			<fieldset>
				<legend>Member Photo</legend>
				<table>
					<tr>
						<!--<td>
							<img src="placeholder.jpg" alt="photo thumbnail" width="80px" height="80px" />
						</td> -->
						<td><input type='file' value='Upload Photo' id='upload_button' name='image' required/></td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class='form_snippet'>
			<fieldset>
				<legend>Allowed Into</legend>
EOT;

$SQL = "SELECT * FROM Premises";
$RESULT = mysql_query($SQL);

while ($premises_row = mysql_fetch_array($RESULT)) {
    $PREMISES_SQL = "SELECT * FROM employees_has_premises WHERE `Employees_ID Number`='" . $ROW['ID'] . "' AND ";
    $PREMISES_SQL .= "`Premises_Premises ID`='" . $premises_row['ID'] . "'";
    if (mysql_num_rows(mysql_query($PREMISES_SQL)) > 0) {
        echo "<input type='checkbox' name='premises[]' value='" . $premises_row['Name'] . "' checked='checked'/> " . $premises_row['Name'] . "<br />";
    } else {
        echo "<input type='checkbox' name='premises[]' value='" . $premises_row['Name'] . "' /> " . $premises_row['Name'] . "<br />";
        }
}

echo <<< EOT
			</fieldset>
		</div>
		<input type="submit" value="Save Changes" />
	</div>
</div>
EOT;
}

?>
</form>
</body>
</html>
