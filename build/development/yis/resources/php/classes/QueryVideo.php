<?php

//$res -new getResults();
//echo $res;

class QueryVideo

{
	private $_db;
	protected $sql;
	protected $_result;
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
	/*
	public function getResults()
	{
		
		$_db = $this->__construct();
		
		
		$results = array();
		$res_video_cat = array();
		$res_video = array();

		$_result_video_cat = $_db->query('SELECT * FROM VIDEO_CAT') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		while ($row_video_cat = $_result_video_cat->fetch_assoc()) {

			array_push($res_video_cat, $row_video_cat);

		      $_result_video = $_db->query('SELECT * FROM VIDEO WHERE video_cat='.$row_video_cat['video_cat'].'') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		   
		     while ($row_video = $_result_video->fetch_assoc()) {				 
				  array_push($res_video_cat, $row_video);				
			} 
			//array_push($res_video_cat, $res_video); 
		}
		      $results= $res_video_cat; 

		return $res_video_cat;
	}
*/
	public function getResults()
	{
		
		$_db = $this->__construct();
		
		
		$results = '[';
		$count_video_cat = 0;

		$_result_video_cat = $_db->query('SELECT * FROM VIDEO_CAT') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		while ($row_video_cat = $_result_video_cat->fetch_assoc()) {

		    $count_video_cat++;
		    if ($count_video_cat > 1) {$results.=',';}
		       $results.='{title:"'.$row_video_cat['name'].'", "items": [';
		     

		    $_result_video = $_db->query('SELECT * FROM VIDEO WHERE video_cat='.$row_video_cat['video_cat'].'') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		    $count_video = 0;

		     while ($row_video = $_result_video->fetch_assoc()) {
				
				$count_video++;
				if ($count_video > 1) {$results.=',';}
				$results.='{video_id:"'.$row_video['video_id'].'",';
				$results.='video_cat:"'.$row_video['video_cat'].'",';
				$results.='video_name:"'.$row_video['video_name'].'",';
				$results.='video_descr:"'.$row_video['video_descr'].'",';
				$results.='video_img:"'.$row_video['video_img'].'",';
				$results.='video_kod:"'.$row_video['video_kod'].'"';
				$results.='}';
			 } 
			   $results.=']}'; 
		}
		 $results.=']'; 
		  echo json_decode($results);

		return $results;
	}

	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}