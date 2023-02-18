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

define ( 'IN_MKP', 1 );


$MK_PATH = "../";
require $MK_PATH."mkportal/conf_mk.php";


switch($MK_BOARD) {
	case 'IPB':
		$driverf = "ipb_driverf.php";
		$board_functions = "ipb_board_functions.php";
    break;
	case 'PHPBB':
    	$driverf = "php_driverf.php";
		$board_functions = "php_board_functions.php";
    break;
	case 'VB':
    	$driverf = "vb_driverf.php";
		$board_functions = "vb_board_functions.php";
    break;
	case 'OXY':
    	$driverf = "oxy_driverf.php";
		$board_functions = "oxy_board_functions.php";
    break;
	default:
    	$driverf = "smf_driverf.php";
		$board_functions = "smf_board_functions.php";
    break;
}

require $MK_PATH."mkportal/include/$driverf";
require $MK_PATH."mkportal/include/functions.php";
require $MK_PATH."mkportal/include/$board_functions";


require "$mklib->template/tpl_main.php";

$mklib->load_lang("lang_admin.php");

//controlla che sei loggato e admin

	if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_access_cpa']) {
		$message = "{$mklib->lang['ad_noperms']}";
		$mklib->error_page($message);
		exit;
	}

	if($mkportals->member['name']=="Guest" OR $mkportals->member['name']=="") {
		$message = "{$mklib->lang['ad_noperms']}";
		$mklib->error_page($message);
		exit;
}


$mkportals->input = $mklib->mkp_input();
$ind = $mkportals->input['ind'];

$switch = array(
                'ad_blocks'       =>   "ad_blocks",
                'ad_blog'         =>   "ad_blog",
                'ad_chat'         =>   "ad_chat",
                'ad_contents'     =>   "ad_contents",
                'ad_download'     =>   "ad_download",
                'ad_gallery'      =>   "ad_gallery",
                'ad_main'         =>   "ad_main",
                'ad_news'         =>   "ad_news",
				'ad_boardnews'    =>   "ad_boardnews",
                'ad_perms'        =>   "ad_perms",
                'ad_poll'         =>   "ad_poll",
                'ad_quote'        =>   "ad_quote",
                'ad_review'       =>   "ad_review",
                'ad_topsite'      =>   "ad_topsite",
                'ad_urlo'         =>   "ad_urlo",
				'ad_nav'          =>   "ad_nav",
				'ad_skin'         =>   "ad_skin",
				'ad_approvals'    =>   "ad_approvals"
                );

if (!isset($switch[$ind])) {
    $ind = "ad_main";
}

require "./admin/{$switch[$ind]}.php";



?>
