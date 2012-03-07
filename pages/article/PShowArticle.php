<?php
//
// ===========================================================================================
//
// PShowArticle
//
//--------------------------------------------------------------------------------------------
// Interception Filter, access, authorithy and other checks.
//
if(!isset($indexIsVisited)) die('No direct access to pagecontroller is allowed.');

//--------------------------------------------------------------------------------------------
//

$db = new CDatabaseController();
$mysqli = $db->Connect();
  
$spPListArticles = DBSP_PListArticles;
$spPDisplayArticle = DBSP_PDisplayArticle;

$idArticle = isset($_GET['idArticle']) ? $_GET['idArticle'] : 0;
$idUser = $_SESSION[idUser];
  
$query  = "CALL {$spPDisplayArticle}({$idArticle});";
$query .= "CALL {$spPListArticles}();";

// Perform query
$results = Array();
$res = $db->MultiQuery($query);
$db->RetrieveAndStoreResultsFromMultiQuery($results);
 
$row = $results[0]->fetch_object();
  $headline = $row->headlineArticle;
  $body = $row->bodyArticle;
  $date = $row->dateArticle;
  $modified = $row->modifiedArticle;
  $idarticle = $row->idArticle;
  $idUserArticle = $row->authorArticle;
  $results[0]->close();
  
$newLink ="<div class='toBeDesided'>";
if(isset($_SESSION['accountUser'])) 
	{
		$newLink .="<a class='to be desided' title='See article' href='?p=article'>New Article</a> ";
	
		if((isset($_SESSION['groupMemberUser']) && $_SESSION['groupMemberUser'] == 'adm') || ($idUser == $idUserArticle))
			{
				$newLink .="| <a class='to be desided' title='See article' href='?p=articleEdit&amp;idArticle={$idarticle}'>Edit Article</a> | ";
				$newLink .="<a class='to be desided' title='See article' href='?p=articleDel&amp;idArticle={$idarticle}'>Delete Article</a> "; 
			}	
	}
	
$newLink .="</div>";
$main = "<p><h1>Main article</h1></p>";
 
 
 
if(empty($row))
  {
    $main .= "<h2>No articles available!</h2>";
  }
  else
  {  
    $body = htmlentities($body, ENT_COMPAT, 'UTF-8');
    $headline = htmlentities($headline, ENT_COMPAT, 'UTF-8');
   
// Prepaire date/modified date
//
$datum = "";
if(!empty($modified)) { $datum .=" | Updated: $modified ";}
$DATE = "<p style='font-size:smaller;'>Created: {$date} {$datum}</p>";
	
// Contents of article.  
    $main .= <<< EOD
    <article class='To be desided'>
	<p>{$newLink}</p>
      <h2>{$headline}</h2>
      <p>{$body}</p>
      {$DATE}
    </article>
EOD;
}

$list = "<h3>All Articles</h3>";
    while($row = $results[2]->fetch_object()) 
    {
      $headline = htmlentities($row->headlineArticle, ENT_COMPAT, 'UTF-8');
      $list .= "<aside><a class='to be desided' title='See article' href='?p=articleShow&amp;idArticle={$row->idArticle}'>{$headline}</a><aside>";
    }
    $results[2]->close();


$leftlist ="<h3 class='columnMenu'>List Articles</h3>";


$html = <<<EOD
  {$main}
EOD;
$left=<<<EOD
{$list}
EOD;
$right=<<<EOD
{$rightCol}
EOD;
$mysqli->close(); 

//--------------------------------------------------------------------------------------------
//
// Print out the complete page
//
//require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();

$page->PrintPage('Article', $left, $html, "");

?>