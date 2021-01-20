<?php

if(isset($_REQUEST['feed']) && ($_REQUEST['feed'])) {
    $feed = $_REQUEST['feed'];
} else {
    $feed = '';
}
if(isset($_REQUEST['what']) && ($_REQUEST['what'])) {
    $what = $_REQUEST['what'];
} else {
    $what = '';
}
if(isset($_REQUEST['what_id']) && ($_REQUEST['what_id'])) {
    $what_id = $_REQUEST['what_id'];
} else {
    $what_id = 0;
}
if(isset($_REQUEST['archived']) && ($_REQUEST['archived'])) {
    $archived = $_REQUEST['archived'];
} else {
    $archived = 0;
}

switch($what){

  case 'feed':
  if($feed != '' && strpos($feed, 'http') === 0){
	  header('Content-Type: text/xml');
	  $xml = file_get_contents($feed);
	 // $xml = str_replace('<content:encoded>', '<content>', $xml);
	  //$xml = str_replace('</content:encoded>', '</content>', $xml);
	//  $xml = str_replace('</dc:creator>', '</author>', $xml);
	//  echo str_replace('<dc:creator', '<author', $xml);
	   echo $xml;
  }
  break;

  case 'local':
if($what_id) {
header('Content-Type: text/xml');	
  $news = new QueryRSS();
  $feed = $news->GetFeed($what_id);
  echo $feed;
}
  break;

  case 'first':

header('Content-Type: text/xml');	
  $news = new QueryRSS();
  $feed = $news->GetFeedFirst();

  echo $feed;

  break;


}


  class QueryRSS
  {
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

	public function GetFeed($params){
		
$_db = $this->__construct();
$what_id = $params;
$details='';
$_result = $_db->query('SELECT * FROM ARTICLES_CATEGORIES WHERE id_cat="'.$what_id.'" AND id_parent="5" LIMIT 1') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
			  

		while($row = $_result->fetch_assoc())
		{
			$details ='';
			
			$details .='<?xml version="1.0" encoding="UTF-8" ?>
				<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:admin="http://webns.net/mvcb/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:feedburner="http://rssnamespace.org/feedburner/ext/1.0" version="2.0">
					<channel>
						<title>'. $row['name'] .'</title>
						<link>'.'www.is.yuzhny.com'.'</link>
						<description>'. $row['name'].'</description>
						';
		



$_archived=0;

$_result_item = $_db->query('SELECT ARTICLES_RELATIONS.id_cat, ARTICLES_ARTICLES.* FROM ARTICLES_RELATIONS, ARTICLES_ARTICLES WHERE ARTICLES_RELATIONS.id_cat="'.$what_id.'" AND ARTICLES_RELATIONS.id_article=ARTICLES_ARTICLES.id_article AND ARTICLES_ARTICLES.archived="'.$_archived.'" ORDER BY  ARTICLES_ARTICLES.date_article DESC LIMIT 30') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);



		while($row = $_result_item->fetch_assoc())
		{
			$details .= '<item>

				<title>'. $row["name"] .'</title>
				<pubDate>'. $row["date_article"] .'</pubDate>
				<author>'. $row["author"] .'</author>
				<link>'.'www.is.yuzhny.com'.'</link>
				<description><![CDATA['. $row["intro"] .']]></description>
				<content><![CDATA['. $row["article"] .']]></content>
			</item>';
		}
}
		$details .= '</channel>
				</rss>';
		//return $items;

		
		return $details;

}

public function GetFeedFirst(){
//echo '!!!';		

$_db = $this->__construct();
$details='';
		$details .='<?xml version="1.0" encoding="UTF-8" ?>
				<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:admin="http://webns.net/mvcb/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:feedburner="http://rssnamespace.org/feedburner/ext/1.0" version="2.0">
					<channel>
						<title>'. 'Последние новости' .'</title>
						<link>'.'www.is.yuzhny.com'.'</link>
						<description>'.'Новости коммунальных служб г. Южного'.'</description>
						';
		
$_archived=0;


$_result_item = $_db->query('SELECT ARTICLES_RELATIONS.id_cat, ARTICLES_CATEGORIES.id_parent, ARTICLES_ARTICLES.* FROM ARTICLES_RELATIONS, ARTICLES_CATEGORIES, ARTICLES_ARTICLES WHERE  ARTICLES_RELATIONS.id_cat=ARTICLES_CATEGORIES.id_cat AND ARTICLES_RELATIONS.id_article=ARTICLES_ARTICLES.id_article AND ARTICLES_ARTICLES.archived="'.$_archived.'" AND ARTICLES_CATEGORIES.id_parent=5 GROUP BY ARTICLES_RELATIONS.id_article ORDER BY ARTICLES_ARTICLES.date_article DESC LIMIT 30') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		while($row = $_result_item->fetch_assoc())
		{
			$details .= '<item>

				<title>'. $row["name"] .'</title>
				<category>'.'Все новости'.'</category>
				<pubDate>'. $row["date_article"] .'</pubDate>
				<author>'. $row["author"] .'</author>
				<link>'.'www.is.yuzhny.com'.'</link>
				<description><![CDATA['. $row["intro"] .']]></description>
				<content><![CDATA['. $row["article"] .']]></content>
			</item>';
		}

		$details .= '</channel>
				</rss>';
		//return $items;

		
		return $details;

}


public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}


	}

	

?>
