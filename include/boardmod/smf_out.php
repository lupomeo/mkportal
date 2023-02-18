<?php



function mkportal_board_out() {
		global $context, $modSettings, $user_settings, $ID_MEMBER, $user_info, $sc, $db_prefix, $mkportals, $DB, $Skin, $MK_PATH, $MK_TEMPLATE, $mklib, $mklib_board, $MK_TIMEDIFF;
  		$MK_PATH = "../";
		require $MK_PATH."mkportal/conf_mk.php";
		$contentspage = ob_get_contents();
     	ob_end_clean();

		$boarddir = $MK_PATH.$FORUM_PATH."/";
		$mkportals->base_url = $boarddir."index.php";
		$mkportals->forum_url = $MK_PATH.$FORUM_PATH;

		// assign member information
		$mkportals->member['mgroup'] = 0;
		$mkportals->member['id'] = $ID_MEMBER;
		$mkportals->member['name'] = $user_info['username'];

		$mkportals->member['last_visit'] = $user_info['last_login'];
		$mkportals->member['session_id'] = $sc;
		$mkportals->member['user_new_privmsg'] = $user_info['messages']."/".$user_info['unread_messages'];
		$mkportals->member['show_popup'] = 0;
		if (array_key_exists('popup_messages',$context['user'])) {
			if ($context['user']['popup_messages'] == true)  {
				$mkportals->member['show_popup'] = 1;
			}
		}
		$mkportals->member['timezone'] = $user_info['time_offset'];
		$mkportals->member['avatar'] = $user_info['avatar'];

		$mkportals->member['theme'] = $user_info['theme'];
		if (empty($user_info['theme'])) {
			$mkportals->member['theme'] = $modSettings['theme_guests'];
		}

		// assign to forum admin access to MKportal CPA
		$mkportals->member['g_access_cp'] = "";
		if($user_info['is_admin']) {
			$mkportals->member['g_access_cp'] = 1;
		}
		if (array_key_exists('ID_GROUP',$user_settings)) {
			$mkportals->member['mgroup'] = $user_settings['ID_GROUP'];
			$mkportals->member['mgroup'] = $user_settings['ID_GROUP'];
		}
		if(!$ID_MEMBER) {
			$mkportals->member['mgroup'] = 99;
		}
		if($mkportals->member['mgroup'] == 0 && array_key_exists('ID_POST_GROUP',$user_settings)) {
			$mkportals->member['mgroup'] = $user_settings['ID_POST_GROUP'];
		}

		include($boarddir . 'Settings.php');
		$to_require = $MK_PATH."mkportal/include/mk_mySQL.php";
		require ($to_require);

		$DB = new db_driver;

		$DB->obj['dbname'] = $db_name;
		$DB->obj['dbuser'] = $db_user;
		$DB->obj['dbpasswd'] = $db_passwd;
		$DB->obj['dbhost'] = $db_server;
		$DB->connect();
		require_once $MK_PATH."mkportal/include/functions.php";
		require_once $MK_PATH."mkportal/include/smf_board_functions.php";
		@require_once "$mklib->template/tpl_main.php";
		if($MK_OFFLINE && !$mkportals->member['g_access_cp'] && !$mklib->member['g_access_cpa']) {
				$message = $mklib->lang['offline'];
				$mklib->off_line_page($message);
				exit;
		}
		$titlepage = "forum";
		if (array_key_exists('page_title', $context)) {
			$titlepage = $context['page_title'];
		}
		$mklib->printpage("$mklib->forumcs", "$mklib->forumcd", $titlepage, $contentspage);
		flush();
		$DB->close_db();

}


?>
