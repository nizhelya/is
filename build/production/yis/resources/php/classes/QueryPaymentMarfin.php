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

		public function create_sign($id) {
		
		$response = hash_hmac( 'sha512' , SKEY , $id );
		
		return $response;
		
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
		
		 $this->sql='CALL YISGRAND.newPaymentMarfin('.$this->address_id.',"'.$this->oplata1.'","'
		.$this->oplata2.'","'
		.$this->oplata3.'","'
		.$this->oplata4.'","'
		.$this->oplata5.'","'
		.$this->oplata6.'","'
		.$this->oplata7.'","'
		.$this->commission.'","'	
		.$this->newOplata.'","'
		.$this->user_id.'", @ins_id, @success, @msg)';
		
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT  @ins_id, @success, @msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['ins_id'] = $this->row['@ins_id'];
			$this->results['summa'] = $this->newOplata + $this->commission;
			$this->results['sign'] = $this->create_sign($this->row['@ins_id']);
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
			$this->results['xml'] ='<?xml version="1.0"  encoding="UTF-8"?><payment-message ><request-auth><sign>'.$this->results['sign'].'</sign><pay_id>'.$this->row['@ins_id'].'</pay_id><summa>'.$this->results['summa'].'</summa></request-auth></payment-message> ';
//https://yis.yuzhny.com/kommuna/marfin/pay.php
	//http://localhost/is/marfin/pay.php

		}	

     	return $this->results;
}
 public function getRaspechatka(stdClass $params)
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

		      $this->sql='CALL YISGRAND.raspechatkaOplataMarfin('.$this->payment_id.',@success,@content)';
		
			//  print($this->sql);

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @content,@success';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['content'] = $this->row['@content'];
			$this->results['success'] = $this->row['@success'];
			$this->results['sql'] = $this->sql;
		}
		return $this->results;
}

	
}