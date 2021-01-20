<?php

class QueryDatabase
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

		$_count = $_db->query('SELECT * FROM owners ') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		$_total = $_count->num_rows;
		

		$_result = $_db->query('SELECT id, name, address, state FROM owners LIMIT '.$start.','.$limit.'' ) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

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
		if($stmt = $_db->prepare("INSERT INTO owners (name, address, state) VALUES (?, ?, ?)")) {
			
			$stmt->bind_param('sss', $name, $address, $state);
			
			$name = $_db->real_escape_string($params->name);
			$address = $_db->real_escape_string($params->address);
			$state = $_db->real_escape_string($params->state);
			
			$stmt->execute();
			
			$params->id = $_db->insert_id;
			
			$stmt->close();
		}
		
		
		return $params;
	}
	
	public function updateRecords(stdClass $params)
	{
		$_db = $this->__construct();
		
		if ($stmt = $_db->prepare("UPDATE owners SET name=?, address=?, state=? WHERE id=?")) {
			$stmt->bind_param('sssi', $name, $address, $state, $id);

			$name = $_db->real_escape_string($params->name);
			$address = $_db->real_escape_string($params->address);
			$state = $_db->real_escape_string($params->state);
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
			if($stmt = $_db->prepare("DELETE FROM owners WHERE id = ? LIMIT 1")) {
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