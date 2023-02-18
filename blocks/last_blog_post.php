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


	$query = $DB->query("select id, id_blog, post from mkp_blog_post ORDER BY 'id' DESC LIMIT 1");
       		 list ($id, $idb, $post) = mysql_fetch_row ($query);
			  $post = str_replace ("<br />", " ", $post);
			  $post = $this->decode_bb($post);
			  $post = strip_tags ($post);
			  $post = stripslashes($post);
              $post = substr ($post, 0, 300);

	$query = $DB->query("select titolo from mkp_blog where id = '$idb'");
	list ($titolo) = mysql_fetch_row($query);
            $content = "
				<tr>
				  <td class=\"tdglobal\">
				  {$this->lang['blog_from']} <a href=\"$this->siteurl/index.php?ind=blog&amp;op=home&amp;idu=$idb\">$titolo</a>: <img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp; $post ...
				  <a href=\"$this->siteurl/index.php?ind=blog&amp;op=home&amp;idu=$idb\">{$this->lang['continue']}...</a>
				  </td>
				</tr>
			";
	if(!$mkportals->member['g_access_cp'] && !$this->member['g_access_blog']) {
			$content = "
				<tr>
				  <td class=\"tdblock\" align=\"center\">
				  {$this->lang['blog_noallow']}
				  </td>
				</tr>
			";
	}
	unset($post);
	unset($id);
	unset($idb);
	unset($titolo);
	unset($quey);


?>
