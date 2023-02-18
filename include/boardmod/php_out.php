<?php



function mkportal_board_out() {
		global $userdata, $Checkmkout, $mkportals, $DB, $Skin, $MK_PATH, $MK_TEMPLATE, $mklib, $ForumOut, $mklib_board, $MK_TIMEDIFF;
		define ( 'IN_MKP', 1 );
		$MK_PATH = "../";
		require $MK_PATH."mkportal/conf_mk.php";
		$mkportals->base_url = $MK_PATH.$FORUM_PATH."/index.php";
		$mkportals->forum_url = $MK_PATH.$FORUM_PATH;

		require_once $MK_PATH."mkportal/include/mk_mySQL.php";
		require "config.php";
		$DB = new db_driver;

		$DB->obj['dbname'] = $dbname;
		$DB->obj['dbuser'] = $dbuser;
		$DB->obj['dbpasswd'] = $dbpasswd;
		$DB->obj['dbhost'] = $dbhost;

		$DB->connect();
		// assign member information
		$mkportals->member['id'] = $userdata['user_id'];
		$mkportals->member['name'] = $userdata['username'];

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
		require_once $MK_PATH."mkportal/include/functions.php";
		require_once $MK_PATH."mkportal/include/php_board_functions.php";
		require_once "$mklib->template/tpl_main.php";
		if($MK_OFFLINE && !$mkportals->member['g_access_cp'] && !$mklib->member['g_access_cpa']) {
				$message = $mklib->lang['offline'];
				$mklib->off_line_page($message);
				exit;
		}

		ob_start();
    	eval($ForumOut);
    	$contentspage = ob_get_contents();
     	ob_end_clean();

		$mklib->printpage("$mklib->forumcs", "$mklib->forumcd", "Forum", $ForumOut);
		$DB->close_db();

}


?>
