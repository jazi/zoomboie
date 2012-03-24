<?php
// -------------------------------------------------------------------------------------------
//
// config.php
//Global
//----------------------------------------------------------------------------
//
// Support for storing in directories
//
// Classes, functions, code
define('TP_SOURCEPATH', 	dirname(__FILE__) . '/src/'); 					// Pagecontrollers and modules
define('TP_PAGESPATH',  	dirname(__FILE__) . '/modules/core/'); 
define('TP_ADMINPATH',  	dirname(__FILE__) . '/modules/core/'); 
define('TP_SQLPATH',		dirname(__FILE__) . '/sql/');					// SQL code
define('TP_ROOT',			dirname(__FILE__) . '/');						// The root of installation
define('TP_MODULESPATH',	dirname(__FILE__) . '/modules/');				// Modules
//
//
// -------------------------------------------------------------------------------------------
//
define('JS_JQUERY', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js');    
// -------------------------------------------------------------------------------------------
//
// These modules (TP_MODULESPATH) are available.
//
$gModulesAvailable = Array(

		// The core, always included
		'core'	=> TP_MODULESPATH . 'core',								

		// Forum Romanum, included by default
		'forum'		=> TP_MODULESPATH . 'forum',

		// Filearchive, sample user interface to work with file uploads.
		'art'	=> TP_MODULESPATH . 'article',
	);
?>