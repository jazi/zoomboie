<?php
// ===========================================================================================
//
// index.php
// Core
// -------------------------------------------------------------------------------------------
//
error_reporting(-1);
$currentDir = dirname(__FILE__) . '/';
global $gPage;

switch($gPage) {
  //
  // The home-page
  //
  case 'home':    			require_once(TP_PAGESPATH . 'PIndex.php'); break;
  //
  // Login
  case 'login':    			require_once(TP_PAGESPATH . '/pages_login/PLogin.php'); break;
  case 'loginp':    		require_once(TP_PAGESPATH . '/pages_login/PLoginProcess.php'); break;
  case 'logoutp':   		require_once(TP_PAGESPATH . '/pages_login/PLogoutProcess.php'); break;
  //
  // Install database
  //
  case 'install':   		require_once(TP_PAGESPATH . '/install/PInstall.php'); break;
  case 'installp':  		require_once(TP_PAGESPATH . '/install/PInstallProcess.php'); break;
  //
  // Administration
  //
  case 'admin':   			require_once(TP_PAGESPATH . '/admin_users/PUsersList.php'); break;
  //
  //Pages
  case 'temp':   			require_once(TP_PAGESPATH . '/PTemplate.php'); break;
  case '404':   			require_once(TP_PAGESPATH . '/P404.php'); break;
  // Article
  //
  case 'article':   		require_once(TP_MODULESPATH. '/article/PAddArticle.php'); break;
  case 'articleShow':		require_once(TP_MODULESPATH. '/article/PShowArticle.php'); break;
  case 'articleEdit':   	require_once(TP_MODULESPATH. '/article/PEditArticle.php'); break;
  case 'articlep':   		require_once(TP_MODULESPATH. '/article/PEditArticleProcess.php'); break;
  case 'articleDel':   		require_once(TP_MODULESPATH. '/article/PDeleteArticle.php'); break;
  //
  // User Profile
  //
  case 'profile':   		require_once(TP_PAGESPATH . '/userprofile/PProfileShow.php'); break;
  //
  // Show, add, edit, delete blogg
  /*
  case 'nypost':  			require_once(TP_MODULESPATH. '/blogg/PAddPost.php'); break;
  case 'nycom':  			require_once(TP_MODULESPATH. '/blogg/PAddComment.php'); break;  
  case 'nycomp':  			require_once(TP_MODULESPATH. '/blogg/PAddCommentProcess.php'); break;
  case 'deletepost':  		require_once(TP_MODULESPATH. '/blogg/PDeletePost.php'); break;
  case 'deletecomment':  	require_once(TP_MODULESPATH. '/blogg/PDeleteComment.php'); break;
  case 'editpost':    		require_once(TP_MODULESPATH. '/blogg/PEditPost.php'); break;
  case 'editpostp':    		require_once(TP_MODULESPATH. '/blogg/PEditPostProcess.php'); break;
  case 'post':  			require_once(TP_MODULESPATH. '/blogg/PVisaPost.php'); break;
  case 'rss':  				require_once(TP_MODULESPATH. '/blogg/PRss.php'); break;
	
  //
  // Default case, trying to access some unknown page, should present some error message
  // or show the home-page
  */
  default:      			require_once(TP_PAGESPATH . '/P404.php'); break;
}
?>