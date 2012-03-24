<?php
// ===========================================================================================
//
// PEditArticleProcess.php
//
// Save changes to a edited article.
//
error_reporting(0);
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();

$intFilter->UserIsSignedInOrRecirectToSignIn();

// -------------------------------------------------------------------------------------------
//
// Take care of _GET variables. Store them in a variable (if they are set).
//

$idArticle =$pc->GETisSetOrSetDefault('idArticle', 0);
$idUser = $pc->SESSIONisSetOrSetDefault('idUser', 0);

$pc->IsNumericOrDie($idArticle, 0);
$pc->IsNumericOrDie($idUser, 0);

$titleArticle  =$pc->POSTisSetOrSetDefault('titleArticle', '');
$textArticle   =$pc->POSTisSetOrSetDefault('textArticle', '');

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