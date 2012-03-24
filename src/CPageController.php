<?php
// ===========================================================================================
//
// File: CPagecontroller.php
//
// Description: Nice to have utility for common methods useful in most pagecontrollers.
//
// Author: Mikael Roos, mos@bth.se
//

class CPageController {

	// ------------------------------------------------------------------------------------
	//
	// Internal variables
	//
	//protected static $iInstance = NULL;
	//public $lang = Array();
	

	// ------------------------------------------------------------------------------------
	//
	// Constructor
	//
	public function __construct() {
		$_SESSION['history3'] = CPageController::SESSIONisSetOrSetDefault('history2');
		$_SESSION['history2'] = CPageController::SESSIONisSetOrSetDefault('history1');
		$_SESSION['history1'] = CPageController::CurrentURL();
		//print_r($_SESSION);
	}


	// ------------------------------------------------------------------------------------
	//
	// Destructor
	//
	public function __destruct() { ; }


	// ------------------------------------------------------------------------------------
	//
	// Check if corresponding $_GET[''] is set, then use it or return the default value.
	//
	public static function GETisSetOrSetDefault($aEntry, $aDefault = '') {

		return isset($_GET["$aEntry"]) && !empty($_GET["$aEntry"]) ? $_GET["$aEntry"] : $aDefault;
	}


	// ------------------------------------------------------------------------------------
	//
	// Check if corresponding $_POST[''] is set, then use it or return the default value.
	//
	public static function POSTisSetOrSetDefault($aEntry, $aDefault = '') {

		return isset($_POST["$aEntry"]) && !empty($_POST["$aEntry"]) ? $_POST["$aEntry"] : $aDefault;
	}


	// ------------------------------------------------------------------------------------
	//
	// Check if corresponding $_SESSION[''] is set, then use it or return the default value.
	//
	public static function SESSIONisSetOrSetDefault($aEntry, $aDefault = '') {

		return isset($_SESSION["$aEntry"]) && !empty($_SESSION["$aEntry"]) ? $_SESSION["$aEntry"] : $aDefault;
	}

	// ------------------------------------------------------------------------------------
	//
	// Check if the value is numeric and optional in the range.
	//
	public static function IsNumericOrDie($aVar, $aRangeLow = 0, $aRangeHigh = 0) {

		$inRangeH = empty($aRangeHigh) ? TRUE : ($aVar <= $aRangeHigh);
		$inRangeL = empty($aRangeLow)  ? TRUE : ($aVar >= $aRangeLow);
		if(!(is_numeric($aVar) && $inRangeH && $inRangeL)) {
			die(sprintf("The variable value '$s' is not numeric or it is out of range.", $aVar));
		}
		return $aVar;
	}


	// ------------------------------------------------------------------------------------
	//
	// Check if the value is a string.
	//
	public static function IsStringOrDie($aVar) {

		if(!is_string($aVar)) {
			die(sprintf("The variable value '$s' is not a string.", $aVar));
		}
	}


	// ------------------------------------------------------------------------------------
	//
	// Static function
	// Redirect to another page
	// Support $aUri to be local uri within site or external site (starting with http://)
	// If empty, redirect to home page of current module.
	//
	public static function RedirectTo($aUri) {

		if(empty($aUri)) {
			CPageController::RedirectToModuleAndPage();			
		} else if(!strncmp($aUri, "http://", 7)) {
			;
		} else if(!strncmp($aUri, "?", 1)) {
			$aUri = WS_SITELINK . "{$aUri}";
		} else {
			$aUri = WS_SITELINK . "?p={$aUri}";
		}

		header("Location: {$aUri}");
		exit;
	}


	// ------------------------------------------------------------------------------------
	//
	// Static function
	// Redirect to another local page using module, page and arguments (Array)
	// Defaults to current module home-page.
	//
	public static function UrlToModuleAndPage($aModule='', $aPage='home') {

		global $gModule;
		
		$m = (empty($aModule)) ? "m={$gModule}" : "m={$aModule}";
		$p = "p={$aPage}";
		$aUrl = WS_SITELINK . "?{$m}&{$p}";

		// Enable sending $aArguments as an Array later on. When needed.
		
		// Set message in SESSION, if defined, When needed.

		return $aUrl;
	}


	// ------------------------------------------------------------------------------------
	//
	// Static function
	// Redirect to another local page using module, page and arguments (Array)
	// Defaults to current module home-page.
	//
	public static function RedirectToModuleAndPage($aModule='', $aPage='home', $aArguments='', $aMessage='') {

		global $gModule;
		
		$m = (empty($aModule)) ? "m={$gModule}" : "m={$aModule}";
		$p = "p={$aPage}";
		$aUrl = WS_SITELINK . "?{$m}&{$p}";

		// Enable sending $aArguments as an Array later on. When needed.
		
		
		// Set message in SESSION, if defined
		if(!empty($aMessage)) {
			self::SetSessionMessage($aPage, $aMessage);
		}

		header("Location: {$aUrl}");
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
		$serverPort = ($_SERVER["SERVER_PORT"] == "80") ? '' : 
										(($_SERVER["SERVER_PORT"] == 443 && @$_SERVER["HTTPS"] == "on") ? '' 
											: ":{$_SERVER['SERVER_PORT']}"
										);
		$refToThisPage .= $_SERVER["SERVER_NAME"] . $serverPort . $_SERVER["REQUEST_URI"];
		
		return $refToThisPage;
	}


} // End of Of Class

?>