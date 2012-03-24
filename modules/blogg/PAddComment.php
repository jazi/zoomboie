<?php
// -------------------------------------------------------------------------------------------
//
// PAddComment.php
//
// -------------------------------------------------------------------------------------------
//
if(!isset($indexIsVisited)) die('No direct access allowed.');
// -------------------------------------------------------------------------------------------
//
// Take care of _GET variables. Store them in a variable (if they are set).
//

$idPost = isset($_GET['idPost']) ? $_GET['idPost'] : '';

if(!is_numeric($idPost)) {
    die("idPost måste vara ett integer PAddcomment. Försök igen.");
	}

$html = <<<EOD
<h2><center>Skriv en ny kommentar</center></h2>

 
<form action="?p=nycomp&amp;idPost={$idPost}" method="POST">
  <table class="form";>
  <tr><td>Rubrik</td></tr>
   <tr><td><input type="text" name="title" size="80" value=""/> </td> </tr>
   
   <tr><td>Skriv din kommentar</td></tr>
   <tr><td> <textarea rows="12" cols="60" font-size="85%" name="text"></textarea></td></tr>
   
   <tr><td>Skriv ditt namn här</td></tr>
   <tr><td><input type="text" name="author" size="80" value=""/></td></tr>
   
   <tr><td>Ange din mail adress</td></tr>
	<tr><td><input type="text" name="email" size="80" value=""/></td></tr>
	
   <tr><td> </td> </tr>
   <tr style="text-align: center;">
    <td>
     <button name="back" value="undo" type="button" onclick="history.back();">Tillbaka</button>
     <button name="undo" value="undo" type="reset" class="negative button">Återställ</button>
     <button name="save" value="save" type="submit" class="primary positive button">Spara</button>
    </td>
   </tr>
  </table>
 </form>

EOD;


// -------------------------------------------------------------------------------------------
//

$htmlSide="";

//
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
