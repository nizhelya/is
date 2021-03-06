<?php
include_once './yis_config.php';

class QueryUserLogin
{
	private $_db;
	protected $_hash='e43&^&h(*jhjj1';
	protected $_result;
	protected $_visit;
	protected $_key;
	protected $_stmt;
	protected $_id;
	protected $login;
	protected $password;
	protected $remember;
	protected $_surname;
	protected $_firstname;
	protected $_lastname;
	protected $smtp = "91.192.128.1"; // SMTP сервер
	protected $subject = "Активация учетной записи"; 
	protected $to_email;
	protected $from_email ='yis@yuzhny.com';
	protected $reply_email ='yis@yuzhny.com';
	protected $name_send='Южненская коммунальная информационная система';
	protected $msg_html ; 
	protected $msg_txt ; 
	protected $_mphone;
	protected $address;
	protected $address_id;
	protected $user_id;
	protected $sql;
	
	
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

	public function registration(stdClass $params)
	{

		$_db = $this->__construct();
		//удаляем  тех пользователей, которые в    течении 3 дней не активировали свой аккаунт. 
		$_result = $_db->query("DELETE FROM YISGRAND.USERS WHERE YISGRAND.USERS.active='0' AND UNIX_TIMESTAMP() - UNIX_TIMESTAMP(YISGRAND.USERS.data) > 259200") 
or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

	 function randStr($num = 10)  
	{ 
		$arr = array_merge(range(0, 9), range('!', '@'), range('A', 'Z'));
		$arr = array_merge($arr, $arr);           
		$key = '';  
		$rand = microtime(true); 
           	for($i = 0; $i < $num; $i++)   
		{ 
		    shuffle($arr);   
		    $key .= $arr[(round(($rand * 1000 - floor($rand * 1000)),2) * 100 )];   
		    $rand = microtime(true);   
		}           
		return $key;  
	}

			if(isset($params->remail) && ($params->remail)) {

				if($stmt = $_db->prepare("INSERT INTO YISGRAND.USERS (login,password,surname,firstname,lastname,email,mphone,keysend,visit) VALUES (?,?,?,?,?,?,?,?,?)")){
					  $stmt->bind_param('ssssssssi', $_login,$_password,$_surname,$_firstname,$_lastname, $_email,$_mphone,$_keysend,$_visit);

					  $_keysend = md5(randStr() . $this->_hash );
					  $_visit =1; 

						 if(isset($params->rlogin) && ($params->rlogin)) {
							$_login = $_db->real_escape_string($params->rlogin);
					  } else {
						  $_login= "";
					  }
						if(isset($params->firstpassword) && ($params->firstpassword)) {
							$_password = $_db->real_escape_string($params->firstpassword);
					  } else {
						  $_password= "";
						}
						if(isset($params->remail) && ($params->remail)) {
							$_email = $_db->real_escape_string($params->remail);
					  } else {
						  $_email= "";
					  }
					  if(isset($params->rmphone) && ($params->rmphone)) {
						  $_mphone=$_db->real_escape_string($params->rkod_phone).$_db->real_escape_string($params->rmphone);
					  } else {
						  $_mphone= "";
					  }
					  if(isset($params->remember) && ($params->remember)) {
						  if($params->remember=='on'){
						    $_remember=1;
						  }else{
						  $_remember= 0;
						  }
					  }else {
						  $_remember= 0;
					  }				  
					  if(isset($params->rsurname) && ($params->rsurname)) {
						  $_surname=$_db->real_escape_string($params->rsurname);
					  } else {
						  $_surname= "";
					  }
					  if(isset($params->rfirstname) && ($params->rfirstname)) {
						  $_firstname=$_db->real_escape_string($params->rfirstname);
					  } else {
						  $_firstname= "";
					  }		
					  if(isset($params->rlastname) && ($params->rlastname)) {
						  $_lastname=$_db->real_escape_string($params->rlastname);
					  } else {
						  $_lastname= "";
					  }			
					  $_link='id='. $_keysend;
			
					  require("../phpmailer/class.phpmailer.php");

					//  $href='http://is.yuzhny.com/is/php/activation.php?login='.$_login.'&code='.$_keysend.'';	
					 $href='https://is.yuzhny.com/is/resources/php/activation.php?login='.$_login.'&code='.$_keysend.'';
					// $href='http://localhost/is/resources/php/activation.php?login='.$_login.'&code='.$_keysend.'';	

					  $this->msg_html = "Здравствуйте! Спасибо за регистрацию на портале <Южненская коммунальная информационная система><br>
							    Ваш логин:    ".$_login."<br>
							    Перейдите    по ссылке, чтобы активировать ваш    аккаунт:<br>
							    <a href=".$href.">".$href."</a><br>
							    С  уважением,   Администрация   портала";
					  $this->msg_txt = "Здравствуйте! Спасибо за регистрацию на портале <Южненская коммунальная информационная система>\r\n";
					  $this->msg_txt .= "Ваш логин:    ".$_login."\r\n";
					  $this->msg_txt .= "Перейдите    по ссылке, чтобы активировать ваш    аккаунт:\r\n";
					  $this->msg_txt .=$href."\r\n";
					  $this->msg_txt .="С  уважением,   Администрация   портала";
					  $mail = new PHPMailer();
					  $mail->IsSMTP();// отсылать используя SMTP
					  $mail->Host = '91.192.128.1'; // SMTP сервер
					  $mail->SMTPAuth = true;     // включить SMTP аутентификацию
					  $mail->Username = 'yis';                 // SMTP username
					  $mail->Password = 'yis2018';                           // SMTP password
					  $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					  $mail->Port = 587;          
					  $mail->From     = 'yis@yuzhny.com'; // укажите от кого письмо
					  $mail->FromName = 'Южненская коммунальная информационная система'; // имя отправителя
					  $mail->AddAddress($_email); // е-мэил кому отправлять
					  $mail->AddReplyTo($this->reply_email,"Info"); // е-мэил того кому прейдет ответ на ваше письмо
					  $mail->WordWrap = 350;// set word wrap
					  $mail->IsHTML(true);// отправить в html формате
					  
					  $mail->CharSet    = 'utf-8';
					  $mail->Subject  =  $this->subject; // тема письма
					  $mail->Body     =  $this->msg_html; // тело письма в html формате
					  $mail->AltBody  = $this->msg_txt; // тело письма текстовое
					  //$params->send_email = true;
					  if(!$mail->Send()) {
					    $params->send_email = true;
					  } else {
					    $params->send_email = true;				 
					    $stmt->execute();			
					    $params->id = $_db->insert_id;	
					    $stmt->close();				  
					    if($params->id = $_db->insert_id){	
					      $params->okey	= true;
					    } else { 
					      $params->okey	= false;
					    }
					  }
				}
			} else {
			  $params->send_email = false;
			}
		return $params;
	}

		public function login(stdClass $params)
	{

		$_db = $this->__construct();	

		if(isset($params->login) && ($params->login)) {
		  $this->login= $_db->real_escape_string($params->login);
		} else {
		   $this->login= null;
		}
		
		if(isset($params->password) && ($params->password)) {
		  $this->password= sha1($params->password.$this->_hash );
		} else {
		   $this->password= null;
		}
				    
		$this->sql='SELECT * FROM YISGRAND.USERS WHERE YISGRAND.USERS.login="'.$this->login.'" and YISGRAND.USERS.password="'.$this->password.'"'; 
//print( $this->sql);		 
		 $_result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		$rows=mysqli_affected_rows($_db);
		$_array=array();
		$results = array();		
		if($rows){
		    while ($row = $_result->fetch_assoc()) {			
			array_push($_array, $row);
			$results['success']= true;
			$results['data']= $_array;
		   }
		}else{
			$results['success']	= false;
			
		}
		return $results;
	}
		public function active($name,$kod)
	{

		$_db = $this->__construct();	
		 $_login=$name;
		 $_key=$kod;
		 $_sql_update='UPDATE YISGRAND.USERS SET YISGRAND.USERS.active=1 WHERE YISGRAND.USERS.login="'.$_login.'" and YISGRAND.USERS.keysend="'.$_key.'"'; 
		 $_result = $_db->query($_sql_update) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 if ($_result) { 	
		   return true;
		} else {
		    return false;
		}
	}

	public function checkLogin(stdClass $params)
	{

		 $_db = $this->__construct();	
		 $_login = $_db->real_escape_string($params->rlogin);
		 $_sql = 'SELECT COUNT(*) AS `cnt` FROM YISGRAND.USERS WHERE YISGRAND.USERS.`login` ="'.$_login.'"'; 
 //print( $_sql);		 

                 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 $row = $_result->fetch_array();
		 $total = $row[0]; // всего записей
// print( $total);		 

		 if ($total) { 	
		    $results['success']	= true;
		    $results['login']	= $_login;
		} else {
		  $results['success']	= false;
		}
		return $results;
	}
	public function checkMyFlat(stdClass $params,stdClass $user,$key)
	{

		 $_db = $this->__construct();	
		if(isset($params->address_id) && ($params->address_id)) {
		  $_address_id = (int) $params->address_id;
		} else {
		  $_address_id = 0;
		}
		if(isset($params->raion_id) && ($params->raion_id)) {
		  $_raion_id = $_db->real_escape_string($params->raion_id);
		} else {
		  $_raion_id = 0;
		}
	  if(isset($params->house_id) && ($params->house_id)) {
		  $_house_id = $_db->real_escape_string($params->house_id);
		} else {
		  $_house_id = 0;
		}
	if(isset($params->address) && ($params->address)) {
		  $_address = $_db->real_escape_string($params->address);
		} else {
		  $_address = "";
		}
		if(isset($key) && ($key)) {
		  $_key = sha1($_db->real_escape_string($key).$this->_hash);
		} else {
		  $_key = null;
		}
		if(isset($user->login) && ($user->login)) { 
		  $_login = $_db->real_escape_string($user->login);
		} else {
		  $_login = null;
		}
		if(isset($user->user_id) && ($user->user_id)) { 
		  $_user_id = (int) $user->user_id;
		} else {
		  $_user_id = 0;
		}

//UPDATE `ADDRESS` SET `hkey`=sha1(Concat(`kod`,"e43&^&h(*jhjj1"))  WHERE `house_id`=166
		  //проверяем совпадает ключ введенный пользователем с ключом в базе 
		 $_sql = 'SELECT COUNT(*) AS `cnt` FROM YIS.ADDRESS WHERE YIS.ADDRESS.address_id ='.$_address_id.' and YIS.ADDRESS.hkey="'.$_key.'"';   		
		 $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 $row = $_result->fetch_array();
		 $total = $row[0]; //при совпадении ключей $total больше 0 
//print($_sql);
		 if ($total) { //секретный ключ совпадает
			
			$results['nokey']	= false; //секретный ключ совпадает
			$results['success']	= true;  //запрос положительный

			//проверяем квартиру на предмет наличия ее в базе NYFLAT для этого пользователя
			$_sql = 'SELECT COUNT(*) AS `cnt` FROM YISGRAND.MYFLAT WHERE  YISGRAND.MYFLAT.user_id='.$_user_id.' and YISGRAND.MYFLAT.address_id ='.$_address_id.'';   		
			$_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
			$row = $_result->fetch_array();
			$total = $row[0]; //при наличии квартиры $total больше 0 
			
			if ($total) { 
			      $results['success']	= false; 	 //запрос отрицательный
			      $results['myflat']	= true;	  //квартира уже имеется в базе

			 }else{  //нет квартиры в базе $total равно 0 
	      
			      //добавляем квартиру базу NYFLAT для этого пользователя
			      $_sql = 'INSERT INTO YISGRAND.MYFLAT (user_id, login,raion_id,house_id, address_id, address) VALUES ('.$_user_id.', "'.$_login.'",'.$_raion_id.','.$_house_id.','.$_address_id.',"'.$_address.'")';  
			      //print($_sql);
			      $_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

			      if($_db->insert_id){ //квартира добавлена
				    $results['success']	= true; 	 //запрос положительный
				    $results['myflat']	= false;		//квартира нет в базе
				    $results['noid']	= false;		//квартира не записана в базу
			      } else {
				    $results['success']	= false; 	 //запрос положительный
				    $results['myflat']	= false;		//квартира нет в базе
				    $results['noid']	= true;	//квартира не записана в базу
			      }
			  }

		} else {	//секретный ключ не совпадает
			 $results['success']	= false; 	 //запрос отрицательный
			 $results['nokey']	= true; 	//секретный ключ не совпадает		  
		}
		return $results;
	}

	public function getResults(stdClass $params)
	{
		 $_db = $this->__construct();	
		if(isset($params->what_id) && ($params->what_id)) {
		  $_id = (int) $params->what_id;
		} else {
		  $_id = 0;
		}
		if(isset($params->login) && ($params->login)) {
		  $_login=$_db->real_escape_string($params->login);
		} else {
		   $_login= null;
		}
		if(isset($params->password) && ($params->password)) {
		  $_password= sha1($params->password.$this->_hash);
		} else {
		   $_password= null;
		}
		if(isset($params->keysend) && ($params->keysend)) {
		  $_keysend= $_db->real_escape_string($params->keysend);
		} else {
		   $_keysend= null;
		}
		if(isset($params->what) && ($params->what)) {
		 $_what = $_db->real_escape_string($params->what);
		} else {
		  $_what = null;
		}
		      
		
		switch ($params->what) {
		 
		     case "registration":
			$_sql='SELECT user_id,login,surname,firstname,lastname,email,mphone,role,active,visit,remember FROM YISGRAND.USERS WHERE YISGRAND.USERS.user_id='.$_id.''; 
			//print($_sql);    
		    break;
		      case "login":
			$_sql='SELECT user_id,login,password,surname,firstname,lastname,email,mphone,role,active,visit,remember FROM YISGRAND.USERS WHERE YISGRAND.USERS.user_id='.$_id.''; 
		//print($_sql);    
		    break;
	    
		    case "activation":
			$_sql='SELECT user_id,login,password,surname,firstname,lastname,email,mphone,role,active,visit,remember '
							.' FROM YISGRAND.USERS WHERE YISGRAND.USERS.login="'.$_login.'" and YISGRAND.USERS.keysend="'.$_keysend.'" AND YISGRAND.USERS.active=0'; 
		  $_sql_update='UPDATE YISGRAND.USERS SET YISGRAND.USERS.active=1, YISGRAND.USERS.password= sha1(concat(YISGRAND.USERS.password,"'.$this->_hash.'")) '
							.' WHERE YISGRAND.USERS.login="'.$_login.'" and YISGRAND.USERS.keysend="'.$_keysend.'" AND YISGRAND.USERS.active=0';;

		    break;
			

		} // End of Switch ($what)
		
		
		
		$_db = $this->__construct();
		
		
		$_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		$rows=mysqli_affected_rows($_db);
		$_array=array();
		$results = array();		
		if($rows){
		    while ($row = $_result->fetch_assoc()) {			
			array_push($_array, $row);
			$results['success']= true;
			$results['data']= $_array;
		   }
	  $_result = $_db->query($_sql_update) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}else{
			$results['success']	= false;
			
		}
		
		
		return $results;
	}
	public function updateUser(stdClass $params)
	{
		$_db = $this->__construct();
		//print($params->user_id);
		if ($stmt = $_db->prepare("UPDATE YISGRAND.USERS SET  address_id=?, address=? WHERE user_id=?")) {
			$stmt->bind_param('isi', $this->address_id, $this->address,$this->user_id);
			$this->user_id = $params->user_id;
			$this->address_id = $params->address_id;
			$this->address = $_db->real_escape_string($params->address);
			$stmt->execute();
			$stmt->close();
		}

		return $params;
	}
	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}

}