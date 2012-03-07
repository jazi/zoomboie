<?php
// ===========================================================================================
//
// index.php
//
// -------------------------------------------------------------------------------------------
//
// Require the files that are common for all pagecontrollers.
//
session_start();
require_once('config.php');
//
// Enable autoload for classes
  function __autoload($class_name)
  {
    require_once(TP_SOURCEPATH . $class_name . '.php');
  }
// Allow only access to pagecontrollers through frontcontroller
//
$indexIsVisited = TRUE;
// -------------------------------------------------------------------------------------------
//
// Redirect to the choosen pagecontroller.
//
$gPage = isset($_GET['p']) ? $_GET['p'] : 'home';

switch($gPage) {
  //
  // The home-page
  //
  case 'home':    			require_once('pages/PIndex.php'); break;
  //
  // Login
  case 'login':    			require_once('pages/pages_login/PLogin.php'); break;
  case 'loginp':    		require_once('pages/pages_login/PLoginProcess.php'); break;
  case 'logoutp':   		require_once('pages/pages_login/PLogoutProcess.php'); break;
  //
  // Install database
  //
  case 'install':   		require_once('pages/install/PInstall.php'); break;
  case 'installp':  		require_once('pages/install/PInstallProcess.php'); break;
  //
  // Administration
  //
  case 'admin':   			require_once('pages/admin_users/PUsersList.php'); break;
  //
  //Pages
  case 'temp':   			require_once('pages/PTemplate.php'); break;
  case '404':   			require_once('pages/P404.php'); break;
  // Article
  //
  case 'article':   		require_once('pages/article/PAddArticle.php'); break;
  case 'articleShow':		require_once('pages/article/PShowArticle.php'); break;
  case 'articleEdit':   	require_once('pages/article/PEditArticle.php'); break;
  case 'articlep':   		require_once('pages/article/PEditArticleProcess.php'); break;
  case 'articleDel':   		require_once('pages/article/PDeleteArticle.php'); break;
  //
  // User Profile
  //
  case 'profile':   		require_once('pages/userprofile/PProfileShow.php'); break;
  //
  // Show, add, edit, delete blogg
  //
  case 'nypost':  			require_once('pages/blogg/PAddPost.php'); break;
  case 'nycom':  			require_once('pages/blogg/PAddComment.php'); break;  
  case 'nycomp':  			require_once('pages/blogg/PAddCommentProcess.php'); break;
  case 'deletepost':  		require_once('pages/blogg/PDeletePost.php'); break;
  case 'deletecomment':  	require_once('pages/blogg/PDeleteComment.php'); break;
  case 'editpost':    		require_once('pages/blogg/PEditPost.php'); break;
  case 'editpostp':    		require_once('pages/blogg/PEditPostProcess.php'); break;
  case 'post':  			require_once('pages/blogg/PVisaPost.php'); break;
  case 'rss':  				require_once('pages/blogg/PRss.php'); break;
	
  //
  // Default case, trying to access some unknown page, should present some error message
  // or show the home-page
  //
  default:      			require_once('pages/P404.php'); break;
}
?>