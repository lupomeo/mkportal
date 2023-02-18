<?php



function mkportal_board_out() {
		global $DB, $mkportals, $Skin, $MK_PATH, $MK_TEMPLATE, $mklib, $mklib_board, $MK_TIMEDIFF;
		global $huser, $timeoffset, $tablepre;
		define ( 'IN_MKP', 1 );
		$MK_PATH = "../";
		require $MK_PATH."mkportal/conf_mk.php";
		$contentspage = ob_get_contents();
		ob_end_clean();
		$boarddir = $MK_PATH.$FORUM_PATH."/";
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

		require_once $MK_PATH."mkportal/include/functions.php";
		require_once $MK_PATH."mkportal/include/oxy_board_functions.php";
		require_once "$mklib->template/tpl_main.php";
		if($MK_OFFLINE && !$mkportals->member['g_access_cp'] && !$mklib->member['g_access_cpa']) {
				$message = $mklib->lang['offline'];
				$mklib->off_line_page($message);
				exit;
		}
		//$contentspage = "<td valign=\"top\"".$contentspage."</td>";
		$mklib->printpage("$mklib->forumcs", "$mklib->forumcd", "forum", $contentspage);

}


?>
