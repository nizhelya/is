<?php
include_once './yis_config.php';

class QueryVodomer
{

	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $address_id;
	protected $what;
	protected $vodomer_id;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $pok_id;	
	protected $type;
	protected $pokaz;
	protected $pred;
	protected $tek;
	protected $st;
	protected $kub;
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
	      
//==================КВАРТИРНЫЕ ВОДОМЕРЫ=============================//

		switch ($this->what) {
			case "TekPokVodomera":			
			      $this->sql='SELECT t1.*,t2.*,t1.voda as type,UCASE(t1.place) as place,t1.date_ar as data_ot,t1.date_ao as data_do,t2.date_do as date_old,t2.tek as tekp,t2.kub as newKubov FROM YIS.VODOMER as t1,YIS.WATER  as t2  WHERE t1.vodomer_id='.$this->vodomer_id.' AND t2.vodomer_id='.$this->vodomer_id.' ORDER BY t2.pok_id DESC limit 1';
			break;
			
			case "TekPokWater":			
			        $this->sql='SELECT t1.*,t2.*,t1.voda as type,UCASE(t1.place) as place,t1.date_ar as data_ot,t1.date_ao as data_do,t2.date_do as date_old,t2.tek as tekp,t2.kub as newKubov FROM YIS.VODOMER as t1,YIS.WATER  as t2  WHERE t1.vodomer_id=t2.vodomer_id and t2.pok_id ='.$this->pok_id.'';

			break;
			case "AllPokVodomera":			
				$this->sql='SELECT * FROM YIS.WATER as t1 WHERE t1.vodomer_id='.$this->vodomer_id.'  ORDER BY t1.pok_id DESC  LIMIT 10 ';
				//	  print($this->sql);
			break;
			case "AllPokVodomeraAll":
				$this->sql='SELECT * FROM YIS.WATER as t1 WHERE t1.vodomer_id='.$this->vodomer_id.'  ORDER BY t1.pok_id DESC  ';

			break;

			case "AppVodomer"://применяется
				 $this->sql='SELECT t1.`vodomer_id`,t2.* FROM YIS.AVODOMER as t1 LEFT JOIN YIS.VODOMER as t2 USING (vodomer_id) '
					    .' WHERE t1.address_id='.$this->address_id.' AND t2.spisan=0  ORDER BY t1.vodomer_id DESC';
					// print($this->sql); 
			break;
			
			case "AppHVodomer"://применяется
				  $this->sql='SELECT *  FROM YIS.VODOMER as t1 WHERE t1.address_id='.$this->address_id.' AND t1.spisan=1 ORDER BY t1.vodomer_id DESC';
					  // print($this->sql); 
					
			break;
			case "TekNachAppVodomera":			  
			   $this->sql='SELECT address_id, data, fdate, usluga, period, sum(zadol) as zadol, hzadol ,edizm, qty,gkub,tarif,'
					.'sum(norma) as norma,sum(xvoda) as xvoda,sum(gvoda) as gvoda,sum(perer) as perer ,sum(nachisleno) as nachisleno,'
					.'sum(budjet) as budjet,sum(pbudjet) as pbudjet, sum(oplacheno) as oplacheno,sum(subsidia) as subsidia, sum(dolg) as dolg,hdolg '
					.' FROM ( '
					.'(SELECT 1 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,'
					.'SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
					.'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,xkub_lg+gkub_lg as gkub,tarif,'
					.'norma,xvoda, gvoda ,perer,nachisleno,budjet,pbudjet,oplacheno,subsidia,dolg,0 as hdolg '
					.' FROM YIS.VODA  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ) '
					.' UNION '
					.' (SELECT 2 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,'
					.' SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
					.'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,xkub_lg+gkub_lg as gkub,tarif,'					
					.'norma,xvoda, gvoda ,perer,nachisleno,budjet,pbudjet,oplacheno,subsidia,dolg,0 as hdolg '
					.' FROM YIS.STOKI  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ) ' 
					.' UNION '
					.' (SELECT 3 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,'
					.' SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
					.'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,kub+people as qty,gkub_lg as gkub,tarif,'
					.'norma,0 as xvoda, podogrev as gvoda ,perer,nachisleno,budjet,pbudjet,oplacheno,subsidia,dolg,0 as hdolg '
					.' FROM YIS.PODOGREV  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ) ' 
					.' ORDER BY data DESC ,p) AS a group by p with rollup';
			//print($this->sql); 
			break;

		} // End of Switch ($what)	      StWaterHouse
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'( '.$this->sql.' )' . $_db->connect_error);
		
		while ($this->row = $this->result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}
		$this->results['data']	= $this->res;
		
		return $this->results;
	}
	

public function delPokVodomera(stdClass $params)
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
			case "AVodomer":
			      $this->sql='CALL YISGRAND.delete_pokaz_avodomera_bank('.$this->pok_id.','.$this->address_id.',"'.$this->login.'",@success,@msg)';
			break;
	
		}
//print($this->sql);

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
		}			
		return $this->results;
	}
	public function newPokVodomera(stdClass $params)
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
			case "AVodomer":
			     			$this->sql='CALL YISGRAND.input_new_pokaz_avodomer_bank('.$this->vodomer_id.',"'.$this->tek.'","'.$this->newValue.'","'.$this->login.'",@success,@msg)';

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


public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}