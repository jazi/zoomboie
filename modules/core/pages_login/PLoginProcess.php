<?php
// ===========================================================================================
//
// PLoginProcess.php
//
// Verify user and password. Create a session and store userinfo in.
//
// -------------------------------------------------------------------------------------------
//
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();
$redirectTo = $pc->SESSIONisSetOrSetDefault('history3');

require_once(TP_SOURCEPATH . 'FDestroySession.php');

// -------------------------------------------------------------------------------------------
//
// Take care of _GET/_POST variables. Store them in a variable (if they are set).
//
$user     	= isset($_POST['nameUser']) ? $_POST['nameUser'] : '';
$password   = isset($_POST['passwordUser']) ? $_POST['passwordUser'] : '';

$db = new CDatabaseController();
$mysqli = $db->Connect();

$user    	= $mysqli->real_escape_string($user);
$password   = $mysqli->real_escape_string($password);

$tableUser       	= DBT_User;
$tableGroupMember  	= DBT_GroupMember;

$query = <<< EOD
SELECT 
  idUser, 
  accountUser,
  GroupMember_idGroup
FROM {$tableUser} AS U
  INNER JOIN {$tableGroupMember} AS GM
    ON U.idUser = GM.GroupMember_idUser
WHERE
  accountUser    = '{$user}' AND
  passwordUser   = md5('{$password}');
  
EOD;

$res = $db->Query($query);
$res = $mysqli->query($query)or die("<p>Could not query database</p><code>{$query}</code>");
//$no = $db->RetrieveAndIgnoreResultsFromMultiQuery();
//
// -------------------------------------------------------------------------------------------
//
// Use the results of the query to populate a session that shows we are logged in
//
session_start(); 													// Must call it since we destroyed it above.
session_regenerate_id(); 											// To avoid problems 
$row = $res->fetch_object();
$returnrows = $res->num_rows;


if($res->num_rows === 1) {
  $_SESSION['idUser']     		 	= $row->idUser;					// Must be one row in the resultset
  $_SESSION['accountUser']   	  	= $row->accountUser;    
  $_SESSION['groupMemberUser'] 	 	= $row->GroupMember_idGroup;
 } else {
  $_SESSION['errorMessage'] 		= 'Inloggningen misslyckades 1';
// $_POST['redirect']      			= 'login';
  }
  
$res->close();
$mysqli->close();

// -------------------------------------------------------------------------------------------
//Redirect to another page
//
//$redirect = isset($_POST['redirect']) ? $_POST['redirect'] :'home';
//header('Location: ' . WS_SITELINK . "?p={$redirect}");
header('Location: ' . $redirectTo);
exit;
?>