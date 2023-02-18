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

// In this class there are the functions board-dependents

if (!defined("IN_MKP")) {
    die ("Sorry !! You cannot access this file directly.");
}

class mklib_board {

//common functions

	function store_location($loc) {
		global $mkportals, $DB;
		switch($loc) {
							case 'portale':
    							$location= "-20";
    						break;
							case 'blog':
    							$location= "-21";
    						break;
							case 'gallery':
    							$location= "-22";
    						break;
							case 'urlobox':
    							$location= "-23";
    						break;
							case 'downloads':
    							$location= "-24";
    						break;
							case 'news':
    							$location= "-25";
    						break;
							case 'topsite':
    							$location= "-26";
    						break;
							case 'chat':
    							$location= "-27";
    						break;
							case 'reviews':
    							$location= "-28";
    						break;
							default:
							$location= "-20";
    						break;
						}
		$ipu = $mkportals->member['ip'];
		$DB->query("UPDATE  ".SESSIONS_TABLE." SET session_page ='$location'  where   session_ip = '$ipu'");
	}


	function get_active_users($loc) {

		global $DB, $mkportals, $mklib;

		$logged_visible_online = 0;
		$logged_hidden_online = 0;
		$guests_online = 0;

		switch($loc) {
							case 'portale':
    							$location= "-20";
    						break;
							case 'blog':
    							$location= "-21";
    						break;
							case 'gallery':
    							$location= "-22";
    						break;
							case 'urlobox':
    							$location= "-23";
    						break;
							case 'downloads':
    							$location= "-24";
    						break;
							case 'news':
    							$location= "-25";
    						break;
							case 'topsite':
    							$location= "-26";
    						break;
							case 'chat':
    							$location= "-27";
    						break;
							case 'reviews':
    							$location= "-28";
    						break;
							default:
							$location= "-20";
    						break;
						}
		$sql = "SELECT u.username, u.user_id, u.user_allow_viewonline, u.user_level, s.session_logged_in, s.session_ip
			FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
			WHERE u.user_id = s.session_user_id
			AND s.session_time >= ".( time() - 300 ) . "
			AND s.session_page = '$location'
			ORDER BY u.username ASC, s.session_ip ASC";
			$DB->query($sql);


			$prev_user_id = 0;
			$prev_user_ip = '';


			while ($row = $DB->fetch_row() )
			{
				if ( $row['session_logged_in'] )
				{
					if ( $row['user_id'] != $prev_user_id )
					{
						$style_color = '';
						if ( $row['user_level'] == ADMIN )
						{
							$row['username'] = '<b>' . $row['username'] . '</b>';
							$style_color = 'style="color:red"';
						}
						else if ( $row['user_level'] == MOD )
						{
							$row['username'] = '<b>' . $row['username'] . '</b>';
							$style_color = 'style="color:#' . $theme['fontcolor2'] . '"';
						}

						if ( $row['user_allow_viewonline'] )
						{
							$user_online_link = '<a href="' . append_sid("{$mkportals->forum_url}/profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'>' . $row['username'] . '</a>';
							$logged_visible_online++;
						}
						else
						{
							$user_online_link = '<a href="' . append_sid("{$mkportals->forum_url}/profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'><i>' . $row['username'] . '</i></a>';
							$logged_hidden_online++;
						}

						if ( $row['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )
						{
							$online_userlist .= ( $online_userlist != '' ) ? ', ' . $user_online_link : $user_online_link;
						}
					}

					$prev_user_id = $row['user_id'];
				}
				else
				{
					if ( $row['session_ip'] != $prev_session_ip )
					{
						$guests_online++;
					}
				}

				$prev_session_ip = $row['session_ip'];
			}


			$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;
			$utenti_in = "{$mklib->lang['b_tusers']} ";
			$utenti_in .= $total_online_users;
			$utenti_in .= " ($logged_visible_online {$mklib->lang['b_rusers']} $guests_online {$mklib->lang['b_guests']} {$mklib->lang['b_and']} $logged_hidden_online {$mklib->lang['b_anons']})<br />";
			$utenti_in .= "{$mklib->lang['b_vusers']}  $online_userlist";
			return $utenti_in;
	}

	function show_emoticons()
 	{
 		global $mkportals, $DB, $Skin, $mklib;
		$css = $this->import_css();
 		$output = "
 		<head>
		{$css}
		</head>
 		<script type=\"text/javascript\">
		<!--
		function add_smilie(code)
		{
		parent.document.editor.ta.value += ' ' + code + ' ';
		//return true;
		}
		//-->
		</script>

		<table class=\"tablemenu\" width=\"100%\">
		<tr>
		";

 		$DB->query("SELECT code, smile_url from ".SMILIES_TABLE."");
		$countr = 0;
		if ( $DB->get_num_rows() )
		{
			while ( $r = $DB->fetch_row() )
			{
				if (strstr( $r['code'], "&quot;" ) )
				{
					$in_delim  = "'";
					$out_delim = '"';
				}
				else
				{
					$in  = '"';
					$out = "'";
				}
				$code = stripslashes($r['code']);
				$image = stripslashes($r['smile_url']);
				if ($countr == 3) {
					$output .= "</tr><tr>";
					$countr = 0;
				}
				$output .= "
	  				<td width=\"50%\" align=\"center\" class=\"tdblock\" valign=\"middle\"><a href={$out}javascript:add_smilie({$in}$code{$in}){$out}><img src=\"{$mkportals->forum_url}/images/smiles/$image\" valign=\"middle\" border=\"0\" alt=\"$image\" /></a></td>
				";
				++$countr;
				if ($countr == 2) {
					$output .= "</tr><tr>";
					$countr = 0;
				}								
			}
			
		}
		$output .= "<td></td></tr></table>";
		print $output;
 	}

	function decode_smilies($message)
 	{
		global $mklib, $DB, $board_config;
		$DB->query("SELECT * from ".SMILIES_TABLE."");
		//$board_config['smilies_path'] = "$mklib->siteurl/$mklib->forumpath/".$board_config['smilies_path'];
		//require "$mklib->forumpath/includes/bbcode.php";
		//$message = smilies_pass($message);
		//$message = str_replace("images/smiles/", "$mklib->siteurl/$mklib->forumpath/images/smiles/", $message);
		while ( $r = $DB->fetch_row() )
		{
			$code = stripslashes($r['code']);
			$image = stripslashes($r['smile_url']);
			$impath = $board_config['smilies_path'];
			$image = "<img src=\"$mklib->siteurl/$mklib->forumpath/$impath/$image\" border=\"0\" alt=\"\" />";
			$message = str_replace($code, $image, $message);
		}

		return $message;
	}
	function popup_pm($m1, $m2, $m3, $m4)
 	{
		global $DB, $mklib, $mkportals;


		$u1 = "$mklib->siteurl/$mklib->forumpath/privmsg.php?folder=inbox";
		$last = time();
		$DB->query("UPDATE ".USERS_TABLE." SET user_lastvisit ='$last' WHERE user_id={$mkportals->member['id']}");
		$pmk_js = "<script type=\"text/javascript\">
     				<!--
       				window.open('$mklib->siteurl/mkportal/include/pmpopup.php?m1=$m1&m2=$m2&m3=$m3&m4=$m4&u1=$u1','NewPM','width=500,height=250,resizable=yes,scrollbars=yes');
     				//-->
     				</script>";


		return $pmk_js;
	}

// admin functions

	//ad_perms
	function build_grouplist($ind)
	{
		switch($ind) {
			case '2':
    			$select2 = "selected=\"selected\"";
    		break;
			case '3':
    			$select3 = "selected=\"selected\"";
    		break;
			default:
    			$select9 = "selected=\"selected\"";
    		break;
    		}
		$cselect.= "<option value=\"9\" $select9>Guests</option>\n";
		$cselect.= "<option value=\"2\" $select2>Moderators</option>\n";
		$cselect.= "<option value=\"3\" $select3>Members</option>\n";

		return $cselect;
	}

	//ad_perms
	function update_groupperms($g_id)
	{
		//in phpbb this function is empty

	}

	//ad_poll
	function get_poll_list()
	{
		global $mklib, $DB;

		$poll_active = $mklib->config['poll_active'];
		$DB->query("SELECT topic_id, vote_text FROM " . VOTE_DESC_TABLE . " order by topic_id DESC LIMIT 30");

		while( $poll = $DB->fetch_row() ) {
			$id = $poll['topic_id'];
			$title = $poll['vote_text'];
			$selected = "";
			if($id == $poll_active) {
				$selected = "selected=\"selected\"";
			}
			$cselect.= "<option value=\"$id\" $selected>$title</option>\n";
		}

		return $cselect;
	}

//blocks functions

	function forum_link($link)
	{
		global $mklib, $mkportals;
		switch($link) {
			case 'profile':
    			$out = $mkportals->forum_url."/profile.php?mode=viewprofile&amp;u";
    		break;
			case 'cpaforum':
    			$out = "{$mkportals->forum_url}/admin/index.php?sid={$mkportals->member['session_id']}";
    		break;
			case 'cpapers':
    			$out = "{$mkportals->forum_url}/profile.php?mode=editprofile";
    		break;
			case 'pm':
    			$out = "{$mkportals->forum_url}/privmsg.php?folder=inbox";
    		break;
			case 'forumsearch':
    			$out = "{$mkportals->forum_url}/search.php";
    		break;
			case 'logout':
    			$out = "{$mkportals->forum_url}/login.php?logout=true&amp;redirect=portalhome&amp;sid={$mkportals->member['session_id']}";
    		break;
			case 'postlink':
    			$out = "{$mkportals->forum_url}/login.php?login=true&amp;sid={$mkportals->member['session_id']}";
    		break;
			case 'register':
    			$out = "{$mkportals->forum_url}/profile.php?mode=register";
    		break;
			case 'onlinelist':
    			$out = "{$mkportals->forum_url}/viewonline.php";
    		break;
			case 'login_extra':
    			$out = "<tr>
                  <td width=\"100%\" colspan=\"2\" align=\"left\" class=\"tdglobal\"><b>{$mklib->lang['auto_login']}</b>
                  <input type=\"checkbox\" name=\"autologin\" /></td>
		  <td><input type=\"hidden\" name=\"redirect\" value=\"portalhome\" /></td>
		  </tr>";
    		break;
			case 'login_user':
    			$out = "username";
    		break;
			case 'login_passw':
    			$out = "password";
    		break;
			case 'calendar_event':
    			$out = "#";
    		break;
			default:
    			$out = "";
    		break;
    		}

		return $out;

	}

	function get_avatar()
 	{
		global $DB, $mkportals, $mklib;


		$query = $DB->query( "SELECT user_allowavatar, user_avatar, user_avatar_type FROM ".USERS_TABLE." where user_id = '{$mkportals->member['id']}'");
			$profiledata = $DB->fetch_row($query);


			$avatar_img = '';
			$img_av = $profiledata['user_avatar'];
			if ( $profiledata['user_avatar_type'] && $profiledata['user_allowavatar'] )
			{
				switch( $profiledata['user_avatar_type'] )
				{
					case 1:
						$dimension = @getimagesize($mklib->siteurl/$mklib->forumpath/images/avatars/$img_av);
						if ($dimension[0] > 80) {
							$dimension[1] = ceil(80 * $dimension[1] / $dimension[0]);
							$dimension[0] = 80;
						}
						if ($dimension[0]) {
							$avatar_img = "<img src=\"$mklib->siteurl/$mklib->forumpath/images/avatars/$img_av\" width=\"$dimension[0]\" height=\"$dimension[1]\" alt=\"\" />";
      					} else {
							$avatar_img = "<img src=\"$mklib->siteurl/$mklib->forumpath/images/avatars/$img_av\" alt=\"\" />";
						}
						break;
					case 2:
						$dimension = @getimagesize($img_av);
						if ($dimension[0] > 80) {
							$dimension[1] = ceil(80 * $dimension[1] / $dimension[0]);
							$dimension[0] = 80;
						}
						if ($dimension[0]) {
							$avatar_img = "<img src=\"$img_av\" width=\"$dimension[0]\" height=\"$dimension[1]\" alt=\"\" />";
						} else {
							$avatar_img = "<img src=\"$img_av\" alt=\"\" />";
						}
					break;
					case 3:
						$dimension = @getimagesize($mklib->siteurl/$mklib->forumpath/images/avatars/gallery/$img_av);
						if ($dimension[0] > 80) {
							$dimension[1] = ceil(80 * $dimension[1] / $dimension[0]);
							$dimension[0] = 80;
						}
						if ($dimension[0]) {
							$avatar_img = "<img src=\"$mklib->siteurl/$mklib->forumpath/images/avatars/gallery/$img_av\" width=\"$dimension[0]\" height=\"$dimension[1]\" alt=\"\" />";
                        } else {
                            $avatar_img = "<img src=\"$mklib->siteurl/$mklib->forumpath/images/avatars/gallery/$img_av\" alt=\"\" />";
                        }
					break;
				}
			}
			return $avatar_img;
	}

	function get_forumnav()
 	{
		global $mklib, $mkportals;
		require "$mklib->mklang/lang_global.php";

		$content = "
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_cerca.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/search.php?search_id=newposts\">{$langmk['m_newpost']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_members.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/memberlist.php\">{$langmk['m_users']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_calendario.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/groupcp.php\">{$langmk['groups']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_help.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/faq.php\">{$langmk['m_help']}</a></td></tr>
     	 	";
			return $content;


	}
	function get_site_stat()
 	{
		global $DB;

		$sql = "SELECT COUNT(user_id) AS total
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS;

		$DB->query($sql);
		$row = $DB->fetch_row();

		$stat['members'] = $row['total'];

		$sql = "SELECT user_id, username
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS . "
				ORDER BY user_id DESC
				LIMIT 1";
		$DB->query($sql);
		$row = $DB->fetch_row();

		$stat['last_member'] = $row['user_id'];
		$stat['last_member_name'] = $row['username'];

		$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
				FROM " . FORUMS_TABLE;
		$DB->query($sql);
		$row = $DB->fetch_row();

		$stat['topics'] = $row['topic_total'];
		$stat['total_posts'] = $row['post_total'];
		$stat['replies'] = $stat['total_posts'] - $stat['topics'];
		return $stat;


	}

	function get_onlineblock()
 	{
		global $DB, $mkportals;

		$logged_visible_online = 0;
		$logged_hidden_online = 0;
		$guests_online = 0;
		$online_userlist = '';


		$user_forum_sql = ( !empty($forum_id) ) ? "AND s.session_page = " . intval($forum_id) : '';
		$sql = "SELECT u.username, u.user_id, u.user_allow_viewonline, u.user_level, s.session_logged_in, s.session_ip
		FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
		WHERE u.user_id = s.session_user_id
			AND s.session_time >= ".( time() - 300 ) . "
			$user_forum_sql
		ORDER BY u.username ASC, s.session_ip ASC";
		$DB->query($sql);


		$prev_user_id = 0;
		$prev_user_ip = '';


	while ($row = $DB->fetch_row() )
	{

		if ( $row['session_logged_in'] )
		{
			// Skip multiple sessions for one user
			if ( $row['user_id'] != $prev_user_id )
			{
				$style_color = '';
				if ( $row['user_level'] == ADMIN )
				{
					$row['username'] = '<b>' . $row['username'] . '</b>';
					$style_color = 'style="color:red"';
				}
				else if ( $row['user_level'] == MOD )
				{
					$row['username'] = '<b>' . $row['username'] . '</b>';
					$style_color = 'style="color:orange"';
				}

				if ( $row['user_allow_viewonline'] )
				{
					$user_online_link = '<a href="' . append_sid("{$mkportals->forum_url}/profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'>' . $row['username'] . '</a>';
					$logged_visible_online++;
				}
				else
				{
					$user_online_link = '<a href="' . append_sid("{$mkportals->forum_url}/profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'><i>' . $row['username'] . '</i></a>';
					$logged_hidden_online++;
				}

				if ( $row['user_allow_viewonline'] || $mkportals->member['g_access_cp'] )
				{
					$online_userlist .= ( $online_userlist != '' ) ? ', ' . $user_online_link : $user_online_link;
				}
			}

			$prev_user_id = $row['user_id'];
		}
		else
		{

			if ( $row['session_ip'] != $prev_session_ip )
			{
				$guests_online++;
			}
		}

		$prev_session_ip = $row['session_ip'];
	}
		return array($logged_visible_online, $logged_hidden_online, $guests_online, $online_userlist);

	}


	function get_onlinehome($languest)
 	{

		global $DB, $mkportals;
		$content = "";
	$inter = ",";
	$total_online_users = 0;
	$logged_visible_online = 0;
	$logged_hidden_online = 0;
	$guests_online = 0;

	$sql = "SELECT u.username, u.user_id, u.user_allow_viewonline, u.user_level, s.session_logged_in, s.session_page, s.session_ip
		FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
		WHERE u.user_id = s.session_user_id
			AND s.session_time >= ".( time() - 300 ) . "
		ORDER BY u.username ASC, s.session_ip ASC";
		$DB->query($sql);


	$prev_user_id = 0;
	$prev_user_ip = '';

	while ($row = $DB->fetch_row() )
	{
		// User is logged in and therefor not a guest
		if ( $row['session_logged_in'] )
		{
			// Skip multiple sessions for one user
			if ( $row['user_id'] != $prev_user_id )
			{
				$style_color = '';
				if ( $row['user_level'] == ADMIN )
				{
					$row['username'] = '<b>' . $row['username'] . '</b>';
					$style_color = 'style="color:red"';

				}
				else if ( $row['user_level'] == MOD )
				{
					$row['username'] = '<b>' . $row['username'] . '</b>';
					$style_color = 'style="color:orange"';
				}

				if ( $row['user_allow_viewonline'] )
				{
					$user_online_link = '<a href="' . append_sid("{$mkportals->forum_url}/profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'>' . $row['username'] . '</a>';
					$logged_visible_online++;
				}
				else
				{
					$user_online_link = '<a href="' . append_sid("{$mkportals->forum_url}/profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'><i>' . $row['username'] . '</i></a>';
					$logged_hidden_online++;
				}

				if ( $row['user_allow_viewonline'] || $mkportals->member['g_access_cp'] )
				{
					switch($row['session_page']) {
							case '-20':
    							$online['portale'] .= "$user_online_link".", \n";
    						break;
							case '-21':
    							$online['blog'] .= "$user_online_link".", \n";
    						break;
							case '-22':
    							$online['gallery'] .= "$user_online_link".", \n";
    						break;
							case '-23':
    							$online['urlobox'] .= "$user_online_link".", \n";
    						break;
							case '-24':
    							$online['downloads'] .= "$user_online_link".", \n";
    						break;
							case '-25':
    							$online['news'] .= "$user_online_link".", \n";
    						break;
							case '-26':
    							$online['topsite'] .= "$user_online_link".", \n";
    						break;
							case '-27':
    							$online['chat'] .= "$user_online_link".", \n";
    						break;
							case '-28':
    							$online['reviews'] .= "$user_online_link".", \n";
    						break;
							default:
							$online['forum'] .= "$user_online_link".", \n";
    						break;
						}

				}
			}

			$prev_user_id = $row['user_id'];
		}
		else
		{
			// Skip multiple sessions for one user
			if ( $row['session_ip'] != $prev_session_ip )
			{
				$guests_online++;
				$user_online_link = "$languest, \n";
				switch($row['session_page']) {
							case '-20':
    							$online['portale'] .= "$user_online_link \n";
    						break;
							case '-21':
    							$online['blog'] .= "$user_online_link \n";
    						break;
							case '-22':
    							$online['gallery'] .= "$user_online_link \n";
    						break;
							case '-23':
    							$online['urlobox'] .= "$user_online_link \n";
    						break;
							case '-24':
    							$online['downloads'] .= "$user_online_link \n";
    						break;
							case '-25':
    							$online['news'] .= "$user_online_link \n";
    						break;
							case '-26':
    							$online['topsite'] .= "$user_online_link \n";
    						break;
							case '-27':
    							$online['chat'] .= "$user_online_link \n";
    						break;
							case '-28':
    							$online['reviews'] .= "$user_online_link \n";
    						break;
							default:
							$online['forum'] .= "$user_online_link \n";
    						break;
						}
			}
		}

		$prev_session_ip = $row['session_ip'];
	}

		$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;

        $online['portale'] = preg_replace( "/".preg_quote($inter)."$/", "", trim($online['portale']) );
		$online['blog'] = preg_replace( "/".preg_quote($inter)."$/", "", trim($online['blog']) );
		$online['gallery'] = preg_replace( "/".preg_quote($inter)."$/", "", trim($online['gallery']) );
		$online['urlobox'] = preg_replace( "/".preg_quote($inter)."$/", "", trim($online['urlobox']) );
		$online['downloads'] = preg_replace( "/".preg_quote($inter)."$/", "", trim($online['downloads']) );
		$online['news'] = preg_replace( "/".preg_quote($inter)."$/", "", trim($online['news']) );
		$online['chat'] = preg_replace( "/".preg_quote($inter)."$/", "", trim($online['chat']) );
		$online['topsite'] = preg_replace( "/".preg_quote($inter)."$/", "", trim($online['topsite']) );
		$online['reviews'] = preg_replace( "/".preg_quote($inter)."$/", "", trim($online['reviews']) );
		$online['forum'] = preg_replace( "/".preg_quote($inter)."$/", "", trim($online['forum']) );

		return array($logged_visible_online, $logged_hidden_online, $guests_online, $online['portale'], $online['blog'], $online['gallery'], $online['urlobox'], $online['downloads'], $online['news'], $online['chat'], $online['topsite'], $online['reviews'], $online['forum']);

	}

	function get_last_posts($by, $sdate)
 	{
		global $DB, $mklib, $mkportals;
		$limit = 5;
		$taglio = 17;


		$sql = "SELECT pt.post_text, pt.bbcode_uid, pt.post_subject, p.*, f.forum_id, f.forum_name, t.*, u.username, u.user_id, u.user_sig, u.user_sig_bbcode_uid
				FROM " . FORUMS_TABLE . " f, " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TEXT_TABLE . " pt
					WHERE pt.post_id = p.post_id
					AND f.forum_id = p.forum_id
					AND p.topic_id = t.topic_id
					AND p.poster_id = u.user_id
					ORDER BY p.post_time DESC LIMIT 0,$limit";
		$DB->query($sql);

		while ( $post = $DB->fetch_row() ) {
  		$post['post_subject'] = strip_tags($post['topic_title']);
		$post['post_subject'] = str_replace( "&#33;" , "!" , $post['post_subject'] );
		$post['post_subject'] = str_replace( "&quot;", "\"", $post['post_subject'] );
			if (strlen($post['post_subject']) > $taglio) {
				$post['post_subject'] = substr( $post['post_subject'],0,($taglio - 3) ) . "...";
				$post['post_subject'] = preg_replace( '/&(#(\d+;?)?)?(\.\.\.)?$/', '...',$post['post_subject'] );
			}

 		$post['date']  = $mklib->create_date($post['post_time']);
		$tid = $post['post_id'];
		$title = $post['post_subject'];
		$mid = $post['user_id'];
		$mname = $post['username'];
		$date = $post['date'];
		$content .= "
				<tr>
				  <td width=\"100%\" class=\"tdblock\">
				  <a class=\"uno\" href=\"$mkportals->forum_url/viewtopic.php?p=$tid#$tid\">$title</a>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\">
				  <a class=\"uno\" href=\"$mkportals->forum_url/profile.php?mode=viewprofile&amp;u=$mid\">$by: $mname</a><br /> $sdate: $date
				  </td>
				</tr>
		";
 		}
		return $content;


	}

	function get_poll_active($post_id)
 	{
		global $DB, $mklib, $mkportals;
		$DB->query("SELECT vote_id, topic_id, vote_text FROM " . VOTE_DESC_TABLE . " where topic_id = $post_id");
		$result = $DB->fetch_row();
		if ( ! $result['vote_id'] ) {
            return "";
        }
		$question = $result['vote_text'];
		$poll_id = $result['vote_id'];

		$out = "
				<tr>
				  <td class=\"tdblock\">
				  <a href=\"$mkportals->forum_url/viewtopic.php?t=$post_id\">$question</a>
				  </td>
				</tr>
            ";

		$DB->query("SELECT  vote_option_text, vote_result FROM " . VOTE_RESULTS_TABLE . " where vote_id = $poll_id");
		$ind = 0;
		$total_votes = 0;
		while ($poll = $DB->fetch_row() ) {
			//$out .= $poll['vote_option_text']." voti ".$poll['vote_result']."<br />";
			$choise[$ind]['text'] = $poll['vote_option_text'];
			$choise[$ind]['vote'] = $poll['vote_result'];
			$total_votes += $poll['vote_result'];
			++$ind;
		}
		foreach ($choise as $entry) {
			$percent = $entry['vote'] == 0 ? 0 : $entry['vote'] / $total_votes * 100;
            $percent = sprintf( '%.2f' , $percent );
            $width   = $percent > 0 ? floor( round( $percent ) * ( 122 / 100 ) ) : 0;
			$out .= "
				<tr>
				  <td class=\"tdblock3\">
				  {$entry['text']}
				  </td>
				</tr>
				<tr>
				  <td align=\"left\">
				  <img src=\"$mklib->images/bar-start.gif\" width=\"4\" height=\"11\" alt=\"\" /><img src=\"$mklib->images/bar.gif\" width=\"$width\" height=\"11\" alt=\"\" /><img src=\"$mklib->images/bar-end.gif\" width=\"4\" height=\"11\" alt=\"\" />
				  </td>
				</tr>

                ";
		}
		$out .= "
				<tr>
				  <td class=\"tdblock\">
				  <span class=\"mktxtcontr\">$total_votes</span> {$mklib->lang['poll_totalvotes']}
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\">
				  <a href=\"$mkportals->forum_url/viewtopic.php?t=$post_id\">{$mklib->lang['poll_go']}</a>
				  </td>
				</tr>
            ";
		return $out;
	}
	function get_forum_list()
	{
		global $mklib, $DB;

		$forum_active = $mklib->config['forum_active'];

		$DB->query("SELECT forum_id, forum_name FROM " . FORUMS_TABLE . "");

		while( $board = $DB->fetch_row() ) {
			$id = $board['forum_id'];
			$title = $board['forum_name'];
			$selected = "";
			if($id == $forum_active) {
				$selected = "selected=\"selected\"";
			}
			$cselect.= "<option value=\"$id\" $selected>$title</option>\n";
		}

		return $cselect;
	}

	function get_board_news()
 	{
		global $DB, $mklib, $mkportals, $db_prefix, $user_info, $modSettings;

		include("$mkportals->forum_url/includes/bbcode.php");
		$limit = $mklib->config['bnews_block'];
		//$taglio = 17;
		$db_prefix = DBPREFIX;
		$forum_active = $mklib->config['forum_active'];
		if(!$forum_active) {
				return "";
		}


		$sql = "SELECT pt.post_text, pt.bbcode_uid, pt.post_subject, p.*, f.forum_id, f.forum_name, t.*, u.username, u.user_id, u.user_sig, u.user_sig_bbcode_uid
				FROM " . FORUMS_TABLE . " f, " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TEXT_TABLE . " pt
					WHERE p.forum_id = $forum_active
					AND pt.post_id = p.post_id
					AND f.forum_id = p.forum_id
					AND p.topic_id = t.topic_id
					AND p.poster_id = u.user_id
					GROUP BY t.topic_id
					ORDER BY t.topic_id DESC LIMIT 0,$limit";
		$DB->query($sql);


		while ( $post = $DB->fetch_row() ) {
  		$title = strip_tags($post['topic_title']);
		$title = str_replace( "&#33;" , "!" ,$title );
		$title = str_replace( "&quot;", "\"", $title );

 		$date  = $mklib->create_date($post['topic_time']);
		$tid = $post['topic_id'];

		$mid = $post['user_id'];
		$mname = $post['username'];
		$message = $post['post_text'];
		$bbcode_uid = $post['bbcode_uid'];
		$message = bbencode_second_pass($message, $bbcode_uid);
		$message = preg_replace('/\:[0-9a-z\:]+\]/si', ']', $message);
		$message = smilies_pass($message);
		$message = str_replace("images/smiles/", "$mklib->siteurl/$mklib->forumpath/images/smiles/", $message);
		$fname = $post['forum_name'];
		$icona = "./mkportal/templates/default/images/icona_news.gif";
		$out .= "
				  <table class=\"tabnews\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\">
				    <tbody>
				    <tr>
				      <td class=\"tdblock\" align=\"center\" width=\"5%\">
				      <img hspace=\"0\" src=\"$icona\" align=\"bottom\" border=\"0\" alt=\"\" />
				      </td>
				      <td class=\"tdblock\" valign=\"top\" width=\"95%\">
				      <b>$fname<br /><a href=\"$mkportals->forum_url/viewtopic.php?t=$tid\">$title</a></b>
				      </td>
				    </tr>
				    <tr>
				      <td colspan=\"2\"><br />
				      $message
				      </td>
				    </tr>
				    <tr>
				      <td align=\"right\" colspan=\"2\">
				      <br /><i>{$mklib->lang['from']}<b> <a href=\"$mkportals->forum_url/profile.php?mode=viewprofile&amp;u=$mid\">$mname</a></b>, $date <a href=\"$mkportals->forum_url/viewtopic.php?t=$tid\"> [ {$mklib->lang['readall']} ]</a></i>
				      </td>
				    </tr>
				  </tbody>
				</table>
		";
 		}
		return $out;
	}
	function calendar_birth($chosen_month, $chosen_year)
 	{

		$birthdays = array();
		$tool_birthdays = array();

		return array($birthdays, $tool_birthdays);
	}

	function calendar_events($chosen_month, $chosen_year)
 	{
		
		$events = array();
		$tool_events = array();
		return array($events, $tool_events);
	}
	function skinselect()
 	{
		global $DB, $mklib, $mkportals, $sc;
		$templateslist .= "<form name=\"skinlist\" action=\"post\">\n <select name=\"selectskin\" class=\"bgselect\" onchange=\"document.location.href=skinlist.selectskin.options[this.selectedIndex].value\">\n";
		$DB->query("SELECT themes_id, template_name FROM " . THEMES_TABLE . "");
		while ( $r = $DB->fetch_row() )
		{
			$selected = "";
			if ($mkportals->member['theme'] == $r['themes_id']) {
				$selected = "selected=\"selected\"";
			}
			if (strlen($r['template_name']) > 14 ) {
				$r['template_name'] = substr($r['template_name'], 0, 14);
			}
			$templateslist .= "\n<option value=\"$mklib->siteurl/index.php?skinid={$r['themes_id']}\" $selected >{$r['template_name']}</option>";

		}

		$templateslist .= "\n</select>\n</form>";
    	$templateslist = "
				<tr>
				  <td class=\"tdblock\" align=\"center\" valign=\"middle\">$templateslist</td>
				</tr>
                ";
		return $templateslist;


		//return "<tr><td>Sorry but this function is not yet available for PhpBB</td></tr>";
	}
	function update_skin($skinid)
 	{
		global $mkportals, $DB, $mklib;
		if (!$mkportals->member['id']) {
			return;
		}
		$DB->query("SELECT template_name FROM " . THEMES_TABLE . " where themes_id = '$skinid'");
		//$DB->query("SELECT  set_skin_set_id from ibf_skin_sets where set_skin_set_id = '$skinid'");
		if ($DB->fetch_row()){
			$DB->query("UPDATE ".USERS_TABLE." SET user_style ='$skinid' where user_id = '{$mkportals->member['id']}'");
			$DB->close_db();
	 		Header("Location: $mkportals->forum_url/index.php");
			exit;
		}

	}

	function import_css()
	{
		global $mkportals, $DB, $mklib;

		$DB->query("SELECT template_name, head_stylesheet FROM " . THEMES_TABLE . " where themes_id = '{$mkportals->member['theme']}'");
		$r = $DB->fetch_row();
		$css2 = $mkportals->forum_url."/templates/".$r['template_name']."/".$r['head_stylesheet'];
		$images_url = $mkportals->forum_url."/templates/".$r['template_name']."/images";
		unset ($r);

		$fh = @fopen($css2, "r");
    	if ($fh) {
        	$css2 = fread($fh, filesize($css2));
        	@fclose($fh);
		}

		$css = "$mklib->template/style.css";
		$fh = @fopen($css, "r");
    	if ($fh) {
        	$css = fread($fh, filesize($css));
        	@fclose($fh);
		}

		//importing body
		$pos = strpos($css2, "body");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$mkpsubs = "body {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif;}".$mkpsubs;
				$css = preg_replace( "`(\.importbody(.*?\}))`is", $mkpsubs, $css);
			}

		//importing main table bg (if different than body bg)
		$pos = strpos($css2, ".bodyline");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importmain(.*?\}))`is", $mkpsubs, $css);
			}

		//importing logostrip
		$sflogo =  $images_url."/sf_logo.jpg";
		if (is_file("$sflogo") ) {
			$mkpsubs = "#logostrip {background-image: url($sflogo); text-align: left;}";
		} else {
			$pos = strpos($css2, ".bodyline");
			$pos2 = strpos($css2, "}", $pos);
			$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
		}
		$css = preg_replace( "`(\#importlogostrip(.*?\}))`is", $mkpsubs, $css);

		//importing light background
		$pos = strpos($css2, "td.row1");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importlightback(.*?\}))`is", $mkpsubs, $css);
			}

		//importing medium background
		$pos = strpos($css2, "td.row3");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importmediumback(.*?\}))`is", $mkpsubs, $css);
			}

		//importing dark background
		$pos = strpos($css2, "th	{");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importdarkback(.*?\}))`is", $mkpsubs, $css);
			}

		//importing module table headers
		$pos = strpos($css2, "td.catHead");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$mkpsubs = preg_replace( "/border(.*?\;)/mi", "border: 0px;", $mkpsubs);
				$css = preg_replace( "`(\.importmodulex(.*?\}))`is", $mkpsubs, $css);
			}

		//importing borders
		$pos = strpos($css2, ".bodyline");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$mkpsubs = preg_replace( "/back(.*?\;)/mi", "", $mkpsubs);
				$css = preg_replace( "`(\.importborders(.*?\}))`is", $mkpsubs, $css);
			}

		//importing form styles
		$pos = strpos($css2, "input,textarea, select");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importforms(.*?\}))`is", $mkpsubs, $css);
			}
/*
		// Not Good !!importing table font formatting
		$pos = strpos($css2, ".gen");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importfont(.*?\}))`is", $mkpsubs, $css);
			}
*/
		//importing hyperlink a:link style
		$pos = strpos($css2, "a:link");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importlink(.*?\}))`is", $mkpsubs, $css);
			}

		//importing hyperlink a:visited style
		$pos = strpos($css2, "a:visited");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importvisited(.*?\}))`is", $mkpsubs, $css);
			}

		//importing hyperlink a:hover style
		$pos = strpos($css2, "a:hover");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importhover(.*?\}))`is", $mkpsubs, $css);
			}

		//adjust images path
		$css = str_replace("url(images", "url($images_url", $css);
		$css = str_replace ("MKPORTALIMGDIR", "$mklib->images", $css);
		$css = "<style type=\"text/css\">\n$css\n</style>\n";
		unset($css2);
		return $css;
	}

	function admin_mail($subject, $message)
 	{
		global $DB, $mklib;

		$headers = "From: webmaster@" . $mklib->sitename . "\r\n" . "Reply-To: webmaster@" . $mklib->sitename . "\r\n" . "X-Mailer: MKportal Mail";

		$dest = "";
		$DB->query("SELECT user_email from ".USERS_TABLE." WHERE user_level = '1'");
		while ( $row = $DB->fetch_row() ) {
			$dest .= $row['user_email'].", ";
		}
		$dest=rtrim($dest, ", ");
		mail($dest, $subject, $message,  $headers);
	}


}

$mklib_board = new mklib_board;

?>
