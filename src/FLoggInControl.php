<?php
//
// FLoggInControl.php
//
// Hold functions for access controll
//-------------------------------------------------------------------------------------------------------------
//
function LoggInControl() 
{
   if(!isset($_SESSION['accountUser']))   {
   
    $_SESSION['errorMessage'] = "Du måste logga in först.";
	
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : "login&r={$_GET['p']}";
    header('Location:' . WS_SITELINK . "?p={$redirect}");
    exit;
   }
}

function LoggInControlAdmin() 
{
   LoggInControl();
   if($_SESSION['groupMemberUser'] != 'adm')    {
   
    $_SESSION['errorMessage'] = " Du har inte behörighet till den här sidan";
	
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'home';
    header('Location: ' . WS_SITELINK . "?p={$redirect}");
    exit;
   }
} 