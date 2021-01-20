<?php
include_once './yis_config.php';

class QueryPayment
{
	private $_db;
	protected $login;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $what;
	protected $nomer;
	protected $type;
	protected $pokaz;
	protected $pred;
	protected $tek;
	protected $kub;
	protected $t; 
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
			      $this->sql='SELECT YIS.PAYMENT.`status`,YIS.PAYMENT.`address_id`,YIS.ADDRESS.`raion_id` '
												.'FROM YIS.PAYMENT,YIS.ADDRESS WHERE YIS.PAYMENT.payment_id='.$this->pay_id.' AND YIS.PAYMENT.`address_id`= YIS.ADDRESS.`address_id` LIMIT 1 ';
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


public function newOplata(stdClass $params)
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

		
		 $this->sql='CALL YISGRAND.newPaymentApp('
		.$this->address_id.',"'
		.$this->oplata1.'","'
		.$this->oplata2.'","'
		.$this->oplata3.'","'
		.$this->oplata4.'","'
		.$this->oplata5.'","'
		.$this->oplata6.'","'		
		.$this->newOplata.'","'
		.$this->user_id.'",'
		.'@kvartplata, @otoplenie, @podogrev, @voda, @stoki, @tbo, '
		.' @ins_id, @success, @msg)';
		
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @kvartplata, @otoplenie, @podogrev, @voda, @stoki, @tbo, @ins_id, @success, @msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['ins_id'] = $this->row['@ins_id'];
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
			$this->results['kvartplata']= floor($this->row['@kvartplata'] *100);
			$this->results['otoplenie']= floor($this->row['@otoplenie'] *100);
			$this->results['podogrev']= floor($this->row['@podogrev'] *100);
			$this->results['voda']= floor($this->row['@voda'] *100);
			$this->results['stoki']= floor($this->row['@stoki'] *100);
			$this->results['tbo']= floor($this->row['@tbo'] *100);
		
		}	
		
	
	
if ($this->results['success'] == 1) {
include_once './ipay.class.php';
include_once './XmlToArray.php';

$iPay = new iPay(  MID , MKEY ,SKEY );
$iPay->set_urls('http://is.yuzhny.com/is/index.php?pay_id='.$this->results['ins_id'].'','http://is.yuzhny.com/is/index.php?pay_id='.$this->results['ins_id'].'');
$iPay->set_mode('real');

// TRANSACTIONS
if ($this->results['kvartplata'] >0) {

$iPay->set_transaction(492, $this->results['kvartplata'] ,'Квартплата',1133);

}

if ($this->results['otoplenie'] >0 || $this->results['podogrev'] >0) {

$iPay->set_transaction(492,$this->results['otoplenie']+ $this->results['podogrev'],'Отопление и подогрев',1132);

}

if ($this->results['voda'] >0 || $this->results['stoki'] >0) {

$iPay->set_transaction(492, $this->results['voda'] + $this->results['stoki'],'Водоснабжение и водоотведение',1131);

}
if ($this->results['tbo'] >0) {

$iPay->set_transaction(492, $this->results['tbo'],'Вывоз мусора (ТБО)',997);

}
// TRANSACTIONS

$xml_result = $iPay->create_payment();
//$this->xmlresult = $iPay->outdata;
$this->xmlresult = $xml_result;
//echo $this->xmlresult;

 // ==================== XML TO ARRAY
$this->xmlresult = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $this->xmlresult );
$array = XML2Array::createArray($this->xmlresult);

$paym = array();
$paym = $array['payment'];

		if(isset($paym['pid']) && ($paym['pid'])) {
		  $pid =  $paym['pid'];
		} else {
		  $pid = 0;
		}

		if(isset($paym['salt']) && ($paym['salt'])) {
		  $psalt =  $paym['salt'];
		} else {
		  $psalt = 0;
		}

		if(isset($paym['sign']) && ($paym['sign'])) {
		  $psign =  $paym['sign'];
		} else {
		  $psign = 0;
		}

		if(isset($paym['sign']) && ($paym['sign'])) {
		  $psign =  $paym['sign'];
		} else {
		  $psign = 0;
		}



		if(isset($paym['status']) && ($paym['status'])) {
		  $pstatus =  $paym['status'];
		} else {
		  $pstatus = 0;
		}

		if(isset($paym['url']) && ($paym['url'])) {
		  $url =  $paym['url'];
		} else {
		  $url = "";
		}

		if ($iPay->check_sign($psalt,$psign)) { 
					$this->results['url'] = $paym['url'];
					$this->results['status'] = $paym['status'];
					$this->up_stat ='UPDATE YIS.PAYMENT SET YIS.PAYMENT.`status`="1", YIS.PAYMENT.`pay_id`="'.$pid.'" WHERE YIS.PAYMENT.`payment_id`="'.$this->results['ins_id'].'" LIMIT 1';
					$this->upd_status = $_db->query($this->up_stat) or die('Connect Error in '.$this->what.'(' .  $this->up_stat . ') ' . $_db->connect_error);
	      } else {
				$this->results['success']=0;
				$this->results['msg']='Ваш ключ неверный';
		}	
}
     	return $this->results;
}
public function delOplata(stdClass $params)
	{

		return null;
	      }
	
}