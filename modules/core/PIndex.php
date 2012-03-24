<?php
//
// ===========================================================================================
//
// PIndex 
//
//--------------------------------------------------------------------------------------------
// Interception Filter, access, authorithy and other checks.
//
//if(!isset($indexIsVisited)) die('No direct access to pagecontroller is allowed.');
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();
error_reporting(-1);
// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------
$MainCol ="";
 
// Next chunk
$MainCol .= <<<EOD
<article>
<h4>Första sida Pindex</h4>
<h4>Gör inställningar för databas i config.<br />
		Prova sedan och logga för att se om tabeller installerarts.</h4>
</article>
EOD;
// -------------------------------------------------------------------------------------------
// Right column
 $rightSide =<<<EOD
<p>Right column</p>
<p class='small'>Logged in user</p>
EOD;

// -------------------------------------------------------------------------------------------
//
$html = <<<EOD
	{$MainCol}
EOD;

$htmlright=<<<EOD
   {$rightSide}
  
EOD;


// -------------------------------------------------------------------------------------------
//

$page = new CHTMLPage();
$page->PrintPage('Home', '', $html, $htmlright);

?>