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
    							$location= "portale";
    						break;
							case 'blog':
    							$location= "blog";
    						break;
							case 'gallery':
    							$location= "gallery";
    						break;
							case 'urlobox':
    							$location= "urlobox";
    						break;
							case 'downloads':
    							$location= "downloads";
    						break;
							case 'news':
    							$location= "news";
    						break;
							case 'topsite':
    							$location= "topsite";
    						break;
							case 'chat':
    							$location= "chat";
    						break;
							case 'reviews':
    							$location= "reviews";
    						break;
							default:
							$location= "portale";
    						break;
						}
		$idu = $mkportals->member['id'];
		$DB->query("UPDATE  ".DBPREFIX.whosonline." SET  location ='$location'  where uid = '$idu'");
	}


	function get_active_users($loc) {

		global $DB, $mkportals, $mklib;

		switch($loc) {
							case 'portale':
    							$location= "portale";
    						break;
							case 'blog':
    							$location= "blog";
    						break;
							case 'gallery':
    							$location= "gallery";
    						break;
							case 'urlobox':
    							$location= "urlobox";
    						break;
							case 'downloads':
    							$location= "downloads";
    						break;
							case 'news':
    							$location= "news";
    						break;
							case 'topsite':
    							$location= "topsite";
    						break;
							case 'chat':
    							$location= "chat";
    						break;
							case 'reviews':
    							$location= "reviews";
    						break;
							default:
							$location= "portale";
    						break;
						}

	$time = (time() - 900);
	$prefix = DBPREFIX;

			$query = $DB->query("SELECT m.hidden, m.username, m.status, w.*, COUNT(w.uid) AS nbuser FROM ".DBPREFIX.whosonline." w LEFT JOIN ".DBPREFIX.members." m ON m.uid=w.uid WHERE w.time > $time AND w.location = '$location' GROUP BY w.uid ORDER BY m.username");

			while ($result = $DB->fetch_row() ) {
  				switch($result['status']) {
							case "Administrator":
							$result['opentag'] = "<span style='color:red;font-weight:bold'>";
							$result['closetag'] = "</span>";
							break;
							case "Super Moderator":
							$result['opentag'] = "<span style='color:green;font-weight:bold'>";
							$result['closetag'] = "</span>";
							break;
							case "Moderator":
							$result['opentag'] = "<span style='color:blue;font-weight:bold'>";
							$result['closetag'] = "</span>";
							break;
							default:
							$result['opentag'] = "";
							$result['closetag'] = "";
    						break;
						}
				if ($result['uid'] == 0) {
					$active['guests']++;
				} else {
						if ($cached[ $result['userid'] ]) {
							continue;
						}
						$cached[ $result['userid'] ] = 1;
						if ($result['hidden'] == "yes") {
							if ( $mkportals->member['mgroup'] == "100") {
								$active['names'] .= "<a href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*, ";
								$active['anon']++;
							} else {
								$active['anon']++;
							}
						} else {
							$active['members']++;
							$active['names'] .= "<a href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>, ";
						}

				}
			}
			$active['names'] = preg_replace( "/,\s+$/", "" , $active['names'] );
			$utenti_in = "{$mklib->lang['b_tusers']} ";
			$utenti_in .= ($active['members'] + $active['guests'] + $active['anon'] );
			$utenti_in .= " ({$active['members']} {$mklib->lang['b_rusers']} {$active['guests']} {$mklib->lang['b_guests']} {$mklib->lang['b_and']} {$active['anon']} {$mklib->lang['b_anons']})<br />";
			$utenti_in .= "{$mklib->lang['b_vusers']}  {$active['members']} {$active['names']}";

			return $utenti_in;

	}

	function show_emoticons()
 	{
 		global $mkportals, $DB, $std, $Skin, $mklib, $user_info;


 		$output = "
 		<head>
		<link href=\"$mklib->template/style.css\" rel=\"stylesheet\" type=\"text/css\">
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

 		$DB->query("SELECT code, url from ".DBPREFIX.smilies."");
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
				$image = stripslashes($r['url']);
				if ($countr == 3) {
					$output .= "</tr><tr>";
					$countr = 0;
				}
				$output .= "
	  				<td align=\"center\" class=\"tdblock\" valign=\"middle\"><a href={$out}javascript:add_smilie({$in}$code{$in}){$out}><img src=\"{$mkportals->forum_url}/images/smilies/$image\" border=\"0\" valign=\"middle\" alt=\"$image\" /></a></td>
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
		global $mkportals, $DB, $mklib;

		$DB->query("SELECT code, url from ".DBPREFIX.smilies."");
		while ( $r = $DB->fetch_row() )
		{
			$code = stripslashes($r['code']);
			$image = stripslashes($r['url']);
			$image = "$mklib->siteurl/$mklib->forumpath/images/smilies/".$image;
			$image = "<img src=\"$image\" border=\"0\" alt=\"\" />";
			$message = str_replace($code, $image, $message);
		}
		return $message;
	}

	function popup_pm($m1, $m2, $m3, $m4)
 	{
		global $DB, $mklib, $mkportals;


		$u1 = "$mklib->siteurl/$mklib->forumpath/u2u.php";

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
/*
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
				$selected = "selected";
			}
			$cselect.= "<option value=\"$g_id\" $selected>$g_title</option>\n";
		}
*/
		//aggiunge i guest
		switch($ind) {
							case '2':
    							$selected2 = "selected";
    						break;
							case '3':
    							$selected3 = "selected";
    						break;
							case '4':
    							$selected4 = "selected";
    						break;
							case '5':
    							$selected5 = "selected";
    						break;
							case '6':
    							$selected6 = "selected";
    						break;
							default:
								$selected1 = "selected";
    						break;
						}
		$cselect.= "<option value=\"1\" $selected1>Guests</option>\n";
		$cselect.= "<option value=\"2\" $selected2>Moderator</option>\n";
		$cselect.= "<option value=\"3\" $selected3>Member</option>\n";
		$cselect.= "<option value=\"4\" $selected4>Super Moderator</option>\n";
		$cselect.= "<option value=\"5\" $selected5>Waiting</option>\n";
		$cselect.= "<option value=\"6\" $selected6>Banned</option>\n";
		return $cselect;
	}

	//ad_perms
	function update_groupperms($g_id)
	{
		global $DB;

		return;

	}

	//ad_poll
	function get_poll_list()
	{
		global $mklib, $DB;

		$prefix = DBPREFIX;
		$poll_active = $mklib->config['poll_active'];
		$DB->query("SELECT p.tid, m.message FROM {$prefix}threads AS p LEFT JOIN {$prefix}posts AS m ON (m.tid = p.tid) WHERE p.pollopts != '' order by tid DESC LIMIT 30");
		while( $poll = $DB->fetch_row() ) {
			if($prevtid == $poll['tid']) {
				continue;
			}
			$id = $poll['tid'];
			$title = $poll['message'];
			$selected = "";
			if($id == $poll_active) {
				$selected = "selected";
			}
			$cselect.= "<option value=\"$id\" $selected>$title</option>\n";
			$prevtid = $poll['tid'];
		}

		return $cselect;
	}

//blocks functions

	function forum_link($link)
	{
		global $mklib, $mkportals;
		switch($link) {
			case 'profile':
    			$out = "{$mkportals->forum_url}/member.php?action=viewpro&uid";
    		break;
			case 'cpaforum':
    			$out = "{$mkportals->forum_url}/cp.php";
    		break;
			case 'cpapers':
    			$out = "{$mkportals->forum_url}/memcp.php?action=profile";
    		break;
			case 'pm':
    			$out = "{$mkportals->forum_url}/u2u.php";
    		break;
			case 'forumsearch':
    			$out = "{$mkportals->forum_url}/misc.php?action=search";
    		break;
			case 'logout':
    			$out = "{$mkportals->forum_url}/misc.php?action=logout";
    		break;
			case 'postlink':
    			$out = "{$mkportals->forum_url}/misc.php";
    		break;
			case 'register':
    			$out = "{$mkportals->forum_url}/member.php?action=reg";
    		break;
			case 'onlinelist':
    			$out = "{$mkportals->forum_url}/misc.php?action=online";
    		break;
			case 'login_extra':
    			$out = "<tr>
                  <input type=\"hidden\" name=\"action\" value=\"login\">
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
		global $mkportals, $DB;

		$mkportals->member['avatar'];

			if (substr($mkportals->member['avatar'], 0, 7) == 'http://')
			{
				$pos = strpos($mkportals->member['avatar'], ",");
				$mkportals->member['avatar'] = substr($mkportals->member['avatar'], 0, $pos);
				$dimension = @getimagesize($mkportals->member['avatar']);
						if ($dimension[0] > 80) {
							$dimension[1] = ceil(80 * $dimension[1] / $dimension[0]);
							$dimension[0] = 80;
						}
				$avatar_img = "<img src=\"{$mkportals->member['avatar']}\" width=\"$dimension[0]\" height=\"$dimension[1]\" alt=\"\" border=\"\" />";
			} else {

				$avatar_img = "<img src=\"{$mkportals->forum_url}/{$mkportals->member['avatar']}\" alt=\"\" border=\"\" />";
			}

			if (!$mkportals->member['avatar'])
			{
				$avatar_img = "";
			}
			return $avatar_img;
	}

	function get_forumnav()
 	{
		global $mklib, $mkportals;
		require "$mklib->mklang/lang_global.php";

		$content = "
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_cerca.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/lastpost.php\">{$langmk['m_newpost']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_cerca.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/misc.php?action=search\">{$langmk['m_search']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_members.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/misc.php?action=list\">{$langmk['m_users']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_help.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->forum_url}/faq.php\">{$langmk['m_help']}</a></td></tr>
     	 	";
			return $content;


	}
	function get_site_stat()
 	{
		global $DB;
		$prefix = DBPREFIX;

		$sql = "SELECT COUNT(uid) AS total
				FROM {$prefix}members";

		$DB->query($sql);
		$row = $DB->fetch_row();

		$stat['members'] = $row['total'];

		$sql = "SELECT uid, username
				FROM {$prefix}members
				ORDER BY uid DESC
				LIMIT 1";
		$DB->query($sql);
		$row = $DB->fetch_row();

		$stat['last_member'] = $row['uid'];
		$stat['last_member_name'] = $row['username'];

		$sql = "SELECT COUNT(tid) AS total
				FROM {$prefix}threads";
		$DB->query($sql);
		$row = $DB->fetch_row();
		$stat['topics'] = $row['total'];

		$sql = "SELECT COUNT(fid) AS total
				FROM {$prefix}posts";
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
	$time = (time() - 900);
	$active = array( 'guests' => 0, 'anon' => 0, 'members' => 0, 'names' => "");
	$cached = array ();

	$query = $DB->query("SELECT m.hidden, m.username, m.status, w.*, COUNT(w.uid) AS nbuser FROM ".DBPREFIX.whosonline." w LEFT JOIN ".DBPREFIX.members." m ON m.uid=w.uid WHERE w.time > $time GROUP BY w.uid ORDER BY m.username");

			while ($result = $DB->fetch_row() ) {
  				switch($result['status']) {
							case "Administrator":
							$result['opentag'] = "<span style='color:red;font-weight:bold'>";
							$result['closetag'] = "</span>";
							break;
							case "Super Moderator":
							$result['opentag'] = "<span style='color:green;font-weight:bold'>";
							$result['closetag'] = "</span>";
							break;
							case "Moderator":
							$result['opentag'] = "<span style='color:blue;font-weight:bold'>";
							$result['closetag'] = "</span>";
							break;
							default:
							$result['opentag'] = "";
							$result['closetag'] = "";
    						break;
						}
				if ($result['uid'] == 0) {
					$active['guests']++;
				} else {
						if ($cached[ $result['uid'] ]) {
							continue;
						}
						$cached[ $result['uid'] ] = 1;
						if ($result['hidden'] == "yes") {
							if ( $mkportals->member['mgroup'] == "100") {
								$active['names'] .= "<a href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*, ";
								$active['anon']++;
							} else {
								$active['anon']++;
							}
						} else {
							$active['members']++;
							$active['names'] .= "<a href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>, ";
						}

				}
			}
			$active['names'] = preg_replace( "/,\s+$/", "" , $active['names'] );
			$utenti_in = "{$mklib->lang['b_tusers']} ";
			$utenti_in .= ($active['members'] + $active['guests'] + $active['anon'] );
			$utenti_in .= " ({$active['members']} {$mklib->lang['b_rusers']} {$active['guests']} {$mklib->lang['b_guests']} {$mklib->lang['b_and']} {$active['anon']} {$mklib->lang['b_anons']})<br />";
			$utenti_in .= "{$mklib->lang['b_vusers']}  {$active['members']} {$active['names']}";

		return array($active['members'], $active['anon'], $active['guests'], $active['names']);


	}


	function get_onlinehome($languest)
 	{

		global $DB, $mkportals;

	$content = "";
	$inter = ",";

	$time = (time() - 900);
	$query = $DB->query("SELECT m.hidden, m.username, m.status, w.*, COUNT(w.uid) AS nbuser FROM ".DBPREFIX.whosonline." w LEFT JOIN ".DBPREFIX.members." m ON m.uid=w.uid WHERE w.time > $time GROUP BY w.uid ORDER BY m.username");
		$online = array();
		$cached  = array();
		$online['members'] = 0;
		$online['guests'] = 0;
		$online['anon'] = 0;

		while ($result = $DB->fetch_row() ) {
				switch($result['status']) {
							case "Administrator":
							$result['opentag'] = "<span style='color:red;font-weight:bold'>";
							$result['closetag'] = "</span>";
							break;
							case "Super Moderator":
							$result['opentag'] = "<span style='color:green;font-weight:bold'>";
							$result['closetag'] = "</span>";
							break;
							case "Moderator":
							$result['opentag'] = "<span style='color:blue;font-weight:bold'>";
							$result['closetag'] = "</span>";
							break;
							default:
							$result['opentag'] = "";
							$result['closetag'] = "";
    						break;
					}

				if ($cached[ $result['uid'] ] && $result['uid'] != 0) {
							continue;
				}
				$cached[ $result['uid'] ] = 1;
				if ($result['uid'] == 0) {
					$online['guests']++;
					switch($result['location']) {
							case 'portale':
    							$online['portale'] .= "$languest{$inter} \n";
    						break;
							case 'blog':
    							$online['blog'] .= "$languest{$inter} \n";
    						break;
							case 'gallery':
    							$online['gallery'] .= "$languest{$inter} \n";
    						break;
							case 'urlobox':
    							$online['urlobox'] .= "$languest{$inter} \n";
    						break;
							case 'downloads':
    							$online['downloads'] .= "$languest{$inter} \n";
    						break;
							case 'news':
    							$online['news'] .= "$languest{$inter} \n";
    						break;
							case 'chat':
    							$online['chat'] .= "$languest{$inter} \n";
    						break;
							case 'topsite':
    							$online['topsite'] .= "$languest{$inter} \n";
    						break;
							case 'reviews':
    							$online['reviews'] .= "$languest{$inter} \n";
    						break;
							default:
							$online['forum'] .= "$languest{$inter} \n";
    						break;
					}
				} else if ($result['hidden'] == "yes") {
						if ( $mkportals->member['mgroup'] == "100") {
							switch($result['location']) {
							case 'portale':
    							$online['portale'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'blog':
    							$online['blog'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'gallery':
    							$online['gallery'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'urlobox':
    							$online['urlobox'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'downloads':
    							$online['downloads'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'news':
    							$online['news'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'chat':
    							$online['chat'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'topsite':
    							$online['topsite'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'reviews':
    							$online['reviews'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							default:
							$online['forum'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							}
							$online['anon']++;
                    	} else {
                        	$online['anon']++;
                    	}
				} else  {
					 $online['members']++;
						switch($result['location']) {
							case 'portale':
    							$online['portale'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'blog':
    							$online['blog'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'gallery':
    							$online['gallery'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'urlobox':
    							$online['urlobox'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'downloads':
    							$online['downloads'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'news':
    							$online['news'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'chat':
    							$online['chat'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'topsite':
    							$online['topsite'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'reviews':
    							$online['reviews'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							default:
							$online['forum'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?action=viewpro&uid={$result['uid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
						}

                    }

		}



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

        $online['total']    = $online['members'] + $online['guests'] + $online['anon'];
        $online['visitors'] = $online['guests']  + $online['anon'];

		return array($online['members'], $online['anon'], $online['guests'], $online['portale'], $online['blog'], $online['gallery'], $online['urlobox'], $online['downloads'], $online['news'], $online['chat'], $online['topsite'], $online['reviews'], $online['forum']);
	}

	function get_last_posts($by, $sdate)
 	{
		global $DB, $mklib, $mkportals, $db_prefix, $user_info, $modSettings;
		$limit = 5;
		$taglio = 17;
		$db_prefix = DBPREFIX;

		$query = $DB->query("SELECT f.password, f.private, f.moderator, f.userlist, f.writelist, f.name, t.* FROM {$db_prefix}threads t LEFT JOIN {$db_prefix}forums f ON t.fid=f.fid WHERE f.status='yes' ORDER BY t.lastpost DESC LIMIT $limit");


		while ( $post = $DB->fetch_row() ) {

		if ($post['private'] > 10 || $post['password']) {
			continue;
		}
		if ($post['private'] > 4 && $mkportals->member['mgroup'] != "100") {
			continue;
		}
		if ($post['private'] > 2 && $mkportals->member['mgroup'] != "100" && $mkportals->member['mgroup'] != "4") {
			continue;
		}

		$title = strip_tags($post['subject']);
		$title = str_replace( "&#33;" , "!" ,$title );
		$title = str_replace( "&quot;", "\"", $title );
			if (strlen($title) > $taglio) {
				$title = substr( $title,0,($taglio - 3) ) . "...";
				$title = preg_replace( '/&(#(\d+;?)?)?(\.\.\.)?$/', '...',$title );
			}

 		$date  = $mklib->create_date($post['lastpost']);
		$tid = $post['tid'];

		$mname = $post['author'];

		$content .= "
				<tr>
				  <td width=\"100%\" class=\"tdblock\">
				  <a class=\"uno\" href=\"$mkportals->forum_url/viewthread.php?goto=lastpost&tid=$tid\">$title</a>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\">
				  <a class=\"uno\" href=\"$mkportals->forum_url/member.php?action=viewpro&member=$mname\">$by: $mname</a><br /> $sdate: $date
				  </td>
				</tr>
		";
 		}

		return $content;


	}

	function get_poll_active($post_id)
 	{
		global $DB, $mklib, $mkportals;

		$prefix = DBPREFIX;
		//$DB->query("SELECT question, options, votes, voters FROM " . TABLE_PREFIX . "poll where pollid = $post_id");
		$DB->query("SELECT p.tid, p.pollopts, m.message FROM {$prefix}threads AS p LEFT JOIN {$prefix}posts AS m ON (m.tid = p.tid) WHERE p.tid = '$post_id'");

		$result = $DB->fetch_row();

		if ( ! $result['message'] ) {
            return "";
        }

		$question = $result['message'];
		$pollops = explode("#|#", $result['pollopts']);
		for($pnum = 0; $pnum < count($pollops); $pnum++) {
			if($pollops[$pnum] != "") {
				$thispollnum = eregi_replace(".*\|\|~\|~\|\| ", "", $pollops[$pnum]);
				$votes[$pnum] = $thispollnum;
				$pos = strpos($pollops[$pnum], "||");
				$choise[$pnum] = substr($pollops[$pnum], 0, $pos);
				//$choise[$pnum] = $pollops[$pnum];
				//$choise[$pnum] = eregi_replace("\|* ", "", $pollops[$pnum]);
				$total_votes += $thispollnum;
			}
		}

		//$choise = explode("||~|~||", $result['pollopts']);
		//$votes = explode("|||", $result['votes']);

		$poll_id = $result['tid'];
		$out = "
				<tr>
				  <td class=\"tdblock\">
				  <a href=\"$mkportals->forum_url/viewthread.php?tid=$post_id\">$question</a>
				  </td>
				</tr>
            ";

		$ind = 0;
		foreach ($choise as $entry) {
			if (!$entry) {
				continue;
			}
			$percent = $votes[$ind] == 0 ? 0 : $votes[$ind] / $total_votes * 100;
            $percent = sprintf( '%.2f' , $percent );
            $width   = $percent > 0 ? floor( round( $percent ) * ( 122 / 100 ) ) : 0;
			$out .= "
				<tr>
				  <td class=\"tdblock3\">
				  {$entry}
				  </td>
				</tr>
				<tr>
				  <td align=\"left\">
				  <img src=\"$mklib->images/bar-start.gif\" border=\"0\" width=\"4\" height=\"11\" alt=\"\" /><img src=\"$mklib->images/bar.gif\" border=\"0\" width=\"$width\" height=\"11\" alt=\"\" /><img src=\"$mklib->images/bar-end.gif\" border=\"0\" width=\"4\" height=\"11\" alt=\"\" />
				  </td>
				</tr>

                ";
			++$ind;
		}
		$out .= "
				<tr>
				  <td class=\"tdblock\">
				  <span class=\"mktxtcontr\">$total_votes</span> {$mklib->lang['poll_totalvotes']}
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\">
				  <a href=\"$mkportals->forum_url/viewthread.php?tid=$post_id\">{$mklib->lang['poll_go']}</a>
				  </td>
				</tr>
            ";
		return $out;
	}


	function get_forum_list()
	{
		global $mklib, $DB;

		$prefix = DBPREFIX;
		$forum_active = $mklib->config['forum_active'];

		$DB->query("SELECT fid, name FROM {$prefix}forums WHERE type != 'group' order by fid");

		while( $board = $DB->fetch_row() ) {
			$id = $board['fid'];
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

		$limit = $mklib->config['bnews_block'];
		$db_prefix = DBPREFIX;
		$forum_active = $mklib->config['forum_active'];
		if(!$forum_active) {
				return "";
		}

		$query = $DB->query("SELECT f.name, t.*, p.author, p.messagehtml, p.dateline
		FROM {$db_prefix}threads t
		LEFT JOIN {$db_prefix}forums f ON t.fid=f.fid
		LEFT JOIN {$db_prefix}posts p ON t.firstpid=p.pid
		WHERE f.fid=$forum_active
		ORDER BY t.tid DESC LIMIT $limit");

		while ( $post = $DB->fetch_row() ) {
  		$title = strip_tags($post['subject']);
		$title = str_replace( "&#33;" , "!" ,$title );
		$title = str_replace( "&quot;", "\"", $title );

 		$date  = $mklib->create_date($post['dateline']);
		$tid = $post['tid'];

		$mid = $post['author'];
		$mname = $post['author'];
		$testo = $post['messagehtml'];
		$testo = str_replace("<img src=\"images/smilies", "<img src=\"$mkportals->forum_url/images/smilies", $testo);
		//$testo = doUBBC($testo, "1");
		$fname = $post['name'];

		$icona = $mkportals->forum_url."/images/smilies/".$post['icon'];
		if(!$post['icon']) {
			$icona = "./mkportal/templates/Default/images/icona_news.gif";
		}
		$out .= "
				<table class=\"tabnews\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\">
				  <tbody>
				  <tr>
				    <td class=\"tdblock\" align=\"center\" width=\"5%\">
				    <img hspace=\"0\" src=\"$icona\" align=\"bottom\" border=\"0\" alt=\"\" />
				    </td>
				    <td class=\"tdblock\" valign=\"top\" width=\"95%\">
				    <b>$fname<br /><a href=\"$mkportals->forum_url/index.php?showtopic=$tid\">$title</a></b>
				    </td>
				  </tr>
				  <tr>
				    <td colspan=\"2\"><br />
				    $testo
				    </td>
				  </tr>
				  <tr>
				    <td align=\"right\" colspan=\"2\">
				    <br /><i>{$mklib->lang['from']}<b> <a href=\"$mkportals->forum_url/index.php?showuser=$mid\">$mname</a></b>, $date <a href=\"$mkportals->forum_url/index.php?showtopic=$tid\"> [ {$mklib->lang['readall']} ]</a></i>
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
		global $mkportals, $DB, $mklib;

		$db_prefix = DBPREFIX;
		$birthdays = array();
		$DB->query("SELECT bday AS bday_day, byear AS bday_year, username from {$db_prefix}members WHERE bmonth='".$chosen_month."' ORDER BY username ASC");

    	while ($user = $DB->fetch_row()) {
       	 	$birthdays[ $user['bday_day'] ]++;
        	if ($birthdays[ $user['bday_day'] ] < 10) {
            	$tool_birthdays[$user['bday_day']] .=  $user['username']." (".($chosen_year - $user['bday_year']).")&nbsp;";
        	}
        	else if ($birthdays[ $user['bday_day'] ] == 10) {
            $tool_birthdays[$user['bday_day']] .=  "...";
        	}
    	}
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

		return "<tr><td>Sorry but this function is not yet available for Oxygen Board</td></tr>";
	}

	function update_skin($skinid)
 	{
		global $mkportals, $DB, $mklib;

	}


	function admin_mail($subject, $message)
 	{
		global $DB, $mklib;

		$headers = "From: webmaster@" . $mklib->sitename . "\r\n" . "Reply-To: webmaster@" . $mklib->sitename . "\r\n" . "X-Mailer: MKportal Mail";

		$dest = "";
		$DB->query("SELECT email from ".DBPREFIX.members." WHERE status = 'Administrator'");
		while ( $row = $DB->fetch_row() ) {
			$dest .= $row['email'].", ";
		}
		$dest=rtrim($dest, ", ");
		mail($dest, $subject, $message,  $headers);
	}


}

$mklib_board = new mklib_board;

?>
