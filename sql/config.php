<?php
// -------------------------------------------------------------------------------------------
//
// config.php
// SQL
//----------------------------------------------------------------------------

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
define('DBT_Topics', 			DB_PREFIX . 'Topics');
define('DBT_Posts', 			DB_PREFIX . 'Posts');

// Define names for Stored Procedures
define('DBSP_PDisplayArticle', 	DB_PREFIX . 'PDisplayArticle');
define('DBSP_PListArticles', 	DB_PREFIX . 'PListArticles');
define('DBSP_PUpdateArticle', 	DB_PREFIX . 'PUpdateArticle');
define('DBSP_PCreateNewArticle',DB_PREFIX . 'PCreateNewArticle');
define('DBSP_PSaveTopics',		DB_PREFIX . 'PSaveTopics');
define('DBSP_PSavePost',		DB_PREFIX . 'PSavePost');
define('DBSP_PViewPosts',		DB_PREFIX . 'PViewPosts');
define('DBSP_PViewPost',		DB_PREFIX . 'PViewPost');
define('DBSP_PViewTopic',		DB_PREFIX . 'PViewTopic');
define('DBSP_PListTopics',		DB_PREFIX . 'PListTopics');
  
// Define names User Defined Functions
define('DBUDF_FCheckUserIsOwnerOrAdmin', DB_PREFIX . 'FCheckUserIsOwnerOrAdmin');
  
// Define names for Triggers
define('DBTR_TInsertUser', 		DB_PREFIX . 'TInsertUser');
define('DBTR_TAddArticle', 		DB_PREFIX . 'TAddArticle');
define('DBTR_TDeleteArticle', 	DB_PREFIX . 'TDeleteArticle');

?>