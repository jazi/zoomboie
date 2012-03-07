<?php
// -------------------------------------------------------------------------------------------
//
// PDeleteArticle.php
//
// -------------------------------------------------------------------------------------------
//
if(!isset($indexIsVisited)) die('No direct access allowed.');
//
// Loggon check
require_once(TP_SOURCEPATH . 'FLoggInControl.php');
LoggInControl();

$db = new CDatabaseController();
$mysqli = $db->Connect();
// -------------------------------------------------------------------------------------------
//
$idArticle = isset($_GET['idArticle']) ? $_GET['idArticle'] : '';

if(!is_numeric($idArticle)) {
die("idArticle måste vara en integer. Försök igen.");
}
// -------------------------------------------------------------------------------------------
//
// Prepare and perform a SQL query.
//
require_once(TP_SQLPATH . 'config.php');
//
$tableArticle = DBT_Article;
//
$query = <<<EOD
DELETE FROM {$tableArticle}
WHERE idArticle = {$idArticle}
LIMIT 1;
EOD;

$res = $db->Query($query);
$idArticle = $mysqli->insert_id;

if(!$mysqli->affected_rows == 1) {
	$_SESSION['errorMessage'] = "Article not removed!";
}

$mysqli->close();

// -------------------------------------------------------------------------------------------

$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'articleShow';
header('Location: ' . WS_SITELINK . "?p={$redirect}");
exit;
?>