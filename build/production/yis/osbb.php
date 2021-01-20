<?php
include_once './resources/osbb_config.php';

$key = "";
$results=array();
$content ="";
$adrec = "";

if    (isset($_GET['adrec']) && !empty($_GET['adrec'])) {
  $adrec = $_GET['adrec'];
  $_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YISGRAND');
  if ($_db->connect_error) {
      die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
  }
      $_db->set_charset("utf8");
      $sql_opl='CALL OSBB.infoApp("'.$adrec.'", @content, @success, @msg ,@email)';
      $result_opl = $_db->query($sql_opl) or die('Connect Error (' . $sql_opl . ') ' . $_db->connect_error);
      $result_opl_callback='SELECT @content,@success, @msg, @email ';
      $res_opl_callback = $_db->query($result_opl_callback) or die('Connect Error in (' .  $result_opl_callback . ') ' . $_db->connect_error);
	while ($res_row = $res_opl_callback->fetch_assoc()) {
	  $results['content'] = $res_row['@content'];
	  $results['success'] = $res_row['@success'];
	  $results['msg']	=$res_row['@msg'];
	  $results['email']	=$res_row['@email'];	  
	}
      if ($results['success'] == "1") {
	  $content = $results['content'];
      } 




} 
echo $results['content'];
?>
