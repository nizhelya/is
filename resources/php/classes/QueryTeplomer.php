<?php
include_once './yis_config.php';

class QueryTeplomer
{

	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $teplomer_id;
	protected $dteplomer_id;
	protected $pok_id;
	protected $address_id;
	protected $what;
	protected $data=NULL;
	protected $res=array();	
	public	  $results=array();
	
		
	public function __construct()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YIS');
		
		if ($_db->connect_error) {
			die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		$_db->set_charset("utf8");
    
		return $_db;
	}
	public function getResults(stdClass $params)
{
		$_db = $this->__construct();	

		$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
		  }
		}
	      
		switch ($this->what) {
//   КВАРТИРНЫЙ ТЕПЛОМЕР
			case "TekPokTeplomera":			
			$this->sql='SELECT t1.*,t2.pred,t2.tek,t2.qty,t2.pok_id,t2.gkal,t2.data as fdate,t2.date_do as date_old,t2.tek as tekp,t2.gkal as newKubov FROM YIS.TEPLOMER as t1,YIS.PTEPLOMER  as t2  WHERE t1.teplomer_id='.$this->teplomer_id.' AND t2.teplomer_id='.$this->teplomer_id.' ORDER BY t2.pok_id DESC limit 1';		
					//print($this->sql);
			break;
			case "AllPokTeplomera":			
				$this->sql='SELECT t1.*,t1.data as fdate,t1.date_do as date_old,t1.gkal as newKubov FROM YIS.PTEPLOMER as t1 WHERE t1.teplomer_id='.$this->teplomer_id.'  ORDER BY t1.pok_id DESC  LIMIT 10 ';
				//	  print($this->sql);
			break;
			case "AllPokTeplomeraAll":
				$this->sql='SELECT t1.*,t1.data as fdate,t1.date_do as date_old,t1.gkal as newKubov FROM YIS.PTEPLOMER as t1 WHERE t1.teplomer_id='.$this->teplomer_id.'  ORDER BY t1.pok_id DESC  ';

			break;
			
			case "AppTeplomer"://применяется
				  $this->sql='SELECT *  FROM YIS.TEPLOMER as t1  WHERE t1.address_id='.$this->address_id.'  AND t1.spisan=0 ';
					//print($this->sql); 
			break;
			case "AppHTeplomer"://применяется
				  $this->sql='SELECT * FROM YIS.TEPLOMER as t1  WHERE t1.address_id='.$this->address_id.' AND t1.spisan=1 ';
					//print($this->sql);
					
			break;	
			case "TekNachAppTeplomera":			  
			   $this->sql='SELECT address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,'
				  .'"Гкал" as edizm,gkal as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg FROM YIS.OTOPLENIE WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ';
			//print($this->sql); 
			break;
		
		} // End of Switch ($what)	
		
//		$this->result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ')');

		
		while ($this->row = $this->result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}
		$this->results['data']	= $this->res;
		
		return $this->results;
	}

	
	public function delPokTeplomera(stdClass $params)
	{

	
		$_db = $this->__construct();	

		$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
		  }
		}

		switch ($this->what) {
			case "ATeplomer":			
			     $this->sql='CALL YISGRAND.delete_pokaz_ateplomera('.$this->pok_id.',@success,@msg)';
		//print($this->sql);
			break;
	  
		}
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		$this->sql_callback='SELECT @success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
		}
			
		return $this->results;

	}
	public function newPokTeplomera(stdClass $params)
	{

	
		$_db = $this->__construct();	

		$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
		  }
		}
		/*NewPokTeplomera*/
		switch ($this->what) {
			case "ATeplomer":			
			      $this->sql='CALL YISGRAND.input_new_pokaz_ateplomera_is('.$this->address_id.', '.$this->teplomer_id.',"'.$this->date_old.'","'.$this->date_new.'", '
			    .'"'.$this->tek.'",'.$this->newValue.',"'.$this->login.'", @success,@msg)';
			break;
		

		}
		
		//print($this->sql);
//		$this->result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);


		$this->sql_callback='SELECT @success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
		}
			
		return $this->results;

	}


public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}