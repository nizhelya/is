<?php

class QueryStatistika
{
	private $_db;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $id;
	protected $what;
	protected $start;
	protected $finish;	
	protected $data=NULL;
	protected $res=array();	
	public	  $results=array();
	
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
		if(isset($params->what) && ($params->what)) {
		 $this->what = $_db->real_escape_string($params->what);
		} else {
		  $this->what = null;
		}
		
		switch ($this->what) {
			  
			
		    case "otoplenie":
			$this->sql='SELECT  DATE_FORMAT(YIS.`OTOPLENIE`.`data`,"%d-%m-%Y") as fdate,CONCAT_WS(" ",YIS.`OTOPLENIE`.`mec`,YIS.`OTOPLENIE`.`god`) as period,'
				   .' YIS.`OTOPLENIE`.`god`,YIS.`OTOPLENIE`. `mec`, sum(IFNULL(YIS.`OTOPLENIE`.`zadol`,0)) as zadol,' 
				   .' sum(IFNULL(YIS.`OTOPLENIE`.`nachisleno`,0)) as nach,sum(IFNULL(YIS.`OTOPLENIE`.`oplacheno`,0)) as oplata,'
				   .' CASE WHEN sum(IFNULL(YIS.`OTOPLENIE`.`nachisleno`,0))>0 THEN '
				   .' ROUND(IFNULL(sum(IFNULL(YIS.`OTOPLENIE`.`oplacheno`,0))/sum(IFNULL(YIS.`OTOPLENIE`.`nachisleno`,0))*100,0),2) ELSE 100 END as percent,' 
				   .' sum(IFNULL(YIS.`OTOPLENIE`.`subsidia`,0)) as subsidia,sum(IFNULL(YIS.`OTOPLENIE`.`budjet`,0)) as budjet,'
				   .' sum(IFNULL(YIS.`OTOPLENIE`.`dolg`,0)) as dolg FROM YIS.`OTOPLENIE` '
				   .' WHERE YIS.`OTOPLENIE`.`data` BETWEEN  DATE_SUB(CURDATE(),INTERVAL 12 MONTH) AND CURDATE()  GROUP BY YIS.`OTOPLENIE`.`data` DESC' ;	
//print($this->sql);		   
		    break;
		  case "podogrev":
			$this->sql='SELECT  DATE_FORMAT(YIS.`PODOGREV`.`data`,"%d-%m-%Y") as fdate,CONCAT_WS(" ",YIS.`PODOGREV`.`mec`,YIS.`PODOGREV`.`god`) as period,'
				   .' YIS.`PODOGREV`.`god`,YIS.`PODOGREV`. `mec`, sum(IFNULL(YIS.`PODOGREV`.`zadol`,0)) as zadol,' 
				   .' sum(IFNULL(YIS.`PODOGREV`.`nachisleno`,0)) as nach,sum(IFNULL(YIS.`PODOGREV`.`oplacheno`,0)) as oplata,'
				   .' CASE WHEN sum(IFNULL(YIS.`PODOGREV`.`nachisleno`,0))>0 THEN '
				   .' ROUND(IFNULL(sum(IFNULL(YIS.`PODOGREV`.`oplacheno`,0))/sum(IFNULL(YIS.`PODOGREV`.`nachisleno`,0))*100,0),2) ELSE 100 END as percent,' 
				   .' sum(IFNULL(YIS.`PODOGREV`.`subsidia`,0)) as subsidia,sum(IFNULL(YIS.`PODOGREV`.`budjet`,0)) as budjet,'
				   .' sum(IFNULL(YIS.`PODOGREV`.`dolg`,0)) as dolg FROM YIS.`PODOGREV` '
				   .' WHERE YIS.`PODOGREV`.`data` BETWEEN  DATE_SUB(CURDATE(),INTERVAL 12 MONTH) AND CURDATE()  GROUP BY YIS.`PODOGREV`.`data` DESC';	
//print($this->sql);		   
		    break;
		  case "voda":
			$this->sql='SELECT  DATE_FORMAT(YIS.`VODA`.`data`,"%d-%m-%Y") as fdate,CONCAT_WS(" ",YIS.`VODA`.`mec`,YIS.`VODA`.`god`) as period,'
				   .' YIS.`VODA`.`god`,YIS.`VODA`. `mec`, sum(IFNULL(YIS.`VODA`.`zadol`,0)) as zadol,' 
				   .' sum(IFNULL(YIS.`VODA`.`nachisleno`,0)) as nach,sum(IFNULL(YIS.`VODA`.`oplacheno`,0)) as oplata,'
				   .' CASE WHEN sum(IFNULL(YIS.`VODA`.`nachisleno`,0))>0 THEN '
				   .' ROUND(IFNULL(sum(IFNULL(YIS.`VODA`.`oplacheno`,0))/sum(IFNULL(YIS.`VODA`.`nachisleno`,0))*100,0),2) ELSE 100 END as percent,' 
				   .' sum(IFNULL(YIS.`VODA`.`subsidia`,0)) as subsidia,sum(IFNULL(YIS.`VODA`.`budjet`,0)) as budjet,'
				   .' sum(IFNULL(YIS.`VODA`.`dolg`,0)) as dolg FROM YIS.`VODA` '
				   .' WHERE YIS.`VODA`.`data` BETWEEN  DATE_SUB(CURDATE(),INTERVAL 12 MONTH) AND CURDATE()  GROUP BY YIS.`VODA`.`data` DESC';	
//print($this->sql);		   
		    break;
		  case "stoki":
			$this->sql='SELECT  DATE_FORMAT(YIS.`STOKI`.`data`,"%d-%m-%Y") as fdate,CONCAT_WS(" ",YIS.`STOKI`.`mec`,YIS.`STOKI`.`god`) as period,'
				   .' YIS.`STOKI`.`god`,YIS.`STOKI`. `mec`, sum(IFNULL(YIS.`STOKI`.`zadol`,0)) as zadol,' 
				   .' sum(IFNULL(YIS.`STOKI`.`nachisleno`,0)) as nach,sum(IFNULL(YIS.`STOKI`.`oplacheno`,0)) as oplata,'
				   .' CASE WHEN sum(IFNULL(YIS.`STOKI`.`nachisleno`,0))>0 THEN '
				   .' ROUND(IFNULL(sum(IFNULL(YIS.`STOKI`.`oplacheno`,0))/sum(IFNULL(YIS.`STOKI`.`nachisleno`,0))*100,0),2) ELSE 100 END as percent,' 
				   .' sum(IFNULL(YIS.`STOKI`.`subsidia`,0)) as subsidia,sum(IFNULL(YIS.`STOKI`.`budjet`,0)) as budjet,'
				   .' sum(IFNULL(YIS.`STOKI`.`dolg`,0)) as dolg FROM YIS.`STOKI` '
				   .' WHERE YIS.`STOKI`.`data` BETWEEN  DATE_SUB(CURDATE(),INTERVAL 12 MONTH) AND CURDATE()  GROUP BY YIS.`STOKI`.`data` DESC';	
//print($this->sql);		   
		    break;
		  case "kvartplata":
			$this->sql='SELECT  DATE_FORMAT(YIS.`KVARTPLATA`.`data`,"%d-%m-%Y") as fdate,CONCAT_WS(" ",YIS.`KVARTPLATA`.`mec`,YIS.`KVARTPLATA`.`god`) as period,'
				   .' YIS.`KVARTPLATA`.`god`,YIS.`KVARTPLATA`. `mec`, sum(IFNULL(YIS.`KVARTPLATA`.`zadol`,0)) as zadol,' 
				   .' sum(IFNULL(YIS.`KVARTPLATA`.`nachisleno`,0)) as nach,sum(IFNULL(YIS.`KVARTPLATA`.`oplacheno`,0)) as oplata,'
				   .' CASE WHEN sum(IFNULL(YIS.`KVARTPLATA`.`nachisleno`,0))>0 THEN '
				   .' ROUND(IFNULL(sum(IFNULL(YIS.`KVARTPLATA`.`oplacheno`,0))/sum(IFNULL(YIS.`KVARTPLATA`.`nachisleno`,0))*100,0),2) ELSE 100 END as percent,' 
				   .' sum(IFNULL(YIS.`KVARTPLATA`.`subsidia`,0)) as subsidia,sum(IFNULL(YIS.`KVARTPLATA`.`budjet`,0)) as budjet,'
				   .' sum(IFNULL(YIS.`KVARTPLATA`.`dolg`,0)) as dolg FROM YIS.`KVARTPLATA` '
				   .' WHERE YIS.`KVARTPLATA`.`data` BETWEEN  DATE_SUB(CURDATE(),INTERVAL 12 MONTH) AND CURDATE()  GROUP BY YIS.`KVARTPLATA`.`data` DESC';	
//print($this->sql);		   
		    break;
		  case "tbo":
			$this->sql='SELECT  DATE_FORMAT(YIS.`TBO`.`data`,"%d-%m-%Y") as fdate,CONCAT_WS(" ",YIS.`TBO`.`mec`,YIS.`TBO`.`god`) as period,'
				   .' YIS.`TBO`.`god`,YIS.`TBO`. `mec`, sum(IFNULL(YIS.`TBO`.`zadol`,0)) as zadol,' 
				   .' sum(IFNULL(YIS.`TBO`.`nachisleno`,0)) as nach,sum(IFNULL(YIS.`TBO`.`oplacheno`,0)) as oplata,'
				   .' CASE WHEN sum(IFNULL(YIS.`TBO`.`nachisleno`,0))>0 THEN '
				   .' ROUND(IFNULL(sum(IFNULL(YIS.`TBO`.`oplacheno`,0))/sum(IFNULL(YIS.`TBO`.`nachisleno`,0))*100,0),2) ELSE 100 END as percent,' 
				   .' sum(IFNULL(YIS.`TBO`.`subsidia`,0)) as subsidia,sum(IFNULL(YIS.`TBO`.`budjet`,0)) as budjet,'
				   .' sum(IFNULL(YIS.`TBO`.`dolg`,0)) as dolg FROM YIS.`TBO` '
				   .' WHERE YIS.`TBO`.`data` BETWEEN  DATE_SUB(CURDATE(),INTERVAL 12 MONTH) AND CURDATE()  GROUP BY YIS.`TBO`.`data` DESC';	
//print($this->sql);		   
		    break;
		} // End of Switch ($what)

		$this->result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		
		while ($this->row = $this->result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}
		$this->results['data']	= $this->res;
		
		return $this->results;
	}
	
	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}