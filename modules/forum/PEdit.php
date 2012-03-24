<?php
// ===========================================================================================
//
// PEdit.php
//
// Show an article in a form and make it possible to edit the information.
//
// -------------------------------------------------------------------------------------------
//
error_reporting(0);
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();

$intFilter->UserIsSignedInOrRecirectToSignIn();

$idUser = $pc->SESSIONisSetOrSetDefault('idUser', 0);
$idPost = $pc->GETisSetOrSetDefault('idpost', 0);
  
$pc->IsNumericOrDie($idPost, 0);  
$pc->IsNumericOrDie($idUser, 0);

$db = new CDatabaseController();
$mysqli = $db->Connect();
  
$spPViewPost = DBSP_PViewPost;
$query = "CALL {$spPViewPost}({$idPost});";

// -------------------------------------------------------------------------------------------
//
$res = $db->Query($query);

$row = $res->fetch_object();
  
$body = $row->bodyPost;
$author = $row->authorPost;
$idTopic = $row->postedInTopic;
$res->close();
$mysqli->close();

// -------------------------------------------------------------------------------------------
//
// Form

$main = <<<EOD
<h2><center>Edit Post</center></h2>
 
<form action="?m=forum&p=editP" method="post">
  <table class="form";>
	<tr><td><h3>Edit a post in topic {$idTopic}</h></td></tr>
	<tr><td><textarea  rows="12" cols="40" name="body">{$body}</textarea></td></tr>
    <input type='hidden' name='idTopic' value='{$idTopic}'>
    <input type='hidden' name='author' value='{$author}'>
	<input type='hidden' name='idPost' value='{$idPost}'>
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

// -------------------------------------------------------------------------------------------
//
// Close the connection to the database
//
//$mysqli->close();

$html = <<<EOD
  {$main}
EOD;
// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
$page = new CHTMLPage();
$page->PrintPage('Edit Post', "", $html, "");
?>