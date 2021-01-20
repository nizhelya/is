<?php

class QueryAdminPn
{
	private $_db;
	protected $_result;
	protected $_total;
	protected $_count;
	protected $_sql;
	protected $_sql_total;
	protected $_limit;
	protected $_start;
	protected $_page;
	protected $_array;
	//protected $_id;
	protected $_what;
	protected $_year;
	protected $_date;
	protected $_usluga;
	protected $_table;
	protected $_place;
	protected $_type;
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
	
	



public function saveComp(stdClass $params)
	{

		 $_db = $this->__construct();	
		
			$_fullname = $_db->real_escape_string($params->fullname);
			$_shortname = $_db->real_escape_string($params->shortname);
			$_short_description = $_db->real_escape_string($params->short_description);
			$_full_description = $_db->real_escape_string($params->full_description);
			$_address = $_db->real_escape_string($params->address);
			$_post_addr = $_db->real_escape_string($params->post_addr);
			
			$_map_file = $_db->real_escape_string($params->map_file);
			
			$_id = $_db->real_escape_string($params->id);



/*$_fullname = $_db->real_escape_string($params->fullname);
			$_shortname = $_db->real_escape_string($params->shortname);
			$_short_description = $_db->real_escape_string($params->short_description);
			$_full_description = $_db->real_escape_string($params->full_description);
			$_address = $_db->real_escape_string($params->address);
			$_post_addr = $_db->real_escape_string($params->post_addr);
			$_map_coordinates = $_db->real_escape_string($params->map_coordinates);
			$_id = $_db->real_escape_string($params->id);
*/

		 $_sql = 'UPDATE COMPANY_LIST SET fullname="'.$_fullname.'", shortname="'.$_shortname.'", short_description="'.$_short_description.'", full_description="'.$_full_description.'", address="'.$_address.'", post_addr="'.$_post_addr.'", map_file="'.$_map_file.'" WHERE id='.$_id.'';   
		//print($_sql);
                 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 //$row = $_result->fetch_array();
		    $row=mysqli_affected_rows($_db);
		   $results=array();
		 if ($row) { 	
		    $results['success']	= true;
		  
		} else {
		  $results['success']	= false;
		}
		return $results;
	}




public function saveDept(stdClass $params)
	{

		 $_db = $this->__construct();	
		
			$_fullname = $params->fullname;
			$_shortname = $params->shortname;
			$_short_description = $params->short_description;
			$_full_description = $params->full_description;
			$_working_time = $params->working_time;
			$_reception_time = $params->reception_time;
			$_info = $params->info;
			$_id = $params->id;

		 $_sql = 'UPDATE COMPANY_DEPTS SET fullname="'.$_fullname.'", shortname="'.$_shortname.'", short_description="'.$_short_description.'", full_description="'.$_full_description.'", working_time="'.$_working_time.'", reception_time="'.$_reception_time.'", info="'.$_info.'" WHERE id='.$_id.'';   
		//print($_sql);
                 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 //$row = $_result->fetch_array();
		    $row=mysqli_affected_rows($_db);
		   $results=array();
		 if ($row) { 	
		    $results['success']	= true;
		  
		} else {
		  $results['success']	= false;
		}
		return $results;
	}


public function addDept(stdClass $params)
	{

		 $_db = $this->__construct();	
		
			$_comp_id = $params->comp_id;

		 $_sql = 'INSERT COMPANY_DEPTS SET comp_id="'.$_comp_id.'", shortname="Новый отдел"';   
		//print($_sql);
                 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 
		   $row=mysqli_affected_rows($_db);
		   $results=array();
		   $affected_id=$_db->insert_id;

		 if ($row) { 	
		    $results['success']	= true;
		    $results['affected_id'] = $affected_id;
		} else {
		  $results['success']	= false;
		}
		return $results;
	}


public function deleteDept(stdClass $params)
	{

		 $_db = $this->__construct();	
		
			$_id = $params->id;

		 $_sql = 'DELETE FROM COMPANY_DEPTS WHERE id='.$_id.' LIMIT 1';   
		//print($_sql);
                 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 //$row = $_result->fetch_array();
		   $row=mysqli_affected_rows($_db);
		   $results=array();
		   //$affected_id=$_db->insert_id;

		 if ($row) { 	
		    $results['success']	= true;
		    //$results['affected_id'] = $affected_id;
		} else {
		  $results['success']	= false;
		}
		return $results;
	}


// PERSONNEL

public function savePers(stdClass $params)
	{

		 $_db = $this->__construct();	
		
			$_id = $params->id;
			$_dept_id = $params->dept_id;
			$_fio = $params->fio;
			$_position = $params->position;
			$_resume = $params->resume;
			$_responsibility = $params->responsibility;
			$_photo = $params->photo;
			$_disp_in_comp_info = $params->disp_in_comp_info;
			
			

		 $_sql = 'UPDATE COMPANY_PERSONNEL SET dept_id="'.$_dept_id.'", fio="'.$_fio.'", position="'.$_position.'", resume="'.$_resume.'", responsibility="'.$_responsibility.'", photo="'.$_photo.'", disp_in_comp_info="'.$_disp_in_comp_info.'" WHERE id='.$_id.'';   
		//print($_sql);
                 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 //$row = $_result->fetch_array();
		    $row=mysqli_affected_rows($_db);
		   $results=array();
		 if ($row) { 	
		    $results['success']	= true;
		  
		} else {
		  $results['success']	= false;
		}
		return $results;
	}



public function addPers(stdClass $params)
	{

		 $_db = $this->__construct();	
		
			$_dept_id = $params->dept_id;
			$_comp_id = $params->comp_id;

		 $_sql = 'INSERT COMPANY_PERSONNEL SET dept_id="'.$_dept_id.'", comp_id="'.$_comp_id.'",fio="Новый сотрудник"';   
		//print($_sql);
                 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 
		   $row=mysqli_affected_rows($_db);
		   $results=array();
		   $affected_id=$_db->insert_id;

		 if ($row) { 	
		    $results['success']	= true;
		    $results['affected_id'] = $affected_id;
		} else {
		  $results['success']	= false;
		}
		return $results;
	}



public function deletePers(stdClass $params)
	{

		 $_db = $this->__construct();	
		
			$_id = $params->id;

		 $_sql = 'DELETE FROM COMPANY_PERSONNEL WHERE id='.$_id.' LIMIT 1';   
		//print($_sql);
                 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 //$row = $_result->fetch_array();
		   $row=mysqli_affected_rows($_db);
		   $results=array();
		   //$affected_id=$_db->insert_id;

		 if ($row) { 	
		    $results['success']	= true;
		    //$results['affected_id'] = $affected_id;
		} else {
		  $results['success']	= false;
		}
		return $results;
	}

// PHONES



public function saveTel(stdClass $params)
	{

		 $_db = $this->__construct();	
		
			$_id = $params->id;
			$_tel_code = $params->tel_code;
			$_tel = $params->tel;
			$_fax = $params->fax;
			$_mob = $params->mob;
			$_disp_in_comp_info = $params->disp_in_comp_info;
			$_disp_in_dept_info = $params->disp_in_dept_info;
			

		 $_sql = 'UPDATE COMPANY_PHONES SET tel_code="'.$_tel_code.'", tel="'.$_tel.'", fax="'.$_fax.'", mob="'.$_mob.'", disp_in_comp_info="'.$_disp_in_comp_info.'", disp_in_dept_info="'.$_disp_in_dept_info.'" WHERE id='.$_id.'';   
		//print($_sql);
                 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 //$row = $_result->fetch_array();
		    $row=mysqli_affected_rows($_db);
		   $results=array();
		 if ($row) { 	
		    $results['success']	= true;
		  
		} else {
		  $results['success']	= false;
		}
		return $results;
	}



public function addTel(stdClass $params)
	{

		 $_db = $this->__construct();	
		
			$_person_id = $params->person_id;
			
		 $_sql = 'INSERT COMPANY_PHONES SET person_id="'.$_person_id.'", tel_code="Код", tel="Телефон" ';   
		//print($_sql);
                 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 
		   $row=mysqli_affected_rows($_db);
		   $results=array();
		   $affected_id=$_db->insert_id;

		 if ($row) { 	
		    $results['success']	= true;
		    $results['affected_id'] = $affected_id;
		} else {
		  $results['success']	= false;
		}
		return $results;
	}



public function deleteTel(stdClass $params)
	{

		 $_db = $this->__construct();	
		
			$_id = $params->id;

		 $_sql = 'DELETE FROM COMPANY_PHONES WHERE id='.$_id.' LIMIT 1';   
		//print($_sql);
                 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 //$row = $_result->fetch_array();
		   $row=mysqli_affected_rows($_db);
		   $results=array();
		   //$affected_id=$_db->insert_id;

		 if ($row) { 	
		    $results['success']	= true;
		    //$results['affected_id'] = $affected_id;
		} else {
		  $results['success']	= false;
		}
		return $results;

}

// GET RESULT


public function getResults(stdClass $params)
	{
		
		$_total= 0;
		$_id	=0;
		$_page	=0;
		$_limit	=0;
		$_start	=0;
		$_sql ="";
		$_sql_total =null;
		$_what	=" ";
		$_page = (int) $params->page;  // get the requested page 
		$_limit = (int) $params->limit; // get how many rows we want to have into the grid 
		$_start = (int) $params->start;
		
		
		
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
		if(isset($params->year) && ($params->year)) {
		  $_year= $params->year;
		} else {
		   $_year= date('Y');
		}
		if(isset($params->usluga) && ($params->usluga)) {
		      //print_r($params->usluga); 
		      
		      switch($params->usluga){
			    case "вода":
			     $_table='VODA'; 
			    break;
			    case "стоки":
			     $_table='STOKI'; 
			    break;
			    }
		} else {
		    $_table=null;
		}
		if(isset($params->period) && ($params->period)) {
		  $_period= $params->period;
		} else {
		   $_period= '00000000';
		}

		switch ($_what) {
		     
// АДМИНКА ПО ОРГАНИЗАЦИЯМ 

		    case "AdmCompList":
			  //$_sql_total='SELECT * FROM COMPANY_LIST';
			  $_sql='SELECT * FROM COMPANY_LIST ORDER BY shortname asc';
			   
		    break;

		    case "AdmDepts":
			  //$_sql_total='SELECT * FROM COMPANY_LIST';
			  $_sql='SELECT * FROM COMPANY_DEPTS WHERE comp_id='.$_id.' ORDER BY shortname DESC';
			   
		    break;

		    case "AdmPers":
			  //$_sql_total='SELECT * FROM COMPANY_LIST';
			  $_sql='SELECT COMPANY_PERSONNEL.*, COMPANY_DEPTS.shortname FROM COMPANY_PERSONNEL, COMPANY_DEPTS WHERE COMPANY_PERSONNEL.comp_id='.$_id.' AND COMPANY_DEPTS.id=COMPANY_PERSONNEL.dept_id ORDER BY COMPANY_DEPTS.shortname DESC';
			   
		    break;

		    case "AdmTel":
			  //$_sql_total='SELECT * FROM COMPANY_LIST';
			  $_sql='SELECT COMPANY_PHONES.*, COMPANY_PERSONNEL.position FROM COMPANY_PHONES, COMPANY_PERSONNEL WHERE COMPANY_PHONES.person_id='.$_id.' AND COMPANY_PERSONNEL.id=COMPANY_PHONES.person_id ORDER BY COMPANY_PHONES.id DESC';
			   
		    break;



		} // End of Switch ($what)
		
		
		//echo $_WHERE;
		//$sidx = $params->sort["property"];
		//$sord = $params->sort["direction"];
		
		$_db = $this->__construct();
		
		if ($_sql_total){
		    $_count = $_db->query($_sql_total) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		    $_total = $_count->num_rows;
		} else {
		    $_total=0;
		}  

		$_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

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
	

	
	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}