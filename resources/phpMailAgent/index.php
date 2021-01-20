<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
date_default_timezone_set('Europe/Moscow');

class MailAgent {

 private $_SMTPServer = 'smtp.mail.ru';
 private $_SMTPLogin = '<ваш логин>';
 private $_SMTPPass = '<ваш пароль>';
 private $_mail = null;
 private $_mailFrom = '<ваш почтовый ящик>';
 
 private function initMailAgent()
 {
	require_once('class.phpmailer.php');
	
	$this->_mail  = new PHPMailer();
	// Устанавливаем, что наши сообщения будет идти через 
	// SMTP сервер
	$this->_mail->IsSMTP();
    
	// Можно раскомментировать след. строчку для отладки	
	// 1 = Ошибки и сообщения
	// 2 = Только сообщения
	//$mail->SMTPDebug  = 2;        		
	
	// Включение SMTP аутентификации
    // Большинство серверов ее требуют	
	$this->_mail->SMTPAuth   = true;   
	// SMTP Сервер отправки сообщений
	$this->_mail->Host       = $this->_SMTPServer; 
	// Порт сервера (чаще всего 25)
	$this->_mail->Port       = 25; 
	// SMTP Логин для авториации
	$this->_mail->Username   = $this->_SMTPLogin;
	// SMTP Пароль для авторизации	
	$this->_mail->Password   = $this->_SMTPPass;
	// Кодировка сообщения
	$this->_mail->CharSet    = 'utf-8';
 }
 
 public function sendMail( $address, $subject, $body, $from='' )
 {
	if ($this->_mail == null) {
		$this->initMailAgent();
	}
 
	// Устанавливаем от кого будет уходить почта
	$this->_mail->SetFrom($from=='' ? $this->_mailFrom : $from);
	// Устанавливаем заголовк письма
	$this->_mail->Subject    = $subject;
	// Текст сообщения
	$this->_mail->MsgHTML($body);
	
	if (is_array($address)) {
	// Отправка сообщений сразу нескольким пользователям
		foreach($address as $value) {
			$this->_mail->AddAddress($value);
		}
	} else {
		// Адрес получателя. Второй параметр - имя получателя (не обязательно)
		$this->_mail->AddAddress($address);
	}
	// Отправляем сообщение
	if(!$this->_mail->Send()) {
	  echo "Ошибка отправки: " . $this->_mail->ErrorInfo;
	} else {
	  echo "Сообщение отправлено! <br/>";
	}
 }

}

$mail = new MailAgent();

$mail->sendMail('vexell@gmail.com', 'Пример письма 1', 'Текст текст текст');
$mail->sendMail('vexell@gmail.com', 'Пример письма 2', '<h1>Большой заголовок!</h1>');
$mail->sendMail(array('vexell@gmail.com', 'vexell@yandex.ru'), 'Пример письма 3', '<h1>Большой заголовок!</h1>');

