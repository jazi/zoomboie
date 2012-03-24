<?php
// -------------------------------------------------------------------------------------------
//
// PAddCommentProcess.php
//
// -------------------------------------------------------------------------------------------
//
if(!isset($indexIsVisited)) die('No direct access allowed.');
// -------------------------------------------------------------------------------------------
//
// Take care of _GET variables. Store them in a variable (if they are set).
//
$idPost = isset($_GET['idPost']) ? $_GET['idPost'] : '';

if(isset($_POST['save'])) {
 if(empty($_POST['title']) || empty($_POST['text']) || empty($_POST['email'])) {
  $_SESSION['errorMessage'] = "Du måste fylla i alla fält!";
  
 } else {
  // MySQL
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE) or die("Connect failed: " . mysqli_connect_error() . "<br/>");
  $mysqli->set_charset("utf8");

  
$title  = $mysqli->real_escape_string($_POST['title']);
$text  	= $mysqli->real_escape_string($_POST['text']);
$author	= $mysqli->real_escape_string($_POST['author']);
$email 	= $mysqli->real_escape_string($_POST['email']);

$tableComments   	 = DB_PREFIX . 'kommentar';

$query =<<<EOD
INSERT INTO {$tableComments} (comment_idPost, titleComment, textComment, authorComment, emailComment, dateComment)
VALUES ('{$idPost}', '{$title}', '{$text}', '{$author}', '{$email}', NOW());
EOD;

$res = $mysqli->query($query) or die("<p>Could not query my database,</p><code>{$query}</code>");
 
$mysqli->close();
  
$_SESSION['Message'] = "Inlägg sparat!";
	

 }
}
header('Location: ' . WS_SITELINK . "?p=post&idPost={$idPost}");
//$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '?p=home';
//header('Location: ' . WS_SITELINK . "{$redirect}");
exit;
