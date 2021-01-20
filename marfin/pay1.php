<?php
include_once 'pay_config.php';


function create_sign($id) {
		
		$response = hash_hmac( 'sha512' , SKEY , $id );
		
		return $response;
		
	}

function check_sign($psalt,$sign ) {

		return ( hash_hmac( 'sha512' , SKEY , $sign ) == $psalt );

	}
$kod = 0;
$now_date = strtotime(date("Y-m-d")); // Результат 1259614800 секунд

	//echo 'now '.$now_date.'<br>';



try {



if((isset($_REQUEST['sign']) && !empty($_REQUEST['sign'])) &&  (isset($_REQUEST['pay_id']) && !empty($_REQUEST['pay_id'])) && (isset($_REQUEST['summa']) && !empty($_REQUEST['summa']))) {
			$psign = $_REQUEST['sign'];
			$pay_id = $_REQUEST['pay_id'];
			$summa = $_REQUEST['summa'];

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
										$chek = $row['chek'];
									}	
								if ($sum = $summa ) {

								$date_end = strtotime($data); 
	//echo "date_end '.$date_end.'";

								$date_chek = floor(($now_date - $date_end ) / 86400 ); 

	//echo "date_chek '.$date_chek.'";

								if ($date_chek = 1 ) {

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
																		$kod =  '0';
															

									}else{
											$kod =  '6';
											throw new Exception('Процедура оплаты не выполнена!');
			
									}
							}else{
								$kod =  '5';
								throw new Exception('Платеж с данным номером уже оплачен');
							}
						}else{
							$kod =  '2';
							throw new Exception('истекло время жизни Платежа (сутки)');
						}
					}else{
						$kod =  '3';
						throw new Exception('Суммы не равны');
					}
			} else {
						$kod =  '1';
						throw new Exception('Не найден платеж c таким id');
			}
		 } else {
			$kod =  '4';     
		throw new Exception('Верификация поступившей нотификации не прошла проверку ');
		}
} else {
    $kod =  '6';     
		throw new Exception('Нет нотификации REQUEST пустой');
		}
}
catch(Exception $e){
		$r['message'] = $e->getMessage();
		
	}
//fwrite($b,print_r($r)); 
	  return print_r($kod);

?>