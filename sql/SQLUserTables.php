﻿<?php
// ===========================================================================================
//
// SQLUserTables.php
//
// Creates new tables in the database. 
//
// -------------------------------------------------------------------------------------------
//
$tableUser      		= DBT_User;
$tableGroup     		= DBT_Group;
$tableGroupMember		= DBT_GroupMember;
$tableArticle			= DBT_Article;
$tableStatistics 		= DBT_Statistics;

// Get Standard Procedure names
$spPDisplayArticle		= DBSP_PDisplayArticle;
$spPListArticles 		= DBSP_PListArticles;
$spPUpdateArticle		= DBSP_PUpdateArticle;
$spPCreateNewArticle 	= DBSP_PCreateNewArticle;
  
// Get User Defined Function names
$udfFCheckUserIsOwnerOrAdmin = DBUDF_FCheckUserIsOwnerOrAdmin;
  
// Get Trigger names
$trInsertUser 			= DBTR_TInsertUser;
$trAddArticle 			= DBTR_TAddArticle;
$trDeleteArticle		= DBTR_TDeleteArticle;


$query = <<<EOD
	DROP TABLE IF EXISTS {$tableUser};
	DROP TABLE IF EXISTS {$tableGroup};
	DROP TABLE IF EXISTS {$tableGroupMember};
	DROP TABLE IF EXISTS {$tableArticle};
	DROP TABLE IF EXISTS {$tableStatistics};
--
-- Table for the User
--
-- Table for User
	CREATE TABLE {$tableUser} (
	idUser INT AUTO_INCREMENT NOT NULL PRIMARY KEY, 
	accountUser CHAR(20) NOT NULL UNIQUE, 
	emailUser CHAR(100) NOT NULL, 
	passwordUser CHAR(32) NOT NULL, 
	nameUser CHAR(100) NOT NULL 
	) ENGINE = MYISAM CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table for the Article
--
	CREATE TABLE {$tableArticle} (
	idArticle INT AUTO_INCREMENT NOT NULL PRIMARY KEY, 
	headlineArticle VARCHAR(100) NOT NULL, 
	bodyArticle VARCHAR(1000) NOT NULL, 
	dateArticle DATETIME NOT NULL, 
	modifiedArticle DATETIME NULL, 
	authorArticle INT NOT NULL, 
	FOREIGN KEY (authorArticle) REFERENCES {$tableUser}(idUser)
	) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table for the Group
--
	CREATE TABLE {$tableGroup} (
	idGroup CHAR(5) NOT NULL PRIMARY KEY,
	nameGroup CHAR(40) NOT NULL
	) ENGINE = MYISAM CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table for the GroupMember
--
	CREATE TABLE {$tableGroupMember} (
	GroupMember_idUser INT NOT NULL,
	GroupMember_idGroup CHAR(10) NOT NULL,
  
	FOREIGN KEY (GroupMember_idUser) REFERENCES {$tableUser}(idUser),
	FOREIGN KEY (GroupMember_idGroup) REFERENCES {$tableGroup}(idGroup),
	PRIMARY KEY (GroupMember_idUser, GroupMember_idGroup)
	) ENGINE = MYISAM CHARSET=utf8 COLLATE=utf8_general_ci;

--
--
  
-- Table for Statistics
	CREATE TABLE {$tableStatistics} (
	idUserStat INT NOT NULL PRIMARY KEY,
	numOfArticlesStat INT NOT NULL DEFAULT 0,
	FOREIGN KEY (idUserStat) REFERENCES {$tableUser}(idUser)
	) ENGINE = MYISAM CHARSET=utf8 COLLATE=utf8_general_ci;


--
-- Trigger for Statistics
-- Add row when new user is created
--
	DROP TRIGGER IF EXISTS {$trInsertUser};
	CREATE TRIGGER {$trInsertUser}
	AFTER INSERT ON {$tableUser}
	FOR EACH ROW
	BEGIN
		INSERT INTO {$tableStatistics} (idUserStat) VALUES (NEW.idUser);
	END;
  
-- Trigger for Statistics
--
	DROP TRIGGER IF EXISTS {$trAddArticle};
	CREATE TRIGGER {$trAddArticle}
	AFTER INSERT ON {$tableArticle}
	FOR EACH ROW
	BEGIN
		UPDATE {$tableStatistics} 
		SET numOfArticlesStat = numOfArticlesStat + 1
		WHERE idUserStat = NEW.authorArticle;
	END;

-- Trigger for DeletedArticle
--
	DROP TRIGGER IF EXISTS {$trDeleteArticle};
	CREATE TRIGGER {$trDeleteArticle}
	AFTER DELETE ON {$tableArticle}
	FOR EACH ROW
	BEGIN
		UPDATE {$tableStatistics} 
		SET numOfArticlesStat = numOfArticlesStat - 1
		WHERE idUserStat = OLD.authorArticle;
	END;
  
  
-- Default users
	INSERT INTO {$tableUser} (accountUser, emailUser, passwordUser, nameUser) VALUES 
	('doe', 'doe@bth.se', md5('doe'), 'Vaktis'), 
	('user', 'user@bth.se', md5('pass'), 'Stundent'), 
	('Mikael', 'mikael@bth.se', md5('hemligt'), 'Mikael');

-- Default groups
	INSERT INTO {$tableGroup} (idGroup, nameGroup) VALUES 
	('adm', 'Administratör'), 
	('usr', 'Bloggare');
  
-- Default group
	INSERT INTO {$tableGroupMember} (GroupMember_idUser, GroupMember_idGroup) VALUES 
	((SELECT idUser FROM {$tableUser} WHERE accountUser = 'doe'), 'usr'),
	((SELECT idUser FROM {$tableUser} WHERE accountUser = 'user'), 'usr'),
	((SELECT idUser FROM {$tableUser} WHERE accountUser = 'Mikael'), 'adm');
  
-- Default articles
	INSERT INTO {$tableArticle} (headlineArticle, bodyArticle, dateArticle, authorArticle) VALUES 
	('Article 1', 'A witness in the impeachment trial of Chief Justice Renato Corona denied yesterday he lead prosecutor.', '2012-02-15 19:10', 1),
	('Article 2', 'A Supreme Court (SC) appointee of President Aquino has recused herself from handling the petition impeachment trial.', '2012-02-14 20:14', 2),
	('Article 3', '“Nanganak na... Wala akong kinalaman dyan, ha. (She just gave birth... I have nothing to do with it.)', '2012-02-14 19:58', 2),
	('Article 4', '“På det hela taget känns denna struktur som en bra utbyggnad. Det ger möjlighet att enkelt integrera fler editorer utan att påverka pagecontrollers som använder dem.', '2012-02-17 07:58', 3);
  
-- Stored Procedure to get a list
-- 
	DROP PROCEDURE IF EXISTS {$spPListArticles};
	CREATE PROCEDURE {$spPListArticles}
	()
	BEGIN
		SELECT idArticle, headlineArticle 
		FROM {$tableArticle} 
		ORDER BY modifiedArticle DESC, dateArticle DESC;
    END;

-- Stored Procedure to display an article
-- 
	DROP PROCEDURE IF EXISTS {$spPDisplayArticle};
	CREATE PROCEDURE {$spPDisplayArticle}
	(
	IN aArticle INT
	)
	BEGIN
		IF aArticle >0 THEN
		SELECT A.idArticle, A.headlineArticle, A.bodyArticle, A.dateArticle, A.modifiedArticle, A.authorArticle
		FROM {$tableArticle} AS A
		WHERE A.idArticle = aArticle;
	ELSE
		SELECT A.idArticle, A.headlineArticle, A.bodyArticle, A.dateArticle, A.modifiedArticle, A.authorArticle
		FROM {$tableArticle} AS A
		ORDER BY A.modifiedArticle DESC, A.dateArticle DESC
		LIMIT 1;
		END IF;
	END;
  
  
-- Stored Procedure to update an article.
-- 
	DROP PROCEDURE IF EXISTS {$spPUpdateArticle};
	CREATE PROCEDURE {$spPUpdateArticle}
	(
    IN aArticle INT, 
    IN aUser INT,
    IN aHeadline VARCHAR(100), 
    IN aBody VARCHAR(1000)
	)
	BEGIN
		UPDATE {$tableArticle} SET  
		headlineArticle = aHeadline, 
		bodyArticle = aBody, 
		modifiedArticle = NOW()
		WHERE idArticle = aArticle AND {$udfFCheckUserIsOwnerOrAdmin}(aArticle, aUser);
	END;
  
  
-- Stored Procedure to create a new article.
-- 
	DROP PROCEDURE IF EXISTS {$spPCreateNewArticle};
	CREATE PROCEDURE {$spPCreateNewArticle}
	(
	IN aHeadline VARCHAR(100), 
	IN aBody VARCHAR(1000),
	IN aUser INT
	)
	BEGIN
		INSERT INTO {$tableArticle} 
		(headlineArticle, bodyArticle, dateArticle, authorArticle) 
		VALUES 
		(aHeadline, aBody, NOW(), aUser);
	END;
  
  
--  Create an UDF that checks if user owns article or is member of group adm.
--
	DROP FUNCTION IF EXISTS {$udfFCheckUserIsOwnerOrAdmin};
	CREATE FUNCTION {$udfFCheckUserIsOwnerOrAdmin}
	(
    aArticle INT,
    aUser INT
	)
	RETURNS BOOLEAN
	BEGIN
		DECLARE isAdmin INT;
		DECLARE isOwner INT;
    
		SELECT idUser INTO isAdmin
		FROM {$tableUser} AS U
		INNER JOIN {$tableGroupMember} AS GM 
		ON U.idUser = GM.GroupMember_idUser
		INNER JOIN {$tableGroup} AS G
		ON G.idGroup = GM.GroupMember_idGroup
		WHERE idGroup = 'adm' AND idUser = aUser;

		SELECT idUser INTO isOwner
		FROM {$tableUser} AS U
		INNER JOIN {$tableArticle} AS A
		ON U.idUser = A.authorArticle
		WHERE idArticle = aArticle AND idUser = aUser;

    RETURN (isAdmin OR isOwner);
	END;
  
EOD;
?>