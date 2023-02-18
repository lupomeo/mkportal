<?

if (!defined("IN_MKP")) {
    die ("Sorry !! You cannot access this file directly.");
}

define('SMF', 1);
error_reporting(E_ALL ^ E_NOTICE);

$boarddir = $MK_PATH.$FORUM_PATH."/";
$mkportals->base_url = $boarddir."index.php";
$mkportals->forum_url = $MK_PATH.$FORUM_PATH;

include($boarddir . 'Settings.php');
define('DBPREFIX', $db_prefix);

require_once($sourcedir . '/QueryString.php');
require_once($sourcedir . '/Subs.php');
require_once($sourcedir . '/Errors.php');
require_once($sourcedir . '/Load.php');
require_once($sourcedir . '/Security.php');

@mysql_pconnect($db_server, $db_user, $db_passwd);
// Connect to the MySQL database.
if (empty($db_persist))
	$db_connection = @mysql_connect($db_server, $db_user, $db_passwd);
else
	$db_connection = @mysql_pconnect($db_server, $db_user, $db_passwd);

// Show an error if the connection couldn't be made.
if (!$db_connection || !@mysql_select_db($db_name, $db_connection))
	db_fatal_error();

// Load the settings from the settings table, and perform operations like optimizing.
reloadSettings();
// Clean the request variables, add slashes, etc.
cleanRequest();
$context = array();


// Start the session. (assuming it hasn't already been.)
loadSession();

// There's a strange bug in PHP 4.1.2 which makes $_SESSION not work unless you do this...
if (@version_compare(PHP_VERSION, '4.2.0') == -1)
	$HTTP_SESSION_VARS['php_412_bugfix'] = true;

loadUserSettings();


// assign member information
$mkportals->member['id'] = $ID_MEMBER;
$mkportals->member['name'] = $user_info['username'];

$mkportals->member['last_visit'] = $user_info['last_login'];
$mkportals->member['session_id'] = $sc;
$mkportals->member['user_new_privmsg'] = $user_info['messages']."/".$user_info['unread_messages'];
if ($user_info['unread_messages'] > (isset($_SESSION['unread_messages']) ? $_SESSION['unread_messages'] : 0))  {
			$mkportals->member['show_popup'] = 1;
} else {
		$mkportals->member['show_popup'] = 0;
}
$_SESSION['unread_messages'] = $user_info['unread_messages'];
$mkportals->member['timezone'] = $user_info['time_offset'];

$mkportals->member['avatar'] = $user_info['avatar'];

// assign to forum admin access to MKportal CPA
if($user_info['is_admin']) {
	$mkportals->member['g_access_cp'] = 1;
}
$mkportals->member['mgroup'] = $user_settings['ID_GROUP'];
if(!$ID_MEMBER) {
	$mkportals->member['mgroup'] = 99;
}
if($mkportals->member['mgroup'] == 0) {
	$mkportals->member['mgroup'] = $user_settings['ID_POST_GROUP'];
}

$mkportals->member['theme'] = $user_info['theme'];
	if (empty($user_info['theme'])) {
		$mkportals->member['theme'] = $modSettings['theme_guests'];
	}

//mysql_close($db_connection);

$to_require = $MK_PATH."mkportal/include/mk_mySQL.php";
	require ($to_require);


	$DB = new db_driver;

	$DB->obj['dbname'] = $db_name;
	$DB->obj['dbuser'] = $db_user;
	$DB->obj['dbpasswd'] = $db_passwd;
	$DB->obj['dbhost'] = $db_server;

	$DB->connect();

// Remember this URL incase someone doesn't like sending HTTP_REFERER.
	$_SESSION['old_url'] = $_SERVER['REQUEST_URI'];

	// For session check verfication.... don't switch browsers...
	$_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];

	writeLog();

	//echo $modSettings['theme_guests'];

?>
