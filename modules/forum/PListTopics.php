<?php
//
// ===========================================================================================
//
// PListTopics
//
//--------------------------------------------------------------------------------------------
// Interception Filter, access, authorithy and other checks.
//
error_reporting(0);
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();
//--------------------------------------------------------------------------------------------
//
$idTopic = $pc->POSTisSetOrSetDefault('id', 0);
$idUser = $pc->SESSIONisSetOrSetDefault('idUser', 0);
  
$pc->IsNumericOrDie($idTopic, 0);
$pc->IsNumericOrDie($idUser, 0);
//
//--------------------------------------------------------------------------------------------
//
$db = new CDatabaseController();
$mysqli = $db->Connect();

// Query
$spPListTopics = DBSP_PListTopics;
$query = "CALL {$spPListTopics};";

$res = $db->Query($query);
  
$main = "<p><h1>Main article</h1></p>";
 
 
$main = "<h1>List of Topics</h1><table class='later'><tr><th>Topic</th><th>Posts</th><th>Date</th><th>Author</th></tr>";
  while($row = $res->fetch_object())
    {
    $Posts = $row->countPosts +1;
    $main .= <<< EOD
    <tr><td><a href='?m=forum&amp;p=show&amp;id={$row->idTopic}'>{$row->headlineTopic}</a></td>
    <td>{$Posts}</td><td>{$row->dateTopic}</td><td> {$row->accountUser}</td></tr>
EOD;
    }
$main .= "</table>";
  
$res->close();
$mysqli->close();


$list ="<h3 class='columnMenu'>Links</h3>";
$list .= "<p>Later</p>";

$html = <<<EOD
  {$main}
EOD;
$left=<<<EOD
{$list}
EOD;
//$right=<<<EOD
//{$rightCol}
//EOD;

//--------------------------------------------------------------------------------------------
//
// Print out the complete page
//

$page = new CHTMLPage();

$page->PrintPage('Topics', $left, $html, "");

?>