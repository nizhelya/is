<?php

class QueryVik
{
	private $_db;
	protected $res;
	protected $what;	
	protected $sql;	
	protected $id;	
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
		if(isset($params->what) && ($params->what)) {
		  $this->what = $params->what;
		} else {
		   $this->what= null;
		}
		if(isset($params->what_id) && ($params->what_id)) {
		   $this->id = (int) $params->what_id;
		} else {
		  $this->what_id= 0;
		}

		switch ( $this->what) {
			case "TekWater":
			
			      $this->sql='SELECT VODOMER.type,UCASE(VODOMER.place) as place,VODOMER.nomer,VODOMER.model,DATE_FORMAT(max(WATER.data),"%d-%m-%Y") as fdate,'
				      .'max(WATER.pred) as pred,max(WATER.tek) as tek,WATER.operator FROM VODOMER,WATER  WHERE VODOMER.address_id='.$this->id.' AND VODOMER.nomer= WATER.nomer AND '
				      .'WATER.address_id='.$this->id.' GROUP BY VODOMER.nomer ORDER BY WATER.data DESC ';
			       //print_r($this->sql); 
			break;
		} // End of Switch ($what)
		
		$_db = $this->__construct();

		//print_r($_sql);
		$this->res = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		  

		$_array=array();
		while ($row = $this->res->fetch_assoc()) {
			array_push($_array, $row);
		}


		$results = array();
		$results['success']	= true;
		$results['data']	= $_array;
		
		return $results;
	}
	
	
	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}