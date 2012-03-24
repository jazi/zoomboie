<?php
// ===========================================================================================
//
// PTemplate.php
//
// A standard template page for a pagecontroller.
//
// -------------------------------------------------------------------------------------------
//
//
//if(!isset($indexIsVisited)) die('No direct access to pagecontroller is allowed.');
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();
// -------------------------------------------------------------------------------------------
//
//
//require(TP_SOURCEPATH . 'FLoggInControl.php');

// -------------------------------------------------------------------------------------------
//
// Page specific code
//

$htmlMain = <<<EOD
<h1>Template</h1>
<h2>Introduction</h2>
<p>
Copy this file, PTemplate.php, to create new pacecontrollers.
</p>
<p>
</p>
<p>
Main body
</p>

EOD;

$htmlLeft = <<<EOD
<h3 class='columnMenu'>Left column</h3>
<p>
This is HTML for the left column. Use it or loose it. 
</p>
<p>
Left side column
</p>
<p>
</p>
EOD;

$htmlRight = <<<EOD
<h3 class='columnMenu'>Right column</h3>
<p>
This is HTML for the right column. Use it or loose it. 
</p>
<p>
Right side column
</p>
<p>
</p>
EOD;

// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
$page = new CHTMLPage();
$page->printPage('Template', $htmlLeft, $htmlMain, $htmlRight);

?>