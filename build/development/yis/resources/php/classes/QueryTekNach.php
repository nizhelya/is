<?php
include_once './yis_config.php';

class QueryTekNach
{
	private $_db;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $id;
	protected $house_id;
	protected $what;
	protected $nomer;
	protected $type;
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

		$_page = (int) $params->page; 
		$_limit = (int) $params->limit;
		$_start = (int) $params->start;

			
			$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$value;}
		  }
		}
		$this->t= date('Ymd');

		switch ($this->what) {
		
		//==================КВАРТИРНЫЕ ВОДОМЕРЫ=============================//

			case "TekPokVodomera":			
			      $this->sql='SELECT YIS.VODOMER.vodomer_id,'
					  .'YIS.VODOMER.address_id,'
					  .'YIS.VODOMER.house_id,'
					  .'YIS.VODOMER.address,'
					  .'YIS.VODOMER.sdate,'
					  .'YIS.VODOMER.pdate,'
					  .'YIS.VODOMER.voda,'
					  .'YIS.VODOMER.st,'
		      			  .'YIS.VODOMER.voda as type,'
					  .'UCASE(YIS.VODOMER.place) as place,'
					  .'YIS.VODOMER.nomer,'
					  .'YIS.VODOMER.model,'
					  .'YIS.VODOMER.position,'
					  .'YIS.WATER.pok_id,'
					  .'YIS.WATER.data,'
					  .'DATE_FORMAT(YIS.WATER.data,"%d-%m-%Y") as fdate,'
					  .'YIS.WATER.pred,'
					  .'YIS.WATER.tek as tekp,'
					  .'YIS.WATER.tek,'
					  .'YIS.WATER.kub,'
					  .'YIS.WATER.tarif_xv,'
					  .'YIS.WATER.xvoda,'
					  .'YIS.WATER.tarif_gv,'
					  .'YIS.WATER.gvoda,'
					  .'YIS.WATER.tarif_st,'
					  .'YIS.WATER.stoki,'
					  .'YIS.WATER.xkub_lg,'
					  .'YIS.WATER.gkub_lg,'
					  .'YIS.WATER.lgota_xv,'
					  .'YIS.WATER.lgota_gv,'
					  .'YIS.WATER.lgota_st,'
					  .'YIS.WATER.operator '
					  .' FROM YIS.VODOMER,YIS.WATER  '
					  .' WHERE YIS.VODOMER.vodomer_id='.$this->vodomer_id.' AND '
					  .' YIS.WATER.vodomer_id='.$this->vodomer_id.''
					  .' ORDER BY YIS.WATER.data_in DESC limit 1';
				//  print($this->sql);

			break;
			
			case "AllPokVodomera":			
				$this->sql='SELECT YIS.WATER.pok_id,'
					  .'YIS.WATER.vodomer_id,'
					  .'YIS.WATER.nomer,'
					  .'YIS.WATER.address_id,'
					  .'YIS.WATER.address,'
					  .'DATE_FORMAT(YIS.WATER.data,"%d-%m-%Y") as fdate,'
					  .'YIS.WATER.pred,'
					  .'YIS.WATER.tek,'
					  .'YIS.WATER.kub,'
					  .'YIS.WATER.tarif_xv,'
					  .'YIS.WATER.xvoda,'
					  .'YIS.WATER.tarif_gv,'
					  .'YIS.WATER.gvoda,'
					  .'YIS.WATER.tarif_st,'
					  .'YIS.WATER.stoki,'
					  .'YIS.WATER.xkub_lg,'
					  .'YIS.WATER.gkub_lg,'
					  .'YIS.WATER.lgota_xv,'
					  .'YIS.WATER.lgota_gv,'
					  .'YIS.WATER.lgota_st,'
					  .'YIS.WATER.operator '
					  .' FROM YIS.WATER  '
					  .' WHERE YIS.WATER.vodomer_id='.$this->vodomer_id.''
					  .' ORDER BY YIS.WATER.data_in DESC  LIMIT 4 ';
					//  print($this->sql);
			break;
case "AllPokVodomeraAll":			
				$this->sql='SELECT YIS.WATER.pok_id,'
					  .'YIS.WATER.vodomer_id,'
					  .'YIS.WATER.nomer,'
					  .'YIS.WATER.address_id,'
					  .'YIS.WATER.address,'
					  .'DATE_FORMAT(YIS.WATER.data,"%d-%m-%Y") as fdate,'
					  .'YIS.WATER.pred,'
					  .'YIS.WATER.tek,'
					  .'YIS.WATER.kub,'
					  .'YIS.WATER.tarif_xv,'
					  .'YIS.WATER.xvoda,'
					  .'YIS.WATER.tarif_gv,'
					  .'YIS.WATER.gvoda,'
					  .'YIS.WATER.tarif_st,'
					  .'YIS.WATER.stoki,'
					  .'YIS.WATER.xkub_lg,'
					  .'YIS.WATER.gkub_lg,'
					  .'YIS.WATER.lgota_xv,'
					  .'YIS.WATER.lgota_gv,'
					  .'YIS.WATER.lgota_st,'
					  .'YIS.WATER.operator '
					  .' FROM YIS.WATER  '
					  .' WHERE YIS.WATER.vodomer_id='.$this->vodomer_id.''
					  .' ORDER BY YIS.WATER.data_in DESC ';
					//  print($this->sql);
			break;
			case "TekPokVodomerov":			
				 $this->sql='SELECT YIS.VODOMER.address_id,'
					  .'YIS.VODOMER.voda as type,'
					  .'UCASE(YIS.VODOMER.place) as place,'
					  .'YIS.VODOMER.nomer,YIS.VODOMER.nomer AS vn,'
					  .'YIS.VODOMER.model,'
					  .'YIS.VODOMER.st,'
					  .'DATE_FORMAT(max(YIS.WATER.data),"%d-%m-%Y") as fdate,'
					  .'max(YIS.WATER.pred) as pred,'
					  .'max(YIS.WATER.tek) as tek,'
					  .'YIS.WATER.kub,'
					  .'YIS.WATER.tarif_xv,'
					  .'YIS.WATER.xvoda,'
					  .'YIS.WATER.tarif_gv,'
					  .'YIS.WATER.gvoda,'
					  .'YIS.WATER.tarif_st,'
					  .'YIS.WATER.stoki,' 
					  .'YIS.WATER.lgota_xv,'
					  .'YIS.WATER.lgota_gv,'
					  .'YIS.WATER.lgota_st,'
					  .'(SELECT YIS.WATER.operator '
					  .' FROM YIS.WATER '
					  .' WHERE YIS.WATER.nomer=vn '
					  .' ORDER BY YIS.WATER.data DESC LIMIT 1) AS operator '
					  .' FROM YIS.VODOMER,YIS.WATER  '
					  .' WHERE YIS.VODOMER.address_id='.$this->address_id.' AND '
					  .' YIS.VODOMER.nomer= YIS.WATER.nomer AND '
					  .' YIS.WATER.address_id='.$this->address_id.'' 
					  .' GROUP BY YIS.VODOMER.nomer ' 
					  .' ORDER BY YIS.WATER.data DESC';
			break;
			case "AppVodomer"://применяется
				  $this->sql='SELECT YIS.VODOMER.vodomer_id,'
					    .'YIS.VODOMER.address_id,'
					    .'YIS.VODOMER.address,'
					    .'YIS.VODOMER.house_id,'
					    .'YIS.VODOMER.sdate,'
					    .'YIS.VODOMER.pdate,'
					    .'YIS.VODOMER.out,'
					    .'YIS.VODOMER.voda,'
					    .'YIS.VODOMER.st,'
					    .'YIS.VODOMER.place,'
					    .'YIS.VODOMER.nomer,'
					    .'YIS.VODOMER.model_id,'
					    .'YIS.VODOMER.model,'
					    .'YIS.VODOMER.note,'
					    .'YIS.VODOMER.position '
					    .' FROM YIS.VODOMER '
					    .' WHERE YIS.VODOMER.address_id='.$this->address_id.' '
					    .' AND YIS.VODOMER.spisan=0 '
					    .' ORDER BY YIS.VODOMER.vodomer_id DESC';
					// print($this->sql); 
			break;
			
			case "AppHVodomer"://применяется
				  $this->sql='SELECT YIS.VODOMER.vodomer_id,'
					    .'YIS.VODOMER.address_id,'
					    .'YIS.VODOMER.address,'
					    .'YIS.VODOMER.house_id,'
					    .'YIS.VODOMER.sdate,'
					    .'YIS.VODOMER.pdate,'
					    .'YIS.VODOMER.voda,'
					    .'YIS.VODOMER.st,'
					    .'YIS.VODOMER.place,'
					    .'YIS.VODOMER.nomer,'
					    .'YIS.VODOMER.model,'
					    .'YIS.VODOMER.note,'
					    .'YIS.VODOMER.position '
					    .' FROM YIS.VODOMER '
					    .' WHERE YIS.VODOMER.address_id='.$this->address_id.' '
					    .' AND YIS.VODOMER.spisan=1 '
					    .' ORDER BY YIS.VODOMER.vodomer_id DESC';
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
//   КВАРТИРНЫЙ ТЕПЛОМЕР
			case "TekPokTeplomera":			
			      $this->sql='SELECT '
					.'YIS.TEPLOMER.teplomer_id,'
					.'YIS.TEPLOMER.dteplomer_id,'
					.'YIS.TEPLOMER.address_id,'
					.'YIS.TEPLOMER.house_id,'					
					.'YIS.TEPLOMER.nomer,'
					.'YIS.TEPLOMER.model_id,'
					.'YIS.TEPLOMER.model,'
					.'YIS.TEPLOMER.edizm,'
					.'YIS.TEPLOMER.out,'
					.'YIS.PTEPLOMER.pok_id,'
					.'YIS.PTEPLOMER.data,'
					.'DATE_FORMAT(YIS.PTEPLOMER.data,"%d-%m-%Y") as fdate,'
					.'YIS.PTEPLOMER.pred,'
					.'YIS.PTEPLOMER.tek as tekp,'
					.'YIS.PTEPLOMER.tek,'
					.'YIS.PTEPLOMER.qty,'
					.'YIS.PTEPLOMER.koef,'
					.'YIS.PTEPLOMER.gkal,'
					.'YIS.PTEPLOMER.tarif,'
					.'YIS.PTEPLOMER.area,'
					.'YIS.PTEPLOMER.area_lg,'
					.'YIS.PTEPLOMER.gkm2,'
					.'YIS.PTEPLOMER.otoplenie,'
					.'YIS.PTEPLOMER.budjet,'
					.'YIS.PTEPLOMER.operator '
					.' FROM YIS.TEPLOMER ,YIS.PTEPLOMER '
					.' WHERE YIS.TEPLOMER.teplomer_id='.$this->teplomer_id.''					
					.' AND YIS.PTEPLOMER.teplomer_id='.$this->teplomer_id.' '
					.' ORDER BY YIS.PTEPLOMER.data_in DESC limit 1 ';
					//print($this->sql);
			break;
			case "AllPokTeplomera":			
				 $this->sql='SELECT * FROM YIS.PTEPLOMER '		
					.' WHERE YIS.PTEPLOMER.teplomer_id='.$this->teplomer_id.''
					.' ORDER BY YIS.PTEPLOMER.data_in DESC  ';
			break;
			
			case "AppTeplomer"://применяется
				  $this->sql='SELECT '
					.'YIS.TEPLOMER.address_id,'
					.'YIS.TEPLOMER.teplomer_id,'
					.'YIS.TEPLOMER.dteplomer_id,'
					.'YIS.TEPLOMER.house_id,'
					.'YIS.TEPLOMER.address,'
					.'YIS.TEPLOMER.nomer,'
					.'YIS.TEPLOMER.model_id,'
					.'YIS.TEPLOMER.model,'
					.'YIS.TEPLOMER.koef,'
					.'YIS.TEPLOMER.area,'
					.'YIS.TEPLOMER.edizm, '
					.'DATE_FORMAT(YIS.TEPLOMER.sdate,"%d-%m-%Y") as sdate,'
					.'DATE_FORMAT(YIS.TEPLOMER.pdate,"%d-%m-%Y") as pdate,'
					.'YIS.TEPLOMER.note, '
					.'YIS.TEPLOMER.out, '
					.'YIS.TEPLOMER.operator '
					.' FROM YIS.TEPLOMER '
					.' WHERE YIS.TEPLOMER.address_id='.$this->address_id.' '
					.' AND YIS.TEPLOMER.spisan=0 ';
					//print($this->sql); 
			break;
			case "AppHTeplomer"://применяется
				  $this->sql='SELECT '
					.'YIS.TEPLOMER.address_id,'
					.'YIS.TEPLOMER.teplomer_id,'
					.'YIS.TEPLOMER.dteplomer_id,'
					.'YIS.TEPLOMER.house_id,'
					.'YIS.TEPLOMER.address,'
					.'YIS.TEPLOMER.nomer,'
					.'YIS.TEPLOMER.model_id,'
					.'YIS.TEPLOMER.model,'
					.'YIS.TEPLOMER.koef,'
					.'YIS.TEPLOMER.area,'
					.'YIS.TEPLOMER.edizm, '
					.'DATE_FORMAT(YIS.TEPLOMER.sdate,"%d-%m-%Y") as sdate,'
					.'DATE_FORMAT(YIS.TEPLOMER.pdate,"%d-%m-%Y") as pdate,'
					.'DATE_FORMAT(YIS.TEPLOMER.data_spis,"%d-%m-%Y") as data_spis,'
					.'YIS.TEPLOMER.note, '
					.'YIS.TEPLOMER.out, '
					.'YIS.TEPLOMER.operator '
					.' FROM YIS.TEPLOMER '
					.' WHERE YIS.TEPLOMER.address_id='.$this->address_id.' '
					.' AND YIS.TEPLOMER.spisan=1 ';
					//print($this->sql);
					
			break;	
			case "TekNachAppTeplomera":			  
			   $this->sql='SELECT address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,'
				  .'"Гкал" as edizm,gkal as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg FROM YIS.OTOPLENIE WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ';
			//print($this->sql); 
			break;
//БАНКИНГ
			case "TekNachAllApp":		  
			   if($this->raion_id == 2 ||  $this->raion_id == 5 || $this->raion_id == 10){ 
				  $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2,'
					      .' t1.zadol as zadol1,t2.zadol as zadol2,'
					      .' t1.zadol + t2.zadol as zadol ,'
					      .' t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,'
					      .' t1.nachisleno + t2.nachisleno  as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,'
					      .' t1.budjet+t1.pbudjet + t2.budjet+t2.pbudjet as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,'
					      .' t1.oplacheno+t2.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->address_id.'  AND t2.address_id='.$this->address_id.'  AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") ';
				} else {
								$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5, CONCAT_WS(" ",t6.mec,t6.god) as period6,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t4.zadol as zadol4,t5.zadol as zadol5,t6.zadol as zadol6,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t4.zadol + t5.zadol + t6.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,'
					      .'t4.nachisleno as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno as nachisleno6,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .' (t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,'
					      .' ((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .' (t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet)) as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, '
					      .' t4.oplacheno as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,'
					      .' t1.oplacheno+t2.oplacheno+t3.oplacheno+ t4.oplacheno+t5.oplacheno+t6.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, '
					      .' t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia as subsidia, '
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t4.dolg as dolg4,t5.dolg as dolg5,t6.dolg as dolg6 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t4.dolg +t5.dolg+t6.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,YIS.PODOGREV as t3,YIS.OTOPLENIE as t4 ,YIS.KVARTPLATA as t5,YIS.TBO as t6  '
					      .' WHERE t1.address_id='.$this->address_id.'  AND t2.address_id='.$this->address_id.' AND t3.address_id='.$this->address_id.'  AND t4.address_id='.$this->address_id.' AND '
					      .' t5.address_id='.$this->address_id.'  AND t6.address_id='.$this->address_id.' AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") AND t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")';
				}
	//	print($this->sql); 

break;
case "TekNachAllApp1":		  
			   if($this->raion_id == 2 ||  $this->raion_id == 5 || $this->raion_id == 10){ 
				  $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2,'
					      .' t1.zadol as zadol1,t2.zadol as zadol2,'
					      .' t1.zadol + t2.zadol as zadol ,'
					      .' t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,'
					      .' t1.nachisleno + t2.nachisleno  as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,'
					      .' t1.budjet+t1.pbudjet + t2.budjet+t2.pbudjet as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,'
					      .' t1.oplacheno+t2.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->address_id.'  AND t2.address_id='.$this->address_id.'  AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01") ';
				} else {
								$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5, CONCAT_WS(" ",t6.mec,t6.god) as period6,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t4.zadol as zadol4,t5.zadol as zadol5,t6.zadol as zadol6,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t4.zadol + t5.zadol + t6.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,'
					      .'t4.nachisleno as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno as nachisleno6,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .' (t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,'
					      .' ((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .' (t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet)) as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, '
					      .' t4.oplacheno as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,'
					      .' t1.oplacheno+t2.oplacheno+t3.oplacheno+ t4.oplacheno+t5.oplacheno+t6.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, '
					      .' t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia as subsidia, '
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t4.dolg as dolg4,t5.dolg as dolg5,t6.dolg as dolg6 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t4.dolg +t5.dolg+t6.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,YIS.PODOGREV as t3,YIS.OTOPLENIE as t4 ,YIS.KVARTPLATA as t5,YIS.TBO as t6  '
					      .' WHERE t1.address_id='.$this->address_id.'  AND t2.address_id='.$this->address_id.' AND t3.address_id='.$this->address_id.'  AND t4.address_id='.$this->address_id.' AND '
					      .' t5.address_id='.$this->address_id.'  AND t6.address_id='.$this->address_id.' AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01") AND t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")';
				}
		    break;

case "TekNachAllApp2":		  
			   if($this->raion_id == 2 ||  $this->raion_id == 5 || $this->raion_id == 10){ 
				  $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2,'
					      .' t1.zadol as zadol1,t2.zadol as zadol2,'
					      .' t1.zadol + t2.zadol as zadol ,'
					      .' t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,'
					      .' t1.nachisleno + t2.nachisleno  as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,'
					      .' t1.budjet+t1.pbudjet + t2.budjet+t2.pbudjet as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,'
					      .' t1.oplacheno+t2.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->address_id.'  AND t2.address_id='.$this->address_id.'  AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01") ';
				} else {
								$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5, CONCAT_WS(" ",t6.mec,t6.god) as period6,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t4.zadol as zadol4,t5.zadol as zadol5,t6.zadol as zadol6,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t4.zadol + t5.zadol + t6.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,'
					      .'t4.nachisleno as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno as nachisleno6,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .' (t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,'
					      .' ((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .' (t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet)) as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, '
					      .' t4.oplacheno as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,'
					      .' t1.oplacheno+t2.oplacheno+t3.oplacheno+ t4.oplacheno+t5.oplacheno+t6.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, '
					      .' t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia as subsidia, '
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t4.dolg as dolg4,t5.dolg as dolg5,t6.dolg as dolg6 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t4.dolg +t5.dolg+t6.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,YIS.PODOGREV as t3,YIS.OTOPLENIE as t4 ,YIS.KVARTPLATA as t5,YIS.TBO as t6  '
					      .' WHERE t1.address_id='.$this->address_id.'  AND t2.address_id='.$this->address_id.' AND t3.address_id='.$this->address_id.'  AND t4.address_id='.$this->address_id.' AND '
					      .' t5.address_id='.$this->address_id.'  AND t6.address_id='.$this->address_id.' AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01") AND t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")';
				}
		    break;
case "TekNachAllApp3":		  
			   if($this->raion_id == 2 ||  $this->raion_id == 5 || $this->raion_id == 10){ 
				  $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2,'
					      .' t1.zadol as zadol1,t2.zadol as zadol2,'
					      .' t1.zadol + t2.zadol as zadol ,'
					      .' t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,'
					      .' t1.nachisleno + t2.nachisleno  as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,'
					      .' t1.budjet+t1.pbudjet + t2.budjet+t2.pbudjet as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,'
					      .' t1.oplacheno+t2.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->address_id.'  AND t2.address_id='.$this->address_id.'  AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01") ';
				} else {
								$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5, CONCAT_WS(" ",t6.mec,t6.god) as period6,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t4.zadol as zadol4,t5.zadol as zadol5,t6.zadol as zadol6,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t4.zadol + t5.zadol + t6.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,'
					      .'t4.nachisleno as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno as nachisleno6,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .' (t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,'
					      .' ((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .' (t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet)) as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, '
					      .' t4.oplacheno as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,'
					      .' t1.oplacheno+t2.oplacheno+t3.oplacheno+ t4.oplacheno+t5.oplacheno+t6.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, '
					      .' t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia as subsidia, '
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t4.dolg as dolg4,t5.dolg as dolg5,t6.dolg as dolg6 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t4.dolg +t5.dolg+t6.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,YIS.PODOGREV as t3,YIS.OTOPLENIE as t4 ,YIS.KVARTPLATA as t5,YIS.TBO as t6  '
					      .' WHERE t1.address_id='.$this->address_id.'  AND t2.address_id='.$this->address_id.' AND t3.address_id='.$this->address_id.'  AND t4.address_id='.$this->address_id.' AND '
					      .' t5.address_id='.$this->address_id.'  AND t6.address_id='.$this->address_id.' AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01") AND t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")  AND t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")';
				}
		    break;	
				case "AppTekOplata":
			 $this->sql='SELECT rec_id,address_id,address, god, data,kvartplata,otoplenie,podogrev,voda,stoki,tbo,summa,prixod,kassa,nomer,operator,data_in ,CASE WHEN data = "'
			.$this->t.'" AND operator = "'.$this->login.'" THEN 1 ELSE 0 END as chek FROM YIS.OPLATA  WHERE YIS.OPLATA.address_id='.$this->address_id.' ORDER BY YIS.OPLATA.data DESC LIMIT 5';
			// print($this->sql);   
		    break;
			case "AppVodomerKassa"://применяется
				  $this->sql='SELECT YIS.VODOMER.vodomer_id,'
					    .'YIS.VODOMER.address_id,'
					    .'YIS.VODOMER.address,'
					    .'YIS.VODOMER.house_id,'
					    .'YIS.VODOMER.out,'
					    .'YIS.VODOMER.voda,'
					    .'YIS.VODOMER.st,'
					    .'YIS.VODOMER.place,'
					    .'YIS.VODOMER.nomer,'
					    .'YIS.VODOMER.model_id,'
					    .'YIS.VODOMER.model,'
					    .'YIS.VODOMER.note,'
					    .'YIS.VODOMER.position '
					    .' FROM YIS.VODOMER '
					    .' WHERE YIS.VODOMER.address_id='.$this->address_id.'  AND YIS.VODOMER.spisan=0 AND YIS.VODOMER.out=0';
			break;

			case "TekPokTeplomerov":			
			      $this->sql='SELECT YIS.VODOMER.address_id,YIS.VODOMER.type,UCASE(YIS.VODOMER.place) as place,YIS.VODOMER.nomer,YIS.VODOMER.model,DATE_FORMAT(max(YIS.WATER.data),"%d-%m-%Y") as fdate,'
				      .'max(YIS.WATER.pred) as pred,max(YIS.WATER.tek) as tek,YIS.WATER.operator FROM YIS.VODOMER,YIS.WATER  WHERE YIS.VODOMER.address_id='.$this->address_id.' AND YIS.VODOMER.nomer= YIS.WATER.nomer AND '
				      .'YIS.WATER.address_id='.$this->address_id.' GROUP BY YIS.VODOMER.nomer,data ORDER BY YIS.WATER.data DESC ';
			       //print_r($this->sql); 
			break;
			case "OplataApp":			
			      $this->sql='SELECT * FROM YIS.OPLATA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.OPLATA.`data` DESC ' ;
			break;
			case "OtoplenieApp":			
			      $this->sql='SELECT * FROM YIS.OTOPLENIE WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.OTOPLENIE.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "OtoplenieAppAll":			
			      $this->sql='SELECT * FROM YIS.OTOPLENIE WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.OTOPLENIE.`data` DESC' ;
			     // print_r($this->sql); 
			break;
			case "PodogrevApp":			
			      $this->sql='SELECT * FROM YIS.PODOGREV WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.PODOGREV.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "PodogrevAppAll":			
			      $this->sql='SELECT * FROM YIS.PODOGREV WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.PODOGREV.`data` DESC ' ;
			     // print_r($this->sql); 
			break;
		case "VodaApp":			
			      $this->sql='SELECT * FROM YIS.VODA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.VODA.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "VodaAppAll":			
			      $this->sql='SELECT * FROM YIS.VODA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.VODA.`data` DESC' ;
			     // print_r($this->sql); 
			break;
			case "StokiApp":			
			      $this->sql='SELECT * FROM YIS.STOKI WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.STOKI.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "StokiAppAll":			
			      $this->sql='SELECT * FROM YIS.STOKI WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.STOKI.`data` DESC ' ;
			     // print_r($this->sql); 
			break;
			case "KvartplataApp":			
			      $this->sql='SELECT * FROM YIS.KVARTPLATA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.KVARTPLATA.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "KvartplataAppAll":			
			      $this->sql='SELECT * FROM YIS.KVARTPLATA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.KVARTPLATA.`data` DESC ' ;
			     // print_r($this->sql); 
			break;
			case "TboApp":			
			      $this->sql='SELECT * FROM YIS.TBO WHERE `address_id` = '.$this->address_id.'  ORDER BY YIS.TBO.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "TboAppAll":			
			      $this->sql='SELECT * FROM YIS.TBO WHERE `address_id` = '.$this->address_id.'  ORDER BY YIS.TBO.`data` DESC ' ;
			     // print_r($this->sql); 
			break;
			case "LgotaNachVoda":			
			      $this->sql='SELECT * FROM YIS.BVODA WHERE `address_id` = '.$this->address_id.'  AND YIS.BVODA.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachVodaData":			
			      $this->sql='SELECT * FROM YIS.BVODA WHERE `address_id` = '.$this->address_id.'  AND YIS.BVODA.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
			break;
			case "LgotaNachStoki":			
			      $this->sql='SELECT * FROM YIS.BSTOKI WHERE `address_id` = '.$this->address_id.'  AND YIS.BSTOKI.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachStokiData":			
			      $this->sql='SELECT * FROM YIS.BSTOKI WHERE `address_id` = '.$this->address_id.'  AND YIS.BSTOKI.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
			break;
		case "LgotaNachPodogrev":			
			      $this->sql='SELECT * FROM YIS.BPODOGREV WHERE `address_id` = '.$this->address_id.'  AND YIS.BPODOGREV.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachPodogrevData":			
			      $this->sql='SELECT * FROM YIS.BPODOGREV WHERE `address_id` = '.$this->address_id.'  AND YIS.BPODOGREV.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
			break;
			case "LgotaNachOtoplenie":			
			      $this->sql='SELECT * FROM YIS.BOTOPLENIE WHERE `address_id` = '.$this->address_id.'  AND YIS.BOTOPLENIE.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachOtoplenieData":			
			      $this->sql='SELECT * FROM YIS.BOTOPLENIE WHERE `address_id` = '.$this->address_id.'  AND YIS.BOTOPLENIE.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
			break;
			case "LgotaNachKvartplata":			
			      $this->sql='SELECT * FROM YIS.BKVARTPLATA WHERE `address_id` = '.$this->address_id.'  AND YIS.BKVARTPLATA.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachKvartplataData":			
			      $this->sql='SELECT * FROM YIS.BKVARTPLATA WHERE `address_id` = '.$this->address_id.'  AND YIS.BKVARTPLATA.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
			break;
			case "LgotaNachTbo":			
			      $this->sql='SELECT * FROM YIS.BTBO WHERE `address_id` = '.$this->address_id.'  AND YIS.BTBO.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachTboData":			
			      $this->sql='SELECT * FROM YIS.BTBO WHERE `address_id` = '.$this->address_id.'  AND YIS.BTBO.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
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