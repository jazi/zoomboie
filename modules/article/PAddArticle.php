<?php
// -------------------------------------------------------------------------------------------
//
// PAddArticle.php
//
// -------------------------------------------------------------------------------------------
//
error_reporting(0);
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();

//require_once(TP_SOURCEPATH . 'FLoggInControl.php');
//LoggInControl();

$intFilter->UserIsSignedInOrRecirectToSignIn();

if(isset($_POST['save'])) 
{
	if(empty($_POST['title']) || empty($_POST['text'])) 
	{
		$_SESSION['errorMessage'] = "Du måste fylla i alla fält!";
	} 	
	else 
	{

// MySQL
		$db = new CDatabaseController();
		$mysqli = $db->Connect();

		$title  = $mysqli->real_escape_string($_POST['title']);
		$text  	= $mysqli->real_escape_string($_POST['text']);
		$idUser = $_SESSION['idUser'];

		$spPCreateNewArticle = DBSP_PCreateNewArticle;

		$title = $mysqli->real_escape_string($title);
		$text = $mysqli->real_escape_string($text);
  
// Query
		$query = <<< EOD
		CALL {$spPCreateNewArticle}('{$title}', '{$text}', {$idUser});
EOD;

		$res = $db->MultiQuery($query);
		$no = $db->RetrieveAndIgnoreResultsFromMultiQuery();
		$idArticle = $mysqli->insert_id;
 
		$mysqli->close();
	
// Redirect to another page

		header('Location: ' . WS_SITELINK . '?p=articleShow');
		exit;
	}
}

$html = <<<EOD

<h1><center>Write a new article</center></h1>
 
<form action="?p=article" method="post">
	<table class="form";>
  
	<tr><td>New headline</td></tr>
	<tr><td><input type="text" size="60" name="title" value=""/></td></tr>
   
	<tr><td>Article</td></tr>
	<tr><td><textarea  rows="12" cols="40" name="text"></textarea></td></tr>
   
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
<p>
<a href='?p=articleShow'>Show Article</a><br />


EOD;
// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
$page = new CHTMLPage();
$page->PrintPage('Add Article', $leftSide, $html, '');

?>