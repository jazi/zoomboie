﻿<?php
// ===========================================================================================
//
// PLogoutProcess.php
//
//
// Destroy the current session (logout user), if it exists. 
//
// ------------------------------------------------------------------------------------
$pc = new CPageController();
$redirectTo = $pc->SESSIONisSetOrSetDefault('history2');
require_once(TP_SOURCEPATH . 'FDestroySession.php');

//
// Redirect to another page
//
//$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'home';
//header('Location: ' . WS_SITELINK . "?p={$redirect}");
header('Location: ' . $redirectTo);
exit;
?>