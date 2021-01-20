<?php

class QueryMyFlat
{
	private $_db;
	protected $sql;
	protected $_result;
	public $results;
	
	public function __construct()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', 'cthubq' ,'hfljyt;crbq', 'YIS');
		
		if ($_db->connect_error) {
			die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		$_db->set_charset("utf8");
		return $_db;
	}
	
	public function getResults(stdClass $params)
	{
		
		$_db = $this->__construct();
		$_user_id = $params->user_id;		
		$this->sql='SELECT * FROM YISGRAND.MYFLAT WHERE YISGRAND.MYFLAT.user_id='.$_user_id.' order by YISGRAND.MYFLAT.osn desc';
		$_result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		
		$results = array();
		
		while ($row = $_result->fetch_assoc()) {
			array_push($results, $row);
		}
		
		return $results;
	}
	
	public function createRecord(stdClass $params)
	{

		$_db = $this->__construct();
		if($stmt = $_db->prepare("INSERT INTO YISGRAND.MYFLAT (user_id, login, address_id,raion_id,house_id, address) VALUES (?, ?, ?, ? ,? , ?)")) {
			
			$stmt->bind_param('isis', $_user_id, $_login,$_raion_id,$_house_id,$_address_id,$_address);
			
			$_user_id = $params->user_id;
			$_address_id = $params->address_id;
			$_house_id = $params->house_id;
			$_raion_id = $params->raion_id;
			$_login = $_db->real_escape_string($params->login);
			$_address = $params->address;
			
			$stmt->execute();
			
			$params->id = $_db->insert_id;
			
			$stmt->close();
		}
		
		
		return $params;
	}
	
	public function updateRecords(stdClass $params)
	{
		$_db = $this->__construct();
		
		if ($stmt = $_db->prepare("UPDATE YISGRAND.MYFLAT SET user_id=?,login=?, address_id=?, address=? WHERE id=?")) {
			$stmt->bind_param('isis', $_user_id, $_login,$_address_id, $_address);
			$_id = $params->id;
			$_user_id = $params->user_id;
			$_address_id = $params->address_id;
			$_login = $_db->real_escape_string($params->login);
			$_address = $_db->real_escape_string($params->address);
			$stmt->execute();
			$stmt->close();
		}

		return $params;
	}
	
	public function destroyRecord(stdClass $params)
	{
		$_db = $this->__construct();
		
		$_id = $params->id;
				
		if(is_numeric($_id)) {
			if($stmt = $_db->prepare("DELETE FROM YISGRAND.MYFLAT WHERE id = ?  LIMIT 1")) {
				$stmt->bind_param('i', $_id);
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