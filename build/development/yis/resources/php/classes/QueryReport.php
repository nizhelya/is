<?php
include_once './yis_config.php';

class QueryReport
{

	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $id;
	protected $what;
	protected $nomer;
	protected $type_id;
	protected $pokaz;
	protected $pred;
	protected $tek;
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
		switch ($this->what) {
			case "HistoryFlatPayment":			
			      $this->sql='CALL YISGRAND.HistoryFlatPayment('
			      .'"'.$this->address_id.'", '
			      .'"", '
			      .'"", '
			      .' @head,@content,@foot)';
			//  print($this->sql);
			break;
		}
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @head,@content,@foot,@success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['head'] = $this->row['@head'];
			$this->results['content'] = $this->row['@content'];
			$this->results['sql'] = $this->sql;
			$this->results['foot'] = $this->row['@foot'];
			$this->results['success'] = $this->row['@success'];
			$this->results['msg'] = $this->row['@msg'];

		}
			
		/*include_once('absent_file.php')*/


		return $this->results;

}
	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}

}