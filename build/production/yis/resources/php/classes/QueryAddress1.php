<?php

class QueryAddress
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
	protected $what_id;
	protected $what;
	protected $year;
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
	
	public function getResults(stdClass $params)
	{
		
		$_total= 0;
		$_page	=0;
		$_limit	=0;
		$_start	=0;
		$_sql ="";
		$_sql_total =null;
		$_page = (int) $params->page;  // get the requested page 
		$_limit = (int) $params->limit; // get how many rows we want to have into the grid 
		$_start = (int) $params->start;
		
				$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
		  }
		}
		if(isset($params->year) && ($params->year)) {
		  $this->year= $params->year;
		} else {
		   $this->year= date('Y');
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
			    case "отопление":
			     $_table='OTOPLENIE'; 
			    break;
			    case "подогрев":
			     $_table='PODOGREV'; 
			    break;
			    case "квартплата":
			     $_table='KVARTPLATA'; 
			    break;
			    case "т.б.о.":
			     $_table='TBO'; 
			    break;
			}
		} else {
		    $_table=null;
		}
	
		switch ($_what) {
  case "raion":
			  $_sql_total=null; 
				$_sql='SELECT * FROM YIS.RAION WHERE YIS.RAION.raion_id not in(8,9,10)  ORDER BY raion';
			   //print($_sql); 
		    break;
		     case "street":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM YIS.STREET WHERE YIS.STREET.street_id not in(22,23,24,25,26,27,28,29,30,31,32) ';
			    
		    break;


		      case "house":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM HOUSE';
	      //print($_sql);
			    
		    break;
					case "StreetsFromRaion":
					$_sql_total=null; 
					if ($this->what_id==0) {
						$_sql='SELECT * FROM YIS.STREET ORDER BY street';
					} else {
						$_sql='SELECT YIS.STREET.street_id, YIS.STREET.street,YIS.STREET.privat FROM YIS.STREET, YIS.HOUSE 
										WHERE YIS.STREET.street_id=YIS.HOUSE.street_id AND YIS.HOUSE.raion_id='.$this->what_id.' AND YIS.HOUSE.raion_id not in(8,9,10) GROUP BY YIS.STREET.street_id ORDER BY YIS.STREET.street';
					}
		    break;

		    case "HousesFromRaion":
			  $_sql_total=null; 
			  $_sql='SELECT raion_id,street_id,house_id,raion,house,house as item FROM YIS.HOUSE WHERE raion_id= '.$this->what_id.' AND YIS.HOUSE.raion_id not in(8,9,10) ORDER BY house';
			    
		    break;

		   case "HousesFromStreet":
			  $_sql_total=null; 
			  if ($this->what_id == 0) {
			    $_sql='SELECT raion_id,street_id,house_id,house,raion,house,house as item FROM YIS.HOUSE WHERE YIS.HOUSE.raion_id not in(8,9,10) ORDER BY house';
			  }  else if($this->privat) {
			    $_sql='SELECT raion_id,street_id,house_id,address_id,house,raion,house,street,address,appartment,address as item,cast(appartment as unsigned) as app FROM YIS.ADDRESS WHERE street_id= '.$this->what_id.' ORDER BY app';
			   } else {
			    $_sql='SELECT raion_id,street_id,house_id,house,raion,house,house as item FROM YIS.HOUSE WHERE street_id= '.$this->what_id.' ORDER BY house';
			  }   
//print($_sql);
		    break;

		 		case "AddressFromHouses":
			  $_sql_total=null; 
			  if ($this->what_id == 0) { $_sql='SELECT address_id, address FROM YIS.ADDRESS ORDER BY address';
			  } else {
			  $_sql='SELECT * FROM YIS.ADDRESS WHERE house_id= '.$this->what_id.'';
			    //print($_sql);
			  }
		    break;
		     case "address":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM ADDRESS  WHERE address_id='.$this->what_id.' LIMIT 1';
			    
		    break;
		   case "HistoryAppartment":
			  $_sql_total=null; 
			  $_sql= 'SELECT `raion_id`,`house_id`,`address_id`,`address`,`lift`,`fio` as owner ,`order`,`data` as data_ordera,`privat`,'
				  .'`room`,`area_full`,`area_life`,`area_balk`,`area_dop`, `nanim`,`tenant`,`absent`,`podnan`,`lgotchik`, `vxvoda`,'
				  .'`vgvoda`, `teplomer`,`boiler`,`kvartplata`,`otoplenie`,`podogrev`,`voda`,`stoki`,`tbo`,`subsidia`,aggr_voda,' .'aggr_teplo,aggr_tbo,aggr_kv,`tarif_kv`,`tarif_ot`,`tarif_gv`,`tarif_xv`,`tarif_st`,`tarif_tbo`,'
				  .'`what_change`,`data_change`,  inn, passport, vidan, viddata '
				  .' FROM YIS.APP_HISTORY WHERE `address_id`='.$this->what_id.' order by `data_in` DESC'; 
//print($_sql);
		    break;
		    case "Appartment":
			  $_sql_total=null; 
			  $_sql= 'SELECT `raion_id`, `house_id`,`address_id`,`address`,`lift`,`fio` as owner ,`order`,`data` as data_ordera,`privat`,'
				  .'`room`,`area_full`,`area_life`,`area_balk`,`area_dop`, `nanim`,`tenant`,`absent`,`podnan`,`lgotchik`,(CASE WHEN lgotchik > 0 THEN 1 ELSE 0 END ) as lgota, `vxvoda`,'
				  .'`vgvoda`, `teplomer`,`dteplomer_id`,`teplomer_id`,`boiler`,`kvartplata`,`otoplenie`,`podogrev`,`voda`,`stoki`,`tbo`,`subsidia`,aggr_voda,' .'aggr_teplo,aggr_tbo,aggr_kv,`tarif_kv`,`tarif_ot`,`tarif_gv`,`tarif_xv`,`tarif_st`,`tarif_tbo`,'
				  .'`what_change`,`data_change`,`data_change` as chdate, inn, passport, vidan,  viddata, '
				  .'(SELECT `number` FROM YIS.DOGOVOR_YTKE WHERE `address_id`='.$this->what_id.' LIMIT 1) AS dog_ytke, '
				  .'(SELECT `data_start` FROM YIS.DOGOVOR_YTKE WHERE `address_id`='.$this->what_id.' LIMIT 1) AS dog_ytke_data, '
				  .'(SELECT `number` FROM YIS.DOGOVOR_VIK WHERE `address_id`='.$this->what_id.' LIMIT 1) AS dog_vik, '
				  .'(SELECT `data_start` FROM YIS.DOGOVOR_VIK WHERE `address_id`='.$this->what_id.' LIMIT 1) AS dog_vik_data '
				  .' FROM YIS.APPARTMENT WHERE `address_id`='.$this->what_id.' order by `data_in` limit 1'; 
//print($_sql);  
		 break;
		    case "Lgotnik"://применяется
			 // $_sql_total='SELECT * FROM VODOMER WHERE address_id='.$this->what_id.''; 
			   $_sql='SELECT YIS.LGOTAMEN.`lgotnik_id`,YIS.LGOTAMEN.`lgota_id`,YIS.LGOTAMEN.`address_id`, YIS.LGOTAMEN.`address`, YIS.LGOTAMEN.`kartochka`, YIS.LGOTAMEN.`inn`, YIS.LGOTAMEN.`passport`, '
				  .' CONCAT(YIS.LGOTAMEN.`surname`,\' \', SUBSTRING(YIS.LGOTAMEN.`firstname`,1,1),\'.\',SUBSTRING(YIS.LGOTAMEN.`lastname`,1,1),\'.\') as fio, '
				  .' YIS.LGOTAMEN.`surname`, YIS.LGOTAMEN.`firstname`, YIS.LGOTAMEN.`lastname`, YIS.LGOTAMEN.`surname_ua`, YIS.LGOTAMEN.`firstname_ua`, YIS.LGOTAMEN.`lastname_ua`, '
				  .' YIS.LGOTAMEN.`document`, YIS.LGOTAMEN.`lgota`, YIS.LGOTAMEN.`category`, YIS.LGOTAMEN.`people`, YIS.LGOTAMEN.`percent`, YIS.LGOTAMEN.`given`, YIS.LGOTAMEN.`data`, '
				  .' DATE_FORMAT(YIS.LGOTAMEN.data,"%d-%m-%Y") as fdate, YIS.LGOTAMEN.`gr`, YIS.LGOTAMEN.`vkl`, YIS.LGOTAMEN.`raion`, YIS.LGOTAMEN.`operator`, YIS.LGOTAMEN.`data_in` '
				  .' FROM YIS.LGOTAMEN WHERE  YIS.LGOTAMEN.address_id='.$this->what_id.' AND YIS.LGOTAMEN.vkl = "да"';
			break;
//==================КВАРТИРНЫЕ ВОДОМЕРЫ=============================//

		switch ($this->what) {
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


		       case "Oplata":
			  $_sql_total='SELECT * FROM OPLATA  WHERE address_id='.$this->what_id.''; 
			  $_sql='SELECT address_id, address, god, DATE_FORMAT(data,"%d-%m-%Y") as fdate,kvartplata,otoplenie,podogrev,voda,stoki,tbo,summa,prixod,kassa,nomer,operator,date_in  FROM OPLATA  WHERE address_id='.$this->what_id.' ORDER BY data DESC';
			    
		    break;

		       case "YearNachisleno":
			  $_sql_total=null; 
			  $_sql='SELECT god FROM VODA    GROUP BY god DESC'; 
					    
		    break;
		       case "NachDetail":
			 //print_r($_period); 
			  $_sql_total=null; 
			  $_sql='SELECT * FROM '.$_table.' WHERE address_id='.$this->what_id.' and data=DATE_FORMAT("'.$_period.'","%Y-%m-%d")'; 
				//	      print($_sql);
		    break;

		    
		
		     case "AppTarif"://применяется
			 
			  $_sql='(SELECT "Квартплата" as usluga,god,mec, DATE_FORMAT(data,"%d-%m-%Y") as fdate,0 as kub,0 as men,tarif as square,0 as gkal FROM KVARTPLATA WHERE address_id='.$this->what_id.' order by data desc) UNION
			  (SELECT "Водоснабжение" as usluga,god,mec, DATE_FORMAT(data,"%d-%m-%Y") as fdate,CASE WHEN people=0 THEN tarif ELSE 0 END as kub,CASE WHEN people=0 THEN 0 ELSE tarif END as men,0 as square,0 as gkal FROM VODA WHERE address_id='.$this->what_id.' order by data desc) UNION
			  (SELECT "Водоотведение" as usluga,god,mec, DATE_FORMAT(data,"%d-%m-%Y") as fdate,CASE WHEN people=0 THEN tarif ELSE 0 END as kub,CASE WHEN people=0 THEN 0 ELSE tarif END as men,0 as square,0 as gkal FROM STOKI WHERE  address_id='.$this->what_id.' order by data desc) UNION
			   (SELECT "Подогрев" as usluga,god,mec, DATE_FORMAT(data,"%d-%m-%Y") as fdate,CASE WHEN people=0 THEN tarif ELSE 0 END as kub,CASE WHEN people=0 THEN 0 ELSE tarif END as men,0 as square,0 as gkal FROM PODOGREV WHERE  address_id='.$this->what_id.' order by data desc) UNION
			   (SELECT "Отопление" as usluga,god,mec, DATE_FORMAT(data,"%d-%m-%Y") as fdate,0 as kub,0 as men,CASE WHEN gkal=0 THEN tarif ELSE 0 END as square,CASE WHEN gkal=0 THEN 0 ELSE tarif_gkal END as gkal FROM OTOPLENIE WHERE  address_id='.$this->what_id.' order by data desc) UNION
			    (SELECT "Вывоз мусора" as usluga,god,mec, DATE_FORMAT(data,"%d-%m-%Y") as fdate,0 as kub,tarif as men,0 as square,0 as gkal FROM TBO WHERE address_id='.$this->what_id.' order by data desc)';
			    //print($_sql);
		    break;

		   

// ТАРИФЫ

		    case "AppTarifHistory":
			  // $_sql_total='SELECT * FROM VODA WHERE address_id='.$this->what_id.''; 
			  $_sql='(SELECT (Select ELT (1,"Квартплата")) as type, DATE_FORMAT(data,"%d-%m-%Y") as fdate,tarif,(Select ELT (1,"метр кв.")) as edizm FROM KVARTPLATA WHERE address_id='.$this->what_id.' order by data asc) UNION
			  (SELECT (Select ELT (1,"Вода")) as type, DATE_FORMAT(data,"%d-%m-%Y") as fdate,tarif, CASE WHEN people=0 THEN "метр куб." ELSE "чел." END AS "edizm" FROM VODA WHERE address_id='.$this->what_id.' order by data asc) UNION
			  (SELECT (Select ELT (1,"Стоки")) as type, DATE_FORMAT(data,"%d-%m-%Y") as fdate,tarif, CASE WHEN people=0 THEN "метр куб." ELSE "чел." END AS "edizm" FROM STOKI WHERE address_id='.$this->what_id.' order by data asc) UNION
			  (SELECT (Select ELT (1,"Отопление")) as type, DATE_FORMAT(data,"%d-%m-%Y") as fdate,tarif, (Select ELT (1,"метр кв.")) as edizm FROM OTOPLENIE WHERE address_id='.$this->what_id.' order by data asc) UNION
			  (SELECT (Select ELT (1,"Подогрев")) as type, DATE_FORMAT(data,"%d-%m-%Y") as fdate,tarif, CASE WHEN people=0 THEN "метр куб." ELSE "чел." END AS edizm FROM PODOGREV WHERE address_id='.$this->what_id.' order by data asc) UNION (SELECT (Select ELT (1,"Вывоз ТБО")) as type, DATE_FORMAT(data,"%d-%m-%Y") as fdate,tarif,(Select ELT (1,"чел.")) as edizm FROM TBO WHERE address_id='.$this->what_id.' order by data asc)';
		    break;


// ИНФО ПО КВАРТИРЕ

		    case "AppVodomer"://применяется
			 // $_sql_total='SELECT * FROM VODOMER WHERE address_id='.$this->what_id.''; 
			   $_sql='SELECT VODOMER.address_id,VODOMER.house_id, VODOMER.address,VODOMER.voda,VODOMER.place,VODOMER.nomer,VODOMER.model,VODOMER.position FROM VODOMER  WHERE VODOMER.address_id='.$this->what_id.'';
			//print($_sql);  
		    break;
		    
		    case "AppHVodomer"://применяется
			 // $_sql_total='SELECT * FROM VODOMER WHERE address_id='.$this->what_id.''; 
			   $_sql='SELECT HVODOMER.`address_id`,HVODOMER.`house_id`, HVODOMER.`address`,HVODOMER.`voda`,HVODOMER.`place`,HVODOMER.`nomer`,HVODOMER.`model`,HVODOMER.`position` FROM HVODOMER  WHERE HVODOMER.`address_id`='.$this->what_id.'';
			//print($_sql);  
		    break;
		 
		
		    case "AppServ":
			//  $_sql_total='SELECT * FROM APP_SERV WHERE address_id='.$this->what_id.''; 
			  $_sql='SELECT kvartplata,otoplenie,podogrev,xvoda,stoki,tbo,subsidia,DATE_FORMAT(date_change,"%d-%m-%Y") as fdate_change,what_change,operator FROM APP_SERV WHERE address_id='.$this->what_id.' ORDER BY date_change DESC';
			   
		    break;

		    case "AppDev":
			//  $_sql_total='SELECT * FROM APP_DEV WHERE address_id='.$this->what_id.'';
			  $_sql='SELECT vxvoda,vgvoda,teplomer,boiler,DATE_FORMAT(date_change,"%d-%m-%Y") as fdate_change,what_change,operator FROM APP_DEV WHERE address_id='.$this->what_id.' ORDER BY date_change DESC';
			   
		    break;

		    case "AppDevVodomer":
			//  $_sql_total='SELECT * FROM VODOMER WHERE address_id='.$this->what_id.'';
			  $_sql='SELECT nr, vtype, vmodel, place, position FROM VODOMER WHERE address_id='.$this->what_id.' ORDER BY vtype DESC';
			   
		    break;

		    case "AppDevTeplomer":
			//  $_sql_total='SELECT * FROM TEPLOMER WHERE address_id='.$this->what_id.'';
			  $_sql='SELECT t_nr, t_model, izmer, qualent, S_pol, t_on FROM TEPLOMER WHERE address_id='.$this->what_id.'';
			   
		    break;

		    case "AppDevList":
			//  $_sql_total='SELECT * FROM WATER WHERE address_id='.$this->what_id.'';
			  $_sql='SELECT CONCAT_WS (" ", VODOMER.place, VODOMER.vtype) AS ctype, VODOMER.place, VODOMER.vtype, VODOMER.vmodel, WATER.nr, DATE_FORMAT(WATER.data,"%d-%m-%Y") as fdate, WATER.prev, WATER.current, WATER.kub, WATER.podogrev, WATER.stoki FROM WATER, VODOMER WHERE WATER.nr=VODOMER.nr AND WATER.address_id='.$this->what_id.' AND VODOMER.address_id='.$this->what_id.' GROUP BY ctype ORDER BY ctype DESC';
			   
		    break;


		    case "AppDevIndications":  

			$_place = $params->place;
			$_type = $params->type;
			  //$_place = mysql_real_escape_string($params->place);
			  //$_type = mysql_real_escape_string($params->type);

			//  $_sql_total='(SELECT * FROM WATER WHERE WATER.address_id='.$this->what_id.') UNION (SELECT * FROM HWATER WHERE HWATER.address_id='.$this->what_id.')';
			  $_sql='(SELECT VODOMER.place, VODOMER.vtype,VODOMER.vmodel, WATER.nr, DATE_FORMAT(WATER.data,"%d-%m-%Y") as fdate, YEAR(WATER.data) as year, WATER.prev, WATER.current, WATER.kub, WATER.podogrev, WATER.stoki FROM WATER, VODOMER WHERE WATER.nr=VODOMER.nr AND WATER.address_id='.$this->what_id.' AND VODOMER.address_id='.$this->what_id.' AND VODOMER.place="'.$_place.'" AND VODOMER.vtype="'.$_type.'" ORDER BY WATER.data ASC) UNION 
			  (SELECT HVODOMER.place, HVODOMER.vtype, HVODOMER.vmodel, HWATER.nr, DATE_FORMAT(HWATER.data,"%d-%m-%Y") as fdate, YEAR(HWATER.data) as year, HWATER.prev, HWATER.current, HWATER.kub, HWATER.podogrev, HWATER.stoki FROM HWATER, HVODOMER WHERE HWATER.nr=HVODOMER.nr AND HWATER.address_id='.$this->what_id.' AND HVODOMER.address_id='.$this->what_id.' AND HVODOMER.place="'.$_place.'" AND HVODOMER.vtype="'.$_type.'" ORDER BY HWATER.data ASC)';
			   
		    break;


// ЗАПРОСЫ ПО ОРГАНИЗАЦИЯМ 

		    case "CompList":
			  //$_sql_total='SELECT * FROM COMPANY_LIST';
			  $_sql='SELECT * FROM COMPANY_LIST ORDER BY shortname asc';
			   
		    break;

		   case "DeptsList":

			  //$_sql_total='SELECT * FROM COMPANY_LIST';
			  $_sql='SELECT COMPANY_DEPTS.id_dept AS id, COMPANY_DEPTS.id_company AS comp_id, COMPANY_DEPTS.place, COMPANY_DEPTS.shortname, COMPANY_DEPTS.fullname, COMPANY_DEPTS.short_description, COMPANY_DEPTS.full_description, COMPANY_DEPTS.working_time, COMPANY_DEPTS.reception_time, (SELECT GROUP_CONCAT(phone," ", fax, mob SEPARATOR "<br>") FROM COMPANY_PHONES WHERE id_dept = COMPANY_DEPTS.id_dept AND disp_in_comp_info = "y") as phones FROM COMPANY_DEPTS WHERE id_company='.$this->what_id.' ORDER BY shortname ASC';
//print($_sql);
		    break;

		    case "PersList":

			  //$_sql_total='SELECT * FROM COMPANY_LIST';
			  $_sql='SELECT COMPANY_PERSONNEL.id_personnel AS id, COMPANY_PERSONNEL.id_company AS comp_id, COMPANY_PERSONNEL.id_dept AS dept_id, COMPANY_PERSONNEL.place, COMPANY_PERSONNEL.position, COMPANY_PERSONNEL.fio, COMPANY_PERSONNEL.resume, COMPANY_PERSONNEL.responsibility, COMPANY_PERSONNEL.photo, (SELECT GROUP_CONCAT(phone," ", fax, mob SEPARATOR "<br>") FROM COMPANY_PHONES WHERE id_personnel = COMPANY_PERSONNEL.id_personnel) as phones, (SELECT fullname FROM COMPANY_DEPTS WHERE id_dept = COMPANY_PERSONNEL.id_dept) as dept_name FROM COMPANY_PERSONNEL WHERE id_company='.$this->what_id.' AND disp_in_comp_info = "y" ORDER BY position ASC';
//print($_sql);
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
	
	public function createRecord(stdClass $params)
	{

		$_db = $this->__construct();
		if($stmt = $_db->prepare("INSERT INTO HOUSE (house) VALUES (?)")) {
			
			$stmt->bind_param('s', $raion);
			
			$raion = $_db->real_escape_string($params->raion);
			
			$stmt->execute();
			
			$params->id = $_db->insert_id;
			
			$stmt->close();
		}
		
		
		return $params;
	}
	
	public function updateRecords(stdClass $params)
	{
		$_db = $this->__construct();
		
		if ($stmt = $_db->prepare("UPDATE RAION SET house=? WHERE house_id=?")) {
			$stmt->bind_param('si', $raion, $id);

			$raion = $_db->real_escape_string($params->raion);
			
			//cast id to int
			$id = (int) $params->id;
						
			$stmt->execute();
									
			$stmt->close();
		}

		return $params;
	}
	
	public function destroyRecord(stdClass $params)
	{
		$_db = $this->__construct();
		
		$id = $params->id;
		
		if(is_numeric($id)) {
			if($stmt = $_db->prepare("DELETE FROM HOUSE WHERE house_id = ? LIMIT 1")) {
				$stmt->bind_param('i', $id);
				$stmt->execute();
				$stmt->close();
			}
		}
				
		return $this;
	}
	
	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}