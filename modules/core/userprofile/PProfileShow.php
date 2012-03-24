<?php
// ===========================================================================================
//
// PProfileShow.php
//
// Show the users profile information in a form (and make it possible to edit the information).
//
// -------------------------------------------------------------------------------------------
//
// Interception Filter, access, authorithy and other checks.
//
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();
$intFilter->UserIsSignedInOrRecirectToSignIn();

// -------------------------------------------------------------------------------------------
//
// Create a new database object, connect to the database.
//
//require_once(TP_SOURCEPATH . 'CDatabaseController');
$db = new CDatabaseController();
$mysqli = $db->Connect();

// -------------------------------------------------------------------------------------------
//
// Prepare and perform a SQL query.
//
$tableUser       = DBT_User;
$tableGroup      = DBT_Group;
$tableGroupMember  = DBT_GroupMember;

$user = $_SESSION['accountUser'];

$query = <<< EOD
SELECT 
  idUser, 
  accountUser,
  emailUser,
  idGroup,
  nameGroup
FROM {$tableUser} AS U
  INNER JOIN {$tableGroupMember} AS GM
    ON U.idUser = GM.GroupMember_idUser
  INNER JOIN {$tableGroup} AS G
    ON G.idGroup = GM.GroupMember_idGroup
WHERE
  accountUser  = '{$user}'
;
EOD;

$res = $db->Query($query);
//$res = $mysqli->query($query)or die("<p>Could not query database</p><code>{$query}</code>");
$no = $db->RetrieveAndIgnoreResultsFromMultiQuery();

$html = "";

// -------------------------------------------------------------------------------------------
//
// Show the results of the query
//
$row = $res->fetch_object();

$html .= <<< EOD
<table class="form";>
<tr>
<th></th>
<td><h3>{$row->accountUser}</h3></td>
</tr>
<tr>
<tr>
<th>Id</th>
<td><input type='text' name='idUser' size='80' readonly value='{$row->idUser}'></td>
</tr>
<tr>
<th>Account</th>
<td><input type='text' name='accountUser' readonly size='80' value='{$row->accountUser}'></td>
</tr>
<tr>
<th>Email</th>
<td><input type='text' name='emailUser' readonly size='80' value='{$row->emailUser}'></td>
</tr>
<tr>
<th>Group</th>
<td><input type='text' name='idGroup' readonly size='80' value='{$row->idGroup}'></td>
</tr>
<tr>
<th>Group description</th>
<td><input type='text' name='nameGroup' readonly size='80' value='{$row->nameGroup}'></td>
</tr>
</table>
EOD;

$res->close();
$mysqli->close();

// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
$page = new CHTMLPage();
$page->PrintPage('Profile', '', $html, '');

?>