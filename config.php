﻿<?php
// -------------------------------------------------------------------------------------------
//
// config.php
//
// -------------------------------------------------------------------------------------------
//
// Settings for the database connection
//
define('DB_HOST', 			'localhost');			// The database host
define('DB_USER', 			'user');				// The username of the database
define('DB_PASSWORD', 		'pass');				// The users password
define('DB_DATABASE', 		'scout');				// The name of the database to use
define('DB_PREFIX', 		'arti_');		    	// Prefix to use infront of tablename and views
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
define('WS_JAVASCRIPT', WS_SITELINK . '/js/');        			// JavaScript code
//   
// -------------------------------------------------------------------------------------------
//
// Define the menu-array, slight workaround using serialize.
//
$wsMenu = Array (
 'Hem'         		=> 		'?p=home',
 'Installera db'  	=> 		'?p=install',
 'Artiklar'  		=> 		'?m=art&p=articleShow',
 'Forum'	  		=> 		'?m=forum&p=home',
 'Template'  		=> 		'?p=temp',
 '404'  			=> 		'?p=P404',
 'Visa filer'    	=> 		'../zoomboie/source.php',
 'Me	'			=>		'../index.php',
);
define('WS_MENU',     serialize($wsMenu));   		 // The menu
//
$menuFooter = Array (
	'Home'	 			=> '?p=home',
	'About' 			=> '?p=about',
	'Credits' 		=> '?p=credits',
	'Legal'				=> '?p=legal',
	'Privacy'			=> '?p=privacy',
);
define('WS_FOOTER_MENU', 		serialize($menuFooter));

?>