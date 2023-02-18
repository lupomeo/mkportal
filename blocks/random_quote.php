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


$content = "";
$link_user = $mklib_board->forum_link("profile");

	$query = $DB->query("SELECT id FROM mkp_quotes WHERE validate = '1'");
	$count = $DB->get_num_rows ($query);
	$start	=	rand(0, ($count -1));
	$query = $DB->query("select id, author, member, member_id, quote, date_added from mkp_quotes WHERE validate = '1' LIMIT $start, 1");
       		 list ($id, $author, $member, $member_id, $quote, $date_added) = mysql_fetch_row ($query);
			 $date_added = $this->create_date($date_added, "short");
			$quote = strip_tags($quote);
            $content = "			
				<tr>
				  <td class=\"tdblock\">
				  <img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" /> {$this->lang['quoted_by']} <i><a href=\"$link_user=$member_id\" class=\"uno\">$member</a></i>{$this->lang['urlo_time']} $date_added
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\" align=\"left\">
				  <i>$quote</i><br />(<b>$author</b>)
				  </td>
				</tr>			
				";
	if(!$id) {
			$content = "
				<tr>
				  <td class=\"tdblock\" align=\"center\">
				  {$this->lang['no_quote']}
				  </td>
				</tr>			
				";
	}
	$link_user = $mklib_board->forum_link("profile");

	unset($query);
	unset($count);
	unset($start);
	unset($id);
	unset($author);
	unset($member);
	unset($member_id);
	unset($quote);
	unset($date_added);


?>
