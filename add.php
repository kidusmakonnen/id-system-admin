<html>
<head>
<title>Add Personnel - ID System</title>
</head>
<body>

<form action="print_id.php" method="POST" enctype="multipart/form-data">
<div id="main_controls">
	<div id="navigation_location">
	</div>
	<div id="form_controls">
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
						<td><input type="date" size="10" placeholder="MM/DD/YYYY" name="birth_date" required /></td>
					</tr>
					<tr>
						<td>Sex</td>
						<td><input type="radio" name="gender" value="m" checked="checked" />Male 
						    <input type="radio" name="gender" value="f" />Female
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
						<td>Experience</td>
						<td>
							<input type="number" name="experience" min='0' value='0'  />
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
							<input type="text" size="20" name="department" />
						</td>
					</tr>
					<tr>
						<td>Hired Date</td>
						<td>
							<input type="text" size="10" name="hired_date" placeholder="MM/DD/YYY" />
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
						<td><input type="file" value="Upload Photo" id="upload_button" name="image" /></td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class="form_snippet">
			<fieldset>
				<legend>Allowed Into</legend>
<?php
mysql_connect('localhost','idsystem','idsystem');
mysql_select_db('test');

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
