<?php
include("db_conf/db_conf.php");
?>

<?php
$remote_data = null;
$premises_id = null;

if ((isset($_GET['data'])) && (isset($_GET['premisesId'])) && (strpos($_GET['data'], '_') !== false)) {
    $remote_data = $_GET['data'];
    $premises_id = $_GET['premisesId'];
    

    list($id, $comp) = explode('_', $remote_data);


    $SQL = "SELECT * FROM premises WHERE ID='" . $premises_id . "'";
    if (mysql_num_rows(mysql_query($SQL)) == 0) {
        echo "Invalid premises ID. Please check your settings.";
        exit;
        }
        
    $SQL = "SELECT * FROM employees WHERE ID='" . $id . "'";
    if (mysql_num_rows(mysql_query($SQL)) == 0) {
        echo "ID Card no longer valid. Contact system administrator.";
        exit;
        }
}


if ($remote_data && $premises_id && $comp == md5("IDS_" . $id)) {
    $SQL = "SELECT * FROM employees WHERE ID='" . $id . "'";
    $RESULT = mysql_query($SQL);
    $EMPLOYEE_INFO = mysql_fetch_array($RESULT);
    
    $full_name = $EMPLOYEE_INFO['first_name'] . " " . $EMPLOYEE_INFO['last_name'];
    $gender = $EMPLOYEE_INFO['gender'];
    $department = $EMPLOYEE_INFO['department'];
    $photo = $EMPLOYEE_INFO['photo'];
    
    //check if employee has access to premises
    $SQL = "SELECT * FROM employees_has_premises WHERE `Employees_ID Number`='" . $id . "' AND `Premises_Premises ID`= $premises_id";
    if (mysql_num_rows(mysql_query($SQL)) > 0) {
        $allowed = true;
    } else {
        $allowed = false;
        }
        
        
    //prepare json 
    $json_data = array();
    
    $json_data['full_name'] = $full_name;
    $json_data['gender'] = $gender;
    $json_data['department'] = departmentIdToName($department);
    $json_data['photo'] = $photo;
    $json_data['allowed'] = $allowed;
    
    echo json_encode($json_data);
    
    //log to database
    if ($allowed) {
        $allowed = 1;
    } else {
        $allowed = 0;
        }
    $SQL = "INSERT INTO logs (EmployeeID, PremisesID, AccessDate, EntryAccess) VALUES ('";
    $SQL .= $id . "', '" . $premises_id . "', '" . date('Y-m-d H:i:s') . "', " . $allowed . ")";
    mysql_query($SQL);

} else {
    echo "Invalid QR Code. Please contact your system administrator.";
    }
function departmentIdToName($dept_id) {
    $SQL = "SELECT * FROM departments WHERE ID='" . $dept_id . "'";
    $ROW = mysql_fetch_array(mysql_query($SQL));
    return $ROW['Name'];
    }

?>