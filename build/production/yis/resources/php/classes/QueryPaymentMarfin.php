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
			      $this->sql='SELECT t1.`status`,t1.`address_id`,t1.`raion_id` FROM YISGRAND.MTB_PAYMENT as t1 ,YISGRAND.ADDRESS as t2 '
			      .' WHERE t1.payment_id='.$this->pay_id.' AND t1.`address_id`= '.$this->address_id.' LIMIT 1 ';
			break;
		case "MarfinPayment":			
			      $this->sql='SELECT t1.* FROM YISGRAND.MTB_PAYMENT as t1  WHERE t1.address_id='.$this->address_id.' ORDER BY t1.payment_id DESC';
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
.' @kvartplata, @teplo, @voda, @tbo, @payment_id,@edrpou,@firstname,@patronymic,@surname,@account,@address,@data_in ,@success, @msg)';

$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);

$this->sql_callback='SELECT  @kvartplata, @teplo, @voda, @tbo, @payment_id,@edrpou,@firstname,@patronymic,@surname,@account,@address,@data_in ,@success, @msg';

$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);

while ($this->row = $this->res_callback->fetch_assoc()) {
  $this->results['kvartplata']	= $this->row['@kvartplata'] *100;
  $this->results['teplo']	= $this->row['@teplo'] *100;
  $this->results['voda']	= $this->row['@voda'] *100;
  $this->results['tbo']		= $this->row['@tbo'] *100;
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


 $partner = array();
 $service = array();
 $teplo = array();
 $voda = array();
 $tbo = array();
 $kvartplata = array();
 $transaction = array();
 $billattr = array();
 $data = array();
 $requestData = array();

 
 if ($this->results['otoplenie'] >0 || $this->results['podogrev'] >0 || $this->results['ptn'] >0) { 
	$teplo["ServiceCode"] ="26134519";
	$teplo["Sum"] =  $this->results['teplo'];
	$service[] =  $teplo;


 }
 if ($this->results['kvartplata'] >0 AND $this->results['ipay'] !=0 ) {
	$kvartplata["ServiceCode"] =$this->results['edrpou'];
	$kvartplata["Sum"] =  $this->results['kvartplata'];
	$service[] =  $kvartplata;
} 
if ($this->results['voda'] >0 || $this->results['stoki'] >0) {
	$voda["ServiceCode"] ="31783053";
	$voda["Sum"] = $this->results['voda'];
	$service[] =  $voda;
}
if ($this->results['tbo'] >0) {
	$tbo["ServiceCode"] ="30750184";
	$tbo["Sum"] = $this->results['tbo'] ;
	$service[] =  $tbo;
}

$partner["PartnerToken"] = "8aff556f-1025-439a-8c7d-fda279523332";
$partner["OperationType"] = 10005;
$partner["Locale"] = "ua";

$billattr["PayerAddress"] = $this->results['address'];

$transaction["TransactionID"] = $this->results['payment_id'];
$transaction["TerminalID"] = "1" ;
$transaction["DateTime"] = $this->results['data_in'];

$data["PayType"] = "7";
$data["Phone"] = "";
$data["Email"] = "";
$data["Account"] = $this->results['account'];
$data["FirstName"] = $this->results['firstname'];
$data["LastName"] = $this->results['surname'];
$data["MiddleName"] = $this->results['patronymic'];
$data["Service"] = $service;
$data["BillAttr"] = $billattr;
$data["Transaction"] = $transaction;

		 
$requestData["Partner"] =  $partner;
$requestData["Data"] = $data;	 

$json_data= json_encode($requestData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);	
/*
$this->sql_callback='INSERT INTO YISGRAND.TEST_JSON(`info`) VALUES ("'.$json_data.'")';
$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
*/
//$url = 'https://stage-papi.xpay.com.ua:488/xpay';
$url = 'http://localhost/ykis/pb/test_json.php';



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true, 
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSLVERSION => 3,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>  $json_data
));

$curl_result = curl_exec( $curl );


if ($curl_result === FALSE) {
    echo 'cURL Error: ' . curl_errno($curl);#curl_errno - возвращает целое число, содержащее номер последней ошибки.
    echo '<br>cURL ErrorNo: ' . curl_error($curl);#возвращает строку содержащую номер последней ошибки для текущей сессии.
    return;
} else {
	//$array_data = simplexml_load_string(mb_convert_encoding($result, "UTF-8", "auto"));
	print_r($curl_result);

}
curl_close( $curl );
/*
$paym = array();
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
*/

}

  return $this->results;

}
	
}