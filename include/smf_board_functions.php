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
		$prefix = DBPREFIX;
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
		$idu = $mkportals->member['id'];
		$DB->query("UPDATE  {$prefix}log_online SET  url ='$location'  where   ID_MEMBER = '$idu'");
	}


	function get_active_users($loc) {

		global $DB, $mkportals, $mklib;

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

	$prefix = DBPREFIX;
	$context['users_online'] = array();
	$context['list_users_online'] = array();
	$context['online_groups'] = array();
	$context['num_guests'] = 0;
	$context['num_users_hidden'] = 0;

		$sql = "SELECT lo.ID_MEMBER, lo.logTime, lo.url, mem.realName, mem.memberName, mem.showOnline, mg.onlineColor, mg.ID_GROUP, mg.groupName
		FROM {$prefix}log_online AS lo
			LEFT JOIN {$prefix}members AS mem ON (mem.ID_MEMBER = lo.ID_MEMBER)
			LEFT JOIN {$prefix}membergroups AS mg ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))
			WHERE lo.url = '$location'";

	$DB->query($sql);

	while ($row = $DB->fetch_row() )
	{
		if (!isset($row['realName']))
		{
			$context['num_guests']++;
			continue;
		}
		elseif (!empty($row['showOnline']) || allowedTo('moderate_forum'))
		{

			if (!empty($row['onlineColor']))
				$link = '<a href="' . $mkportals->forum_url . '/index.php?action=profile;u=' . $row['ID_MEMBER'] . '" style="color: ' . $row['onlineColor'] . ';">' . $row['realName'] . '</a>';
			else
				$link = '<a href="' . $mkportals->forum_url . '/index.php?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a>';

			$context['users_online'][$row['logTime'] . $row['memberName']] = array(
				'id' => $row['ID_MEMBER'],
				'username' => $row['memberName'],
				'name' => $row['realName'],
				'group' => $row['ID_GROUP'],
				'href' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],
				'link' => $link,
				'hidden' => empty($row['showOnline']),
			);

			$context['list_users_online'][$row['logTime'] . $row['memberName']] = empty($row['showOnline']) ? '<i>' . $link . '</i>' : $link;

		}
		else
			$context['num_users_hidden']++;
	}

	krsort($context['users_online']);
	krsort($context['list_users_online']);
	ksort($context['online_groups']);
	$context['users_online'] = count($context['users_online']);

	$listusers = implode(', ', $context['list_users_online']);


			$total_online_users = $context['users_online'] + $context['num_users_hidden'] + $context['num_guests'];
			$utenti_in = "{$mklib->lang['b_tusers']} ";
			$utenti_in .= $total_online_users;
			$utenti_in .= " ({$context['users_online']} {$mklib->lang['b_rusers']} {$context['num_guests']} {$mklib->lang['b_guests']} {$mklib->lang['b_and']} {$context['num_users_hidden']} {$mklib->lang['b_anons']})<br />";
			$utenti_in .= "{$mklib->lang['b_vusers']}  $listusers";
			return $utenti_in;
	}

	function show_emoticons()
 	{
 		global $mkportals, $DB, $std, $Skin, $mklib, $user_info, $modSettings;
		$css = $this->import_css();

		$smileset = $mkportals->member['smiley_set'] = (!in_array($user_info['smiley_set'], explode(',', $modSettings['smiley_sets_known'])) && $user_info['smiley_set'] != 'none') || empty($modSettings['smiley_sets_enable']) ? (!empty($settings['smiley_sets_default']) ? $settings['smiley_sets_default'] : $modSettings['smiley_sets_default']) : $user_info['smiley_set'];

		if (!$smileset) {
			$smileset = "default";
		}

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

 		$DB->query("SELECT code, filename from ".DBPREFIX.smileys."");
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
				$image = stripslashes($r['filename']);
				if ($countr == 3) {
					$output .= "</tr><tr>";
					$countr = 0;
				}
				$output .= "
	  				<td width=\"50%\" align=\"center\" class=\"tdblock\" valign=\"middle\"><a href={$out}javascript:add_smilie({$in}$code{$in}){$out}><img src=\"{$mkportals->forum_url}/Smileys/$smileset/$image\" border=\"0\" valign=\"middle\" alt=\"$image\" /></a></td>
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
		global $mklib, $user_info, $modSettings;

		$user_info['smiley_set'] = $mkportals->member['smiley_set'] = (!in_array($user_info['smiley_set'], explode(',', $modSettings['smiley_sets_known'])) && $user_info['smiley_set'] != 'none') || empty($modSettings['smiley_sets_enable']) ? (!empty($settings['smiley_sets_default']) ? $settings['smiley_sets_default'] : $modSettings['smiley_sets_default']) : $user_info['smiley_set'];
		if (!$user_info['smiley_set']) {
			$user_info['smiley_set'] = "default";
		}

		//$user_info['smiley_set'] = "default";
		//$message = doUBBC($message);
		parsesmileys($message);
		//$message = str_replace("images/smiles/", "$mklib->siteurl/$mklib->forumpath/images/smiles/", $message);

		return $message;
	}
	function popup_pm($m1, $m2, $m3, $m4)
 	{
		global $DB, $mklib, $mkportals;


		$u1 = "$mklib->siteurl/$mklib->forumpath/index.php?action=pm";

		//$DB->query("UPDATE ".DBPREFIX."members SET unreadMessages='0' WHERE ID_MEMBER='{$mkportals->member['id']}'");


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
		global $DB;

		$prefix = DBPREFIX;
		$DB->query( "SELECT ID_GROUP, groupName FROM {$prefix}membergroups ORDER BY `ID_GROUP`");
		while( $row = $DB->fetch_row() ) {
			if($row['ID_GROUP'] == 1) {
				continue;
			}
			$g_id= $row['ID_GROUP'];
			$g_title = $row['groupName'];
			$selected = "";
			if($g_id == $ind) {
				$selected = "selected=\"selected\"";
			}
			$cselect.= "<option value=\"$g_id\" $selected>$g_title</option>\n";
		}
		//aggiunge i guest
		if($ind == "99") {
				$selected = "selected=\"selected\"";
			}
		$cselect.= "<option value=\"99\" $selected>Guests</option>\n";
		return $cselect;
	}

	//ad_perms
	function update_groupperms($g_id)
	{
		global $DB;

		$prefix = DBPREFIX;
		$query = $DB->query( "SELECT groupName FROM {$prefix}membergroups WHERE ID_GROUP = '$g_id'");
		$row = $DB->fetch_row($query);
		return $row['g_title'];

	}

	//ad_poll
	function get_poll_list()
	{
		global $mklib, $DB;

		$prefix = DBPREFIX;
		$poll_active = $mklib->config['poll_active'];
		$DB->query("SELECT ID_POLL, question FROM {$prefix}polls order by ID_POLL DESC LIMIT 30");

		while( $poll = $DB->fetch_row() ) {
			$id = $poll['ID_POLL'];
			$title = $poll['question'];
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
    			$out = "{$mkportals->forum_url}/index.php?action=profile;u";
    		break;
			case 'cpaforum':
    			$out = "{$mkportals->forum_url}/index.php?action=admin";
    		break;
			case 'cpapers':
    			$out = "{$mkportals->forum_url}/index.php?action=profile";
    		break;
			case 'pm':
    			$out = "{$mkportals->forum_url}/index.php?action=pm";
    		break;
			case 'forumsearch':
    			$out = "{$mkportals->forum_url}/index.php?action=search";
    		break;
			case 'logout':
    			$out = "{$mkportals->forum_url}/index.php?action=logout;sesc={$mkportals->member['session_id']}";
    		break;
			case 'postlink':
    			$out = "{$mkportals->forum_url}/index.php?action=login2";
    		break;
			case 'register':
    			$out = "{$mkportals->forum_url}/index.php?action=register";
    		break;
			case 'onlinelist':
    			$out = "{$mkportals->forum_url}/index.php?action=who";
    		break;
			case 'login_extra':
    			$out = "<tr>
                  <td width=\"100%\" colspan=\"2\" align=\"left\" class=\"tdblock\"><b>{$mklib->lang['auto_login']}</b>
                  <input type=\"checkbox\" name=\"cookieneverexp\" id=\"cookieneverexp\" checked=\"checked\" /></td>
                </tr>";
				$_SESSION['login_url'] = $mklib->siteurl;
				$_SESSION['logout_url'] = $mklib->siteurl;
    		break;
			case 'login_user':
    			$out = "user";
    		break;
			case 'login_passw':
    			$out = "passwrd";
    		break;
			case 'calendar_event':
    			$out = "$mkportals->forum_url/index.php?action=calendar";
    		break;
			default:
    			$out = "";
    		break;
    		}

		return $out;

	}

	function get_avatar()
 	{
		global $mkportals, $DB;

		$prefix = DBPREFIX;;

			if (substr($mkportals->member['avatar']['url'], 0, 7) == 'http://')
			{
				$dimension = url_image_size($mkportals->member['avatar']['url']);
				if ($dimension[0] > 80) {
					$dimension[1] = ceil(80 * $dimension[1] / $dimension[0]);
					$dimension[0] = 80;
				}
				$avatar_img = "<img src=\"{$mkportals->member['avatar']['url']}\" width=\"$dimension[0]\" height=\"$dimension[1]\" alt=\"\" border=\"\" />";

			} else {

				$avatar_img = "<img src=\"{$mkportals->forum_url}/avatars/{$mkportals->member['avatar']['url']}\" alt=\"\" border=\"\" />";
			}

			if (!$mkportals->member['avatar']['url'])
			{
				$avatar_img = "";
			}
			if ($mkportals->member['avatar']['ID_ATTACH']) {
				$idattach = $mkportals->member['avatar']['ID_ATTACH'];
				$query = $DB->query( "SELECT filename FROM {$prefix}attachments WHERE ID_ATTACH = '$idattach'");
				$row = $DB->fetch_row($query);
				$avatar_img = "<img src=\"{$mkportals->forum_url}/attachments/{$row['filename']}\" alt=\"\" border=\"\" />";
			}
			return $avatar_img;
			exit;
	}

	function get_forumnav()
 	{
		global $mklib, $mkportals;
		require "$mklib->mklang/lang_global.php";

		$content = "
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_cerca.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/index.php?action=unread\">{$langmk['m_newpost']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_cerca.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/index.php?action=unreadreplies\">{$langmk['new_replies']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_members.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/index.php?action=mlist\">{$langmk['m_users']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_help.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/Themes/default/help/index.english.html\">{$langmk['m_help']}</a></td></tr>
     	 	";
			return $content;


	}
	function get_site_stat()
 	{
		global $DB;
		$prefix = DBPREFIX;

		$sql = "SELECT COUNT(ID_MEMBER) AS total
				FROM {$prefix}members";

		$DB->query($sql);
		$row = $DB->fetch_row();

		$stat['members'] = $row['total'];

		$sql = "SELECT ID_MEMBER, memberName
				FROM {$prefix}members
				ORDER BY ID_MEMBER DESC
				LIMIT 1";
		$DB->query($sql);
		$row = $DB->fetch_row();

		$stat['last_member'] = $row['ID_MEMBER'];
		$stat['last_member_name'] = $row['memberName'];

		$sql = "SELECT COUNT(ID_TOPIC) AS total
				FROM {$prefix}topics";
		$DB->query($sql);
		$row = $DB->fetch_row();
		$stat['topics'] = $row['total'];

		$sql = "SELECT COUNT(ID_MSG) AS total
				FROM {$prefix}messages";
		$DB->query($sql);
		$row = $DB->fetch_row();
		$stat['total_posts'] = $row['total'];


		$stat['replies'] = $stat['total_posts'] - $stat['topics'];
		return $stat;


	}

	function get_onlineblock()
 	{
		global $DB, $mkportals;



	$prefix = DBPREFIX;
	$context['users_online'] = array();
	$context['list_users_online'] = array();
	$context['online_groups'] = array();
	$context['num_guests'] = 0;
	$context['num_users_hidden'] = 0;
	$logged_visible_online = 0;

		$sql = "SELECT lo.ID_MEMBER, lo.logTime, mem.realName, mem.memberName, mem.showOnline, mg.onlineColor, mg.ID_GROUP, mg.groupName
		FROM {$prefix}log_online AS lo
			LEFT JOIN {$prefix}members AS mem ON (mem.ID_MEMBER = lo.ID_MEMBER)
			LEFT JOIN {$prefix}membergroups AS mg ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))";

	$DB->query($sql);

	while ($row = $DB->fetch_row() )
	{
		if (!isset($row['realName']))
		{
			$context['num_guests']++;
			continue;
		}
		elseif (!empty($row['showOnline']) || allowedTo('moderate_forum'))
		{
			if (!empty($row['showOnline'])) {
				$logged_visible_online++;
			} else {
				$context['num_users_hidden']++;
			}
			if (!empty($row['onlineColor']))
				$link = '<a href="' . $mkportals->forum_url . '/index.php?action=profile;u=' . $row['ID_MEMBER'] . '" style="color: ' . $row['onlineColor'] . ';">' . $row['realName'] . '</a>';
			else
				$link = '<a href="' . $mkportals->forum_url . '/index.php?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a>';

			$context['users_online'][$row['logTime'] . $row['memberName']] = array(
				'id' => $row['ID_MEMBER'],
				'username' => $row['memberName'],
				'name' => $row['realName'],
				'group' => $row['ID_GROUP'],
				'href' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],
				'link' => $link,
				'hidden' => empty($row['showOnline']),
			);

			$context['list_users_online'][$row['logTime'] . $row['memberName']] = empty($row['showOnline']) ? '<i>' . $link . '</i>' : $link;


		}
		else
			$context['num_users_hidden']++;
	}

	krsort($context['users_online']);
	krsort($context['list_users_online']);
	ksort($context['online_groups']);

	$listusers = implode(', ', $context['list_users_online']);

		return array($logged_visible_online, $context['num_users_hidden'], $context['num_guests'], $listusers);


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

	$prefix = DBPREFIX;
	$context['users_online'] = array();
	$context['list_users_online'] = array();

	$context['num_users_hidden'] = 0;

		$sql = "SELECT lo.ID_MEMBER, lo.logTime, lo.url, mem.realName, mem.memberName, mem.showOnline, mg.onlineColor, mg.ID_GROUP, mg.groupName
		FROM {$prefix}log_online AS lo
			LEFT JOIN {$prefix}members AS mem ON (mem.ID_MEMBER = lo.ID_MEMBER)
			LEFT JOIN {$prefix}membergroups AS mg ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))";

	$DB->query($sql);
	while ($row = $DB->fetch_row() )
	{
		if (!isset($row['realName']))
		{
			$guests_online++;
			$user_online_link = "$languest, \n";
				switch($row['url']) {
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
			continue;
		}
		elseif (!empty($row['showOnline']) || allowedTo('moderate_forum'))
		{

			if (!empty($row['showOnline'])) {
				$logged_visible_online++;
			} else {
				$logged_hidden_online++;
			}
			if (!empty($row['onlineColor']))
				$link = '<b><a href="' . $mkportals->forum_url . '/index.php?action=profile;u=' . $row['ID_MEMBER'] . '" style="color: ' . $row['onlineColor'] . ';">' . $row['realName'] . '</a></b>';
			else
				$link = '<a href="' .$mkportals->forum_url . '/index.php?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a>';

			$context['users_online'][$row['logTime'] . $row['memberName']] = array(
				'id' => $row['ID_MEMBER'],
				'username' => $row['memberName'],
				'name' => $row['realName'],
				'group' => $row['ID_GROUP'],
				'href' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],
				'link' => $link,
				'hidden' => empty($row['showOnline']),
			);

			$user_online_link = empty($row['showOnline']) ? '<i>' . $link . '</i>' : $link;
			switch($row['url']) {
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
		else
			$logged_hidden_online++;
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
		global $DB, $mklib, $mkportals, $db_prefix, $user_info, $modSettings;
		$limit = 5;
		$taglio = 17;
		$db_prefix = DBPREFIX;

		$sql = "SELECT
			m.posterTime, m.subject, m.ID_TOPIC, m.ID_MEMBER, m.ID_MSG,
			IFNULL(mem.realName, m.posterName) AS posterName, t.ID_BOARD, b.name AS bName,
			m.body, m.smileysEnabled
		FROM {$db_prefix}messages AS m, {$db_prefix}topics AS t, {$db_prefix}boards AS b
			LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = m.ID_MEMBER)
			WHERE t.ID_TOPIC = m.ID_TOPIC
			AND b.ID_BOARD = t.ID_BOARD" . (!empty($modSettings['recycle_enable']) && $modSettings['recycle_board'] > 0 ? "
			AND b.ID_BOARD != $modSettings[recycle_board]" : '') . "
			AND $user_info[query_see_board]
		ORDER BY m.ID_MSG DESC
		LIMIT $limit";

		$DB->query($sql);

		while ( $post = $DB->fetch_row() ) {
  		$title = strip_tags($post['subject']);
		$title = str_replace( "&#33;" , "!" ,$title );
		$title = str_replace( "&quot;", "\"", $title );
			if (strlen($title) > $taglio) {
				$title = substr( $title,0,($taglio - 3) ) . "...";
				$title = preg_replace( '/&(#(\d+;?)?)?(\.\.\.)?$/', '...',$title );
			}

 		$date  = $mklib->create_date($post['posterTime']);
		$tid = $post['ID_TOPIC'];

		$mid = $post['ID_MEMBER'];
		$mname = $post['posterName'];

		$content .= "
				<tr>
				  <td width=\"100%\" class=\"tdblock\">
				  <a class=\"uno\" href=\"$mkportals->forum_url/index.php?topic=$tid\">$title</a>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\">
				  <a class=\"uno\" href=\"$mkportals->forum_url/index.php?action=profile;u=$mid\">$by: $mname</a><br /> $sdate: $date
				  </td>
				</tr>
		";
 		}

		return $content;


	}

	function get_poll_active($post_id)
 	{
		global $DB, $mklib, $mkportals, $sc;

		$prefix = DBPREFIX;


		$sql = "SELECT ID_MEMBER
		FROM {$prefix}log_polls
		WHERE ID_POLL = $post_id
		AND ID_MEMBER = {$mkportals->member['id']}
		LIMIT 1
		";
		$DB->query($sql);
		$allow_vote = $DB->get_num_rows($request) == 0;


		$sql = "SELECT p.ID_POLL, p.question, m.ID_TOPIC, m.ID_POLL
		FROM {$prefix}polls AS p
		LEFT JOIN {$prefix}topics AS m ON (m.ID_POLL = p.ID_POLL)
		where p.ID_POLL = $post_id";

		$DB->query($sql);
		$result = $DB->fetch_row();
		if ( ! $result['ID_POLL'] ) {
            return "";
        }
		$question = $result['question'];
		$poll_id = $result['ID_POLL'];
		$topic_id = $result['ID_TOPIC'];

		$out = "
				<tr>
				  <td class=\"tdblock\">
				  <a href=\"$mkportals->forum_url/index.php?topic=$topic_id\">$question</a>
				  </td>
				</tr>
            ";

		$DB->query("SELECT ID_CHOICE, label, votes FROM {$prefix}poll_choices where ID_POLL = $poll_id");
		$ind = 0;
		$total_votes = 0;
		while ($poll = $DB->fetch_row() ) {
			$idch = $poll['ID_CHOICE'];
			$choise[$ind]['text'] = $poll['label'];
			$choise[$ind]['vote'] = $poll['votes'];
			$choise[$ind]['id'] = $poll['ID_CHOICE'];
			$total_votes += $poll['votes'];
			++$ind;
		}
		if ($allow_vote && $mkportals->member['id']) {
			$out .= "
				<tr>
				  <td class=\"tdblock\">
				    <form action=\"$mkportals->forum_url/index.php?action=vote;topic=$topic_id;poll=$poll_id\" method=\"post\" style=\"margin: 0px;\">
			";
		}
		foreach ($choise as $entry) {
			$percent = $entry['vote'] == 0 ? 0 : $entry['vote'] / $total_votes * 100;
            $percent = sprintf( '%.2f' , $percent );
            $width   = $percent > 0 ? floor( round( $percent ) * ( 122 / 100 ) ) : 0;
			if ($allow_vote && $mkportals->member['id']) {
				$out .= "
                    
				    <div style=\"margin-top: 5px;\"><input type=\"radio\" name=\"options[]\" value=\"{$entry['id']}\" class=\"bgselect\" />&nbsp;<strong>{$entry['text']}</strong></div>
                    
                ";
			} else {
				$out .= "
				<tr>
				  <td class=\"tdblock\">
				  {$entry['text']}
				  </td>
				</tr>
				<tr>
				  <td align=\"left\">
				  <img src=\"$mklib->images/bar-start.gif\" border=\"0\" width=\"4\" height=\"11\" alt=\"\" /><img src=\"$mklib->images/bar.gif\" border=\"0\" width=\"$width\" height=\"11\" alt=\"\" /><img src=\"$mklib->images/bar-end.gif\" border=\"0\" width=\"4\" height=\"11\" alt=\"\" />
				  </td>
				</tr>
                ";
			}
		}

		if ($allow_vote && $mkportals->member['id']) {

			$out .= "
				
				      <input type=\"hidden\" name=\"sc\" value=\"$sc\" />
				      <input type=\"submit\" value=\"{$mklib->lang['poll_vote']}\" class=\"bgselect\" style=\"margin-top: 10px;\" />
				    </form>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdblock\">
				  <span class=\"mktxtcontr\">$total_votes</span> {$mklib->lang['poll_totalvotes']}
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\">
				    <a href=\"$mkportals->forum_url/index.php?topic=$topic_id\">{$mklib->lang['poll_go']}</a>
				  </td>
				</tr>
            ";
		} else {

			$gvot = $mklib->lang['poll_go'];
			if ($mkportals->member['id']) {
				$gvot = $mklib->lang['poll_voted'];
			}
			$out .= "
				<tr>
				  <td class=\"tdblock\">
				  <span class=\"mktxtcontr\">$total_votes</span> {$mklib->lang['poll_totalvotes']}
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\">
				  <a href=\"$mkportals->forum_url/index.php?topic=$topic_id\">$gvot</a>
				  </td>
				</tr>
            ";
		}


  return $out;
	}


	function get_forum_list()
	{
		global $mklib, $DB;

		$prefix = DBPREFIX;
		$forum_active = $mklib->config['forum_active'];

		$DB->query("SELECT ID_BOARD, name FROM {$prefix}boards order by ID_BOARD");

		while( $board = $DB->fetch_row() ) {
			$id = $board['ID_BOARD'];
			$title = $board['name'];
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

		$user_info['smiley_set'] = $mkportals->member['smiley_set'] = (!in_array($user_info['smiley_set'], explode(',', $modSettings['smiley_sets_known'])) && $user_info['smiley_set'] != 'none') || empty($modSettings['smiley_sets_enable']) ? (!empty($settings['smiley_sets_default']) ? $settings['smiley_sets_default'] : $modSettings['smiley_sets_default']) : $user_info['smiley_set'];

		if (!$user_info['smiley_set']) {
			$user_info['smiley_set'] = "default";
		}
		$limit = $mklib->config['bnews_block'];
		//$taglio = 17;
		$db_prefix = DBPREFIX;
		$forum_active = $mklib->config['forum_active'];
		if(!$forum_active) {
				return "";
		}
		$sql = "SELECT
			m.posterTime, m.subject, m.ID_TOPIC, m.ID_MEMBER, m.ID_MSG, m.ID_BOARD,
			IFNULL(mem.realName, m.posterName) AS posterName, t.ID_BOARD, b.name AS bName,
			m.body, m.smileysEnabled, m.Icon
		FROM {$db_prefix}topics AS t, {$db_prefix}messages AS m, {$db_prefix}boards AS b
			LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = m.ID_MEMBER)
			WHERE m.ID_MSG = t.ID_FIRST_MSG
			AND b.ID_BOARD = $forum_active
			AND b.ID_BOARD = t.ID_BOARD
		ORDER BY m.ID_MSG DESC
		LIMIT $limit";

		$DB->query($sql);

		while ( $post = $DB->fetch_row() ) {
  		$title = strip_tags($post['subject']);
		$title = str_replace( "&#33;" , "!" ,$title );
		$title = str_replace( "&quot;", "\"", $title );

 		$date  = $mklib->create_date($post['posterTime']);
		$tid = $post['ID_TOPIC'];

		$mid = $post['ID_MEMBER'];
		$mname = $post['posterName'];
		$testo = $post['body'];
		$testo = doUBBC($testo);
		$fname = $post['bName'];
		$icona = $mkportals->forum_url."/Themes/default/images/post/".$post['Icon'].".gif";
		$out .= "
				    <table class=\"tabnews\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\">
				      <tbody>
				      <tr>
					<td class=\"tdblock\" align=\"center\" width=\"5%\">
					<img hspace=\"0\" src=\"$icona\" align=\"bottom\" border=\"0\" alt=\"\" />
					</td>
					<td class=\"tdblock\" valign=\"top\" width=\"95%\">
					<b>$fname<br /><a href=\"$mkportals->forum_url/index.php?topic=$tid\">$title</a></b>
					</td>
				      </tr>
				      <tr>
					<td colspan=\"2\"><br />
					$testo
					</td>
				      </tr>
				      <tr>
					<td align=\"right\" colspan=\"2\">
					<br /><i>{$mklib->lang['from']}<b> <a href=\"$mkportals->forum_url/index.php?action=profile;u=$mid\">$mname</a></b>, $date <a href=\"$mkportals->forum_url/index.php?topic=$tid\"> [ {$mklib->lang['readall']} ]</a></i>
					</td>
				      </tr>
				      </tbody>
				    </table>
		";
 		}
		return $out;
	}

	function skinselect()
 	{
		global $DB, $mklib, $mkportals, $sc;

		if ( $mkportals->member['mgroup'] == 99) {
            return "";
        }
		$templateslist .= "<form name=\"skinlist\" action=\"post\">\n <select name=\"selectskin\" class=\"bgselect\" onchange=\"document.location.href=skinlist.selectskin.options[this.selectedIndex].value\">\n";
		$DB->query("SELECT * from ".DBPREFIX.themes."");
		while ( $r = $DB->fetch_row() )
		{
			$selected = "";
			if ($r['variable'] == "name") {
				if ($mkportals->member['theme'] == $r['ID_THEME']) {
					$selected = "selected=\"selected\"";
				}
				if (strlen($r['value']) > 12 ) {
					$r['value'] = substr($r['value'], 0, 12);
				}
			$templateslist .= "\n<option value=\"$mklib->siteurl/index.php?skinid={$r['ID_THEME']}\" $selected >{$r['value']}</option>";

			}
		}

		$templateslist .= "\n</select>\n</form>";
    	$templateslist = "
				<tr>
				  <td class=\"tdblock\" align=\"center\" valign=\"middle\">$templateslist</td>
				</tr>
                ";
		return $templateslist;
	}

	function update_skin($skinid)
 	{
		global $mkportals, $DB, $mklib;

		$DB->query("SELECT ID_THEME from ".DBPREFIX.themes." where ID_THEME = '$skinid'");
		if ($DB->fetch_row()){
			$DB->query("UPDATE  ".DBPREFIX.members." SET ID_THEME ='$skinid' where ID_MEMBER = '{$mkportals->member['id']}'");
			$DB->close_db();
	 		Header("Location: $mkportals->forum_url/index.php");
			exit;
		}
	}

	function calendar_birth($chosen_month, $chosen_year)
 	{
		global $mkportals, $DB, $mklib, $modSettings;

		$birthdays = array();

		$DB->query("SELECT DAYOFMONTH(birthdate) AS bday_day, YEAR(birthdate) AS bday_year, realName from ".DBPREFIX.members." WHERE MONTH(birthdate)='".$chosen_month."'");
    	while ($user = $DB->fetch_row()) {
       	 	$birthdays[ $user['bday_day'] ]++;
        	if ($birthdays[ $user['bday_day'] ] < 10) {
            	$tool_birthdays[$user['bday_day']] .=  $user['realName']." (".($chosen_year - $user['bday_year']).")&nbsp;";
        	}
        	else if ($birthdays[ $user['bday_day'] ] == 10) {
            $tool_birthdays[$user['bday_day']] .=  "...";
        	}
    	}

		return array($birthdays, $tool_birthdays);
	}
	function calendar_events($chosen_month, $chosen_year)
 	{
		global $mkportals, $DB, $mklib;
		$events = array();

    	$DB->query("SELECT ID_TOPIC, title, DAYOFMONTH(eventDate) AS mday from ".DBPREFIX.calendar." WHERE MONTH(eventDate)='".$chosen_month."' AND YEAR(eventDate)='".$chosen_year."'");
		while ( $event = $DB->fetch_row() ) {

       	 	$events[ $event['mday'] ][] = $event;
       	 	$entry = substr($event['title'], 0, 20);
     	 	if ( strlen($event['title']) > 20 ) {
       	     	$entry .= "...";
       	 	}
       	 	$tool_events[$event['mday']] .= $entry."<br />";
    	}

		return array($events, $tool_events, $tool_idevents);
	}

	function import_css()
	{
		global $mkportals, $DB, $mklib;
		$DB->query("SELECT * from ".DBPREFIX."themes where ID_THEME = '{$mkportals->member['theme']}'");
		while ( $r = $DB->fetch_row() )
		{
			if ($r['variable'] == "images_url") {
				$images_url = $r['value'];
			}
			if ($r['variable'] == "theme_dir") {
				$theme_dir = $r['value'];
			}
		}
		unset ($r);
		$css2 = $theme_dir."/style.css";
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


		//importing body bg
		$pos = strpos($css2, "body\n");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importbgbody(.*?\}))`is", $mkpsubs, $css);
			}

		//importing body fonts
		$pos = strpos($css2, "body, td");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importbody(.*?\}))`is", $mkpsubs, $css);
			}

		//importing main table bg (if different than body bg)
		$pos = strpos($css2, "#bodyarea");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importmain(.*?\}))`is", $mkpsubs, $css);
			}

		//importing logostrip
		$sflogo =  $theme_dir."/images/sf_logo.jpg";
		if (is_file("$sflogo") ) {
			$mkpsubs = "#logostrip {background-image: url($images_url/sf_logo.jpg); text-align: left;}";
		} else {
			$pos = strpos($css2, "#headerarea");
			$pos2 = strpos($css2, "}", $pos);
				if ($pos) {
					$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				}
		}
		$css = preg_replace( "`(\#importlogostrip(.*?\}))`is", $mkpsubs, $css);

		
		//importing light background
		$pos = strpos($css2, ".windowbg2");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importlightback(.*?\}))`is", $mkpsubs, $css);
			}
		

		//importing medium background
		$pos = strpos($css2, ".windowbg");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importmediumback(.*?\}))`is", $mkpsubs, $css);
			}

		//importing dark background
		$pos = strpos($css2, ".titlebg");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importdarkback(.*?\}))`is", $mkpsubs, $css);
			}

		//importing module table headers
		$pos = strpos($css2, ".catbg");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importmodulex(.*?\}))`is", $mkpsubs, $css);
			}
		
		//importing borders
		$pos = strpos($css2, ".tborder");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));		
				$mkpsubs = preg_replace( "/back(.*?\;)/mi", "", $mkpsubs);
				$mkpsubs = str_replace("color:", "border-color:", $mkpsubs);
				$css = preg_replace( "`(\.importborders(.*?\}))`is", $mkpsubs, $css);
			}

		//importing form styles
		$pos = strpos($css2, "input");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importforms(.*?\}))`is", $mkpsubs, $css);
			}

		//importing table font formatting
		$pos = strpos($css2, "body, td");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importfont(.*?\}))`is", $mkpsubs, $css);
			}

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
		$DB->query("SELECT  emailAddress from ".DBPREFIX."members WHERE ID_GROUP = '1'");
		while ( $row = $DB->fetch_row() ) {
			$dest .= $row['emailAddress'].", ";
		}
		$dest=rtrim($dest, ", ");
		mail($dest, $subject, $message,  $headers);
	}


}

$mklib_board = new mklib_board;

?>
