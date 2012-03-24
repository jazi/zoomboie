<?php
// ===========================================================================================
//
// PInstall.php
//
// Info page for installation. Links to page for creating tables in the database.
//
// -------------------------------------------------------------------------------------------
//
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();
//
// Page specific code
//
require_once(TP_SQLPATH . 'config.php');

$database = DB_DATABASE;
$prefix  = DB_PREFIX;

$html = <<<EOD

<h2>Installation</h2>
<h3>Skapa tabeller</h3>
<p>
Klicka på nedanstånde länk för att radera databasen på allt innehåll och skapa nya tabeller. 
Du har valt databasen '{$database}' och tabellerna kommer skapas med prefixet '{$prefix}'. Ändra i
config.php om detta inte stämmer.
</p>
<p>
<a href='?p=installp'>Töm databasen och skapa nya tabeller</a>.
</p>

EOD;

// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//

$page = new CHTMLPage();

$page->PrintPage('Install', '', $html, '');

?>