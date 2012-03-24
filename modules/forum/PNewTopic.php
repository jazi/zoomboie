<?php
// -------------------------------------------------------------------------------------------
//
// PNewTopic.php
//
// -------------------------------------------------------------------------------------------
//
error_reporting(0);
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();
$intFilter->UserIsSignedInOrRecirectToSignIn();

$idTopic = $pc->GETisSetOrSetDefault('id', 0);
$idUser = $pc->SESSIONisSetOrSetDefault('idUser', 0);
  
$pc->IsNumericOrDie($idTopic, 0);
$pc->IsNumericOrDie($idUser, 0);

//$redirectTo = $pc->SESSIONisSetOrSetDefault('history2');

if(isset($_POST['save'])) 
{
	if(empty($_POST['headline']) || empty($_POST['body'])) 
	{
		$_SESSION['errorMessage'] = "Please add both Headline and text";
		//$pc->redirectTo($redirectTo);
	} 	
	else 
	{

$headline = $pc->POSTisSetOrSetDefault('headline', '');
$body = $pc->POSTisSetOrSetDefault('body', '');

  
$pc->IsNumericOrDie($idUser, 0);
$pc->IsNumericOrDie($idTopic, 0);
$pc->IsStringOrDie($headline);
$pc->IsStringOrDie($body);

// MySQL
$db = new CDatabaseController();
$mysqli = $db->Connect();

$headline = $mysqli->real_escape_string($headline);
$body = $mysqli->real_escape_string($body);

$spPSaveTopics = DBSP_PSaveTopics;

  
// Query
$query = "CALL {$spPSaveTopics}({$idTopic}, '{$headline}', '{$body}', {$idUser});";
$res = $db->MultiQuery($query);
$no = $db->RetrieveAndIgnoreResultsFromMultiQuery();
 
$mysqli->close();
	
// Redirect to another page

 header('Location: ' . WS_SITELINK . '?m=forum&p=list');
    exit;
	}
}

$html = <<<EOD

<h1><center>New Topic</center></h1>
 
<form action="?m=forum&p=newT" method="post">
	<table class="form";>
  
	<tr><td>New headline</td></tr>
	<tr><td><input type="text" size="60" name="headline" value=""/></td></tr>
   
	<tr><td>Article</td></tr>
	<tr><td><textarea  rows="12" cols="40" name="body"></textarea></td></tr>
   
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