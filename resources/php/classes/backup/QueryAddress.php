<?php

class QueryAddress
{
	private $_db;
	protected $_result;
	protected $_total;
	protected $_count;
	protected $_WHERE;
	protected $_TABLE;
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
		$_TABLE =" ";
		$_LIMIT	=" ";
		$_what	=" ";
		$_page = (int) $params->page;  // get the requested page 
		$_limit = (int) $params->limit; // get how many rows we want to have into the grid 
		$_start = (int) $params->start;
		$_id = (int) $params->what_id;
		$_what = $params->what;

		switch ($_what) {
		    case "address":
			   $_TABLE= ' ADDRESS'; 
			  if ($_id) {
				$_WHERE= ' WHERE address_id='.$_id.'';
			  }  
		  
			$_LIMIT= ' LIMIT  1';
		    
		    break;
		    case "all":
			  
			 if ($_id) {
				$_WHERE= ' WHERE house_id='.$_id.'';
			  }       
			$_LIMIT= ' ';
			    
		    break;
		    case "AppTenant":
			  $_TABLE= ' APP_TENANT'; 
			 if ($_id) {
				$_WHERE= ' WHERE address_id='.$_id.'';
			  }       
			 $_LIMIT= ' LIMIT  1';
			    
		    break;
		}
		

		//echo $_WHERE;
		//$sidx = $params->sort["property"];
		//$sord = $params->sort["direction"];
		
		$_db = $this->__construct();

		$_count = $_db->query('SELECT * FROM '.$_TABLE.' ') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		$_total = $_count->num_rows;
		

		$_result = $_db->query('SELECT * FROM '.$_TABLE.' '.$_WHERE.' '.$_LIMIT.'' ) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		$_array=array();
		while ($row = $_result->fetch_assoc()) {
			array_push($_array, $row);
		}


		$results = array();
		$results['success']	= true;
		$results['total']	= $_total;
		$results['results']	= $_array;
		
		return $results;
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