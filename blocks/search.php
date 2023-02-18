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

$forumsearch = $mklib_board->forum_link("forumsearch");
$content = "
				<tr><td class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=search\">{$this->lang['internalpages']}</a></td></tr>
				<tr><td class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=gallery&amp;op=search\">{$this->lang['images']}</a></td></tr>
				<tr><td class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=downloads&amp;op=search\">{$this->lang['download']}</a></td></tr>
				<tr><td class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=reviews&amp;op=search\">{$this->lang['reviews']}</a></td></tr>
				<tr><td class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;&nbsp;<a class=\"uno\" href=\"$forumsearch\">{$this->lang['forum']}</a></td></tr>

				<tr>
				  <td class=\"tdblock\" align=\"center\">
				    <a href=\"http://www.google.it/\"><img src=\"$this->siteurl/mkportal/modules/search/google_logo.gif\" alt=\"Google\" align=\"top\" /></a><br />

				    <form action=\"http://www.google.com/search\" method=\"get\" target=\"blank\">	    
				    <input size=\"12\" name=\"q\" class=\"mkblkinput\" /><br />
				    <input type=\"hidden\" name=\"hl\" />
				    <input type=\"submit\" name=\"btnG\" value=\"{$this->lang['m_search']}\" />
				    </form>
				  </td>
				</tr>
";

unset ($forumsearch);


?>
