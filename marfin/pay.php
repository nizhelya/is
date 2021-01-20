<?php
include_once 'pay_config.php';
include_once 'XmlToArray.php';

header('Content-Type: application/octet-stream');


function create_sign($id) {
		
		$response = hash_hmac( 'sha512' , SKEY , $id );
		
		return $response;
		
	}

function check_sign($psalt,$sign ) {

		return ( hash_hmac( 'sha512' , SKEY , $sign ) == $psalt );

	}
$kod = 1;
$commission = 0;
$sum= 0;

$now_date = strtotime(date("Y-m-d")); // Результат 1259614800 секунд
$now_t = strtotime("now"); // Результат 1259614800 секунд
$filename = '/tmp/marfin.txt';
 if (!$handle = fopen($filename, 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

try {

if(isset($HTTP_RAW_POST_DATA)) {
			$postdata = file_get_contents("php://input");
			$kod =  0;
			$xmlresult = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $postdata );
			$array = XML2Array::createArray($xmlresult);
			$paym = $array['payment-message']['request-auth'];

			$psign = $paym['sign'];
			$pay_id =$paym['pay_id'];
			$summa = $paym['summa'];

			$psalt = create_sign($pay_id);

			if ($iPay = check_sign($psalt,$pay_id)) { 

					$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YIS');		
					if ($_db->connect_error) {
						die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
					}
					$_db->set_charset("utf8");   

					$sql='SELECT *	FROM YISGRAND.MTB_PAYMENT 	WHERE  YISGRAND.MTB_PAYMENT.`payment_id`='.$pay_id.'';

					$result = $_db->query($sql) or die('Connect Error in  (' .  $sql . ') ' . $_db->connect_error);

					$row_cnt = $result->num_rows;
					if ($row_cnt > 0 ) {
							while ($row = $result->fetch_assoc()) {
										$data = $row['data'];
										$sum = $row['summa'];
										$commission = $row['commission'];
										$chek = $row['chek'];

									}	
								$sum1='';
								$sum1.=substr(number_format($sum+$commission, 2, '.', ''), 0, -3);
								$sum1.=substr(number_format($sum+$commission, 2, '.', ''), -2);


								if ($summa == $sum1) {

								$date_end = strtotime($data); 
								$date_chek = floor(($now_date - $date_end ) / 86400 ); 

								if ($date_chek == 0 ) {

									if ($chek != 0 ) {

							
														$sql_opl='CALL YISGRAND.OplataPaymentMarfin('.$pay_id.', @success, @msg)';
														$result_opl = $_db->query($sql_opl) or die('Connect Error (' . $sql_opl . ') ' . $_db->connect_error);				    
														$result_opl_callback='SELECT @success, @msg';
														$res_opl_callback = $_db->query($result_opl_callback) or die('Connect Error in (' .  $result_opl_callback . ') ' . $_db->connect_error);										
														while ($res_row = $res_opl_callback->fetch_assoc()) {
															$results['success'] = $res_row['@success'];
															$results['msg']	=$res_row['@msg'];
														}	
																if ($results['success'] == "1") {
																		$r['message'] ="Oплаты  выполнена";
																		$kod =  0;
																}else{
																		$kod =  6;
																		throw new Exception('Процедура оплаты не выполнена!');
			
																}
									}else{
										$kod =  5;
										throw new Exception('Платеж с данным номером уже оплачен');
									}
						}else{
							$kod =  3;
							throw new Exception('истекло время жизни Платежа (сутки)');
						}
					}else{
						$kod =  2;
						throw new Exception('Суммы не равны');
					}
			} else {
						$kod =  1;
						throw new Exception('Не найден платеж c таким id');
			}
		 } else {
			$kod =  4;     
		throw new Exception('Верификация поступившей нотификации не прошла проверку ');
		}
} else {
    $kod =  6;     
		throw new Exception('Нет нотификации REQUEST пустой');
		}
}
catch(Exception $e){
		$r['message'] = $e->getMessage();
		
	}
fwrite($handle,$r['message'] .' '.$pay_id.' '. $summa.' '.$sum1.' '.$psign); 

	  echo $kod;

?>