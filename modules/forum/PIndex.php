<?php
// ===========================================================================================
// PIndex.php  
//
//
error_reporting(0);
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();
// -------------------------------------------------------------------------------------------
// Interception Filter, controlling access, authorithy and other checks.
//$intFilter = new CInterceptionFilter();
//$intFilter->FrontControllerIsVisitedOrDie();
  
  
// -------------------------------------------------------------------------------------------
// Page specific code
  
$html = <<<EOD
<h1>Forum</h1>
<h3>Introduction</h3>
<p> This is a new forum for discussions.
</p>
EOD;
  
// -------------------------------------------------------------------------------------------
// Create and print out the resulting page
$page = new CHTMLPage();  
$page->printPage('Forum', '', $html, '');
exit;
?>