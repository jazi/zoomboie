<?php
// -------------------------------------------------------------------------------------------
//
// PUsersList.php
//
// Show all users in a list.
//
// -------------------------------------------------------------------------------------------
//
// Interception Filter, access, authorithy and other checks.
//
$pc = new CPageController();
$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();
$intFilter->UserIsSignedInOrRecirectToSignIn();
$intFilter->UserIsMemberOfGroupAdminOrDie();
// -------------------------------------------------------------------------------------------

$orderBy   = isset($_GET['orderby'])   ? $_GET['orderby']   : '';
$orderOrder = isset($_GET['order'])    ? $_GET['order']  : '';

$orderStr = "";
if(!empty($orderBy) && !empty($orderOrder)) {
  $orderStr = " ORDER BY {$orderBy} {$orderOrder}";
}
// -------------------------------------------------------------------------------------------
//
// Prepare the order by ref, can you figure out how it works?
//
$ascOrDesc = $orderOrder == 'ASC' ? 'DESC' : 'ASC';
$httpRef = "?p=admin&amp;order={$ascOrDesc}&amp;orderby=";
// -------------------------------------------------------------------------------------------
//
// Create a new database object, we are using the MySQLi-extension.
//
$db = new CDatabaseController();
$mysqli = $db->Connect();

// Prevent SQL injections
$orderStr = $mysqli->real_escape_string($orderStr);

// -------------------------------------------------------------------------------------------
//
// Prepare and perform a SQL query.
//
$tableUser       = DBT_User;
$tableGroup      = DBT_Group;
$tableGroupMember  = DBT_GroupMember;

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
{$orderStr}
EOD;

$res = $db->Query($query);
$res = $mysqli->query($query)or die("<p>Could not query database</p><code>{$query}</code>");

$html = "<h2>Admin: Visa användarkonton</h2>";

// -------------------------------------------------------------------------------------------
//
// Show the results of the query
//
$html .= <<< EOD
<table class="admin";>
<tr>
<td><a href='{$httpRef}idUser'>Id</a></th>
<td><a href='{$httpRef}accountUser'>Account</a></th>
<td><a href='{$httpRef}emailUser'>Email</a></th>
<td><a href='{$httpRef}idGroup'>Grupp</a></th>
<td><a href='{$httpRef}nameGroup'>Grupp description</a></th>
</tr>
EOD;

while($row = $res->fetch_object()) {
  $html .= <<< EOD
<tr>
<td>{$row->idUser}</td>
<td>{$row->accountUser}</td>
<td>{$row->emailUser}</td>
<td>{$row->idGroup}</td>
<td>{$row->nameGroup}</td>
</tr>
EOD;
}

$html .= "</table>";
$html .= "<p class='form';>Antal rader i resultset: {$res->num_rows}</p>";

$res->close();

$mysqli->close();

// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
$page = new CHTMLPage();
$page->PrintPage('Admin', '', $html, '');

?>