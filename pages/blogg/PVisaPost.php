<?php
// ===========================================================================================
//
// PVisaPost.php
//
// -------------------------------------------------------------------------------------------
//
//
if(!isset($indexIsVisited)) die('No direct access.');

//
// -------------------------------------------------------------------------------------------
//
// Create a new database object, connect to the database.
//
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

if (mysqli_connect_error()) {
   echo "Connect failed: ".mysqli_connect_error()."<br>";
   exit();
}

$mysqli->set_charset("utf8");

// -------------------------------------------------------------------------------------------
//
// Take care of _GET variables. Store them in a variable (if they are set).
//
$idPost = isset($_GET['idPost']) ? $mysqli->real_escape_string($_GET['idPost']) : '';

//if(!is_numeric($idPost)) {
  //  die("idPost måste vara ett integerVisa post.{$idPost} Försök igen.");
//}
// -------------------------------------------------------------------------------------------
//
// Prepare and perform SQL query.
//
$tableUser           = DB_PREFIX . 'User';
$tableGroup          = DB_PREFIX . 'Group';
$tableGroupMember    = DB_PREFIX . 'GroupMember';
$tablePost   		 = DB_PREFIX . 'posts';
$tableComments   	 = DB_PREFIX . 'kommentar';

$query = <<<EOD
SELECT 
*
FROM {$tablePost} AS TP
LEFT JOIN {$tableComments} AS TK ON TP.idPost=TK.comment_idPost
LEFT JOIN {$tableUser} AS TU ON TP.post_idUser=TU.idUser
WHERE TP.idPost = {$idPost}
;
EOD;

$query .= <<<EOD
SELECT * 
FROM  {$tableComments}
WHERE comment_idPost={$idPost}
ORDER BY dateComment DESC
;
EOD;
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
$mysqli->multi_query($query) or die("Could not query database PIndex");
$res = $mysqli->store_result() or die("Failed to retrive result from query");
$row = $res->fetch_object();

$post_IdUser = $row->post_idUser;
//Visar länk till delete och edit när någon är inloggad
$editPost="";
$deletePost="";

if(isset($_SESSION['accountUser'])) {
	if($_SESSION['idUser']==$post_IdUser){
		$editPost .="| <a href='?p=editpost&amp;idPost={$idPost}'>Redigera inlägg</a>";
		$deletePost .="| <a href='?p=deletepost&amp;idPost={$idPost}'>Radera inlägg</a>"; 
		}	
	}	
$posts ="";

 // Inlägg
$posts .= <<<EOD
   
  <div class='rubrikPost'>
	
	Publicerat:{$row->datePost} av <a href='?p=home&amp;author={$row->accountUser}'>{$row->accountUser}</a> 
	| <a href="?p=nycom&amp;idPost={$row->idPost}">Skriv en kommentar</a>
	{$editPost}
	{$deletePost}
	<br />{$row->titlePost} 
   </div>
    <div class='textPost'>
		<p>{$row->textPost}</p>
	</div>
	********************************************************************************************************
EOD;

$res->close();

($mysqli->next_result() && ($res = $mysqli->store_result()))
 or die("Failed to retrive result from query.");
 
$comments ="";
 
 // Kommentarer
 while($row = $res->fetch_object()) {
 $deleteComment="";
 if(isset($_SESSION['accountUser']))   {
	if($_SESSION['idUser']==$post_IdUser){
	$deleteComment .="| <a href='?p=deletecomment&amp;idComment={$row->idComment}&amp;idPost={$row->comment_idPost}'>Radera kommentar</a>"; 
	}
}

 $email = explode('@', $row->emailComment);
 $email = $email[0];
 
$comments .= <<<EOD
   
  <div class='rubrikPost'>
    Kommentar skrivits av {$row->authorComment}, den {$row->dateComment} med signatur "{$email}" {$deleteComment}
   <br/>{$row->titleComment}
  </div>

    <div class='textComment'>
	<p>{$row->textComment}</p>
	</div>
	<hr>
EOD;
}
$res->close();

$html = "";
$html .= <<<EOD
	{$posts}
	{$comments}

</div>
EOD;
//
$mysqli->close();

// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php');

$page = new CHTMLPage();

$page->printHTMLHeader('Template');
$page->printPageHeader();
$page->printPageBodySingle($html);
$page->printPageFooter();