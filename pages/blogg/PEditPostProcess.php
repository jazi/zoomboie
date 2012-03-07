<?php
// ===========================================================================================
//
// PEditPostProcess.php
//
// Save changes to a edited post.
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
$idPost    	= isset($_GET['idPost'])   ? $_GET['idPost'] : '';
$titlePost  = $mysqli->real_escape_string($_POST['titlePost']);
$textPost   = $mysqli->real_escape_string($_POST['textPost']);
$tagPost    = $mysqli->real_escape_string($_POST['tagPost']);

if(!is_numeric($idPost)) {
  die("idPost måste vara ett integer editP. Försök igen.");
}
// -------------------------------------------------------------------------------------------
//
// Prepare and perform a SQL query.
//
$tablePost   		 = DB_PREFIX . 'posts';

$query = <<< EOD
UPDATE {$tablePost} 
SET
  textPost   = '{$textPost}',
  titlePost  = '{$titlePost}',
  tagPost    = '{$tagPost}'  
WHERE 
  idPost = {$idPost}
;
EOD;

$res = $mysqli->query($query) or die("Could not query database");

// -------------------------------------------------------------------------------------------
//
// Close the connection to the database
//
$mysqli->close();
// -------------------------------------------------------------------------------------------
//
// Redirect to another page
//
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'home';
header('Location: ' . WS_SITELINK . "?p={$redirect}");
exit;