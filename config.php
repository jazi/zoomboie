<?php
// -------------------------------------------------------------------------------------------
//
// config.php
//
//----------------------------------------------------------------------------
//
// Support for storing in directories
//
// Classes, functions, code
define('TP_SOURCEPATH', dirname(__FILE__) . '/src/'); 				// Pagecontrollers and modules
define('TP_PAGESPATH',  dirname(__FILE__) . '/pages/'); 
define('TP_ADMINPATH',  dirname(__FILE__) . '/pages/admin_users/'); 
define('TP_SQLPATH',	dirname(__FILE__) . '/sql/');				// SQL code
define('TP_ROOT',		dirname(__FILE__) . '/');					// The root of installation
//
//
// -------------------------------------------------------------------------------------------
//
// Settings for this website (WS), used as default values in CHTMPLPage.php
//
define('WS_SITELINK',   '../zoomboie/');						// Link to site 3.
define('WS_TITLE',      'zoomboie');  							// The H1 label of this site.
define('WS_STYLESHEET', 'css/stylesheet_liquid.css');  			// Default stylesheet of the site.
define('WS_FAVICON', 	'image/favicon.ico'); 					// Small icon to display in browser
define('WS_IMAGE', 		'image/');      						// Default dir for images of the site.
define('WS_VALIDATORS', TRUE);	          						// Show links to w3c validators tools.
define('WS_TIMER', 		FALSE);             					// Time generation of a page and display in footer.
define('WS_CHARSET', 	'utf-8');         						// Use this charset
define('WS_LANGUAGE', 	'en');             						// Default language
define('WS_FOOTER',     '&copy; jaz template 2012 <br />');		// Footer at the end of the page.

// -------------------------------------------------------------------------------------------
//
// Define the menu-array, slight workaround using serialize.
//
$wsMenu = Array (
 'Hem'         		=> 		'?p=home',
 'Installera db'  	=> 		'?p=install',
 'Artiklar'  		=> 		'?p=articleShow',
 'Template'  		=> 		'?p=temp',
 '404'  			=> 		'?p=P404',
 'Visa filer'    	=> 		'../zoomboie/source.php',
 'Me	'			=>		'../index.php',
);
define('WS_MENU',     serialize($wsMenu));   		 // The menu

?>
