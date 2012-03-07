<?php
// ===========================================================================================
//
// PEditArticleProcess.php
//
// Save changes to a edited article.
//
if(!isset($indexIsVisited)) die('No direct access allowed.');

//session_start();
//
require_once(TP_SOURCEPATH . 'FLoggInControl.php');
LoggInControl();

// -------------------------------------------------------------------------------------------
//
// Take care of _GET variables. Store them in a variable (if they are set).
//
$idArticle = isset($_GET['idArticle']) ? $_GET['idArticle'] : 0;
$idUser = isset($_SESSION['idUser']) ? $_SESSION['idUser'] : 0;

//$idArticle = $mysqli->real_escape_string($idArticle);
$titleArticle  = ($_POST['titleArticle']);
$textArticle   = ($_POST['textArticle']);


 if(empty($_POST['titleArticle']) || empty($_POST['textArticle'])) {
  $_SESSION['errorMessage'] = "No field can be empty.";
 } 

// -------------------------------------------------------------------------------------------
//
// Prepare and perform a SQL query.
// 

$db = new CDatabaseController();
$mysqli = $db->Connect();

$idArticle = $mysqli->real_escape_string($idArticle);
$titleArticle = $mysqli->real_escape_string($titleArticle);
$textArticle = $mysqli->real_escape_string($textArticle);

$spPUpdateArticle = DBSP_PUpdateArticle;
// -------------------------------------------------------------------------------------------
// Create query
$query = "CALL {$spPUpdateArticle}({$idArticle}, {$idUser}, '{$titleArticle}', '{$textArticle}');";

// -------------------------------------------------------------------------------------------  
// Perform query
$res = $db->MultiQuery($query);
$no = $db->RetrieveAndIgnoreResultsFromMultiQuery();
$mysqli->close();

// -------------------------------------------------------------------------------------------
// Redirect to another page

$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'articleShow' ;
header('Location: ' . WS_SITELINK . "?p={$redirect}");
exit;

?>