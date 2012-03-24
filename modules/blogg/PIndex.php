<?php
//
// ===========================================================================================
//
// PIndex 
//
//----------------------------------------------------------------------------------------------------------------------------------------
// Interception Filter, access, authorithy and other checks.
//
if(!isset($indexIsVisited)) die('No direct access to pagecontroller is allowed.');

/*
 * SQL
 */
 
 /*
//$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

//if(mysqli_connect_error()) {
// echo "Connect failed: " . mysqli_connect_error() . "<br/>";
// exit();
//}

$mysqli->set_charset("utf8");
//-------------------------------------------------------------------------------------------------------------------------------------------
$table1         = DB_PREFIX . 'User';
$table2         = DB_PREFIX . 'Group';
$table3			= DB_PREFIX . 'GroupMember';
$table4  		= DB_PREFIX . 'posts';

*/
// Queries
/*
$query = <<<EOD
--
-- Query1 
--

EOD;

$query .= <<<EOD
--
-- 


EOD;

$query .= <<<EOD
--
-- 

EOD;
*/

//$mysqli->multi_query($query) or die("Could not query database PIndex");
//$res = $mysqli->store_result() or die("Failed to retrive result from query");

$MainCol ="";
 
 // Next chunk
$MainCol .= <<<EOD
<article>
<h4>Första sida Pindex</h4>

<h4>Gör inställningar för databas i config.<br />
		Prova sedan och logga för att se om tabeller installerarts.</h4>
</article>
EOD;

 
// Höger kolumn
 $rightSide =<<<EOD
<p>Höger kolumn</p>
<p class='small'>Höger kolumn</p>
EOD;

$html = <<<EOD
	{$MainCol}
EOD;

$htmlright=<<<EOD
   {$rightSide}
  
EOD;

$htmlleft=<<<EOD
   {$lefttSide}
  Vänster sida
EOD;

//
// Print out the complete page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();

$page->PrintPage('Template', '', $html, $htmlright);
/*
$page->printHTMLHeader('Template');
$page->printPageHeader();
$page->printPageBody($html, $htmlSide);
$page->printPageFooter();
*/
