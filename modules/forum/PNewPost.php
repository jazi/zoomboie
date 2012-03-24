<?php
// -------------------------------------------------------------------------------------------
//
// PNewPost.php
//
// -------------------------------------------------------------------------------------------
//
error_reporting(0);
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();
$intFilter->UserIsSignedInOrRecirectToSignIn();

$idTopic = $pc->GetisSetOrSetDefault('id', 0);
$idTopicP = $pc->POSTisSetOrSetDefault('idP', 0);
$idUser = $pc->SESSIONisSetOrSetDefault('idUser', 0);
$idPost = $pc->POSTisSetOrSetDefault('idPost', 0);
$body = $pc->POSTisSetOrSetDefault('body', '');

$pc->IsNumericOrDie($idTopic, 0);
$pc->IsNumericOrDie($idTopicP, 0);
$pc->IsNumericOrDie($idUser, 0);
$pc->IsNumericOrDie($idPost, 0);
$pc->IsStringOrDie($body);

//$redirectTo = $pc->SESSIONisSetOrSetDefault('history2');

if(isset($_POST['save'])) 
{
	if(empty($_POST['body'])) 
	{
		$_SESSION['errorMessage'] = "Please add a text";
		//$pc->redirectTo($redirectTo);
	} 	
	else 
	{

// MySQL
$db = new CDatabaseController();
$mysqli = $db->Connect();

$body = $mysqli->real_escape_string($body);
$idPost = $mysqli->real_escape_string($idPost);
$idTopic = $mysqli->real_escape_string($idTopic);
$idTopicP = $mysqli->real_escape_string($idTopicP);
$idUser = $mysqli->real_escape_string($idUser);
$spPSavePost= DBSP_PSavePost;

  
// Query
$query = "CALL {$spPSavePost}({$idPost}, '{$body}', {$idUser}, {$idTopicP});";
$res = $db->MultiQuery($query);
$no = $db->RetrieveAndIgnoreResultsFromMultiQuery();
 
$mysqli->close();
	
// Redirect to another page

 header('Location: ' . WS_SITELINK . '?m=forum&p=show&id='.$idTopicP);
    exit;
	}
}
// Form
//
$html = <<<EOD

<h1><center>New Post</center></h1>
 
<form action="?m=forum&p=newP" method="post">
	<table class="form";>
	<tr><td>Write a new post in topic {$idTopic}</td></tr>
	<tr><td><textarea  rows="12" cols="40" name="body"></textarea></td></tr>
    <input type='hidden' name='idP' value='{$idTopic}'>
	<input type='hidden' name='idPost' value='0'>
	<tr style="text-align: center;">
    <td>
     <button name="back" value="undo" type="button" onclick="history.back();">Back</button>
     <button name="undo" value="undo" type="reset" class="negative button">Undo</button>
     <button name="save" value="save" type="submit" class="primary positive button"></span>Save</button>
    </td>
   </tr>
  </table>
 </form>
EOD;

$leftSide = <<<EOD
<p>Later</p>
EOD;
// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
$page = new CHTMLPage();
$page->PrintPage('New Topic', '', $html, '');

?>