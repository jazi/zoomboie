<?php
// 
//PRss.php
//
//
if(!isset($indexIsVisited)) die('No direct access to pagecontroller is allowed.');
//
// MySql
//
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

if(mysqli_connect_error()) {
 echo "Connect failed: " . mysqli_connect_error() . "<br/>";
 exit();
}
//
$mysqli->set_charset("utf8");
//
/**
 * SQL
 */
$tablePost = DB_PREFIX . 'posts';

$query = <<<EOD
--
-- Inläggen
--

SELECT 
idPost,
titlePost,
textPost,
datePost
FROM {$tablePost} 
ORDER BY datePost DESC LIMIT 10;
EOD;

$res = $mysqli->query($query) or die("Could not query database");

/**
 * Inläggen
 */
$ws_sitelink 	= WS_SITELINK;
$ws_title 		= WS_TITLE;

while($row = $res->fetch_object()) {
 $row->datePost = strtotime($row->datePost);
 $row->datePost = date('c', $row->datePost);
 $seq .= "<rdf:li resource=\"{$ws_sitelink}?p=post&amp;id={$row->idPost}\"/>";
 
 $content .= "<item rdf:about=\"{$ws_sitelink}?p=post&amp;id={$row->idPost}\">
				<title>{$row->titlePost}</title>
				<link>{$ws_sitelink}?p=post&amp;id={$row->idPost}</link>
				<description>{$row->textPost}</description>
				<dc:date>{$row->datePost}</dc:date>
			</item>";
}

/**
 * XML
 */
$xml = <<<EOD
<?xml version="1.0" encoding="UTF-8" ?>
<rdf:RDF 
 xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
 xmlns="http://purl.org/rss/1.0/"
 xmlns:dc="http://purl.org/dc/elements/1.1/">
 <channel rdf:about="{$ws_sitelink}?p=rss">
  <title>{$ws_title}</title>
  <link>{$ws_sitelink}</link>
  <description>De senaste inläggen från {$ws_title}</description>
  <items>
   <rdf:Seq>
    {$seq}
   </rdf:Seq>
  </items>
 </channel>
  
 {$content}

</rdf:RDF>
EOD;

$mysqli->close();

echo $xml;
/*
<?xml version="1.0"?>
<rdf:RDF 
 xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
 xmlns="http://purl.org/rss/1.0/"
 xmlns:dc="http://purl.org/dc/elements/1.1/"
>
  <channel rdf:about="http://example.com/news.rss">
    <title>Example Channel</title>
    <link>http://example.com/</link>
    <description>My example channel</description>
    <items>
      <rdf:Seq>
        <rdf:li resource="http://example.com/2002/09/01/"/>
        <rdf:li resource="http://example.com/2002/09/02/"/>
      </rdf:Seq>
    </items>
  </channel>
  <item rdf:about="http://example.com/2002/09/01/">
     <title>News for September the First</title>
     <link>http://example.com/2002/09/01/</link>
     <description>other things happened today</description>
     <dc:date>2002-09-01</dc:date>
  </item>
  <item rdf:about="http://example.com/2002/09/02/">
     <title>News for September the Second</title>
     <link>http://example.com/2002/09/02/</link>
     <dc:date>2002-09-02</dc:date>
  </item>
</rdf:RDF>
*/ 