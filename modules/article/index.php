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
  
  // Article
  //
  case 'article':   		require_once($currentDir . 'PAddArticle.php'); break;
  case 'articleShow':		require_once($currentDir . 'PShowArticle.php'); break;
  case 'articleEdit':   	require_once($currentDir . 'PEditArticle.php'); break;
  case 'articlep':   		require_once($currentDir . 'PEditArticleProcess.php'); break;
  case 'articleDel':   		require_once($currentDir . 'PDeleteArticle.php'); break;

//Login
  case 'login':  			require_once(TP_PAGESPATH . 'login/PLogin.php'); break;
  case 'loginp':  			require_once(TP_PAGESPATH . 'login/PLoginProcess.php'); break;
  case 'logoutp':  			require_once(TP_PAGESPATH . 'login/PLogoutProcess.php'); break;

//Default 
  default:  				require_once(TP_MODULESPATH . '/core/home/P404.php'); break;
  }
?>