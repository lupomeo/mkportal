<?

if (!defined("IN_MKP")) {
    die ("Sorry !! You cannot access this file directly.");
}


$boarddir = $MK_PATH.$FORUM_PATH."/";
define('O2_PATH', $boarddir);

error_reporting(E_ALL ^ E_NOTICE);

require(O2_PATH . 'header.php');


$mkportals->base_url = $boarddir."index.php";
$mkportals->forum_url = $MK_PATH.$FORUM_PATH;


// assign member information
$mkportals->member['id'] = $huser['uid'];
$mkportals->member['name'] = $huser['username'];
$mkportals->member['last_visit'] = $huser['lastvisit'];
$mkportals->member['timezone'] = $timeoffset;
$mkportals->member['avatar'] = $huser['avatar'];

switch($huser['status']) {
	case 'Administrator':
		$mkportals->member['g_access_cp'] = 1;
		$mkportals->member['mgroup'] = 100;
    break;
	case 'Member':
		$mkportals->member['mgroup'] = 3;
    break;
	case 'Moderator':
    	$mkportals->member['mgroup'] = 2;
    break;
	case 'Super Moderator':
    	$mkportals->member['mgroup'] = 4;
    break;
	case 'Waiting':
    	$mkportals->member['mgroup'] = 5;
    break;
	case 'Banned':
    	$mkportals->member['mgroup'] = 6;
    break;
	default:
    	$mkportals->member['mgroup'] = 1;
    break;
}


include($boarddir . 'include/config.php');
define('DBPREFIX', $tablepre);
$to_require = $MK_PATH."mkportal/include/mk_mySQL.php";
	require ($to_require);


	$DB = new db_driver;

	$DB->obj['dbname'] = $dbname;
	$DB->obj['dbuser'] = $dbuser;
	$DB->obj['dbpasswd'] = $dbpw;
	$DB->obj['dbhost'] = $dbhost;

	$DB->connect();

	$mkportals->member['user_new_privmsg'] = 0;
	$mkportals->member['show_popup'] = 0;

	if ($huser['uid']) {
			$query = $DB->query("SELECT u2uid from ".DBPREFIX.u2u." where msgto = '$huser[username]' AND isnew = 'yes'");
			$mkportals->member['user_new_privmsgn'] = $DB->get_num_rows($query);
			$query = $DB->query("SELECT u2uid from ".DBPREFIX.u2u." where msgto = '$huser[username]'");
			$mkportals->member['user_new_privmsg'] = $DB->get_num_rows($query);
			$mkportals->member['user_new_privmsg'] = $mkportals->member['user_new_privmsg']."/".$mkportals->member['user_new_privmsgn'];
	}


?>
