<?php
// ===========================================================================================
//
// PEditPost.php
//
// Show the information in a form and make it possible to edit the information.
//
//
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

if (mysqli_connect_error()) {
   echo "Connect failed: ".mysqli_connect_error()."<br>";
   exit();
}
$mysqli->set_charset("utf8");

// -------------------------------------------------------------------------------------------
//
// Take care of _GET variables. Store them in a variable (if they are set).
//
$idPost = isset($_GET['idPost']) ? $_GET['idPost'] : '';

if(!is_numeric($idPost)) {
    die("idPost måste vara en inteer. Försök igen.");
}
// -------------------------------------------------------------------------------------------
//
// Prepare and perform a SQL query.
//
$tablePost   		 = DB_PREFIX . 'posts';
$tableComments   	 = DB_PREFIX . 'kommentar';

$query = <<<EOD
SELECT 
  * 
FROM {$tablePost} 
WHERE 
  idPost = {$idPost};
EOD;

$res = $mysqli->query($query) or die("Could not query database");

$html = <<<EOD
<div class='pageBody';>
<h2>Uppdatera information om lärare</h2>
EOD;
// -------------------------------------------------------------------------------------------
//
// Show the results of the query
//
$row = $res->fetch_object();

$html = <<<EOD
<h2><center>Ändra inlägg</center></h2>
<p class="form";>Inlägget skrivet av:{$_SESSION['accountUser']}<br />
Datum: {$row->datePost}<br />
</p>
 
<form action="?p=editpostp&amp;idPost={$row->idPost}" method="post">
  <table class="form";>
   <tr>
    <td>Rubrik: </td>
    <td>
     <input type="text" name="titlePost" size="80" value="{$row->titlePost}"/>
    </td>
   </tr>
   <tr>
    <td>Text: </td>
    <td>
     <textarea rows="6" cols="60" name="textPost">{$row->textPost}</textarea>
    </td>
   </tr>
   <tr>
    <td>Taggar: </td>
    <td>
     <input type="text" name="tagsPost" size="80" value=" {$row->tagPost}"/>
    </td>
   </tr>
   <tr style="text-align: center;">
    <td></td>
    <td>
     <button name="back" value="undo" type="button" onclick="history.back();"><span class="leftarrow icon"></span>Tillbaka</button>
     <button name="undo" value="undo" type="reset" class="negative button"><span class="cross icon"></span>Återställ</button>
     <button name="save" value="save" type="submit" class="primary positive button"><span class="check icon"></span>Spara</button>
    </td>
   </tr>
  </table>
 </form>

EOD;

$res->close();
// -------------------------------------------------------------------------------------------
//
// Close the connection to the database
//
$mysqli->close();
$htmlSide="";
// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();

$page->printHTMLHeader('Template');
$page->printPageHeader();
$page->printPageBody($html, $htmlSide);
$page->printPageFooter();