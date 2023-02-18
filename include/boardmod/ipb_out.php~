<?php

function mkportal_board_out($output) {

			global $ibforums, $DB, $std, $mkportals, $Skin, $MK_PATH, $MK_TEMPLATE, $mklib, $mklib_board, $MK_TIMEDIFF;
			define ( 'IN_MKP', 1 );
			$MK_PATH = "../";
			require $MK_PATH."mkportal/conf_mk.php";
			$boarddir = $MK_PATH.$FORUM_PATH."/";
			$mkportals->member = $ibforums->member;
			$mkportals->input = $ibforums->input;
			$mkportals->base_url = $boarddir."index.php";
			$mkportals->forum_url = $MK_PATH.$FORUM_PATH;
			$mkportals->member['user_new_privmsg'] = $mkportals->member['msg_total']."/".$mkportals->member['new_msg'];
			if($ibforums->member['mgroup'] == 4) {
				$mkportals->member['g_access_cp'] = 1;
			}
			$mkportals->member['theme'] = $mkportals->member['skin'];
			$mkportals->member['timezone'] = ($std->get_time_offset() /3600);
			if (substr($ibforums->skin['_setname'], 0, 9) == "mkportal2") {
				$MK_TEMPLATE = "default";
			}
			require $MK_PATH."mkportal/include/functions.php";
			require_once $MK_PATH."mkportal/include/ipb_board_functions.php";
			require_once "$mklib->template/tpl_main.php";
			if($MK_OFFLINE && !$mkportals->member['g_access_cp'] && !$mklib->member['g_access_cpa']) {
				$message = $mklib->lang['offline'];
				$mklib->off_line_page($message);
				exit;
			}
			$mkpsubs = "#ipbwrapper{
				margin: 0px auto 0px auto;
				text-align: left;
			}";
			$output = preg_replace( "`(\#ipbwrapper(.*?\}))`is", $mkpsubs,$output);

			$mkpsubs = "img{ 
				border: 0;
			}";
			$output = preg_replace( "`(\img{(.*?\}))`is", $mkpsubs,$output);

			$mkpsubs = ".divpad{
				padding: 0px;
			}";
			$output = preg_replace( "`(\.divpad(.*?\}))`is", $mkpsubs,$output);
			$output = str_replace("background: transparent;", " ", $output);
			//$output = "<td valign=\"top\"  align=\"left\">".$output."</td>";
			//$output = "<td width=\"100%\" valign=\"top\" align=\"center\">".$output."</td>";

			if ($ibforums->vars['disable_gzip'] != 1 ) {
        		@ob_start('ob_gzhandler');
        	}

			$mklib->printpage("$mklib->forumcs", "$mklib->forumcd", $ibforums->vars['board_name'], $output);
			if ( ! USE_SHUTDOWN ) {
        		$std->my_deconstructor();
        		$DB->close_db();
        	}
}


?>
