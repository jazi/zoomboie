<?php
// -------------------------------------------------------------------------------------------
//
// PDeleteComment.php
//
// -------------------------------------------------------------------------------------------
// Create a new database object, we are using the MySQLi-extension.
//
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

if (mysqli_connect_error()) {
   echo "Connect failed: ".mysqli_connect_error()."<br>";
   exit();
}

$mysqli->set_charset("utf8");

// -------------------------------------------------------------------------------------------
//
$idPost = isset($_GET['idPost']) ? $_GET['idPost'] : '';
$idComment = isset($_GET['idComment']) ? $_GET['idComment'] : '';

if((!is_numeric($idPost)) || (!is_numeric($idComment))){
  die("idPost måste vara en integer. Försök igen.");
}

// -------------------------------------------------------------------------------------------
//
// Prepare and perform a SQL query.
//
$tablePost   		 = DB_PREFIX . 'posts';
$tableComments   	 = DB_PREFIX . 'kommentar';

$query =<<<EOD
DELETE FROM {$tableComments} 
WHERE idComment = {$idComment} 
LIMIT 1;
EOD;

$res = $mysqli->query($query) or die("Could not query database");

if(!$mysqli->affected_rows == 1) {
	$_SESSION['errorMessage'] = "Kommentaren gick inte att ta bort!";
}

// -------------------------------------------------------------------------------------------
//
// Close the connection to the database
//
$mysqli->close();

// -------------------------------------------------------------------------------------------
header('Location: ' . WS_SITELINK . "?p=post&idPost={$idPost}");
exit;
