<?php
// ===========================================================================================
//
// PInstallProcess.php
//
// Creates new tables in the database. 
//
// -------------------------------------------------------------------------------------------
//

if(!isset($indexIsVisited)) die('No direct access to pagecontroller is allowed.');
 
//
// Create a new database object, connect to the database.
//

$db = new CDatabaseController();
  $mysqli = $db->Connect();
  $query = $db->LoadSQL('SQLUserTables.php');
  $res = $db->MultiQuery($query); 
  $no = $db->RetrieveAndIgnoreResultsFromMultiQuery();
//

 $html = <<<EOD
  <h1>Database installed</h1>
  <p>Antal lyckade statements: {$no}  ||
  Error code: {$mysqli->errno} ({$mysqli->error})</p>  
  <p>Query=</p>
  <pre>{$query}</pre>

EOD;

// -------------------------------------------------------------------------------------------
// Close the connection to the database
//  $mysqli->close();

// -------------------------------------------------------------------------------------------
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');
// Create and print out the resulting page
  $page = new CHTMLPage();
  $page->printPage('Installation', '', $html, '');
