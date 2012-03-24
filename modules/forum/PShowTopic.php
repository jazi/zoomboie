<?php
//
// ===========================================================================================
//
// PShowTopic
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

$idTopic = $pc->GetisSetOrSetDefault('id', 0);
$idUser = $pc->SESSIONisSetOrSetDefault('idUser', 0);
  
$pc->IsNumericOrDie($idTopic, 0);
$pc->IsNumericOrDie($idUser, 0);

$db = new CDatabaseController();
$mysqli = $db->Connect();
  
$spPViewTopic = DBSP_PViewTopic;
$spPViewPosts = DBSP_PViewPosts;
  
$query = "CALL {$spPViewTopic}({$idTopic});";
$query .= "CALL {$spPViewPosts}({$idTopic});";

$results = Array();
$res = $db->MultiQuery($query);
$db->RetrieveAndStoreResultsFromMultiQuery($results);
 
$row = $results[0]->fetch_object();
  
$main = <<<EOD
  <h1>{$row->headlineTopic}</h1>
  <table class='list'><tr><th>Topic</th><th>Author</th><th>Date</th></tr>
  <td class='first'>{$row->bodyTopic}</td><td>{$row->accountUser}</td><td> {$row->dateTopic}</td><td> </td>
  </tr>
EOD;

$results[0]->close();
  
while($row = $results[2]->fetch_object()) 
  {
    ($idUser == $row->authorPost) ? $edit="<div style='float:right'><a title='Edit post' href='?m=forum&amp;p=edit&amp;idpost={$row->idPost}'>Edit Post
	</a></div>" : $edit="";
    
    $main .= "<tr><td>{$row->bodyPost}</td><td>{$row->accountUser}</td><td>{$row->datePost}</td><td>{$edit} </td></tr>";
  }
$main .= "</table>";
$main .= "<p><a href='?m=forum&amp;p=newP&amp;id={$idTopic}'>New post</a></p>";
$results[2]->close();
$mysqli->close();


$list ="<h3 class='columnMenu'>Later</h3>";
$list .= "Later";

$html =<<<EOD
{$main}
EOD;
$left=<<<EOD
{$list}
EOD;
 
//
//--------------------------------------------------------------------------------------------
//
// Print out the complete page
//

$page = new CHTMLPage();

$page->PrintPage('Forum', $left, $html, "");

?>