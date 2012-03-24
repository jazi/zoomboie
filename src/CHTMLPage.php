<?php
// ========================================================================================
//Template
//J.Zibell 2012
//
// Class CHTMLPage
// 
//
class CHTMLPage {
// ------------------------------------------------------------------------------------
//
// Internal variables
//  
// ------------------------------------------------------------------------------------
//
// Constructor
//
  public function __construct() {
  }
// ------------------------------------------------------------------------------------
//
// Destructor
//
  public function __destruct() {
  }
// ------------------------------------------------------------------------------------
//
  public function PrintPage($aTitle="", $aHTMLLeft="", $aHTMLMain="", $aHTMLRight="") {

		$titlePage	= $aTitle;
		$titleSite	= WS_TITLE;
		$language	= WS_LANGUAGE;
		$charset	= WS_CHARSET;
		$stylesheet	= WS_STYLESHEET;
		$favicon 	= WS_FAVICON;
		$footer		= WS_FOOTER;
		
		$top 	= $this->getLoginLogoutMenu();
		$nav 	= $this->prepareNavigationBar();
		$body 	= $this->preparePageBody($aHTMLLeft, $aHTMLMain, $aHTMLRight);
		$w3c	= $this->prepareValidatorTools();
		$timer	= $this->prepareTimer();
		
		$html = <<<EOD
<!DOCTYPE html>
<html lang="{$language}">
	<head>
		<meta charset="{$charset}" />
		<title>{$titlePage}</title>
		<link rel="shortcut icon" href="{$favicon}" />
		<link rel="stylesheet" href="{$stylesheet}" />
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="js/markitup/jquery.markitup.js"></script>
    <script type="text/javascript" src="js/markitup/sets/default/set.js"></script>  <!--change default to html to get html setup -->
    <link rel="stylesheet" type="text/css" href="js/markitup/skins/markitup/style.css" /> 
    <link rel="stylesheet" type="text/css" href="js/markitup/sets/default/style.css" /> <!-- change default to html to get html setup -->
    <script type="text/javascript" >
      $(document).ready(function() {
      $("textarea").markItUp(mySettings);
      });
	  </script>
	</head>
	<body>
		<div id='wrap'>
			<div id='top'>{$top}</div>
			<div id='head'>
				<div id='title'><p>{$titleSite}</p></div>
				<div id='nav'>{$nav}</div>
			</div>
			{$body}
			<div id='footer'><p>{$footer}</p></div>
			<div id='bottom'><p>{$timer}{$w3c}</p></div>
		</div>
	</body>
</html>

EOD;

// Print the header and page
//
		header("Content-Type: text/html; charset={$charset}");
		echo $html;
	}

//
// ------------------------------------------------------------------------------------
//
// Create a errormessage if its set in the SESSION
//
	public function getErrorMessage() {

        $html = "";

        if(isset($_SESSION['errorMessage'])) {
        
            $html = <<<EOD
<div class='errorMessage'>
{$_SESSION['errorMessage']}
</div>
EOD;

            unset($_SESSION['errorMessage']);
        }

        return $html;   
	}
  
// ------------------------------------------------------------------------------------
//
// Prepare the login-menu, changes look if user is logged in or not
//
	 public function getLoginLogoutMenu() {

    $html    = "";
        if(isset($_SESSION['accountUser'])) {
        
          $admHtml = "";
          if(isset($_SESSION['groupMemberUser']) && $_SESSION['groupMemberUser'] == 'adm') {
            $admHtml = "<a href='?p=admin'>Admin</a> ";
          }
        
      $html = <<<EOD
		<div id='loginbar'>
			<p><a href='?p=profile'>{$_SESSION['accountUser']}</a>  
			{$admHtml} 
			<a href='?p=logoutp'>Logga ut</a></p>
		</div>
EOD;
		}else {
      $html = <<<EOD
		<div id='loginbar'>
			<p><a href='?p=login'>Login</a></p>
		</div>
EOD;
    }
    return $html;  
  }

// ------------------------------------------------------------------------------------
//
// Prepare the header-div of the page
//
	public function prepareNavigationBar() {
	
	GLOBAL $gPage;
	$menu = unserialize(WS_MENU);
	
		$nav = "<ul>";
		foreach($menu as $key => $value) {
			$selected = (strcmp($gPage, substr($value, 3)) == 0) ? " class='sel'" : "";
			$nav .= "<li{$selected}><a href='{$value}'>{$key}</a></li>";
		}
		$nav .= '</ul>';

		return $nav;	
}

// ------------------------------------------------------------------------------------
//
// Prepare everything within the body-div
//
//
	public function PreparePageBody($aBodyLeft, $aBodyMain, $aBodyRight) {

		// General error message from session
		$htmlErrorMessage = $this->getErrorMessage();
		
		// Stylesheet must support this
		// 1, 2 or 3-column layout? 
		// LMR, show left, main and right column
		// LM,  show left and main column
		// MR,  show main and right column
		// M,   show main column
		//
		$cols  = empty($aBodyLeft)  ? '' : 'L';
		$cols .= empty($aBodyMain)  ? '' : 'M';
		$cols .= empty($aBodyRight) ? '' : 'R';

		// Get content for each column, if defined, else empty
		$bodyLeft  = empty($aBodyLeft)  ? "" : "<div id='left_{$cols}'>{$aBodyLeft}</div>";
		$bodyRight = empty($aBodyRight) ? "" : "<div id='right_{$cols}'>{$aBodyRight}</div>";
		$bodyMain  = empty($aBodyMain)  ? "" : "<div id='main_{$cols}'>{$aBodyMain}<p class='last'>&nbsp;</p></div>";

		$html = <<<EOD
<div id='body'> 											
	{$htmlErrorMessage}
	<div id='container_{$cols}'>
		<div id='content_{$cols}'>
			{$bodyLeft}
			{$bodyMain}
		</div> 												<!-- End Of #content -->
	</div> 													<!-- End Of #container -->
	{$bodyRight}
	<div class='clear'>&nbsp;</div>
</div> 														<!-- End Of #body -->

EOD;

		return $html;
	}


// ------------------------------------------------------------------------------------
//
// Prepare html for validator tools
//
	public function PrepareValidatorTools() {

		if(!WS_VALIDATORS) { return ""; }

 		$refToThisPage 			= CHTMLPage::CurrentURL();
 		$linkToCSSValidator	 	= "<a href='http://jigsaw.w3.org/css-validator/check/referer'>CSS</a>";
		$linkToMarkupValidator 	= "<a href='http://validator.w3.org/check/referer'>XHTML</a>";
		$linkToCheckLinks	 	= "<a href='http://validator.w3.org/checklink?uri={$refToThisPage}'>Links</a>";
 		$linkToHTML5Validator	= "<a href='http://html5.validator.nu/?doc={$refToThisPage}'>HTML5</a>";
 
		return "<br />{$linkToCSSValidator} {$linkToMarkupValidator} {$linkToCheckLinks} {$linkToHTML5Validator}";
	}


// ------------------------------------------------------------------------------------
//
// Prepare html for the timer
//
	public function PrepareTimer() {
	
		if(WS_TIMER) {
			global $gTimerStart;
			return 'Page generated in ' . round(microtime(TRUE) - $gTimerStart, 5) . ' seconds.';
		}
	}


// ------------------------------------------------------------------------------------
//
// Static function
// Redirect to another page
// Support $aUri to be local uri within site or external site (starting with http://)
//
	public static function RedirectTo($aUri) {

		if(strncmp($aUri, "http://", 7)) {
			$aUri = WS_SITELINK . "?p={$aUri}";
		}

		header("Location: {$aUri}");
		exit;
	}


// ------------------------------------------------------------------------------------
//
// Static function
// Create a URL to the current page.
//
	public static function CurrentURL() {

		// Create link to current page
		$refToThisPage = "http";
		$refToThisPage .= (@$_SERVER["HTTPS"] == "on") ? 's' : '';
		$refToThisPage .= "://";
		$serverPort = ($_SERVER["SERVER_PORT"] == "80") ? '' : ":{$_SERVER['SERVER_PORT']}";
		$refToThisPage .= $serverPort . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		
		return $refToThisPage;
	}


} // End of Of Class

?>