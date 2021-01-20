<?php

class QueryFlatHistory
{
	private $_db;
	protected $_result;
	protected $_total;
	protected $_count;
	protected $_sql;
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
		$_db = new mysqli('localhost', 'cthubq' ,'hfljyt;crbq', 'YIS');
		
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
		$_id = (int) $params->what_id;
		$_what = (string) $params->what;
		$_db = $this->__construct();



		if(isset($params->what) && ($params->what)) {
		 $_what = $params->what;
		} else {
		  $_what = null;
		}
		if(isset($params->what_id) && ($params->what_id)) {
		  $_id = (int) $params->what_id;
		} else {
		  $_id = 0;
		}



		if ($_limit) {
		  $_LIMIT= ' LIMIT  '.$_start.','.$_limit.'';
		}

		switch ($_what) {   
		    case 'kvartplata':
			 
		//$_count = $_db->query('SELECT * FROM '.$_place.''.$_WHERE.'') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		$_total = 0; //$_count->num_rows;
		$_sql='SELECT house_id, DATE_FORMAT(date_ch,"%d-%m-%Y") as fdate, tarif, tarif1 FROM TARIF_KVARTPLATA WHERE house_id='.$_id.' order by date_ch  '.$_LIMIT.' ' ;
		//print($_sql);
		$_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		    break;
		   
		  case 'teplo':
		
		$_total = 0;
		$_sql='SELECT DATE_FORMAT(date_ch,"%d-%m-%Y") as fdate, otoplenie,counter,counter_ot,norma,norma_ot,norma12,norma12_ot,teplomer FROM TARIF_TEPLO ORDER BY date_ch  LIMIT 7 ' ;
		//print($_sql);
		$_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		    break;

		  case 'tbo':
		
		$_total = 0;
		$_sql='SELECT DATE_FORMAT(date_ch,"%d-%m-%Y") as fdate, tarif FROM TARIF_TBO ORDER BY date_ch  LIMIT 7 ' ;
		//print($_sql);
		$_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		    break;
		  case 'voda':
			   
		$_total = 0;
		$_sql='SELECT  DATE_FORMAT(date_ch,"%d-%m-%Y") as fdate,voda_counter,voda_norma,voda_norma12,stoki_counter,stoki_norma,stoki_norma12 FROM TARIF_VODA ORDER BY  date_ch  LIMIT 7 ' ;
		//print($_sql);
		$_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		    break;

		  case 'stoki':
			   
				$_place='TARIF_STOKI';
			      
		    break;

		 }	// SWITCH END    
		
		

		

		//echo $_WHERE;
		//$sidx = $params->sort["property"];
		//$sord = $params->sort["direction"];
		

		
		$_array=array();
		while ($row = $_result->fetch_assoc()) {
			array_push($_array, $row);
		}


		$results = array();
		$results['success']	= true;
		$results['total']	= $_total;
		$results['data']	= $_array;
		
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