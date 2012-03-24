<?php
// ===========================================================================================
//
// index.php
//
// Index for forum module 
//

$intFilter = new CInterceptionFilter();
$intFilter->FrontControllerIsVisitedOrDie();
// -------------------------------------------------------------------------------------------
$currentDir = dirname(__FILE__) . '/';
global $gPage;

switch($gPage) {
  case 'home':    	require_once($currentDir . 'PIndex.php'); break;
  case 'show': 		require_once($currentDir . 'PShowTopic.php'); break;
  case 'list':    	require_once($currentDir . 'PListTopics.php'); break;
  case 'newT':     	require_once($currentDir . 'PNewTopic.php'); break;
  case 'newP':    	require_once($currentDir . 'PNewPost.php'); break;
  case 'editP':    	require_once($currentDir . 'PEditProcess.php'); break;
  case 'edit':    	require_once($currentDir . 'PEdit.php'); break;

//Login
  case 'login':  	require_once(TP_PAGESPATH . 'login/PLogin.php'); break;
  case 'loginp':  	require_once(TP_PAGESPATH . 'login/PLoginProcess.php'); break;
  case 'logoutp':  require_once(TP_PAGESPATH . 'login/PLogoutProcess.php'); break;

//Default 
  default:  		require_once(TP_MODULESPATH . '/core/home/P404.php'); break;
  }
?>