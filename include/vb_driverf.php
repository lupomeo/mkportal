<?

if (!defined("IN_MKP")) {
    die ("Sorry !! You cannot access this file directly.");
}

define('NO_REGISTER_GLOBALS', 1);
define('THIS_SCRIPT', 'index');
define('MK_PATH', $MK_PATH);

error_reporting(E_ALL ^ E_NOTICE);

chdir($MK_PATH.$FORUM_PATH);

$globaltemplates = array(
'FORUMHOME',
'forumhome_event',
'forumhome_forumbit_level1_nopost',
'forumhome_forumbit_level1_post',
'forumhome_forumbit_level2_nopost',
'forumhome_forumbit_level2_post',
'forumhome_lastpostby',
'forumhome_loggedinuser',
'forumhome_moderator',
'forumhome_pmloggedin',
'forumhome_subforumbit_nopost',
'forumhome_subforumbit_post',
'forumhome_subforumseparator_nopost',
'forumhome_subforumseparator_post'
);

require_once('./global.php');
require_once('./includes/functions_bigthree.php');
require_once('./includes/functions_forumlist.php');

// assign member information
$mkportals->member['id'] = $bbuserinfo['userid'];
$mkportals->member['name'] = $bbuserinfo['username'];


$mkportals->member['last_visit'] = $bbuserinfo['lastvisit'];
//$mkportals->member['session_id'] = $sc;
$mkportals->member['user_new_privmsg'] = $bbuserinfo['pmtotal']."/".$bbuserinfo['pmunread'];

if($bbuserinfo['pmpopup'] > 1) {
	$mkportals->member['show_popup'] = 1;
}
$mkportals->member['timezone'] = $bbuserinfo['timezoneoffset'];
$mkportals->member['avatar'] = $bbuserinfo['avatar'];


// assign to forum admin access to MKportal CPA
if($bbuserinfo['usergroupid'] == 6) {
	$mkportals->member['g_access_cp'] = 1;
}
$mkportals->member['mgroup'] = $bbuserinfo['usergroupid'];

if(!$mkportals->member['id']) {
	$mkportals->member['mgroup'] = 1;
}

$mkportals->member['theme'] = $bbuserinfo['styleid'];
	if ($bbuserinfo['styleid'] == 0) {
		$mkportals->member['theme'] = $vboptions['styleid'];
	}

// return MKDIR and load DBdriver.
chdir('../');

$MK_PATH = MK_PATH;
if ($MK_PATH == "../")
	chdir('mkportal');

require $MK_PATH."mkportal/conf_mk.php";
$boarddir = $MK_PATH.$FORUM_PATH."/";
$mkportals->base_url = $boarddir."index.php";
$mkportals->forum_url = $MK_PATH.$FORUM_PATH;


require ("$boarddir"."includes/config.php");

$to_require = $MK_PATH."mkportal/include/mk_mySQL.php";
	require ($to_require);


	$DB = new db_driver;

	$DB->obj['dbname'] = $dbname;
	$DB->obj['dbuser'] = $dbusername;
	$DB->obj['dbpasswd'] = $dbpassword;
	$DB->obj['dbhost'] = $servername;

	$DB->connect();

// needed for vb
$board_functions = "vb_board_functions.php";
//mysql_close($db_connection);

?>
