<?php

class QueryRaion
{
	private $_db;
	protected $_result;
	protected $_total;
	protected $_count;
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
		$page = (int) $params->page;  // get the requested page 
		$limit = (int) $params->limit; // get how many rows we want to have into the grid 
		$start = (int) $params->start;
		//$sidx = $params->sort["property"];
		//$sord = $params->sort["direction"];
		
		$_db = $this->__construct();

		$_count = $_db->query('SELECT * FROM RAION ') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		$_total = $_count->num_rows;
		

		$_result = $_db->query('SELECT * FROM RAION LIMIT '.$start.','.$limit.'' ) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		$owners=array();
		while ($row = $_result->fetch_assoc()) {
			array_push($owners, $row);
		}


		$results = array();
		$results['success']	= true;
		$results['total']	= $_total;
		$results['results']	= $owners;
		
		return $results;
	}
	
	public function createRecord(stdClass $params)
	{

		$_db = $this->__construct();
		if($stmt = $_db->prepare("INSERT INTO RAION (raion) VALUES (?)")) {
			
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
		
		if ($stmt = $_db->prepare("UPDATE RAION SET raion=? WHERE raion_id=?")) {
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
			if($stmt = $_db->prepare("DELETE FROM RAION WHERE raion_id = ? LIMIT 1")) {
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