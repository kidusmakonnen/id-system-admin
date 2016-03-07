<?php
mysql_connect('localhost', 'idsystem', 'idsystem');
mysql_select_db('test');
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>

<div id="main_controls">
<div id="search_tools">
<form method="POST" action="searchresults.php">
Search: <input type="text" name="query" size="70" />
<div id="advanced_search">
Department:
<select name="department">
    <option>Sth</option>
</select><br />
Hiring Date:<br />From: <input type="date" class="datepicker" name="date_from" />
To: <input type="date" class="datepicker" name="date_to" />
</div>
<input type="submit" value="Search"/>
<input type="button" value="Advanced Search"/>
</form>
</div>
<div id="search_results">
<?php
if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $SQL = "SELECT * FROM employees WHERE first_name like '%" . $query . "%' OR last_name like '%". $query . "%'";
    $RESULT = mysql_query($SQL);
    echo "<h3> Search Results</h3>";
    echo "<table>";
    $counter = 0;
    while ($ROW = mysql_fetch_array($RESULT)) {
        if (($counter % 2) == 0) echo "<tr>";
        echo "<td>";
        generateSearchResultItem($ROW);
        echo "</td>";
        $counter++;
        if (($counter % 2) == 0) echo "</tr>";
        }
     echo "</table>";
} else {
    echo "<h3>Eh</h3>";
    }
    
function generateSearchResultItem($ROW) {
    echo "<div class='search_result_item'>";
    echo "<table>";
    echo "<tr>";
    echo "<td rowspan='4'>";
    echo "<a href='display.php?employeeId=" . $ROW['ID'] . "'><img src='employee_photos/" . $ROW['photo'] . "' height='20%'/></a>";
    echo "</td>";
    echo "<td><b>Name</b></td><td><b>Department</b></td>"; 
    echo "</tr>";
    echo "<tr>"; 
    echo "<td>" . $ROW['first_name'] . " " . $ROW['last_name'] . "</td>";
    echo "<td>" . departmentIdToName($ROW['department']) . "</td></tr>";
    echo "<tr>"; 
    echo "<td><b>Gender</b></td><td><b>Hired Date</b></td></tr>";
    echo "<tr><td>" . $ROW['gender'] . "</td><td>" . $ROW['hired_date'] . "</td></tr>";
    echo "</table>";
    echo "</div>"; 
}

function departmentIdToName($dept_id) {
    $SQL = "SELECT * FROM departments WHERE ID='" . $dept_id . "'";
    $ROW = mysql_fetch_array(mysql_query($SQL));
    return $ROW['Name'];
    }
?>
</div>
</div>

</body>
</html>