<?php
// -------------------------------------------------------------------------------------------
//
// config.php
// SQL
//----------------------------------------------------------------------------
// Settings for the database connection
//
define('DB_HOST',     	'Localhost');  				// The database host
define('DB_USER',		'user' );
define('DB_PASSWORD',	'pass' );
define('DB_DATABASE',   'scout');    				// The name of the database to use
//
// The following supports having many databases in one database by using table/view prefix.
//
define('DB_PREFIX',   	'arti_');    				// Prefix to use infront of tablename and views

// -------------------------------------------------------------------------------------------
//
// Define the names for the database (tables, views, procedures, functions, triggers)
//
define('DBT_User', 				DB_PREFIX . 'User');
define('DBT_Group', 			DB_PREFIX . 'Group');
define('DBT_GroupMember',		DB_PREFIX . 'GroupMember');
define('DBT_Statistics',		DB_PREFIX . 'Statistics');
define('DBT_Article',			DB_PREFIX . 'Article');
define('DBT_DeletedArticle', 	DB_PREFIX . 'DeletedArticle');

// Define names for Stored Procedures
define('DBSP_PDisplayArticle', 	DB_PREFIX . 'PDisplayArticle');
define('DBSP_PListArticles', 	DB_PREFIX . 'PListArticles');
define('DBSP_PUpdateArticle', 	DB_PREFIX . 'PUpdateArticle');
define('DBSP_PCreateNewArticle',DB_PREFIX . 'PCreateNewArticle');
  
// Define names User Defined Functions
define('DBUDF_FCheckUserIsOwnerOrAdmin', DB_PREFIX . 'FCheckUserIsOwnerOrAdmin');
  
// Define names for Triggers
define('DBTR_TInsertUser', 		DB_PREFIX . 'TInsertUser');
define('DBTR_TAddArticle', 		DB_PREFIX . 'TAddArticle');
define('DBTR_TDeleteArticle', 	DB_PREFIX . 'TDeleteArticle');

?>