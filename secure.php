<?PHP
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: *');
   header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
   require("utility/mysqli.class.php");
$config['db_host']      = "localhost";
$config['db_username']  = "root";
$config['db_password']  = "";
$config['db_name']      = "perfectforms";
$db = new db();
$newpassword = $_POST["new_password"];
$old_password = $_POST["old_password"];
$userid = $_POST["userid"];
$count = 0;

try {
	$count = $db->field("SELECT COUNT(id) FROM users WHERE id=".$userid." and password=".$old_password);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

if($count){
	$data["password"] = $newpassword;
	$data["update_at"] = date('Y-m-d H:i:s');
	$where["password"] = $old_password;
	$where["id"] = $userid;
	$db->update("users", $data, $where);
	$db->update("users", $data, $where);
	$dataresult['status'] = '1';
	$dataresult['count'] = $count;
	$dataresult['msg'] = 'Password updated successfully';
	echo json_encode($dataresult);
}else{
	$dataresult['status'] = '0';
	$dataresult['msg'] = 'Invalid Old Password';
	echo json_encode($dataresult);
}

?>