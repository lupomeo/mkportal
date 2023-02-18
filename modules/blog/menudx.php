<?
/*
+--------------------------------------------------------------------------
|   MkPortal
|   ========================================
|   by Meo <Amedeo de longis>
|      Kim <Monica Vecchi>
|   (c) 2003 - 2004 mkportal.it
|   http://www.mkportal.it
|   Email: luponero@mclink.it kimera@coccomeo.net
|
+---------------------------------------------------------------------------
|
|   > MKPortal
|   > Written By Amedeo de longis & Monica Vecchi
|   > Date started: 9.2.2004
|
+--------------------------------------------------------------------------
*/

$this->load_lang("lang_blogmenudx.php");

$queryb = $DB->query("SELECT id FROM mkp_blog");
	$countblog = $DB->get_num_rows($queryb);
	$queryb = $DB->query("SELECT id FROM mkp_blog_post");
	$countpost = $DB->get_num_rows($queryb);
	$queryb = $DB->query("SELECT id FROM mkp_blog_commenti");
	$countcomm = $DB->get_num_rows($queryb);

$contentdx = "
				  <tr>
				    <td class=\"tdblock\">
				      <span class=\"mktxtcontr\">$countblog</span> <b>{$this->lang['mb_blog']}</b>:
				    </td>
				  </tr>
				  <tr>
				    <td class=\"tdglobal\">
				    {$this->lang['mb_usercreated']}<br />
				  </td>
				</tr>
				<tr>
				  <td class=\"tdblock\">
				  <span class=\"mktxtcontr\">$countpost</span> <b>{$this->lang['mb_msgs']}</b>:
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\">
				  {$this->lang['mb_userwrite']}<br />
				  </td>
				</tr>
				<tr>
				  <td class=\"tdblock\">
				  <span class=\"mktxtcontr\">$countcomm</span> <b>{$this->lang['mb_comments']}</b>:
				  </td>
				</tr>
				<tr>
				  <td class=\"tdglobal\">
				  {$this->lang['mb_msgwrite']}<br />
				  </td>
				</tr>
     	 	";
	$menudx .= $Skin->view_block("{$this->lang['mb_stats']}", $contentdx);

	$content = "";
	$file = $this->sitepath."mkportal/blocks/login.php";
	@require $file;
	$menudx .= $Skin->view_block("{$this->lang['mb_personalm']}", $content);

$contentdx = "";

          $query = mysql_query("select id, id_blog, post from mkp_blog_post ORDER BY 'id' DESC LIMIT 10");
       		 while (list ($id, $idb, $post) = mysql_fetch_row ($query)) {
			  $post = str_replace ("<br />", " ", $post);
			  $post = $this->decode_bb($post);
			  $post = strip_tags ($post);
			  $post = stripslashes($post);
              $post = substr ($post, 0, 80);
			   $post = wordwrap($post, 20, "\n", 1);
            $contentdx .= "
				<tr>
				  <td class=\"tdglobal\">
				  <img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;$post ...
				  </td>
				</tr>
				<tr>
				  <td class=\"tdblock\">
				  <a href=\"$this->siteurl/index.php?ind=blog&amp;op=home&amp;idu=$idb\">{$this->lang['mb_continued']}...</a>
				  </td>
				</tr>
			";
        	}
	$menudx .= $Skin->view_block("{$this->lang['mb_precents']}", $contentdx);

	$contentdx = "";
	 $query = mysql_query("select id_blog, post, ncom from mkp_blog_post ORDER BY 'ncom' DESC LIMIT 10");
       		 while (list ($idb, $post, $ncom) = mysql_fetch_row ($query)) {
			  $post = str_replace ("<br />", " ", $post);
			  $post = $this->decode_bb($post);
			  $post = strip_tags ($post);
			  $post = stripslashes($post);
              $post = substr ($post, 0, 80);
			  $post = wordwrap($post, 20, "\n", 1);
            $contentdx .= "
				<tr>
				  <td class=\"tdglobal\">
				  <img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;$post ...
				  </td>
				</tr>
				<tr>
				  <td class=\"tdblock\">
				  <span class=\"mktxtcontr\">$ncom</span> {$this->lang['mb_comments']}&nbsp;<a href=\"$this->siteurl/index.php?ind=blog&amp;op=home&amp;idu=$idb\">>...</a>
				  </td>
				</tr>
			";
        	}
	$menudx .= $Skin->view_block("{$this->lang['mb_pcomments']}", $contentdx);

?>
