<?php
// ===========================================================================================
//
// PInstallProcess.php
//
// Creates new tables in the database. 
//
// -------------------------------------------------------------------------------------------
// Create a new database object, connect to the database.
//
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

if (mysqli_connect_error()) {
   echo "Connect failed: ".mysqli_connect_error()."<br>";
   exit();
}

$mysqli->set_charset("utf8");

// -------------------------------------------------------------------------------------------
//
// Prepare SQL for User & Group structure.
//
$tableUser      	= DB_PREFIX . 'User';
$tableGroup     	= DB_PREFIX . 'Group';
$tableGroupMember	= DB_PREFIX . 'GroupMember';
$tableArticle		= DB_PREFIX . 'Article';

$query = <<<EOD
DROP TABLE IF EXISTS {$tableUser};
DROP TABLE IF EXISTS {$tableGroup};
DROP TABLE IF EXISTS {$tableGroupMember};
DROP TABLE IF EXISTS {$tableArticle};


--
-- Table for the User
--
CREATE TABLE {$tableUser} (

  -- Primary key(s)
  idUser INT AUTO_INCREMENT NOT NULL PRIMARY KEY,

  -- Attributes
  accountUser CHAR(20) NOT NULL UNIQUE,
  infoUser CHAR(50) NOT NULL,
  emailUser CHAR(100) NOT NULL,
  passwordUser CHAR(32) NOT NULL
) ENGINE = MYISAM CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Table for the Article
--
CREATE TABLE {$tableArticle} (

  -- Primary key(s)
  idArticle INT AUTO_INCREMENT NOT NULL PRIMARY KEY,

  -- Foreign keys
  Article_idUser INT NOT NULL,
  FOREIGN KEY (Article_idUser) REFERENCES {$tableUser}(idUser),
  
  -- Attributes
  titleArticle VARCHAR(256) NOT NULL,
  contentArticle BLOB NOT NULL,
  createdArticle DATETIME NOT NULL,
  modifiedArticle DATETIME NULL,
  deletedArticle DATETIME NULL
)ENGINE = MYISAM CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Table for the Group
--
CREATE TABLE {$tableGroup} (

  -- Primary key(s)
  idGroup CHAR(5) NOT NULL PRIMARY KEY,

  -- Attributes
  nameGroup CHAR(40) NOT NULL
) ENGINE = MYISAM CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Table for the GroupMember
--
CREATE TABLE {$tableGroupMember} (

  -- Primary key(s)
  --
  -- The PK is the combination of the two foreign keys, see below.
  --
  
  -- Foreign keys
  GroupMember_idUser INT NOT NULL,
  GroupMember_idGroup CHAR(10) NOT NULL,
  
  FOREIGN KEY (GroupMember_idUser) REFERENCES {$tableUser}(idUser),
  FOREIGN KEY (GroupMember_idGroup) REFERENCES {$tableGroup}(idGroup),

  PRIMARY KEY (GroupMember_idUser, GroupMember_idGroup)
  
  -- Attributes

) ENGINE = MYISAM CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Add default user(s) 
--
INSERT INTO {$tableUser} (accountUser, infoUser, emailUser, passwordUser)
VALUES ('mikael', 'Huvudlärare med huvudet på skaft', 'mos@bth.se', md5('hemligt'));
INSERT INTO {$tableUser} (accountUser, infoUser, emailUser, passwordUser)
VALUES ('doe', 'Vaktmästare med borste och skaft', 'doe@bth.se', md5('doe'));
INSERT INTO {$tableUser} (accountUser, infoUser, emailUser, passwordUser)
VALUES ('user', 'Bara lärare utan skaft', 'user@user.se', md5('pass'));
INSERT INTO {$tableUser} (accountUser, infoUser, emailUser, passwordUser)
VALUES ('Karl', 'Matte lärare', 'karl@user.se', md5('karl'));
INSERT INTO {$tableUser} (accountUser, infoUser, emailUser, passwordUser)
VALUES ('Pelle', 'Gympalärare med innebandy skaft', 'pelle@user.se', md5('pelle'));
--
-- Add default groups
--
INSERT INTO {$tableGroup} (idGroup, nameGroup) VALUES ('adm', 'Administratör av sidan');
INSERT INTO {$tableGroup} (idGroup, nameGroup) VALUES ('blog', 'Bloggare');
--
-- Add default groupmembers
--
INSERT INTO {$tableGroupMember} (GroupMember_idUser, GroupMember_idGroup) 
VALUES ((SELECT idUser FROM {$tableUser} WHERE accountUser = 'doe'), 'blog');
INSERT INTO {$tableGroupMember} (GroupMember_idUser, GroupMember_idGroup) 
VALUES ((SELECT idUser FROM {$tableUser} WHERE accountUser = 'mikael'), 'adm');
INSERT INTO {$tableGroupMember} (GroupMember_idUser, GroupMember_idGroup) 
VALUES ((SELECT idUser FROM {$tableUser} WHERE accountUser = 'user'), 'blog');
INSERT INTO {$tableGroupMember} (GroupMember_idUser, GroupMember_idGroup) 
VALUES ((SELECT idUser FROM {$tableUser} WHERE accountUser = 'Karl'), 'blog');
INSERT INTO {$tableGroupMember} (GroupMember_idUser, GroupMember_idGroup) 
VALUES ((SELECT idUser FROM {$tableUser} WHERE accountUser = 'Pelle'), 'blog');

INSERT INTO {$tableArticle} ( Article_idUser, titleArticle, contentArticle, createdArticle) 
VALUES ('2', 'Artikel 1', 'Har borjar artikel 1....', '2012-01-21 18:01:00');
INSERT INTO {$tableArticle} (Article_idUser, titleArticle, contentArticle, createdArticle) 
VALUES ('2', 'Artikel 2', 'Har borjar artikel 2....', '2012-01-22 18:01:00');
INSERT INTO {$tableArticle} (Article_idUser, titleArticle, contentArticle, createdArticle) 
VALUES ('2', 'Artikel 3', 'Har borjar artikel 3....', '2012-01-23 18:01:00');


EOD;

// -----
// Prepare and perform a SQL query.
//
$tablePost = DB_PREFIX . 'posts';
$tableComments  = DB_PREFIX . 'kommentar';

$query .= <<<EOD
DROP TABLE IF EXISTS {$tableComments};
DROP TABLE IF EXISTS {$tablePost};

--
-- Table for the posts
--
CREATE TABLE {$tablePost} (

  idPost INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  
  post_idUser INT NOT NULL,
  FOREIGN KEY (post_idUser) REFERENCES {$tableUser}(idUser),
  
  -- Attributes
  titlePost CHAR(50) NOT NULL,
  textPost TEXT NOT NULL,
  tagPost CHAR(50),
  datePost DATETIME NOT NULL
) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Table to store the comments
--
CREATE TABLE {$tableComments} (

  -- Primary key(s)
  idComment INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  comment_idPost INT NOT NULL,

  -- Foreign key(s)
  FOREIGN KEY (comment_idPost) REFERENCES {$tablePost}(idPost),

  -- Attributes
  titleComment CHAR(50) NOT NULL,
  textComment TEXT NOT NULL,
  authorComment CHAR(50) NOT NULL,
  emailComment CHAR(50) NOT NULL,
  dateComment DATETIME NOT NULL
) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Insert some dummy values to start with
--
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('1', 'Rubrik 1', 'Inlägg 1Inlägg 1Inlägg 1Inlägg 1Inlägg 1', 'blogg', '2011-04-15 18:01:00');
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('1', 'Rubrik 2', 'Inlägg 2Inlägg 2Inlägg 2Inlägg 2Inlägg 2', 'blogg', '2011-04-16 18:02:00');
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('3', 'Rubrik 3', 'Inlägg 3Inlägg 3Inlägg 3Inlägg 3Inlägg 3', 'blogg, it', '2011-04-17 18:03:00');
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('1', 'Rubrik 4', 'Inlägg 4Inlägg 4Inlägg 4Inlägg 4Inlägg 4', 'php, it, Tagg2', '2011-04-18 18:04:00');
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('4', 'Rubrik 5', 'Inlägg 5Inlägg 5Inlägg 5Inlägg 5Inlägg 5', 'css', '2011-04-19 18:05:00');
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('5', 'Rubrik 6', 'Inlägg 6nlägg 6Inlägg 6Inlägg 6Inlägg 6', 'Mysql', '2011-04-20 18:06:00');
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('5', 'Rubrik 7', 'Inlägg 7Inlägg 7Inlägg 7Inlägg 7Inlägg 7', 'it, blogg', '2011-04-21 18:07:00');
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('1', 'Rubrik 8', 'Inlägg 8Inlägg 8Inlägg 8Inlägg 8Inlägg 8', 'bio', '2011-04-22 18:08:00');
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('2', 'Rubrik 9', 'Inlägg 9Inlägg 9Inlägg 9Inlägg 9Inlägg 9', 'resor', '2011-05-23 18:09:00');
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('2', 'Rubrik 10', 'Inlägg 10Inlägg 10Inlägg 10Inlägg 10Inlägg 10', 'it', '2011-04-24 18:10:00');
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('3', 'Rubrik 11', 'Inlägg 11Inlägg 11Inlägg 11Inlägg 11Inlägg 8', 'pc', '2011-05-26 18:11:00');
INSERT INTO {$tablePost}(post_idUser, titlePost, textPost, tagPost, datePost)
VALUES ('1', 'Rubrik 12', 'Övningens syfte är att omsätta vår kunskap i C/C++, Java, C#, Visual Basic, Perl, 
shellscript eller liknande programmeringsspråk till grunderna i PHP. Vi betraktar PHP som ett vanligt programmeringsspråk, 
ett språk att likställa med C++ och Java. Vi övar på variabler, funktioner, kontrollstrukturer, datastrukturer samt 
klasser och objekt. Vi blir kompisar med PHPs referensmanual. Momentet avslutas med en liten programmeringsövning.
Detta är ett av de kursmoment som förutsätter att du genomgått en programmeringskurs på högskolenivå (eller har liknande kunskaper). 
Om du har fallenhet för programmering så kan det gå bra ändå men räkna då med att få lägga extra tid på detta moment. 
I övningarna nedan förutsätts att studenten är bekant med programmeringens grundkonster såsom variabler, funktioner, 
klasser, objekt, objektorientering, loopar if, switch och liknande. En annan förutsättning är att du är bekväm/känner till HTML/CSS, 
det är inga avancerade exempel men du bör känna dig hemma i grunderna.
', 'bth', '2011-05-17 18:12:00');


INSERT INTO {$tableComments}(comment_idPost, titleComment, textComment, authorComment, emailComment, dateComment)
VALUES ('1', 'Comment1', 'Comment1 Comment1', 'JAN1', 'aaa@nnkk.com', '2011-04-25 18:01:00');
INSERT INTO {$tableComments}(comment_idPost, titleComment, textComment, authorComment, emailComment, dateComment)
VALUES ('1', 'Comment 2', 'Comment 2', 'JAN12', 'bbb@nnkk.com', '2011-04-26 18:02:00');
INSERT INTO {$tableComments}(comment_idPost, titleComment, textComment, authorComment, emailComment, dateComment)
VALUES ('3', 'Comment 3', 'Comment 3', 'JAN13', 'ccc@nnkk.com', '2011-04-27 18:03:00');
INSERT INTO {$tableComments}(comment_idPost, titleComment, textComment, authorComment, emailComment, dateComment)
VALUES ('4', 'Comment 4', 'Comment 4', 'JAN14', 'ddd@nnkk.com', NOW());



EOD;

$res = $mysqli->multi_query($query) or die("Could not query database");

// -------------------------------------------------------------------------------------------
//
// Retrieve and ignore the results from the above query
// Some may succed and some may fail. Lets count the number of succeded 
// statements to really know.
//
$statements = 0;
do {
  $res = $mysqli->store_result();
  $statements++;
} while($mysqli->more_results() && $mysqli->next_result());

// -------------------------------------------------------------------------------------------
//
// Prepare the text
//
$html = "<h2>Installera databas</h2><div class='quary'>";
//$html .= "<p>Query=<br/><pre>{$query}</pre>";
$html .= "<p>Antal lyckade statements: {$statements}</p>";
$html .= "<p>Error code: {$mysqli->errno} ({$mysqli->error})</p></div>";
$html .= "<p><a href='?p=home'>Hem</a></p>";

// -------------------------------------------------------------------------------------------
//
// Close the connection to the database
//
$mysqli->close();

// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
require_once(TP_SOURCEPATH . 'CHTMLPage.php'); 

$page = new CHTMLPage();

$page->PrintPage('Template', '', $html, '');
/*
$page->printHTMLHeader('Installation av databas');
$page->printPageHeader();
$page->printPageBody($html, $htmlSida);
$page->printPageFooter();
*/