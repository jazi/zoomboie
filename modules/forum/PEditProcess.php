<?php
// ===========================================================================================
//
// PEditProcess.php
//
// Save changes to a edited post.
//
error_reporting(0);
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();

$intFilter->UserIsSignedInOrRecirectToSignIn();

// -------------------------------------------------------------------------------------------
//
//

$idPost 	=$pc->POSTisSetOrSetDefault('idPost', 0);
$idTopic 	=$pc->POSTisSetOrSetDefault('idTopic', 0);
$author 	=$pc->POSTisSetOrSetDefault('author', 0);
$idUser 	=$pc->SESSIONisSetOrSetDefault('idUser', 0);
$textBody   =$pc->POSTisSetOrSetDefault('body', '');

$pc->IsNumericOrDie($idPost, 0);
$pc->IsNumericOrDie($idTopic, 0);
$pc->IsNumericOrDie($idUser, 0);
$pc->IsNumericOrDie($author, 0);
$pc->IsStringOrDie($textBody);

 if(empty($textBody)) {
  $_SESSION['errorMessage'] = "No field can be empty.";
  exit;
 } 

// -------------------------------------------------------------------------------------------
//
// Prepare and perform a SQL query.
// 

$db = new CDatabaseController();
$mysqli = $db->Connect();

$idPost = $mysqli->real_escape_string($idPost);
$idTopic = $mysqli->real_escape_string($idTopic);
$author = $mysqli->real_escape_string($author);
$textBody = $mysqli->real_escape_string($textBody);

$spPSavePost = DBSP_PSavePost;
// -------------------------------------------------------------------------------------------
// Create query
$query = "CALL {$spPSavePost}({$idPost}, '{$textBody}', {$author}, {$idTopic});";

// -------------------------------------------------------------------------------------------  
// Perform query
$res = $db->MultiQuery($query);
$no = $db->RetrieveAndIgnoreResultsFromMultiQuery();
$mysqli->close();

// -------------------------------------------------------------------------------------------
// Redirect to another page

header('Location: ' . WS_SITELINK . "?m=forum&p=show&id=".$idTopic);
exit;

?>