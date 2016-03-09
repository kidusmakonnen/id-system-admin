<?php
$conn = mysql_connect('localhost', 'idsystem', 'idsystem');
mysql_select_db('test');
if (isset($_GET['data'])) $remote_data = $_GET['data'];
if (isset($_GET['premisesId'])) $premises_id = $_GET['premisesId'];

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
} else {
    echo "Invalid QR Code. Please contact your system administrator and get a replacement.";
    }
function departmentIdToName($dept_id) {
    $SQL = "SELECT * FROM departments WHERE ID='" . $dept_id . "'";
    $ROW = mysql_fetch_array(mysql_query($SQL));
    return $ROW['Name'];
    }

?>