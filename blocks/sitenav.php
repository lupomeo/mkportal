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



			$content = "
				<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/atb_home.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php\">{$this->lang['home']}</a></td></tr>
		 ";
		$content .= "
		      		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/atb_forum.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$mkportals->base_url}\">{$this->lang['forum']}</a></td></tr>
		";
		if (!$this->config['mod_blog']) {
		$content .= "
		      		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/atb_blog.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=blog\">{$this->lang['blog']}</a></td></tr>
		";
		}
		if (!$this->config['mod_gallery']) {
		$content .= "
		      		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/atb_foto.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=gallery\">{$this->lang['gallery']}</a></td></tr>
		";
		}
		if (!$this->config['mod_urlobox']) {
		$content .= "
		      		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/atb_urlo.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=urlobox\">{$this->lang['urlobox']}</a></td></tr>
		";
		}
		if (!$this->config['mod_downloads']) {
		$content .= "
		      		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/atb_down.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=downloads\">{$this->lang['download']}</a></td></tr>
		";
		}
		if (!$this->config['mod_news']) {
		$content .= "
		      		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/atb_racconti.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=news\">{$this->lang['news']}</a></td></tr>
		";
		}
		if (!$this->config['mod_topsite']) {
		$content .= "
		      		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/atb_toplist.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=topsite\">{$this->lang['topsite']}</a></td></tr>
		";
		}
		if (!$this->config['mod_reviews']) {
		$content .= "
		      		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/atb_media.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=reviews\">{$this->lang['reviews']}</a></td></tr>
		";
		}
		if (!$this->config['mod_quote']) {
		$content .= "
		      		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/atb_quote.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=quote\">{$this->lang['quote']}</a></td></tr>
		";
		}
		if (!$this->config['mod_chat']) {
		$content .= "
		      		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/atb_chat.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->siteurl/index.php?ind=chat\" target=\"_new\">{$this->lang['chat']}</a></td></tr>
     	 	";
		}
		$query = $DB->query( "SELECT icon, title, url FROM mkp_mainlinks WHERE type = '2' ORDER BY `id`");
		while( $row = $DB->fetch_row($query) ) {
		$content .= "
		      		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"{$row['icon']}\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"{$row['url']}\">{$row['title']}</a></td></tr>
		";
		}


?>
