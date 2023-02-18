<?php



function mkportal_board_out($output) {
		global $pagestarttime, $query_count, $querytime, $DB_site, $bbuserinfo;
		global $vbphrase, $vboptions, $stylevar, $_REQUEST;
		global $mkportals, $DB, $Skin, $MK_PATH, $MK_TEMPLATE, $mklib, $mklib_board, $MK_TIMEDIFF;

		define ( 'IN_MKP', 1 );
		$MK_PATH = "../";
		require $MK_PATH."mkportal/conf_mk.php";
		$boarddir = $MK_PATH.$FORUM_PATH."/";
		$mkportals->base_url = $boarddir."index.php";
		$mkportals->forum_url = $MK_PATH.$FORUM_PATH;
		$mkportals->member['id'] = $bbuserinfo['userid'];
		$mkportals->member['name'] = $bbuserinfo['username'];
		$mkportals->member['last_visit'] = $bbuserinfo['lastvisit'];
		$mkportals->member['user_new_privmsg'] = $bbuserinfo['pmtotal']."/".$bbuserinfo['pmunread'];
		//$mkportals->member['show_popup'] = $bbuserinfo['pmpopup'];
		$mkportals->member['timezone'] = $bbuserinfo['timezoneoffset'];
		$mkportals->member['avatar'] = $user_info['avatar'];
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
		require ("$boarddir"."includes/config.php");

		$to_require = $MK_PATH."mkportal/include/mk_mySQL.php";
		require ($to_require);


		$DB = new db_driver;

		$DB->obj['dbname'] = $dbname;
		$DB->obj['dbuser'] = $dbusername;
		$DB->obj['dbpasswd'] = $dbpassword;
		$DB->obj['dbhost'] = $servername;
		$DB->connect();

		require_once $MK_PATH."mkportal/include/functions.php";
		require_once $MK_PATH."mkportal/include/vb_board_functions.php";
		require_once "$mklib->template/tpl_main.php";
		if($MK_OFFLINE && !$mkportals->member['g_access_cp'] && !$mklib->member['g_access_cpa']) {
				$message = $mklib->lang['offline'];
				$mklib->off_line_page($message);
				exit;
		}
		$output = preg_replace( "`(\<!-- logo -->(.*?\</table>))`is", "", $output);
		$output = str_replace ("<div style=\"padding:0px 25px 0px 25px\">", "<div style=\"width:100%\">", $output);
		$output = str_replace ("margin: 5px 10px 10px 10px;", "", $output);
		//$output = "<td valign=\"top\"".$output."</td>";
		$mklib->printpage("$mklib->forumcs", "$mklib->forumcd", "Forum", $output);

}


?>
