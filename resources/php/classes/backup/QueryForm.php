<?php

class QueryForm
{
	private $_db;
	protected $_result;
	protected $_what;
	protected $_sql;
	protected $_id;
	public $results;
	
	public function __construct()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', 'cthubq' ,'hfljyt;crbq', 'YISGRAND');
		
		if ($_db->connect_error) {
			die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		$_db->set_charset("utf8");
    
		return $_db;
	}
	
	public function getResults( $params)
	{
		
		$_id =$params[0];  // get the requested page 
		$_what =  $params[1]; // get how many rows we want to have into the grid 
		//print_r($params);
		switch ($_what) {
		   
		    case "Appartment":
			  $_sql= 'SELECT RAION.raion, ADDRESS.address_id,ADDRESS.address,ADDRESS.lift,ADDRESS.room, APP_BTI.owner,APP_BTI.nanim, APP_BTI.number_order,DATE_FORMAT(date_order,"%d-%m-%Y") as fdate_order,APP_TENANT.tenant,APP_TENANT.absent, APP_TENANT.podnan, APP_TENANT.lgotchik,APP_BTI.privat,APP_BTI.area_full,APP_BTI.area_life,APP_BTI.area_balk, APP_BTI.area_dop,APP_DEV.vxvoda,APP_DEV.vgvoda,APP_DEV.teplomer,APP_DEV.boiler,APP_SERV.kvartplata,APP_SERV.otoplenie,APP_SERV.podogrev,APP_SERV.xvoda,APP_SERV.stoki,APP_SERV.tbo  FROM RAION,ADDRESS,APP_BTI,APP_TENANT,APP_DEV,APP_SERV  WHERE ADDRESS.address_id='.$_id.' and APP_BTI.address_id= '.$_id.' and APP_TENANT.address_id= '.$_id.' and APP_DEV.address_id= '.$_id.' and APP_SERV.address_id= '.$_id.' and ADDRESS.raion_id=RAION.raion_id'; 
			  break;
		    } // End of Switch ($what)
		
		$_db = $this->__construct();

		//print_r($_sql);
		$_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		  

		$_array=array();

		

		$results = array();
		$results['success'] = true;
		while ($row = $_result->fetch_assoc()) {
			$results['data'] = $row;
		}
		//$results['data']	= '3';
		
		return $results;
	}
	
	
	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}