<?php

$isForm = false;
$isUpload = false;


$arch = (int) $_GET['archived']; 


$a = new QueryTreeArticles;
$b = $a->getTreeArticles($arch);
echo $b;
//print_r $b;
//return $b;

class QueryTreeArticles
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
	public $results='';
public $count_company = 0;
public $count_dept = 0;
public $count_pers = 0;
//public $arch2 = $arch;
	
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
	
	




public function getTreeArticles($arch)
	{
		
		$_db = $this->__construct();
		
		
	//	$this->results = '{"text":".","children":[';
$this->results = '[';

		$count_company = 0;

		$_result_company = $_db->query('SELECT * FROM ARTICLES_CATEGORIES WHERE id_parent= 5 ') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		while ($row_company = $_result_company->fetch_assoc()) {

		    $count_company++;
		    if ($count_company > 1) {$this->results.=',';}



		    $this->results.='{id:"cat'.$row_company['id_cat'].'",';
		    $this->results.='orig_id:"'.$row_company['id_cat'].'",';
		    $this->results.='text:"'.$row_company['name'].'",';
		    $this->results.='what:"category",';
		    $this->results.='date:"",';
		    $this->results.='iconCls:"task-folder",';
		    $this->results.='expanded:false,';


$_result_articles = $_db->query('SELECT * FROM ARTICLES_CATEGORIES WHERE id_parent = '.$row_company['id_cat'].'') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
$row=mysqli_affected_rows($_db);
$this->results.='subcategories:"'.$row.'",';


$_result_articles = $_db->query('SELECT * FROM ARTICLES_RELATIONS WHERE id_cat = '.$row_company['id_cat'].'') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
$row=mysqli_affected_rows($_db);
$this->results.='articles:"'.$row.'",';
	    		   
$child2 =1;  


		    $_result_depts = $_db->query('SELECT * FROM ARTICLES_CATEGORIES WHERE id_parent = '.$row_company['id_cat'].'') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		    

 //$this->results.= '========'.$_result_depts->fetch_assoc().'========';

		    $count_dept = 0;
		     while ($row_depts = $_result_depts->fetch_assoc()) {
				
if ($child2 == 1) {$this->results.='children:['; $child2 = $child2 + 1;}

				$count_dept++;
				if ($count_dept > 1) {$this->results.=',';}
				$this->results.='{id:"subcat'.$row_depts['id_cat'].'",';
				$this->results.='orig_id:"'.$row_depts['id_cat'].'",';
				$this->results.='text:"'.$row_depts['name'].'",';
				$this->results.='what:"subcategory",';
				$this->results.='date:"",';
				$this->results.='iconCls:"task-folder",';
				$this->results.='expanded:false,';

$_result_articles = $_db->query('SELECT * FROM ARTICLES_CATEGORIES WHERE id_parent = '.$row_depts['id_cat'].'') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
$row=mysqli_affected_rows($_db);
$this->results.='subcategories:"'.$row.'",';


$_result_articles = $_db->query('SELECT * FROM ARTICLES_RELATIONS WHERE id_cat = '.$row_depts['id_cat'].'') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
$row=mysqli_affected_rows($_db);
$this->results.='articles:"'.$row.'",';
					
$child3 =1;
				$_result_personnel = $_db->query('SELECT ARTICLES_RELATIONS.id_article, ARTICLES_RELATIONS.id_cat, ARTICLES_RELATIONS.place, ARTICLES_ARTICLES.name,  
DATE_FORMAT(ARTICLES_ARTICLES.date_article, "%d %m %Y") AS date,ARTICLES_ARTICLES.published FROM ARTICLES_RELATIONS, ARTICLES_ARTICLES WHERE ARTICLES_RELATIONS.id_cat='.$row_depts['id_cat'].' AND ARTICLES_ARTICLES.id_article=ARTICLES_RELATIONS.id_article AND ARTICLES_ARTICLES.archived="'.$arch.'"') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
								
				$count_pers = 0;
				while ($row_personnel = $_result_personnel->fetch_assoc()) {

			$count_pers++;
			if ($count_pers > 1) {$this->results.=',';}


if ($child3 == 1) {$this->results.='children:['; $child3 = $child3 + 1;}
$rnd = rand(10000, 10000000);

				        $this->results.='{id:"art-'.$row_personnel['id_cat'].'-'.$row_personnel['id_article'].'-'.$rnd.'",';
				        $this->results.='orig_id:"'.$row_personnel['id_article'].'",';
					$this->results.='text:"'.$row_personnel['name'].'",';
					$this->results.='date:"'.$row_personnel['date'].'",';
					$this->results.='place:"'.$row_personnel['place'].'",';
					$this->results.='published:"'.$row_personnel['published'].'",';
					$this->results.='what:"article",';
					$this->results.='iconCls:"task",';

					$this->results.='leaf:true}';

/*if ($row_personnel['published'] == 1) {
$this->results.='checked:true ';
} else {
$this->results.='checked:false ';
}*/

					

				}
				if ($child3 > 1) {$this->results.=']'; } else {$this->results.='expandable:false';  /*$this->results.='leaf:true'; */ /*$this->results= trim($this->results,',');*/}
				 $this->results.='}'; 
			 } 




/////////////////////////////////////////////////////////// СТАТЬИ В ОСНОВНЫХ КАТЕГОРИЯХ


$_result_personnel2 = $_db->query('SELECT ARTICLES_RELATIONS.id_article, ARTICLES_RELATIONS.id_cat, ARTICLES_RELATIONS.place, ARTICLES_ARTICLES.name,  
DATE_FORMAT(ARTICLES_ARTICLES.date_article, "%d %m %Y") AS date,ARTICLES_ARTICLES.published FROM ARTICLES_RELATIONS, ARTICLES_ARTICLES WHERE  ARTICLES_RELATIONS.id_cat='.$row_company['id_cat'].' AND ARTICLES_ARTICLES.id_article=ARTICLES_RELATIONS.id_article AND ARTICLES_ARTICLES.archived="'.$arch.'"') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
								
				$count_pers2 = 0;
				while ($row_personnel2 = $_result_personnel2->fetch_assoc()) {





			$count_pers2++;
			if ($count_pers2 > 1 or $child2 >1) {$this->results.=',';}



if ($child2 == 1) {$this->results.='children:['; $child2 = $child2 + 1;}

$rnd = rand(10000, 10000000);

					$this->results.='{id:"art-'.$row_personnel2['id_cat'].'-'.$row_personnel2['id_article'].'-'.$rnd.'",';
				        $this->results.='orig_id:"'.$row_personnel2['id_article'].'",';
					$this->results.='text:"'.$row_personnel2['name'].'",';
					$this->results.='date:"'.$row_personnel2['date'].'",';
					$this->results.='place:"'.$row_personnel2['place'].'",';
					$this->results.='published:"'.$row_personnel2['published'].'",';
					$this->results.='what:"article",';
					$this->results.='iconCls:"task",';

					$this->results.='leaf:true}';

/*if ($row_personnel2['published'] == 1) {
$this->results.='checked:true }';
} else {
$this->results.='checked:false }';
}
*/



}

/////////////////////////////////////////////////////////




			  if ($child2 > 1) {$this->results.=']'; } else {$this->results.='expandable:false'; /*$this->results.='leaf:true'; */ /*$this->results= trim($this->results,',');*/}
			   $this->results.='}'; 
		}

//$this->results= trim($this->results,',');

		  $this->results.=']'; 
 //$this->results.='}'; 

	  $results = Array();
//	  $results['success']	= true;


//	  $results['data'] = $this->results;

$results = $this->results;


		return $results;
	}




	
	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}

