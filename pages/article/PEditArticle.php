<?php
// ===========================================================================================
//
// PEditArticle.php
//
// Show an article in a form and make it possible to edit the information.
//
// -------------------------------------------------------------------------------------------
//
if(!isset($indexIsVisited)) die('No direct access allowed.');

require_once(TP_SOURCEPATH . 'FLoggInControl.php');
LoggInControl();

$idArticle = isset($_GET['idArticle']) ? $_GET['idArticle'] : 0;
$idUser = isset($_SESSION['idUser']) ? $_SESSION['idUser'] : 0;
$user = $_SESSION['accountUser'];
// Prepare and perform a SQL query.

$db = new CDatabaseController();
$mysqli = $db->Connect();
$spPDisplayArticle = DBSP_PDisplayArticle;

$query = "CALL {$spPDisplayArticle}({$idArticle});";
// -------------------------------------------------------------------------------------------
//
$result = Array();
$res = $db->MultiQuery($query);
$db->RetrieveAndStoreResultsFromMultiQuery($result);

$row = $result[0]->fetch_object();
  
$body = htmlentities($row->bodyArticle, ENT_COMPAT, 'UTF-8');
$headline = htmlentities($row->headlineArticle, ENT_COMPAT, 'UTF-8');
$idArticle1 = $row->idArticle;
$result[0]->close();

// -------------------------------------------------------------------------------------------
//
// Show the results of the query

$main = <<<EOD
<h2><center>Edit Article</center></h2>
<p class="form";>Article written by: {$user}<br /></p>
 
<form action="?p=articlep&amp;idArticle={$idArticle1}" method="post">
  <table class="form";>
   <tr>
    <td>Rubrik: </td>
    <td><input type="text" name="titleArticle" size="80" value="{$headline}"/></td>
   </tr>
   <tr>
    <td>Text: </td>
    <td><textarea rows="6" cols="60" name="textArticle">{$body}</textarea></td>
   </tr>
   <tr style="text-align: center;">
    <td></td>
    <td>
     <button name="back" value="undo" type="button" onclick="history.back();"><span class="leftarrow icon"></span>Back</button>
     <button name="undo" value="undo" type="reset" class="negative button"><span class="cross icon"></span>Undo</button>
     <button name="save" value="save" type="submit" class="primary positive button"><span class="check icon"></span>Save</button>
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
$page->PrintPage('EditArticle', "", $html, "");
?>