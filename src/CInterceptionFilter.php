<?php
// ===========================================================================================
//
// Class CInterceptionFilter
//
// Used in each pagecontroller to check access, authority.
//
//
// Author: Mikael Roos
//


class CInterceptionFilter {

	// ------------------------------------------------------------------------------------
	//
	// Internal variables
	//

	// ------------------------------------------------------------------------------------
	//
	// Constructor
	//
	public function __construct() {
		;
	}


	// ------------------------------------------------------------------------------------
	//
	// Destructor
	//
	public function __destruct() {
		;
	}


	// ------------------------------------------------------------------------------------
	//
	// Check if index.php (frontcontroller) is visited, disallow direct access to 
	// pagecontrollers
	//
	public function FrontControllerIsVisitedOrDie() {
		
		global $gPage; // Always defined in frontcontroller
		
		if(!isset($gPage)) {
			die('No direct access to pagecontroller is allowed.');
		}
	}


	// ------------------------------------------------------------------------------------
	//
	// Check if user has signed in or redirect user to sign in page
	//
	public function UserIsSignedInOrRecirectToSignIn() {
		
		if(!isset($_SESSION['accountUser'])) { 
			require(TP_PAGESPATH . 'login/PLogin.php');
		}
	}


	// ------------------------------------------------------------------------------------
	//
	// Check if index.php (frontcontroller) is visited, disallow direct access to 
	// pagecontrollers
	//
	public function UserIsMemberOfGroupAdminOrDie() {
		
		// User must be member of group adm or die
		if($_SESSION['groupMemberUser'] != 'adm') 
			die('You do not have the authourity to access this page');
	}


} // End of Of Class

?>