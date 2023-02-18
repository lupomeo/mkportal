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
define ( 'IN_IPB', 1 );
global $MK_BOARD;
$MK_BOARD = "IPB";

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
		
		$DB->query("UPDATE ibf_sessions SET  location ='$location'  where member_id = '$idu'");
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


		$time = (time() - 300);

		$DB->query("SELECT s.member_id, s.member_name, s.running_time, s.login_type, s.location, g.suffix, g.prefix, g.g_perm_id, m.org_perm_id
					    FROM ibf_sessions s
					     LEFT JOIN ibf_groups g ON (g.g_id=s.member_group)
					     LEFT JOIN ibf_members m on (s.member_id=m.id)
					    WHERE s.location='$location'
					    AND s.running_time > '$time'
					     ORDER BY s.running_time DESC");
			$cached = array();
			$active = array( 'guests' => 0, 'anon' => 0, 'members' => 0, 'names' => "");
			while ($result = $DB->fetch_row() ) {
				$result['g_perm_id'] = $result['org_perm_id'] ? $result['org_perm_id'] : $result['g_perm_id'];
				if ($result['member_id'] == 0) {
					$active['guests']++;
				} else {
					if (empty( $cached[ $result['member_id'] ] ) ) {
						$cached[ $result['member_id'] ] = 1;
						if ($result['login_type'] == 1) {
							if ( $mkportals->member['mgroup'] == "4") {
								$active['names'] .= "<a href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*, ";
								$active['anon']++;
							} else {
								$active['anon']++;
							}
						} else {
							$active['members']++;
							$active['names'] .= "<a href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>, ";
						}
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

 		$DB->query("SELECT typed, image from ibf_emoticons where  emo_set = 'default'");
		$countr = 0;
		if ( $DB->get_num_rows() )
		{
			while ( $r = $DB->fetch_row() )
			{
				if (strstr( $r['typed'], "&quot;" ) )
				{
					$in_delim  = "'";
					$out_delim = '"';
				}
				else
				{
					$in  = '"';
					$out = "'";
				}
				$code = stripslashes($r['typed']);
				$image = stripslashes($r['image']);
				if ($countr == 3) {
					$output .= "</tr><tr>";
					$countr = 0;
				}
				$output .= "
	  				<td width=\"50%\" align=\"center\" class=\"tdblock\" valign=\"middle\"><a href={$out}javascript:add_smilie({$in}$code{$in}){$out}><img src=\"$mklib->siteurl/$mklib->forumpath/style_emoticons/default/$image\" border=\"0\" valign=\"left\" alt=\"$image\" /></a></td>
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

		$DB->query("SELECT typed, image from ibf_emoticons where  emo_set = 'default'");
		while ( $r = $DB->fetch_row() )
		{
			$code = stripslashes($r['typed']);
			$image = stripslashes($r['image']);
			$image = "<img src=\"$mklib->siteurl/$mklib->forumpath/style_emoticons/default/$image\" border=\"0\" alt=\"\" />";
			$message = str_replace($code, $image, $message);
		}
		return $message;
	}
	function popup_pm($m1, $m2, $m3, $m4)
 	{
		global $DB, $mklib, $mkportals;

		$u1 = "$mklib->siteurl/$mklib->forumpath/index.php?act=Msg";

		$DB->query("UPDATE ibf_members SET show_popup=0 WHERE id={$mkportals->member['id']}");


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

		$DB->query( "SELECT g_id, g_title FROM ibf_groups ORDER BY `g_id`");
		while( $row = $DB->fetch_row() ) {
			if($row['g_id'] == 4) {
				continue;
			}
			$g_id= $row['g_id'];
			$g_title = $row['g_title'];
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

		$query = $DB->query( "SELECT g_title FROM ibf_groups WHERE g_id = '$g_id'");
		$row = $DB->fetch_row($query);
		$g_title = $row['g_title'];
		return $row['g_title'];

	}

	//ad_poll
	function get_poll_list()
	{
		global $mklib, $DB;

		$prefix = DBPREFIX;
		$poll_active = $mklib->config['poll_active'];
		$DB->query("SELECT pid, tid, poll_question FROM ibf_polls order by pid DESC LIMIT 30");

        if ($DB->get_num_rows()) {
    		while( $poll = $DB->fetch_row() ) {
    			$id = $poll['tid'];
    			$title = $poll['poll_question'];
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
		switch($link) {
			case 'profile':
    			$out = "{$mkportals->forum_url}/index.php?showuser";
    		break;
			case 'cpaforum':
    			$out = "{$mkportals->forum_url}/admin.php";
    		break;
			case 'cpapers':
    			$out = "{$mkportals->forum_url}/index.php?act=UserCP";
    		break;
			case 'pm':
    			$out = "{$mkportals->forum_url}/index.php?act=Msg";
    		break;
			case 'forumsearch':
    			$out = "{$mkportals->forum_url}/index.php?act=Search";
    		break;
			case 'logout':
    			$out = "{$mkportals->forum_url}/index.php?act=Login&amp;CODE=03";
    		break;
			case 'postlink':
    			$out = "{$mkportals->forum_url}/index.php?act=Login&amp;CODE=01&amp;return=$mklib->siteurl";
    		break;
			case 'postlink2':
    			$out = "name=\"LOGIN\" onsubmit=\"return ValidateForm()\"";
    		break;
			case 'register':
    			$out = "{$mkportals->forum_url}/index.php?act=Reg&amp;CODE=00";
    		break;
			case 'onlinelist':
    			$out = "{$mkportals->forum_url}/index.php?act=Online&amp;CODE=listall&amp;sort_key=click";
    		break;
			case 'login_extra':
    			$out = "<tr>
                   <td class=\"tdblock\" width=\"100%\" colspan=\"2\" align=\"left\"><b>{$mklib->lang['anon_login']}</b>&nbsp;<input type=\"checkbox\" name=\"Privacy\" value=\"1\" style=\"margin:0px;\" />
				  <input type=\"hidden\" name=\"CookieDate\" value=\"1\" />
				  </td>
				</tr>
				";
    		break;
			case 'login_user':
    			$out = "UserName";
    		break;
			case 'login_passw':
    			$out = "PassWord";
    		break;
			case 'calendar_event':
    			$out = "$mkportals->forum_url/index.php?act=calendar";
    		break;
			default:
    			$out = "n/a";
    		break;
    		}

		return $out;

	}

	function get_poll_active($tid)
 	{
		global $DB, $mklib, $mkportals;

		if (!$tid) {
            return;
        }
        if ( $mkportals->member['id'] ) {
            $extra = "LEFT JOIN ibf_voters v ON (v.member_id={$mkportals->member['id']} and v.tid=t.tid)";
            $sql   = ", v.member_id as member_voted";
        }
        $DB->query("SELECT t.tid, t.title, t.state, t.last_vote, p.* $sql
                     FROM ibf_topics t, ibf_polls p
                     $extra
                     WHERE t.tid=$tid AND p.tid=t.tid");
        $poll = $DB->fetch_row();
          if ( ! $poll['pid'] ) {
            return;
        }
          $poll['poll_question'] = $poll['poll_question'] ? $poll['poll_question'] : $poll['title'];
        if ( $poll['state'] == 'closed' ) {
            $controllo = 1;
            $poll_footer = "<tr><td>{$mklib->lang['poll_closed']}";
        }
        else if (! $mkportals->member['id'] ) {
            $controllo = 1;
            $poll_footer = "<tr><td>{$mklib->lang['poll_noallow']}";
        }
        else if ( $poll['member_voted'] ) {
            $controllo = 1;
            $poll_footer = "<tr><td>{$mklib->lang['poll_voted']}";
        }

        else {
            $controllo = 0;
            $poll_footer = "<input type=\"submit\" value=\"{$mklib->lang['poll_vote']}\" class=\"bgselect\" style=\"margin-top: 10px;\" /></form>";
        }
        if ($controllo == 1) {
            $total_votes = 0;
            $output = "            
				<tr>
				  <td class=\"tdblock\">
				  <a href=\"$mkportals->forum_url/index.php?showtopic={$poll['tid']}\">{$poll['poll_question']}</a>
				  </td>
				</tr>
            ";
            $poll_answers = unserialize(stripslashes($poll['choices']));

            reset($poll_answers);
            foreach ($poll_answers as $entry) {
                $id     = $entry[0];
                $scelta = $entry[1];
                $votes  = $entry[2];

                $total_votes += $votes;

                if ( strlen($scelta) < 1 )    {
                    continue;
                }

                $percent = $votes == 0 ? 0 : $votes / $poll['votes'] * 100;
                $percent = sprintf( '%.2f' , $percent );
                $width   = $percent > 0 ? floor( round( $percent ) * ( 122 / 100 ) ) : 0;

                $output .= "
				<tr>
				  <td class=\"tdblock\">
				  $scelta
				  </td>
				</tr>
				<tr>
				  <td align=\"left\">
				  <img src=\"$mklib->images/bar-start.gif\" border=\"0\" width=\"4\" height=\"11\" alt=\"\" /><img src=\"$mklib->images/bar.gif\" border=\"0\" width=\"$width\" height=\"11\" alt=\"\" /><img src=\"$mklib->images/bar-end.gif\" border=\"0\" width=\"4\" height=\"11\" alt=\"\" />
				  </td>
				</tr>                    
                ";
            }
        } else {
            $poll_answers = unserialize(stripslashes($poll['choices']));
            reset($poll_answers);

            $output = "            
				<tr>
				  <td class=\"tdblock\">
				  <a href=\"$mkportals->forum_url/index.php?showtopic={$poll['tid']}\">{$poll['poll_question']}</a>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\" style=\"padding: 2px\">
				    <form action=\"$mkportals->forum_url/index.php?act=Poll&amp;t=$tid\" method=\"post\">
            ";

            foreach ($poll_answers as $entry)
            {
                $id     = $entry[0];
                $scelta = $entry[1];
                $votes  = $entry[2];

                $total_votes += $votes;

                if ( strlen($scelta) < 1 )
                {
                    continue;
                }


                $output   .= "                    
				    <div style=\"margin-top: 5px;\"><input type=\"radio\" name=\"poll_vote\" value=\"$id\" class=\"bgselect\" />&nbsp;<strong>$scelta</strong></div>                    
                ";


            }

        }

         $output   .= "	                       
              $poll_footer	      
				  </td>
				</tr>
				<tr>
				  <td class=\"tdblock\">
				  <span class=\"mktxtcontr\">$total_votes</span> {$mklib->lang['poll_totalvotes']}
				  </td>
				</tr>                    
                ";
         return $output;



	}

	function get_avatar()
 	{
		global $mkportals, $DB, $mklib;



			$idu = $mkportals->member['id'];
			$DB->query("SELECT avatar_location, avatar_size, avatar_type FROM ibf_member_extra where id = '$idu'");

			$row = $DB->fetch_row($query);

			//echo "ciao".$row['avatar_location'];
			//$avatar = $std->get_avatar( $row['avatar_location'], '1', $row['avatar_size'], $row['avatar_type'] );

			if ( $row['avatar_type'] == 'local' )
			{
				$avatar = "<img src=\"$mklib->siteurl/$mklib->forumpath/style_avatars/{$row['avatar_location']}\" border=\"0\" alt=\"\" />";
			}
			if ( $row['avatar_type'] == 'url' )
			{
				$dimension = explode("x", $row['avatar_size']);
				$avatar = "<img src=\"{$row['avatar_location']}\" border=\"0\" width=\"$dimension[0]\" height=\"$dimension[1]\" alt=\"\" />";
			}
			if ( $row['avatar_type'] == 'upload' )
  			{
   				$row['avatar_location'] = str_replace("upload:", "", $row['avatar_location']);
  				$avatar = "$mklib->forumpath/uploads/{$row['avatar_location']}";
   				$dimension = explode("x", $row['avatar_size']);
   				$avatar = "<img src=\"$mklib->siteurl/$mklib->forumpath/uploads/{$row['avatar_location']}\" width=\"$dimension[0]\" height=\"$dimension[1]\" border=\"0\" alt=\"\" />";
  			}


			return $avatar;


	}

	function get_forumnav()
 	{
		global $mklib, $mkportals;
		require "$mklib->mklang/lang_global.php";


		$out = "
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_npost.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->base_url}?act=Search&amp;CODE=getnew\">{$langmk['m_newpost']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_members.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->base_url}?act=Members\">{$langmk['m_users']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_calendario.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->base_url}?act=calendar\">{$langmk['m_calendar']}</a></td></tr>
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_help.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->base_url}?act=Help\">{$langmk['m_help']}</a></td></tr>
     	 	";

		if (stristr($_SERVER['PHP_SELF'], $mklib->forumpath)) {
        	$out .= "<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$mklib->images/atb_assistant.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"javascript:buddy_pop();\" title=\"{$langmk['m_assistent']}\">{$langmk['m_assistent']}</a></td></tr>";
    	}

			//$out = "ciao {$mklib->lang['b_vusers']}";
			//$out = $mklib->lang['b_vusers'];
			return $out;


	}
	function get_site_stat()
 	{
		global $DB;

		$DB->query("SELECT cs_value FROM ibf_cache_store where cs_key = 'stats'");

		$row = $DB->fetch_row();
		$temp = unserialize(stripslashes($row['cs_value']));


		foreach ($temp as $k => $v)
        	{
        		$r[$k] = stripslashes($v);

        	}

		$stat['members'] = $r['mem_count'];
		$stat['last_member'] = $r['last_mem_id'];
		$stat['last_member_name'] = $r['last_mem_name'];
		$stat['topics'] = $r['total_topics'];
		$stat['total_posts'] = $r['total_replies']+$r['total_topics'];
		$stat['replies'] = $r['total_replies'];
		unset ($temp);
		return $stat;


	}

	function get_onlineblock()
 	{
		global $DB, $mkportals;



	$time = (time() - 900);

		$DB->query("SELECT s.member_id, s.member_name, s.running_time, s.login_type, s.location, g.suffix, g.prefix, g.g_perm_id, m.org_perm_id
					    FROM ibf_sessions s
					     LEFT JOIN ibf_groups g ON (g.g_id=s.member_group)
					     LEFT JOIN ibf_members m on (s.member_id=m.id)
					    WHERE s.running_time > '$time'
					     ORDER BY s.running_time DESC");
			$cached = array();
			$active = array( 'guests' => 0, 'anon' => 0, 'members' => 0, 'names' => "");
			while ($result = $DB->fetch_row() ) {
				$result['g_perm_id'] = $result['org_perm_id'] ? $result['org_perm_id'] : $result['g_perm_id'];
				if ($result['member_id'] == 0) {
					$active['guests']++;
				} else {
					if (empty( $cached[ $result['member_id'] ] ) ) {
						$cached[ $result['member_id'] ] = 1;
						if ($result['login_type'] == 1) {
							if ( $mkportals->member['mgroup'] == "4") {
								$active['names'] .= "<a href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*, ";
								$active['anon']++;
							} else {
								$active['anon']++;
							}
						} else {
							$active['members']++;
							$active['names'] .= "<a href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>, ";
						}
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
	$DB->query("SELECT s.id, s.member_id, s.member_name, s.login_type, s.location, g.suffix, g.prefix
                    FROM ibf_sessions s
                      LEFT JOIN ibf_groups g ON (g.g_id=s.member_group)
                    WHERE running_time > $time
                    ORDER BY s.running_time DESC");

        $cached = array();
        $online = array();
        while ($result = $DB->fetch_row() ) {
            if ( strstr( $result['id'], '_session' ) ) {
                if ( $mkportals->vars['spider_anon'] ) {
                    if ( $mkportals->member['mgroup'] == "4" ) {
						switch($result['location']) {
							case 'portale':
    							$online['portale'] .= "{$result['member_name']}*{$inter} \n";
    						break;
							case 'blog':
    							$online['blog'] .= "{$result['member_name']}*{$inter} \n";
    						break;
							case 'gallery':
    							$online['gallery'] .= "{$result['member_name']}*{$inter} \n";
    						break;
							case 'urlobox':
    							$online['urlobox'] .= "{$result['member_name']}*{$inter} \n";
    						break;
							case 'downloads':
    							$online['downloads'] .= "{$result['member_name']}*{$inter} \n";
    						break;
							case 'news':
    							$online['news'] .= "{$result['member_name']}*{$inter} \n";
    						break;
							case 'chat':
    							$online['chat'] .= "{$result['member_name']}*{$inter} \n";
    						break;
							case 'topsite':
    							$online['topsite'] .= "{$result['member_name']}*{$inter} \n";
    						break;
							case 'reviews':
    							$online['reviews'] .= "{$result['member_name']}*{$inter} \n";
    						break;
							default:
							$online['forum'] .= "{$result['member_name']}*{$inter} \n";
    						break;
						}
                    }
                } else {
					switch($result['location']) {
							case 'portale':
    							$online['portale'] .= "{$result['member_name']}{$inter} \n";
    						break;
							case 'blog':
    							$online['blog'] .= "{$result['member_name']}{$inter} \n";
    						break;
							case 'gallery':
    							$online['gallery'] .= "{$result['member_name']}{$inter} \n";
    						break;
							case 'urlobox':
    							$online['urlobox'] .= "{$result['member_name']}{$inter} \n";
    						break;
							case 'downloads':
    							$online['downloads'] .= "{$result['member_name']}{$inter} \n";
    						break;
							case 'news':
    							$online['news'] .= "{$result['member_name']}{$inter} \n";
    						break;
							case 'chat':
    							$online['chat'] .= "{$result['member_name']}{$inter} \n";
    						break;
							case 'topsite':
    							$online['topsite'] .= "{$result['member_name']}{$inter} \n";
    						break;
							case 'reviews':
    							$online['reviews'] .= "{$result['member_name']}{$inter} \n";
    						break;
							default:
							$online['forum'] .= "{$result['member_name']}{$inter} \n";
    						break;
						}
                }
            } else if ($result['member_id'] == 0 )
            {
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
            } else {
                if ( empty( $cached[ $result['member_id'] ] ) ) {
                    $cached[ $result['member_id'] ] = 1;

                    if ($result['login_type'] == 1) {
                        if ($mkportals->member['mgroup'] == 4) {

						switch($result['location']) {
							case 'portale':
    							$online['portale'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*{$inter} \n";
    						break;
							case 'blog':
    							$online['blog'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*{$inter} \n";
    						break;
							case 'gallery':
    							$online['gallery'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*{$inter} \n";
    						break;
							case 'urlobox':
    							$online['urlobox'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*{$inter} \n";
    						break;
							case 'downloads':
    							$online['downloads'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*{$inter} \n";
    						break;
							case 'news':
    							$online['news'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*{$inter} \n";
    						break;
							case 'chat':
    							$online['chat'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*{$inter} \n";
    						break;
							case 'topsite':
    							$online['topsite'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*{$inter} \n";
    						break;
							case 'reviews':
    							$online['reviews'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*{$inter} \n";
    						break;
							default:
							$online['forum'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>*{$inter} \n";
    						break;
						}
							$online['anon']++;
                        } else {
                            $online['anon']++;
                        }
                    } else {
                        $online['members']++;
						switch($result['location']) {
							case 'portale':
    							$online['portale'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>{$inter} \n";
    						break;
							case 'blog':
    							$online['blog'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>{$inter} \n";
    						break;
							case 'gallery':
    							$online['gallery'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>{$inter} \n";
    						break;
							case 'urlobox':
    							$online['urlobox'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>{$inter} \n";
    						break;
							case 'downloads':
    							$online['downloads'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>{$inter} \n";
    						break;
							case 'news':
    							$online['news'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>{$inter} \n";
    						break;
							case 'chat':
    							$online['chat'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>{$inter} \n";
    						break;
							case 'topsite':
    							$online['topsite'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>{$inter} \n";
    						break;
							case 'reviews':
    							$online['reviews'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>{$inter} \n";
    						break;
							default:
							$online['forum'] .= "<a class=\"uno\" href=\"{$mkportals->base_url}?showuser={$result['member_id']}\">{$result['prefix']}{$result['member_name']}{$result['suffix']}</a>{$inter} \n";
    						break;
						}

                    }
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

		$DB->query("SELECT id, password, permission_array FROM ibf_forums");
		while( $f = $DB->fetch_row() ) {
			$perms = unserialize(stripslashes($f['permission_array']));
			if ( $std->check_perms($perms['read_perms']) != TRUE or ($f['password'] != "" ) ) {
        		$bad[] = $f['id'];
        	}	else {
        		$good[] = $f['id'];
        	}
        }

		if ( count($bad) > 0 ) {
    		$qe = " AND forum_id NOT IN(".implode(',', $bad ).") ";
    	}

		$DB->query("SELECT tid, title, posts, starter_id as member_id, starter_name as member_name, start_date as post_date, views
 		            FROM ibf_topics
 		            WHERE state!='closed' AND approved=1 AND (moved_to IS NULL or moved_to='') $qe
 		            ORDER BY start_date DESC LIMIT 0,$limit");


		while ( $post = $DB->fetch_row() ) {
  		$title = strip_tags($post['title']);
		$title = str_replace( "&#33;" , "!" ,$title );
		$title = str_replace( "&quot;", "\"", $title );
			if (strlen($title) > $taglio) {
				$title = substr( $title,0,($taglio - 3) ) . "...";
				$title = preg_replace( '/&(#(\d+;?)?)?(\.\.\.)?$/', '...',$title );
			}

 		$date  = $mklib->create_date($post['post_date']);
		$tid = $post['tid'];

		$mid = $post['member_id'];
		$mname = $post['member_name'];

		$content .= "
				<tr>
				  <td width=\"100%\" class=\"tdblock\">
				  <a class=\"uno\" href=\"$mkportals->forum_url/index.php?showtopic=$tid\">$title</a>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\">
				  <a class=\"uno\" href=\"$mkportals->forum_url/index.php?showuser=$mid\">$by: $mname</a><br /> $sdate: $date
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

		$DB->query("SELECT id, name FROM ibf_forums WHERE parent_id > '0' order by id");

		while( $board = $DB->fetch_row() ) {
			$id = $board['id'];
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
		//$taglio = 17;
		$db_prefix = DBPREFIX;
		$forum_active = $mklib->config['forum_active'];
		if(!$forum_active) {
				return "";
		}


		$DB->query("SELECT t.*, p.*, p.icon_id as icona, f.name as forum_name, m.id as member_id, m.name as member_name
		FROM ibf_posts p
		LEFT JOIN ibf_topics t on (t.tid=p.topic_id and t.topic_firstpost=p.pid and t.approved=1 and t.moved_to IS NULL)
		LEFT JOIN ibf_members m on (p.author_id=m.id)
		LEFT JOIN ibf_forums f on (t.forum_id=f.id)
		WHERE t.forum_id = $forum_active
		GROUP BY p.topic_id
		ORDER BY t.start_date DESC
		LIMIT $limit");


		while ( $post = $DB->fetch_row() ) {
  		$title = strip_tags($post['title']);
		$title = str_replace( "&#33;" , "!" ,$title );
		$title = str_replace( "&quot;", "\"", $title );

 		$date  = $mklib->create_date($post['start_date']);
		$tid = $post['tid'];

		$mid = $post['member_id'];
		$mname = $post['member_name'];
		$testo = $post['post'];
		$testo = str_replace("style_emoticons/<#EMO_DIR#>", "$mkportals->forum_url/style_emoticons/default", $testo);
		//$testo = doUBBC($testo, "1");
		$fname = $post['forum_name'];
		if(!$post['icona']) {
			$post['icona'] = "11";
		}
		$icona = $mkportals->forum_url."/style_images/1/folder_post_icons/icon".$post['icona'].".gif";
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

	function skinselect()
 	{
		global $DB, $mklib, $mkportals, $sc;

		if (!$mkportals->member['id']) {
			return;
		}
		$templateslist .= "<form name=\"skinlist\" action=\"post\">\n <select name=\"selectskin\" class=\"bgselect\" onchange=\"document.location.href=skinlist.selectskin.options[this.selectedIndex].value\">\n";
		$DB->query("SELECT set_skin_set_id, set_name from ibf_skin_sets");
		while ( $r = $DB->fetch_row() )
		{
			if ($r['set_skin_set_id'] == "1") {
				continue;
			}
			$selected = "";
			if ($mkportals->member['theme'] == $r['set_skin_set_id']) {
				$selected = "selected=\"selected\"";
			}
			$r['set_name'] = str_replace("(Import)", "", $r['set_name']);
			if (strlen($r['set_name']) > 12 ) {
				$r['set_name'] = substr($r['set_name'], 0, 12);
			}
			$templateslist .= "\n<option value=\"$mklib->siteurl/index.php?skinid={$r['set_skin_set_id']}\" $selected >{$r['set_name']}</option>";

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

		if (!$mkportals->member['id']) {
			return;
		}
		$DB->query("SELECT  set_skin_set_id from ibf_skin_sets where set_skin_set_id = '$skinid'");
		if ($DB->fetch_row()){
			$DB->query("UPDATE ibf_members SET skin ='$skinid' where id = '{$mkportals->member['id']}'");
			$DB->close_db();
	 		Header("Location: $mkportals->forum_url/index.php");
			exit;
		}
	}

	function calendar_birth($chosen_month, $chosen_year)
 	{
		global $mkportals, $DB, $mklib;

		$birthdays = array();
		$DB->query("SELECT bday_day, bday_year, name from ibf_members WHERE bday_month='".$chosen_month."' ORDER BY lower(name) ASC");

    	while ($user = $DB->fetch_row()) {
       	 	$birthdays[ $user['bday_day'] ]++;
        	if ($birthdays[ $user['bday_day'] ] < 10) {
            	$tool_birthdays[$user['bday_day']] .=  $user['name']." (".($chosen_year - $user['bday_year']).")&nbsp;";
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

    	$DB->query("SELECT eventid, title, userid, priv_event, read_perms, mday from ibf_calendar_events WHERE month='".$chosen_month."' AND year='".$chosen_year."'");

		while ( $event = $DB->fetch_row() ) {
			if ( $event['priv_event'] == 1 ) {
        		if ($mkportals->member['id'] != $event['userid']) {
           			continue;
            	}
        	}
       		if ( $event['read_perms'] != '*' ) {
       	     	if ( ! preg_match( "/(^|,)".$mkportals->member['mgroup']."(,|$)/", $event['read_perms'] ) ) {
         	       continue;
         	   }
       	 	}
       	 	$events[ $event['mday'] ][] = $event;
       	 	$entry = substr($event['title'], 0, 20);
     	 	if ( strlen($event['title']) > 20 ) {
       	     	$entry .= "...";
       	 	}
       	 	$tool_events[$event['mday']] .= $entry."<br />";
    	}
		return array($events, $tool_events);
	}

	function import_css()
	{
		global $mkportals, $DB, $mklib;
		if ($mkportals->member['theme']) {
			$DB->query("SELECT set_image_dir, set_cache_css from ibf_skin_sets where set_skin_set_id = '{$mkportals->member['theme']}'");
		}
		else {
			$DB->query("SELECT set_image_dir, set_cache_css from ibf_skin_sets where set_default = '1'");
		}
		$r = $DB->fetch_row();
		$images_url = $r['set_image_dir'];

		$css2 = $r['set_cache_css'];
		unset ($r);
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
				$css = preg_replace( "`(\.importbody(.*?\}))`is", $mkpsubs, $css);
			}

		//importing logostrip
		$sflogo =  $mkportals->forum_url."/style_images/".$images_url."/sf_logo.jpg";
		if (is_file("$sflogo") ) {
			$mkpsubs = "#logostrip {background-image: url(style_images/".$images_url."/sf_logo.jpg); text-align: left;}";
		} else {
			$pos = strpos($css2, "#logostrip");
			$pos2 = strpos($css2, "}", $pos);
		$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
		}
		$css = preg_replace( "`(\#importlogostrip(.*?\}))`is", $mkpsubs, $css);

		/*
		//importing main table bg (if different than body bg)
		$pos = strpos($css2, "body");
		$pos2 = strpos($css2, "}", $pos);
		$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
		$css = preg_replace( "`(\.importmain(.*?\}))`is", $mkpsubs, $css);
		*/

		//importing light background
		$pos = strpos($css2, ".post1");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importlightback(.*?\}))`is", $mkpsubs, $css);
			}

		//importing medium background
		$pos = strpos($css2, ".row1");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importmediumback(.*?\}))`is", $mkpsubs, $css);
			}

		//importing dark background
		$pos = strpos($css2, ".maintitle");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importdarkback(.*?\}))`is", $mkpsubs, $css);
			}

		//importing module table headers
		$pos = strpos($css2, ".subtitle");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));
				$css = preg_replace( "`(\.importmodulex(.*?\}))`is", $mkpsubs, $css);
			}
		
		//importing borders
		$pos = strpos($css2, ".borderwrap");
		$pos2 = strpos($css2, "}", $pos);
			if ($pos) {
				$mkpsubs = substr($css2, $pos, ($pos2 - ($pos -1)));		
				$mkpsubs = preg_replace( "/back(.*?\;)/mi", "", $mkpsubs);
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
		$pos = strpos($css2, "table");
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
		$css = str_replace( "url(", "url(".$mklib->siteurl."/".$mklib->forumpath."/", $css);
		$css = str_replace( "<#IMG_DIR#>", $images_url, $css);
		//$css = str_replace ("MKPORTALIMGDIR", "$mklib->images", $css);
		$css = "<style type=\"text/css\">\n$css\n</style>\n";
		unset($css2);
		return $css;
	}

	function admin_mail($subject, $message)
 	{
		global $DB, $mklib;

		$headers = "From: webmaster@" . $mklib->sitename . "\r\n" . "Reply-To: webmaster@" . $mklib->sitename . "\r\n" . "X-Mailer: MKportal Mail";
		$dest = "";
		$DB->query("SELECT email from ibf_members WHERE mgroup = '4'");
		while ( $row = $DB->fetch_row() ) {
			$dest .= $row['email'].", ";
		}
		$dest=rtrim($dest, ", ");
		mail($dest, $subject, $message,  $headers);
	}

}

$mklib_board = new mklib_board;

?>
