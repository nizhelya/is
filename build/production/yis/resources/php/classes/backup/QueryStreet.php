<?php

class QueryStreet
{
	private $_db;
	protected $_result;
	protected $_total;
	protected $_count;
	protected $_street;
	protected $_page;
	protected $_limit;
	protected $_start;
	protected $_id;
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
		$_page = (int) $params->page;  // get the requested page 
		$_limit = (int) $params->limit; // get how many rows we want to have into the grid 
		$_start = (int) $params->start;
		//$sidx = $params->sort["property"];
		//$sord = $params->sort["direction"];
		
		$_db = $this->__construct();

		$_count = $_db->query('SELECT * FROM STREET ') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		$_total = $_count->num_rows;
		

		$_result = $_db->query('SELECT * FROM STREET LIMIT '.$_start.','.$_limit.'' ) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		$_data=array();
		while ($row = $_result->fetch_assoc()) {
			array_push($_data, $row);
		}


		$results = array();
		$results['success']	= true;
		$results['total']	= $_total;
		$results['results']	= $_data;
		
		return $results;
	}
	
	public function createRecord(stdClass $params)
	{

		$_db = $this->__construct();
		if($stmt = $_db->prepare("INSERT INTO STREET (street) VALUES (?)")) {
			
			$stmt->bind_param('s', $_street);
			
			$_street = $_db->real_escape_string($params->street);
			
			$stmt->execute();
			
			$params->id = $_db->insert_id;
			
			$stmt->close();
		}
		
		
		return $params;
	}
	
	public function updateRecords(stdClass $params)
	{
		$_db = $this->__construct();
		
		if ($stmt = $_db->prepare("UPDATE STREET SET street=? WHERE street_id=?")) {
			$stmt->bind_param('si', $_street, $_id);

			$_street = $_db->real_escape_string($params->street);
			
			//cast id to int
			$_id = (int) $params->id;
						
			$stmt->execute();
									
			$stmt->close();
		}

		return $params;
	}
	
	public function destroyRecord(stdClass $params)
	{
		$_db = $this->__construct();
		
		$_id = $params->id;
		
		if(is_numeric($id)) {
			if($stmt = $_db->prepare("DELETE FROM STREET WHERE street_id = ? LIMIT 1")) {
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