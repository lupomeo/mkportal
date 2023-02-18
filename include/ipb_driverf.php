<?

if (!defined("IN_MKP")) {
    die ("Sorry !! You cannot access this file directly.");
}
define ( 'IN_IPB', 1 );
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

require $MK_PATH."mkportal/include/class_mkportals.php";

$boarddir = $MK_PATH.$FORUM_PATH."/";
define( 'KERNEL_PATH', $boarddir.'ips_kernel/' );

$INFO = array();
require $boarddir."conf_global.php";

$INFO['sql_driver'] = ! $INFO['sql_driver'] ? 'mysql' : strtolower($INFO['sql_driver']);

require ( KERNEL_PATH.'class_db_'.$INFO['sql_driver'].".php" );

$DB = new db_driver;

$DB->obj['sql_database']     = $INFO['sql_database'];
$DB->obj['sql_user']         = $INFO['sql_user'];
$DB->obj['sql_pass']         = $INFO['sql_pass'];
$DB->obj['sql_host']         = $INFO['sql_host'];
$DB->obj['sql_tbl_prefix']   = $INFO['sql_tbl_prefix'];
$DB->obj['query_cache_file'] = $boarddir.'sources/sql/'.$INFO['sql_driver'].'_queries.php';
$DB->obj['use_shutdown']     = '0';


$DB->connect();



$mkportals = new mkportals_set();

$mkportals->base_url = $boarddir."index.php";
$mkportals->forum_url = $MK_PATH.$FORUM_PATH;

require $boarddir."sources/functions.php";
require $boarddir."sources/classes/class_session.php";


$std    = new FUNC;
$sess   = new session();
$mkportals->member     = $sess->authorise();

$mkportals->member['user_new_privmsg'] = $mkportals->member['msg_total']."/".$mkportals->member['new_msg'];
if($mkportals->member['mgroup'] == 4) {
	$mkportals->member['g_access_cp'] = 1;
}
if(!$mkportals->member['id']) {
	$mkportals->member['mgroup'] = 2;
}
$mkportals->member['theme'] = $mkportals->member['skin'];


if ($mkportals->member['theme']) {
	$DB->query("SELECT  set_name from ibf_skin_sets where set_skin_set_id = '{$mkportals->member['theme']}'");
}
else {
	$DB->query("SELECT set_name from ibf_skin_sets where  set_default = '1'");
}
$r = $DB->fetch_row();
$mkportals->theme_name = strstr($r['set_name'], "mkportal");
unset ($r);

if (substr($mkportals->theme_name, 0, 9) == "mkportal2") {
$MK_TEMPLATE = "default";
}
$mkportals->input = $std->parse_incoming();

$DB->query("SELECT cs_value from ibf_cache_store where cs_key = 'settings'");
$r = $DB->fetch_row();
$tmp = unserialize( $std->txt_safeslashes($r['cs_value']) );

 if ( is_array( $tmp ) and count( $tmp ) )
 {
  foreach( $tmp as $k => $v )
  {
   $ibforums->vars[ $k ] = stripslashes($v);
  }
 }

unset( $tmp );
unset ($r);
//altrimenti non funziona get_time_offset.
$ibforums->member['id'] = $mkportals->member['id'];
$ibforums->member['time_offset'] = $mkportals->member['time_offset'];
$mkportals->member['timezone'] = ($std->get_time_offset() /3600);

?>
