<?

if (!defined("IN_MKP")) {
    die ("Sorry !! You cannot access this file directly.");
}


define('IN_PHPBB', true);

error_reporting(E_ALL ^ E_NOTICE);

$phpbb_root_path = $MK_PATH.$FORUM_PATH."/";
$mkportals->base_url = $phpbb_root_path."index.php";
$mkportals->forum_url = $MK_PATH.$FORUM_PATH;

include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);


$to_require = $MK_PATH."mkportal/include/mk_mySQL.php";
	require ($to_require);


	$DB = new db_driver;

	$DB->obj['dbname'] = $dbname;
	$DB->obj['dbuser'] = $dbuser;
	$DB->obj['dbpasswd'] = $dbpasswd;
	$DB->obj['dbhost'] = $dbhost;

	$DB->connect();

// assign member information
$mkportals->member['id'] = $userdata['user_id'];
$mkportals->member['name'] = $userdata['username'];
$mkportals->member['ip'] = $user_ip;

if($userdata['user_id'] == -1) {
	$mkportals->member['id'] = "";
}
$mkportals->member['last_visit'] = $userdata['user_lastvisit'];
$mkportals->member['session_id'] = $userdata['session_id'];

$mkportals->member['user_new_privmsg'] = $userdata['user_unread_privmsg']."/".$userdata['user_new_privmsg'];
if ($userdata['user_last_privmsg'] > $userdata['user_lastvisit'] && $userdata['user_new_privmsg'] > 0) {
	$mkportals->member['show_popup'] = 1;
}

$mkportals->member['timezone'] = $userdata['user_timezone'];
//$mkportals->member['dateformat'] = $userdata['user_dateformat'];


// assign to forum admin access to MKportal CPA
if($userdata['user_level'] == 1) {
	$mkportals->member['g_access_cp'] = 1;
}

//assign member group -> attention don't change this !!
$mkportals->member['mgroup'] = 3;
if($userdata['user_id'] == -1) {
	$mkportals->member['mgroup'] = 9;
}
if($userdata['user_level'] == 2) {
	$mkportals->member['mgroup'] = 2;
}
$mkportals->member['theme'] = $userdata['user_style'];
if (empty($userdata['user_style'])) {
		$mkportals->member['theme'] = $board_config['default_style'];
}

?>
