<?php

class QueryTarifTables
{
	private $_db;
	protected $_result;
	protected $_total;
	protected $_count;
	protected $_WHERE;
	protected $_place;
	protected $_limit;
	protected $_LIMIT;
	protected $_start;
	protected $_page;
	protected $_array;
	protected $_id;
	protected $_what;
	public $results;
	
	public function __construct()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', 'root' ,'hfljyt;crbq', 'YISGRAND');
		
		if ($_db->connect_error) {
			die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		$_db->set_charset("utf8");
    
		return $_db;
	}
	
	public function getResults(stdClass $params)
	{
		
		$_total= 0;
		$_id	=0;
		$_page	=0;
		$_limit	=0;
		$_start	=0;
		$_WHERE =" ";
		$_place =" ";
		$_LIMIT	=" ";
		$_what	=" ";
		$_page = (int) $params->page;  // get the requested page 
		$_limit = (int) $params->limit; // get how many rows we want to have into the grid 
		$_start = (int) $params->start;
		$_id = (string) $params->what_id;
		$_what = (string) $params->what;

		switch ($_what) {   
		    case 'userlogin':
			

		    $_result = $this-> GetByLogin($_id);

		    if ($_result) {  $_result = $this->OpenSession($_result['user_id']); } else { return 'wrong login';}


		    break;

		 	}	// SWITCH END    
		
		
		$_array=array();
		while ($row = $_result->fetch_assoc()) {
			array_push($_array, $row);
		}

		$results = array();
		$results['success']	= true;
		$results['total']	= $_total;
		$results['data']	= $_array;
		
		return $results;
		
		
		

//=======================
//
	// Получает пользователя по логину
	//
		private function GetByLogin($login)
	{	
		$_db = $this->__construct();
		$t = "SELECT * FROM users WHERE login = '%s'";
		$query = sprintf($t, mysql_real_escape_string($login));
		
		$result = $_db->query($t) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		$res = mysql_fetch_array($result);

		return $res[0];
	}

		private function OpenSession($_user_id)
	{
		$_db = $this->__construct();
		// генерируем SID
		$sid = $this->GenerateStr(10);
				
		// вставляем SID в БД
		$now = date('Y-m-d H:i:s'); 
		$session = array();
		$session['user_id'] = $_user_id;
		$session['sid'] = $sid;
		$session['time_start'] = $now;
		$session['time_last'] = $now;				
		
		$session_s = implode(',', $session);
		
				if($stmt = $_db->prepare("INSERT INTO sessions VALUES ? LIMIT 1")) {
				$stmt->bind_param('i', $session_s);
				$stmt->execute();
				$stmt->close();
			}
	
		// возвращаем SID
		return $sid;	
	}


		private function GenerateStr($length = 10) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;  

		while (strlen($code) < $length) 
            $code .= $chars[mt_rand(0, $clen)];  

		return $code;
	}

//=======================



		
	}
	
	public function createRecord(stdClass $params)
	{

		$_db = $this->__construct();
		if($stmt = $_db->prepare("INSERT INTO HOUSE (house) VALUES (?)")) {
			
			$stmt->bind_param('s', $raion);
			
			$raion = $_db->real_escape_string($params->raion);
			
			$stmt->execute();
			
			$params->id = $_db->insert_id;
			
			$stmt->close();
		}
		
		
		return $params;
	}
	
	public function updateRecords(stdClass $params)
	{
		$_db = $this->__construct();
		
		if ($stmt = $_db->prepare("UPDATE RAION SET house=? WHERE house_id=?")) {
			$stmt->bind_param('si', $raion, $id);

			$raion = $_db->real_escape_string($params->raion);
			
			//cast id to int
			$id = (int) $params->id;
						
			$stmt->execute();
									
			$stmt->close();
		}

		return $params;
	}
	
	public function destroyRecord(stdClass $params)
	{
		$_db = $this->__construct();
		
		$id = $params->id;
		
		if(is_numeric($id)) {
			if($stmt = $_db->prepare("DELETE FROM HOUSE WHERE house_id = ? LIMIT 1")) {
				$stmt->bind_param('i', $id);
				$stmt->execute();
				$stmt->close();
			}
		}
				
		return $this;
	}
	
	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}