<?php
include_once 'ipay.class.php';
include_once 'yis_config.php';
include_once 'XmlToArray.php';



try {
if    (isset($_POST['xml']) && !empty($_POST['xml'])) {//код подтверждения 
			$code = $_POST['xml'];
			// ==================== XML TO ARRAY
			$xmlresult = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $code );
			$array = XML2Array::createArray($xmlresult);
			$paym = $array['payment'];
			$pid = $paym['@attributes']['id'];
			$pstatus = $paym['status'];
			$psalt = $paym['salt'];
			$psign = $paym['sign'];


			$iPay = new iPay(  MID , MKEY ,SKEY );
			$iPay->set_urls('https://yis.yuzhny.com/kommuna/php','https://is.yuzhny.com/is/');
			if ($iPay->check_sign($psalt,$psign)) { 

			  if ($pstatus == 5) {

					$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YIS');		
								if ($_db->connect_error) {
						die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
					}
					$_db->set_charset("utf8");
    

					$sql='SELECT count(YIS.PAYMENT.`payment_id`) as cnt	FROM YIS.PAYMENT 	WHERE '
								.' YIS.PAYMENT.`pay_id`="'.$pid.'" AND '
								.' YIS.PAYMENT.`status`<> 5  AND '
								.' YIS.PAYMENT.`salt`="'.$psalt.'" AND '
								.' YIS.PAYMENT.`sign`="'.$psign.'" ';

					$result = $_db->query($sql) or die('Connect Error in  (' .  $sql . ') ' . $_db->connect_error);
					$row_cnt = $result->num_rows;
					if ($row_cnt > 0 ) {
									$_sql_update='UPDATE YIS.PAYMENT SET YIS.PAYMENT.`status` = "'.$pstatus.'" WHERE  '
								.' YIS.PAYMENT.`pay_id`="'.$pid.'" AND '
								.' YIS.PAYMENT.`salt`="'.$psalt.'" AND '
								.' YIS.PAYMENT.`sign`="'.$psign.'" LIMIT 1';
										$_result = $_db->query($_sql_update) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
										$rows=mysqli_affected_rows($_db);
									if ($rows > 0 ) {
														$sql_opl='CALL YISGRAND.OplataPaymentApp("'.$pid.'", @success, @msg)';
														$result_opl = $_db->query($sql_opl) or die('Connect Error (' . $sql_opl . ') ' . $_db->connect_error);				    
														$result_opl_callback='SELECT @success, @msg';
														$res_opl_callback = $_db->query($result_opl_callback) or die('Connect Error in (' .  $result_opl_callback . ') ' . $_db->connect_error);										
														while ($res_row = $res_opl_callback->fetch_assoc()) {
															$results['success'] = $res_row['@success'];
															$results['msg']	=$res_row['@msg'];
														}	
																if ($results['success'] == "1") {
																		echo '200';
																}

									}else{
											throw new Exception('Ошибка!');
									}
					}else{
						throw new Exception('Ошибка!');
					}
			} else {
					throw new Exception('Ошибка!');
			}

		 } else {     
		throw new Exception('Ошибка!');
		}

} else {     
		throw new Exception('Ошибка!');
		}
}

		  
		  

?>