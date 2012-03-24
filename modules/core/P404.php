<?php
//
// ===========================================================================================
//
// P404.php
//
//--------------------------------------------------------------------------------------------
// Interception Filter, access, authorithy and other checks.
//
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();

$MainCol ="";
 
$MainCol .= <<<EOD
<h1>404 Not Found</h1>
<p>
You have used a link that is not supported. The page you are trying to reach does not exist.
</p>
EOD;

$html = <<<EOD
	{$MainCol}
EOD;

//
// Print out the complete page
//
$page = new CHTMLPage();
$page->PrintPage('404', '', $html, '');

?>