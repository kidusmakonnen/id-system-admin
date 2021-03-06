<?php
include("db_conf/db_conf.php");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
<title>Add Personnel - ID System</title>
</head>
<body style='background-image:url("system_images/pattern.png");'>

<form action="print_id.php" method="POST" enctype="multipart/form-data">
<div id="main_controls">
	<div id="navigation_location">
        <a href="index.php" >Home</a> > Add Employee
    </div>
	<div id="form_controls">
        <h2>Add Personnel</h2>
		<div class="form_snippet">
			<fieldset>
				<legend>Personal Info</legend>
				<table>
					<tr>
						<td>First Name</td>
						<td><input type="text" size="30" name="first_name" required /></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input type="text" size="30" name="last_name" required /></td>
					</tr>
					<tr>
						<td>Birth Place</td>
						<td><input type="text" size="30" name="birth_place" required /></td>
					</tr>
					<tr>
						<td>Birth Date</td>
						<td><input type="date" size="10" placeholder="YYYY-MM-DD" name="birth_date" required /></td>
					</tr>
					<tr>
						<td>Sex</td>
						<td><input type="radio" name="gender" value="M" checked="checked" />Male 
						    <input type="radio" name="gender" value="F" />Female
						</td>
				</table>
			</fieldset>
		</div>
		<div class="form_snippet">
			<fieldset>
				<legend>Contact Info</legend>
				<table>
					<tr>
						<td>Home Phone</td>
						<td><input type="text" size="10" name="home_phone" /></td>
					</tr>
					<tr>
						<td>Mobile Phone</td>
						<td><input type="text" size="10" name="mobile_phone" /></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="email" size="30" name="email" required /></td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class="form_snippet">
			<fieldset>
				<legend>Professional Info</legend>
				<table>
					<tr>
						<td>Profession</td>
						<td><input type="text" size="30" name="profession" /></td>
					</tr>
					
					<tr>
						<td>Hired Department</td>
						<td>
                            <select name="department" required>
                            <?php
                                $SQL = "SELECT * FROM departments";
                                $RESULT = mysql_query($SQL);
                                while ($ROW = mysql_fetch_array($RESULT)) {
                                    echo "<option value='" . $ROW['ID'] . "'>" . $ROW['Name'] . "</option>";
                                    }
                            ?>
						</td>
					</tr>
					<tr>
						<td>Hired Date</td>
						<td>
							<input type="date" size="10" name="hired_date" placeholder="YYYY-MM-DD" />
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div clas="form_snippet">
			<fieldset>
				<legend>Member Photo</legend>
				<table>
					<tr>
						<!--<td>
							<img src="placeholder.jpg" alt="photo thumbnail" width="80px" height="80px" />
						</td> -->
						<td><input type="file" value="Upload Photo" id="upload_button" name="image" required/></td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class="form_snippet">
			<fieldset>
				<legend>Allowed Into</legend>

<?php
$SQL = "SELECT * FROM Premises";
$RESULT = mysql_query($SQL);

while ($row = mysql_fetch_array($RESULT)) {
	echo "<input type='checkbox' name='premises[]' value='" . $row['Name'] . "' /> " . $row['Name'] . "<br />";
}
?>
			</fieldset>
		</div>
		<input type="submit" value="Submit" />
	</div>
</div>
</form>
</body>
</html>
