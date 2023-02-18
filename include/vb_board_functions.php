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

		$DB->query("UPDATE " . TABLE_PREFIX . "session SET location ='$location'  where userid = '$idu'");

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

		$DB->query("SELECT
			user.username, (user.options & 512) AS invisible, user.usergroupid,
			session.userid, session.inforum, session.lastactivity, session.location, groups.opentag, groups.closetag,
			IF(displaygroupid=0, user.usergroupid, displaygroupid) AS displaygroupid
		FROM " . TABLE_PREFIX . "session AS session
		LEFT JOIN " . TABLE_PREFIX . "user AS user ON(user.userid = session.userid)
		LEFT JOIN " . TABLE_PREFIX . "usergroup AS groups ON(groups.usergroupid = user.usergroupid)
		WHERE session.lastactivity > $time
		AND session.location LIKE '%$location%'
		ORDER BY username ASC
		");
			$cached = array();
			$active = array( 'guests' => 0, 'anon' => 0, 'members' => 0, 'names' => "");
			while ($result = $DB->fetch_row() ) {

				if ($result['userid'] == 0) {
					$active['guests']++;
				} else {
						if ($cached[ $result['userid'] ]) {
							continue;
						}
						$cached[ $result['userid'] ] = 1;
						if ($result['invisible'] == 512) {
							if ( $mkportals->member['mgroup'] == "6") {
								$active['names'] .= "<a href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*, ";
								$active['anon']++;
							} else {
								$active['anon']++;
							}
						} else {
							$active['members']++;
							$active['names'] .= "<a href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>, ";
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
 		global $mkportals, $DB, $std, $Skin, $mklib;
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

 		$DB->query("SELECT smilietext, smiliepath from " . TABLE_PREFIX . "smilie");
		$countr = 0;
		if ( $DB->get_num_rows() )
		{
			while ( $r = $DB->fetch_row() )
			{
				if (strstr( $r['smilietext'], "&quot;" ) )
				{
					$in_delim  = "'";
					$out_delim = '"';
				}
				else
				{
					$in  = '"';
					$out = "'";
				}
				$code = stripslashes($r['smilietext']);
				$image = stripslashes($r['smiliepath']);
				if (!strpos($image, "ttp://")) {
					$image = "$mklib->siteurl/$mklib->forumpath/".$image;
				}
				if ($countr == 3) {
					$output .= "</tr><tr>";
					$countr = 0;
				}
				$output .= "
	  				<td width=\"50%\" align=\"center\" class=\"tdblock\" valign=\"middle\"><a href={$out}javascript:add_smilie({$in}$code{$in}){$out}><img src=\"$image\" border=\"0\" valign=\"middle\" alt=\"$image\" /></a></td>
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

		$DB->query("SELECT smilietext, smiliepath from " . TABLE_PREFIX . "smilie");
		while ( $r = $DB->fetch_row() )
		{
			$code = stripslashes($r['smilietext']);
			$image = stripslashes($r['smiliepath']);
			if (!strpos($image, "ttp://")) {
					$image = "$mklib->siteurl/$mklib->forumpath/".$image;
			}
			$image = "<img src=\"$image\" border=\"0\" alt=\"\" />";
			$message = str_replace($code, $image, $message);
		}
		return $message;
	}
	function popup_pm($m1, $m2, $m3, $m4)
 	{
		global $DB, $mklib, $mkportals;

		$u1 = "$mklib->siteurl/$mklib->forumpath/private.php";

		$DB->query("UPDATE " . TABLE_PREFIX . "user SET  pmpopup='1' WHERE userid={$mkportals->member['id']}");


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

		$DB->query( "SELECT  usergroupid, title FROM " . TABLE_PREFIX . "usergroup ORDER BY `usergroupid`");
		while( $row = $DB->fetch_row() ) {
			if($row['usergroupid'] == 6) {
				continue;
			}
			$g_id= $row['usergroupid'];
			$g_title = $row['title'];
			$selected = "";
			if($g_id == $ind) {
				$selected = "selected=\"selected\"";
			}
			$cselect.= "<option value=\"$g_id\" $selected>$g_title</option>\n";
		}
		return $cselect;
	}

	//ad_perms
	function update_groupperms($g_id)
	{
		global $DB;

		$query = $DB->query( "SELECT title FROM " . TABLE_PREFIX . "usergroup WHERE usergroupid = '$g_id'");
		$row = $DB->fetch_row($query);
		$g_title = $row['title'];
		return $row['title'];

	}

	//ad_poll
	function get_poll_list()
	{
		global $mklib, $DB;

		$poll_active = $mklib->config['poll_active'];
		$DB->query("SELECT  pollid, question FROM " . TABLE_PREFIX . "poll order by pollid DESC LIMIT 30");

        if ($DB->get_num_rows()) {
    		while( $poll = $DB->fetch_row() ) {
    			$id = $poll['pollid'];
    			$title = $poll['question'];
    			$selected = "";
    			if($id == $poll_active) {
    				$selected = "selected=\"selected\"";
    			}
    			$cselect.= "<option value=\"$id\" $selected>$title</option>\n";
    		}
        }
        else {
            $cselect.= "<option value=\"0\"></option>\n";
        }

		return $cselect;
	}

//blocks functions

	function forum_link($link)
	{
		global $mklib, $mkportals;

		$idu = $mkportals->member['id'];

		switch($link) {
			case 'profile':
    			$out = "{$mkportals->forum_url}/member.php?u";
    		break;
			case 'cpaforum':
    			$out = "{$mkportals->forum_url}/admincp/index.php";
    		break;
			case 'cpapers':
    			$out = "{$mkportals->forum_url}/usercp.php";
    		break;
			case 'pm':
    			$out = "{$mkportals->forum_url}/private.php?";
    		break;
			case 'forumsearch':
    			$out = "{$mkportals->forum_url}/search.php";
    		break;
			case 'logout':
    			$out = "{$mkportals->forum_url}/login.php?do=logout&amp;u=$idu";
    		break;
			case 'postlink':
    			$out = "{$mkportals->forum_url}/login.php";
    		break;
			case 'postlink2':
    			$out = "name=\"LOGIN\" onsubmit=\"md5hash(vb_login_password,vb_login_md5password,vb_login_md5password_utf)\"";
    		break;
			case 'register':
    			$out = "{$mkportals->forum_url}/register.php";
    		break;
			case 'onlinelist':
    			$out = "{$mkportals->forum_url}/online.php";
    		break;
			case 'login_extra':
    			$out = "
				<script type=\"text/javascript\" src=\"{$mkportals->forum_url}/clientscript/vbulletin_md5.js\"></script>
				<tr>
                    <td class=\"tdblock\" width=\"100%\" colspan=\"2\" align=\"left\"><b>{$mklib->lang['auto_login']}</b>&nbsp;<input type=\"checkbox\" name=\"cookieuser\" value=\"1\"  style=\"margin:0px;\" />
				    <input type=\"hidden\" name=\"s\" value=\"\" />
				    <input type=\"hidden\" name=\"do\" value=\"login\" />
				    <input type=\"hidden\" name=\"forceredirect\" value=\"1\" />
				    <input type=\"hidden\" name=\"vb_login_md5password\" />
				    <input type=\"hidden\" name=\"vb_login_md5password_utf\" />
				  </td>
				</tr>";
    		break;
			case 'login_user':
    			$out = "vb_login_username";
    		break;
			case 'login_passw':
    			$out = "vb_login_password";
    		break;
			case 'calendar_event':
    			$out = "$mkportals->forum_url/calendar.php?s=";
    		break;
			default:
    			$out = "n/a";
    		break;
    		}

		return $out;

	}

	function get_poll_active($post_id)
 	{
		global $DB, $mklib, $mkportals;
		$DB->query("SELECT question, options, votes, voters FROM " . TABLE_PREFIX . "poll where pollid = $post_id");
		$result = $DB->fetch_row();
		if ( ! $result['question'] ) {
            return "";
        }
		$question = $result['question'];
		$choise = explode("|||", $result['options']);
		$votes = explode("|||", $result['votes']);
		$total_votes = $result['voters'];

		$DB->query("SELECT threadid FROM " . TABLE_PREFIX . "thread where pollid = $post_id");
		$result = $DB->fetch_row();
		$poll_id = $result['threadid'];
		$out = "
				<tr>
				  <td class=\"tdblock\">
				  <a href=\"$mkportals->forum_url/viewtopic.php?t=$post_id\">$question</a>
				  </td>
				</tr>
            ";

		$ind = 0;
		foreach ($choise as $entry) {
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
				  <a href=\"$mkportals->forum_url/showthread.php?t=$poll_id\">{$mklib->lang['poll_go']}</a>
				  </td>
				</tr>
            ";
		return $out;
	}

	function get_avatar()
 	{
		global $mkportals, $DB, $mklib;

		require_once("$mkportals->forum_url/includes/functions_user.php");
		$avatar = fetch_avatar_url($mkportals->member['id']);
		if (!strpos($avatar, "ttp://")) {
			$avatar = "$mkportals->forum_url/".$avatar;
		}

		$avatar = "<img src=\"$avatar\" border=\"0\" alt=\"\" />";
		return $avatar;
	}

	function get_forumnav()
 	{
		global $mklib, $mkportals;
		require "$mklib->mklang/lang_global.php";


		$out = "
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_npost.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$mkportals->forum_url/search.php?do=getnew\">{$langmk['m_newpost']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_members.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$mkportals->forum_url/memberlist.php\">{$langmk['m_users']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_calendario.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$mkportals->forum_url/calendar.php\">{$langmk['m_calendar']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_help.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$mkportals->forum_url/faq.php\">{$langmk['m_help']}</a></td></tr>
     	 	";
			return $out;


	}
	function get_site_stat()
 	{
		global $DB;


		$sql = "SELECT COUNT(userid) AS total
				FROM " . TABLE_PREFIX . "user";

		$DB->query($sql);
		$row = $DB->fetch_row();

		$stat['members'] = $row['total'];

		$sql = "SELECT userid, username
				FROM " . TABLE_PREFIX . "user
				ORDER BY userid DESC
				LIMIT 1";
		$DB->query($sql);
		$row = $DB->fetch_row();

		$stat['last_member'] = $row['userid'];
		$stat['last_member_name'] = $row['username'];

		$sql = "SELECT COUNT(threadid) AS total
				FROM " . TABLE_PREFIX . "thread";
		$DB->query($sql);
		$row = $DB->fetch_row();
		$stat['topics'] = $row['total'];

		$sql = "SELECT COUNT(postid) AS total
				FROM " . TABLE_PREFIX . "post";
		$DB->query($sql);
		$row = $DB->fetch_row();
		$stat['total_posts'] = $row['total'];


		$stat['replies'] = $stat['total_posts'] - $stat['topics'];
		return $stat;


	}

	function get_onlineblock()
 	{
		global $DB, $mkportals;

	$time = (time() - 900);

		$DB->query("SELECT
			user.username, (user.options & 512) AS invisible, user.usergroupid,
			session.userid, session.inforum, session.lastactivity, groups.opentag, groups.closetag,
			IF(displaygroupid=0, user.usergroupid, displaygroupid) AS displaygroupid
		FROM " . TABLE_PREFIX . "session AS session
		LEFT JOIN " . TABLE_PREFIX . "user AS user ON(user.userid = session.userid)
		LEFT JOIN " . TABLE_PREFIX . "usergroup AS groups ON(groups.usergroupid = user.usergroupid)
		WHERE session.lastactivity > $time
		ORDER BY username ASC
		");

			$active = array( 'guests' => 0, 'anon' => 0, 'members' => 0, 'names' => "");
			$cached = array ();

			while ($result = $DB->fetch_row() ) {
				if ($result['userid'] == 0) {
					$active['guests']++;
				} else {
						if ($cached[ $result['userid'] ]) {
							continue;
						}
						$cached[ $result['userid'] ] = 1;
						if ($result['invisible'] == 512) {
							if ( $mkportals->member['mgroup'] == "6") {
								$active['names'] .= "<a href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*, ";
								$active['anon']++;
							} else {
								$active['anon']++;
							}
						} else {
							$active['members']++;
							$active['names'] .= "<a href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>, ";
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
	$DB->query("SELECT
			user.username, (user.options & 512) AS invisible, user.usergroupid, groups.opentag, groups.closetag,
			session.userid, session.inforum, session.lastactivity, session.location AS location,
			IF(displaygroupid=0, user.usergroupid, displaygroupid) AS displaygroupid
		FROM " . TABLE_PREFIX . "session AS session
		LEFT JOIN " . TABLE_PREFIX . "user AS user ON(user.userid = session.userid)
		LEFT JOIN " . TABLE_PREFIX . "usergroup AS groups ON(groups.usergroupid = user.usergroupid)
		WHERE session.lastactivity > $time
		ORDER BY username ASC
		");
		$online = array();
		$cached  = array();
		$online['members'] = 0;
		$online['guests'] = 0;
		$online['anon'] = 0;

		while ($result = $DB->fetch_row() ) {
				//$result['location'] = $this->decodeloc($result['session.location']);
				$result['location'] =  $this->decodeloc($result['location']);
				if ($cached[ $result['userid'] ] && $result['userid'] != 0) {
							continue;
				}
				$cached[ $result['userid'] ] = 1;
				if ($result['userid'] == 0) {
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
				} else if ($result['invisible'] == 512) {
						if ( $mkportals->member['mgroup'] == "6") {
							switch($result['location']) {
							case 'portale':
    							$online['portale'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'blog':
    							$online['blog'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'gallery':
    							$online['gallery'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'urlobox':
    							$online['urlobox'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'downloads':
    							$online['downloads'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'news':
    							$online['news'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'chat':
    							$online['chat'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'topsite':
    							$online['topsite'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							case 'reviews':
    							$online['reviews'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
    						break;
							default:
							$online['forum'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>*{$inter} \n";
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
    							$online['portale'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'blog':
    							$online['blog'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'gallery':
    							$online['gallery'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'urlobox':
    							$online['urlobox'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'downloads':
    							$online['downloads'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'news':
    							$online['news'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'chat':
    							$online['chat'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'topsite':
    							$online['topsite'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							case 'reviews':
    							$online['reviews'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
    						break;
							default:
							$online['forum'] .= "<a class=\"uno\" href=\"{$mkportals->forum_url}/member.php?u={$result['userid']}\">{$result['opentag']}{$result['username']}{$result['closetag']}</a>{$inter} \n";
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
		global $DB, $mklib, $mkportals, $db_prefix, $user_info, $modSettings, $std;
		$limit = 5;
		$taglio = 17;

     $DB->query("
	SELECT post.*,post.username AS postusername,user.userid,thread.forumid
	FROM " . TABLE_PREFIX . "post AS post
    LEFT JOIN " . TABLE_PREFIX . "user AS user ON(user.userid = post.userid)
	LEFT JOIN " . TABLE_PREFIX . "thread AS thread ON(thread.threadid = post.threadid)
	LEFT JOIN " . TABLE_PREFIX . "deletionlog AS deletionlog ON(deletionlog.primaryid = post.postid AND type = 'post')
	WHERE post.visible=1 AND deletionlog.primaryid IS NULL
	ORDER BY dateline DESC
	LIMIT 0, $limit
");



		while ( $post = $DB->fetch_row() ) {
		$forumid= $post['forumid'];
		$foruminfo = verify_id('forum', $forumid, 1, 1);
		$_permsgetter_ = 'forumdisplay';
		$forumperms = fetch_permissions($forumid);
		if (!$forumperms || $foruminfo['password']) {
			continue;
		}
		$title = strip_tags($post['title']);
		$title = str_replace( "&#33;" , "!" ,$title );
		$title = str_replace( "&quot;", "\"", $title );
			if (strlen($title) > $taglio) {
				$title = substr( $title,0,($taglio - 3) ) . "...";
				$title = preg_replace( '/&(#(\d+;?)?)?(\.\.\.)?$/', '...',$title );
			}

 		$date  = $mklib->create_date($post['dateline']);
		$tid = $post['postid'];

		$mid = $post['userid'];
		$mname = $post['postusername'];

		$content .= "
				<tr>
				  <td width=\"100%\" class=\"tdblock\">
				  <a class=\"uno\" href=\"$mkportals->forum_url/showthread.php?p=$tid#post$tid\">$title</a>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\">
				  <a class=\"uno\" href=\"$mkportals->forum_url/member.php?u=$mid\">$by: $mname</a><br /> $sdate: $date
				  </td>
				</tr>
		";
 		}

		return $content;


	}

	function get_forum_list()
	{
		global $mklib, $DB;

		$prefix = DBPREFIX;
		$forum_active = $mklib->config['forum_active'];

		$DB->query("SELECT forumid, title FROM " . TABLE_PREFIX . "forum WHERE parentid > '0' order by forumid");

		while( $board = $DB->fetch_row() ) {
			$id = $board['forumid'];
			$title = $board['title'];
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

		require_once("$mkportals->forum_url/includes/functions_bbcodeparse.php");
		$limit = $mklib->config['bnews_block'];
		//$taglio = 17;
		$db_prefix = DBPREFIX;
		$forum_active = $mklib->config['forum_active'];
		if(!$forum_active) {
				return "";
		}


		$DB->query("
		SELECT post.*,post.username AS postusername, user.userid,thread.forumid, thread.iconid AS icona, thread.threadid, thread.title AS ttitle, forum.title AS f_title
		FROM " . TABLE_PREFIX . "post AS post
    	LEFT JOIN " . TABLE_PREFIX . "user AS user ON(user.userid = post.userid)
		LEFT JOIN " . TABLE_PREFIX . "forum AS forum ON(thread.forumid = forum.forumid)
		LEFT JOIN " . TABLE_PREFIX . "thread AS thread ON(thread.firstpostid = post.postid)
		LEFT JOIN " . TABLE_PREFIX . "deletionlog AS deletionlog ON(deletionlog.primaryid = post.postid AND type = 'post')
		WHERE thread.forumid=$forum_active AND post.visible=1 AND deletionlog.primaryid IS NULL
		ORDER BY dateline DESC
		LIMIT 0, $limit
		");
		while ( $post = $DB->fetch_row() ) {
  		$title = strip_tags($post['ttitle']);
		$title = str_replace( "&#33;" , "!" ,$title );
		$title = str_replace( "&quot;", "\"", $title );

 		$date  = $mklib->create_date($post['dateline']);
		$tid = $post['threadid'];

		$mid = $post['userid'];
		$mname = $post['postusername'];
		//$testo = $post['pagetext'];
		$testo = parse_bbcode($post['pagetext'], $forum_active, 1);
		$testo = str_replace("img src=\"images/smilies", "img src=\"$mkportals->forum_url/images/smilies", $testo); 
		$fname = $post['f_title'];
		if(!$post['icona']) {
			$post['icona'] = "1";
		}
		$icona = $mkportals->forum_url."/images/icons/icon".$post['icona'].".gif";
		$out .= "
				    <table class=\"tabnews\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\">
				      <tbody>
				      <tr>
					<td class=\"tdblock\" align=\"center\" width=\"5%\">
					<img hspace=\"0\" src=\"$icona\" align=\"bottom\" border=\"0\" alt=\"\" />
					</td>
					<td class=\"tdblock\" valign=\"top\" width=\"95%\">
					<b>$fname<br /><a href=\"$mkportals->forum_url/showthread.php?t=$tid\">$title</a></b>
					</td>
				      </tr>
				      <tr>
					<td colspan=\"2\"><br />
					$testo
					</td>
				      </tr>
				      <tr>
					<td align=\"right\" colspan=\"2\">
					<br /><i>{$mklib->lang['from']}<b> <a href=\"$mkportals->forum_url/member.php?u=$mid\">$mname</a></b>, $date <a href=\"$mkportals->forum_url/showthread.php?t=$tid\"> [ {$mklib->lang['readall']} ]</a></i>
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

		if (!$mkportals->member['id']) {
			return;
		}
		$templateslist .= "<form name=\"skinlist\" action=\"post\">\n <select name=\"selectskin\" class=\"bgselect\" onchange=\"document.location.href=skinlist.selectskin.options[this.selectedIndex].value\">\n";
		$DB->query("SELECT  styleid, title from " . TABLE_PREFIX . "style WHERE userselect='1'");
		while ( $r = $DB->fetch_row() )
		{
			$selected = "";
			if ($mkportals->member['theme'] == $r['styleid']) {
				$selected = "selected=\"selected\"";
			}
			if (strlen($r['title']) > 14 ) {
				$r['title'] = substr($r['title'], 0, 14);
			}
			$templateslist .= "\n<option value=\"$mklib->siteurl/index.php?skinid={$r['styleid']}\" $selected >{$r['title']}</option>";

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
			$DB->close_db();
	 		Header("Location: $mkportals->forum_url/index.php?styleid=$skinid");
			exit;
	}

	function calendar_birth($chosen_month, $chosen_year)
 	{
		global $mkportals, $DB, $mklib, $modSettings;

		$birthdays = array();

		$DB->query("SELECT username, DAYOFMONTH(birthday_search) AS bday_day, YEAR(birthday_search) AS bday_year from " . TABLE_PREFIX . "user WHERE MONTH(birthday_search)='".$chosen_month."'");
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
		global $mkportals, $DB, $mklib;
		$events = array();
		$startt   = mktime( 0, 0, 0, $chosen_month, 1, $chosen_year);
		$endt   = mktime( 0, 0, 0, $chosen_month+1, 0, $chosen_year);

		//$today = date("d");
		//$startt  = mktime(0, 0, 0, date("m")  , date("d")-$today, date("Y"));
		//$endt  = mktime(0, 0, 0, date("m")  , date("d")+31, date("Y"));


    	$DB->query("SELECT eventid, title, dateline_from AS mmday from " . TABLE_PREFIX . "event WHERE dateline_from >='".$startt."' AND dateline_from  <= '".$endt."' AND visible = '1'");
		while ( $event = $DB->fetch_row() ) {
			$event['mday'] = intval(date("d", $event['mmday']));
       	 	$events[ $event['mday'] ][] = $event;
       	 	$entry = substr($event['title'], 0, 20);
     	 	if ( strlen($event['title']) > 20 ) {
       	     	$entry .= "...";
       	 	}
       	 	$tool_events[$event['mday']] .= $entry."<br />";
    	}

		return array($events, $tool_events, $tool_idevents);
	}
	function decodeloc($loc)
	{
		global $mkportals, $FORUM_PATH;
		$location = "portale";
		if (strpos($loc, "=blog")) {
			$location = "blog";
		}
		if (strpos($loc, "=gallery")) {
			$location = "gallery";
		}
		if (strpos($loc, "=urlobox")) {
			$location = "urlobox";
		}
		if (strpos($loc, "=downloads")) {
			$location = "downloads";
		}
		if (strpos($loc, "=news")) {
			$location = "news";
		}
		if (strpos($loc, "=topsite")) {
			$location = "topsite";
		}
		if (strpos($loc, "=chat")) {
			$location = "chat";
		}
		if (strpos($loc, "=reviews")) {
			$location = "reviews";
		}
		if (strpos($loc, $FORUM_PATH)) {
			$location = "";
		}
		return $location;
	}

	function import_css()
	{
		global $mkportals, $DB, $mklib;
		$DB->query("SELECT css from " . TABLE_PREFIX . "style where styleid = '{$mkportals->member['theme']}'");
		$r = $DB->fetch_row();
		$css2 = $r['css'];
		unset ($r);

		$pos1 = strpos($css2, "link rel");
		if ($pos1) {
			$pos1 = strpos($css2, "href=");
			$pos1 = ($pos1 +6);
			$pos2 = strpos($css2, ".css");
			$pos2 = ($pos2 +4);
			$mksub = substr($css2, ($pos1), ($pos2 - $pos1));
			$mksub = "$mkportals->forum_url/".$mksub;
			$fh = @fopen($mksub, "r");
    		if ($fh) {
       			 $css2 = fread($fh, filesize($mksub));
        		@fclose($fh);
			}
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
				$mkpsubs = preg_replace( "/margin(.*?\;)/mi", "", $mkpsubs);
				$css = preg_replace( "`(\.importbody(.*?\}))`is", $mkpsubs, $css);
			}

/*
		//importing logostrip
		$sflogo =  $mkportals->forum_url."/images/misc/sf_logo.jpg";
		if (is_file("$sflogo") ) {
			$mkpsubs = "#logostrip {background-image: url(images/misc/sf_logo.jpg); text-align: left;}";
		} else {
			$pos = strpos($css2, ".page");
			$pos2 = strpos($css2, "}", $pos);
		$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
		}
		$css = preg_replace( "`(\#importlogostrip(.*?\}))`is", $mkpsubs, $css);
*/		

		//importing logostrip
		$pos = strpos($css2, ".page");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\#importlogostrip(.*?\}))`is", $mkpsubs, $css);
			}

		//importing main table bg (if different than body bg)
		$pos = strpos($css2, ".page");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importmain(.*?\}))`is", $mkpsubs, $css);
			}

		//importing light background
		$pos = strpos($css2, ".alt1");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importlightback(.*?\}))`is", $mkpsubs, $css);
			}

		//importing medium background
		$pos = strpos($css2, ".alt2");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importmediumback(.*?\}))`is", $mkpsubs, $css);
			}

		//importing dark background
		$pos = strpos($css2, ".tcat");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importdarkback(.*?\}))`is", $mkpsubs, $css);
			}

		//importing module table headers
		$pos = strpos($css2, ".thead");
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
				$css = preg_replace( "`(\.importborders(.*?\}))`is", $mkpsubs, $css);
			}

		//importing form styles
		$pos = strpos($css2, ".bginput");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importforms(.*?\}))`is", $mkpsubs, $css);
			}

		//importing table font formatting
		$pos = strpos($css2, "td, th, p, li");
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
		$css = str_replace("url(", "url($mkportals->forum_url/", $css);
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
		$DB->query("SELECT email from " . TABLE_PREFIX . "user WHERE  usergroupid  = '6'");
		while ( $row = $DB->fetch_row() ) {
			$dest .= $row['email'].", ";
		}
		$dest=rtrim($dest, ", ");
		mail($dest, $subject, $message,  $headers);
	}



}

$mklib_board = new mklib_board;

?>
