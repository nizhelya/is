<?php
include_once './yis_config.php';

class QueryPaymentMarfin
{
	private $_db;
	protected $login;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $url_callback;
	protected $row;	
	protected $what;
	protected $nomer;
	protected $type;
	protected $pokaz;
	protected $pred;
	protected $tek;
	protected $kvartplata =0;
	protected $teplo=0;
	protected $voda=0;
	protected $tbo=0;
	protected $data=NULL;
	protected $res=array();	
	public	  $results=array();
	
	
	public function connect()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YISGRAND');
		if ($_db->connect_error) {
			return false;
		} else {		
		$_db->set_charset("utf8");    
		return $_db;
		}
	}

	
public function getResults(stdClass $params)
	{


			$_db = $this->connect();


	
				$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$value;}
		  }
		}
	
		switch ($this->what) {

		

			case "PaymentStatus":			
			      $this->sql='SELECT YISGRAND.MTB_PAYMENT.`status`,YISGRAND.MTB_PAYMENT.`address_id`,YISGRAND.ADDRESS.`raion_id` '
												.'FROM YISGRAND.MTB_PAYMENT,YISGRAND.ADDRESS WHERE YISGRAND.MTB_PAYMENT.payment_id='.$this->pay_id.' AND YISGRAND.MTB_PAYMENT.`address_id`= '.$this->address_id.' LIMIT 1 ';
			      // print_r($this->sql); 
			break;
		case "MarfinPayment":			
			      $this->sql='SELECT * FROM YISGRAND.MTB_PAYMENT WHERE YISGRAND.MTB_PAYMENT.address_id='.$this->address_id.' ORDER BY YISGRAND.MTB_PAYMENT.payment_id DESC';
			      // print_r($this->sql); 
			break;
		} // End of Switch ($what)
		
	
		

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		
		while ($this->row = $this->result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}
		$this->results['data']	= $this->res;
		
		return $this->results;
	}


public function newOplata(stdClass $params){
	
$_db = $this->connect();
$array = (array) $params;
  foreach ( $array as $key => $value ) 
    {
      if(isset($value)) { 
	if (is_int($value)) { $this->$key= (int)$value;}
	else if (is_float($value)) { $this->$key= $value;}
	else {$this->$key =$value;}
	}
    }
$this->sql='CALL YISGRAND.newPaymentMarfin('
.$this->address_id.',"'
.$this->oplata1.'","'
.$this->oplata2.'","'
.$this->oplata3.'","'
.$this->oplata4.'","'
.$this->oplata5.'","'
.$this->oplata6.'","'	
.$this->oplata7.'","'
.$this->newOplata.'","'
.$this->user_id.'",'
.' @kvartplata, @otoplenie, @podogrev, @voda, @stoki, @tbo,@ptn, @payment_id,@edrpou,@firstname,@patronymic,@surname,@account,@address,@data_in ,@success, @msg)';

$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);

$this->sql_callback='SELECT @kvartplata, @otoplenie, @podogrev, @voda, @stoki, @tbo,@ptn, @payment_id,@edrpou,@firstname,@patronymic,@surname,@account,@address,@data_in ,@success, @msg';

$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);

while ($this->row = $this->res_callback->fetch_assoc()) {
  $this->results['kvartplata']	= $this->row['@kvartplata'] *100;
  $this->results['otoplenie']	= $this->row['@otoplenie'] *100;
  $this->results['podogrev']	= $this->row['@podogrev'] *100;
  $this->results['voda']	= $this->row['@voda'] *100;
  $this->results['stoki']	= $this->row['@stoki'] *100;
  $this->results['tbo']		= $this->row['@tbo'] *100;
  $this->results['ptn']		= $this->row['@ptn'] *100;
  $this->results['payment_id'] 	= $this->row['@payment_id'];
  $this->results['edrpou'] 	= $this->row['@edrpou'];
  $this->results['firstname'] 	= $this->row['@firstname'];
  $this->results['patronymic'] 	= $this->row['@patronymic'];
  $this->results['surname'] 	= $this->row['@surname'];
  $this->results['account'] 	= $this->row['@account'];
  $this->results['address'] 	= $this->row['@address'];
  $this->results['data_in'] 	= $this->row['@data_in'];
  $this->results['success'] 	= $this->row['@success'];
  $this->results['msg']		= $this->row['@msg'];
}	

if ($this->results['success'] == 1) {


 $partner = [];
 $service = [];
 $transaction = [];
 $billattr = [];
 $data = [];
 $requestData = [];

 
 if ($this->results['otoplenie'] >0 || $this->results['podogrev'] >0 || $this->results['ptn'] >0) { 
	$service["26134519"] =  $this->results['otoplenie']+ $this->results['podogrev'] + $this->results['ptn'];	
 }
 if ($this->results['kvartplata'] >0 AND $this->results['ipay'] !=0 ) {
	$service[$this->results['edrpou']] =  $this->results['kvartplata'];
} 
if ($this->results['voda'] >0 || $this->results['stoki'] >0) {
	$service["31783053"] =   $this->results['voda'] + $this->results['stoki'];
}
if ($this->results['tbo'] >0) {
	$service["30750184"] =  $this->results['tbo'];
}

 $partner = ["PartnerToken"=>"8aff556f-1025-439a-8c7d-fda279523332",
	     "OperationType"=>10005,
	     "Locale"=>"ua"
	     ];
 $billattr = ["PayerAddress"=>$this->results['address']]; 
 $transaction = ["TransactionID"=>$this->results['payment_id'],
		 "TerminalID"=>"1",
		 "DateTime"=>$this->results['data_in']]; 
 $data = ["PayType"=>"7",
		 "Phone"=>"",
		 "Email"=>"",
		 "Account"=>$this->results['account'],
		 "FirstName"=>$this->results['firstname'],
		 "LastName"=>$this->results['surname'],
		 "MiddleName"=>$this->results['patronymic'],
		 "Service"=>$service,
		 "BillAttr"=>$billattr,
		 "Transaction"=>$transaction]; 	
		 
$requestData=["Partner"=>$partner,"Data"=>$data];		 

$json = json_encode($requestData);

$url = 'https://stage-papi.xpay.com.ua:488/xpay';

$headers = array(
	'cache-control: max-age=0',
	'upgrade-insecure-requests: 1',
	'user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
	'sec-fetch-user: ?1',
	'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
	'x-compress: null',
	'sec-fetch-site: none',
	'sec-fetch-mode: navigate',
	'accept-encoding: deflate, br',
	'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true, 
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSLVERSION => 3,
  CURLOPT_HEADER => $headers,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>  $json
));
/*
$channel = curl_init();
curl_setopt($channel, CURLOPT_POST, TRUE);
curl_setopt($channel, CURLOPT_POSTFIELDS, $json );
curl_setopt($channel, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, FALSE);					
curl_setopt($channel, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($channel, CURLOPT_MAXREDIRS,      1);
curl_setopt($channel, CURLOPT_URL,$url );
$curl_result = curl_exec( $channel );
*/
$curl_result = curl_exec( $curl );

if ($curl_result === FALSE) {
    echo 'cURL Error: ' . curl_errno($curl);#curl_errno - возвращает целое число, содержащее номер последней ошибки.
    echo '<br>cURL ErrorNo: ' . curl_error($curl);#возвращает строку содержащую номер последней ошибки для текущей сессии.
    return;
} else {
	//$array_data = simplexml_load_string(mb_convert_encoding($result, "UTF-8", "auto"));
	print_r(htmlentities($curl_result));

}
curl_close( $curl );

$paym ="";
$paym = json_decode($curl_result);

  if(isset($paym['Code']) && ($paym['Code'])) {
    $code =  $paym['Code'];
  } else {
    $code = 0;
  }
   if(isset($paym['message']) && ($paym['message'])) {
    $message =  $paym['message'];
  } else {
    $message = 0;
  }
 
 if(isset($paym['Data']['OperationID']) && ($paym['Data']['OperationID'])) {
    $ndoc =  $paym['Data']['OperationID'];
  } else {
    $ndoc = "";
  }
   if(isset($paym['Data']['OperationStatus']) && ($paym['Data']['OperationStatus'])) {
    $status =  $paym['Data']['OperationStatus'];
  } else {
    $status = "";
  }
   if(isset($paym['Data']['URI']) && ($paym['Data']['URI'])) {
    $uri =  $paym['Data']['URI'];
  } else {
    $uri = "";
  }
  if ($code == 200 && $status == 10 ) { 
  $this->results['success']=1;
  $this->results['url'] = $uri;
  $this->up_stat ='UPDATE YISGRAND.MTB_PAYMENT as t1  SET t1.`status`="'.$status.'", t1.`nomer`="'.$code.'" WHERE t1.`payment_id`="'.$this->results['payment_id'].'" ';
  			    //   print_r($this->up_stat); 

  $this->upd_status = $_db->query($this->up_stat) or die('Connect Error in '.$this->what.'(' .  $this->up_stat . ') ' . $_db->connect_error);
  
  
  } else {
    $this->results['success']=0;
    $this->results['msg']='Сервіс платежів Xpay<br>Платеж не сформований';
    }	


}
  return $this->results;

}
	
}