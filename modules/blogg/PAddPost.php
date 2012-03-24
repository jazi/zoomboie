<?php
// -------------------------------------------------------------------------------------------
//
// PAddPost.php
//
// -------------------------------------------------------------------------------------------
//
if(!isset($indexIsVisited)) die('No direct access allowed.');
// -------------------------------------------------------------------------------------------
//
require_once(TP_SOURCEPATH . 'FLoggInControl.php');
LoggInControl();

// Create a new database object, we are using the MySQLi-extension.

if(isset($_POST['save'])) {
 if(empty($_POST['title']) || empty($_POST['text'])) {
  $_SESSION['errorMessage'] = "Du måste fylla i alla fält!";
 } else {
  // MySQL
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE) or die("Connect failed: " . mysqli_connect_error() . "<br/>");
  $mysqli->set_charset("utf8");

$title  = $mysqli->real_escape_string($_POST['title']);
$text  	= $mysqli->real_escape_string($_POST['text']);
$tags 	= $mysqli->real_escape_string($_POST['tags']);

$tablePost = DB_PREFIX . 'posts';

$query = <<<EOD
INSERT INTO {$tablePost} (post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ({$_SESSION['idUser']}, '{$title}', '{$text}', '{$tags}', NOW());
EOD;

$res = $mysqli->query($query) or die("<p>Could not query my database,</p><code>{$query}</code>");
 
$mysqli->close();
  
$_SESSION['Message'] = "Inlägg sparat!";
	
// Redirect to another page
//
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '?p=home';
header('Location: ' . WS_SITELINK . "?p={$redirect}");
exit;
 }
}

$html = <<<EOD

<h2><center>Skriv nytt inlägg</center></h2>
 
<form action="?p=nypost" method="post">
  <table class="form";>
  
  <tr><td><p class="tydlig";>Använda html för att formatera texten. Taggarna separeras med "," och ett mellanslag.</p></td></tr>
  
	<tr><td>Ny Rubrik</td></tr>
   <tr><td><input type="text" size="60" name="title" value=""/></td></tr>
   
   <tr><td>Skriv inlägg här</td></tr>
   <tr><td><textarea rows="12" cols="60" name="text"></textarea></td></tr>
   
   <tr><td>Skriv taggar här, separerade med ","</td></tr>
   <tr><td><input type="text" size="60" name="tags" value=""/></td></tr>
   
   <tr style="text-align: center;">
    <td>
     <button name="back" value="undo" type="button" onclick="history.back();">Tillbaka</button>
     <button name="undo" value="undo" type="reset" class="negative button">Återställ</button>
     <button name="save" value="save" type="submit" class="primary positive button"></span>Spara</button>
    </td>
   </tr>
  </table>
 </form>

EOD;
// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//

require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();

$page->printHTMLHeader('Foggler Blogg');
$page->printPageHeader();
$page->printPageBodySingle($html);
$page->printPageFooter();
