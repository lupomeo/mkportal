<?
/*
+--------------------------------------------------------------------------
|   MkPortal
|   ========================================
|   by Meo aka Luponero <Amedeo de longis>
|
|   (c) 2004 mkportal.it
|   http://www.mkportal.it
|   Email: luponero@mclink.it
|
+---------------------------------------------------------------------------
|
|   > MKPortal
|   > Written By Amedeo de longis
|   > Date started: 9.2.2004
|
+--------------------------------------------------------------------------
*/


require "conf_mk.php";

$BOARD = $MK_BOARD;
$forumpath = $FORUM_PATH;


switch($BOARD) {
				case 'IPB':
    				$confff = "conf_global.php";
    			break;
				case 'PHPBB':
    				$confff = "config.php";
				break;
				case 'VB':
    				$confff = "includes/config.php";
				break;
				case 'OXY':
    				$confff = "include/config.php";
    			break;
				default:
    				$confff = "Settings.php";
    			break;
	}


	require "../$forumpath/$confff";

	switch($BOARD) {
				case 'IPB':
    				$dbhost = $INFO['sql_host'];
					$dbname = $INFO['sql_database'];
					$dbuser = $INFO['sql_user'];
					$dbpasswd = $INFO['sql_pass'];
    			break;
				case 'PHPBB':
    				$dbhost = $dbhost;
					$dbname = $dbname;
					$dbuser = $dbuser;
					$dbpasswd = $dbpasswd;
    			break;
				case 'VB':
    				$dbhost = $servername;
					$dbname = $dbname;
					$dbuser = $dbusername;
					$dbpasswd = $dbpassword;
    			break;
				case 'OXY':
    				$dbhost = $dbhost;
					$dbname = $dbname;
					$dbuser = $dbuser;
					$dbpasswd = $dbpw;
    			break;
				default:
    				$dbhost = $db_server;
					$dbname = $db_name;
					$dbuser = $db_user;
					$dbpasswd = $db_passwd;
    			break;
	}

		mysql_connect($dbhost, $dbuser, $dbpasswd);
		$checkdb_conn = mysql_select_db($dbname);

	if (!$checkdb_conn) {
		echo "Error, Couldn't connect to database";
		exit;
	}

$query1 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_quote', '0')";
$query2 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_blog', '0')";
$query3 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_gallery', '0')";
$query4 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_download', '0')";
$query5 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_news', '0')";
$query6 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_topsite', '0')";
$query7 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_review', '0')";

mysql_query($query1);
mysql_query($query2);
mysql_query($query3);
mysql_query($query4);
mysql_query($query5);
mysql_query($query6);
mysql_query($query7);

$query8="ALTER TABLE `mkp_blog` ADD `validate` tinyint(1) NOT NULL default '1' AFTER `banner`";
mysql_query($query8);

$query9="ALTER TABLE `mkp_gallery` ADD `validate` tinyint(1) NOT NULL default '1' AFTER `data`";
mysql_query($query9);

$query10="ALTER TABLE `mkp_download` ADD `validate` tinyint(1) NOT NULL default '1' AFTER `peso`";
mysql_query($query10);

$query11="ALTER TABLE `mkp_news` ADD `validate` tinyint(1) NOT NULL default '1' AFTER `data`";
mysql_query($query11);

$query11="ALTER TABLE `mkp_reviews` ADD `validate` tinyint(1) NOT NULL default '1' AFTER `date`";
mysql_query($query11);

//last

$query1 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('watermark_enable', '0')";
$query2 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('watermark_pos', '2')";
$query3 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('watermark_level', '60')";

mysql_query($query1);
mysql_query($query2);
mysql_query($query3);

echo "Upgrade completed";
exit;
?>
