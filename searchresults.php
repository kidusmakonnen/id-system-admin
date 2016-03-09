<?php
mysql_connect('localhost', 'idsystem', 'idsystem');
mysql_select_db('test');
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<title>Search Results</title>
<script>
$(document).ready(function(){
    $('.advanced_search').hide();  
    $(function() {
                $( ".datepicker" ).datepicker();
            });     
    $('#advanced_button').click(function() {
                $('.advanced_search').toggle("blind", {}, 500, callback);
                });
                
            function callback() {
                setTimeout(function() {
                $( "#effect:visible" ).removeAttr( "style" ).fadeOut();
                }, 1000 );
            };
            
          });
</script>

</head>
<body>

<div id="main_controls">
<div id="navigation_location">
<a href="index.php" >Home</a> > <a href="search.php">Search</a> > Search Results
</div>
<div id="search_tools">
<form method="POST" action="searchresults.php">
Search: <input type="text" name="query" size="70" /><br />
<p>
<div class="advanced_search">
<b>Advanced search:</b><br /><br />
Department:
<select name="department">
<option value='-1'>All</option>
<?php
    $SQL = "SELECT * FROM departments";
    $RESULT = mysql_query($SQL);
    while ($ROW = mysql_fetch_array($RESULT)) {
        echo "<option value='" . $ROW['ID'] . "'>" . $ROW['Name'] . "</option>";
    }
?>
    
</select><br />
Hiring Date:<br />From: <input type="text" class="datepicker" name="date_begin" />
To: <input type="text" class="datepicker" name="date_end" />
</div>
</p>
<input type="submit" value="Search"/>
<input type="button" id="advanced_button" value="Advanced Search"/>
</form>
</div>
<div id="search_results">
<?php
if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $date_begin = $date_end = 1970;
    $SQL = "SELECT * FROM employees WHERE (first_name like '%" . $query . "%' OR last_name like '%". $query . "%')";
    if (isset($_POST['department']) && $_POST['department'] != -1) {
        $SQL .= " AND department='" . $_POST['department'] . "'";
        }
    if (isset($_POST['date_begin'])) {
        $date_begin = date('Y-m-d H:i:s', strtotime($_POST['date_begin']));
        }
        
    if (isset($_POST['date_end'])) {
        $date_end = date('Y-m-d H:i:s', strtotime($_POST['date_end']));
        }
    
    if (date('Y', strtotime($date_begin)) != 1970 && date('Y', strtotime($date_begin)) != 1970) {
        $SQL .= " AND hired_date BETWEEN '" . $date_begin . "' AND '" . $date_end . "'";
        }
    $msc = microtime(true);
    $RESULT = mysql_query($SQL);
    $msc = round(microtime(true) - $msc, 4);
    $num_rows = mysql_num_rows($RESULT);
    if ($num_rows > 0) {
        if ($_POST['query'] != "") echo "<h3> Search for \"" . $_POST['query'] . "\"";
        else echo "<h3>Displaying All Employees";
        if (isset($_POST['department']) && $_POST['department'] != -1) echo " from " . departmentIdToName($_POST['department']) . " department";
        echo ". $num_rows results (" . $msc . " seconds)</h3>";
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
        if ($_POST['query'] == "") {
            echo "<h3>Employee Database Empty. <a href='add.php'>Click here</a> to add new employee.</h3>";
            } else {
        echo "<h3>No Results</h3>";
        }
        }
} 
    
function generateSearchResultItem($ROW) {
    echo "<div class='search_result_item'>";
    echo "<table>";
    echo "<tr>";
    echo "<td style='height:150px' rowspan='4'>";
    echo "<a href='display.php?employeeId=" . $ROW['ID'] . "'><img src='employee_photos/" . $ROW['photo'] . "' style='max-width:100%;max-height:100%'/></a>";
    echo "</td>";
    echo "<td>Name</td><td>Department</td>"; 
    echo "</tr>";
    echo "<tr>"; 
    echo "<td><b>" . $ROW['first_name'] . " " . $ROW['last_name'] . "</b></td>";
    echo "<td><b>" . departmentIdToName($ROW['department']) . "</b></td></tr>";
    echo "<tr>"; 
    echo "<td>Gender</td><td>Hired Date</td></tr>";
    echo "<tr><td><b>" . $ROW['gender'] . "</b></td><td><b>" . $ROW['hired_date'] . "</b></td></tr>";
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