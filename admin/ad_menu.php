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

$menu = $Skin->view_block("{$this->lang['ad_mgeneral']}", "<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"mktxtcontr\" href=\"$this->siteurl/index.php\">
		{$this->lang['portal_home']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php\">
		{$this->lang['ad_preferences']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_perms\">
		{$this->lang['ad_mperm']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_approvals\">
		{$this->lang['ad_apprmenu']}</a></td></tr>");
$menu .= $Skin->view_block("{$this->lang['ad_mblocks']}", "
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_blocks\">
		{$this->lang['ad_mposition']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_blocks&amp;op=blocks_list\">
		{$this->lang['ad_mmanage']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_blocks&amp;op=blocks_main_new\">
		{$this->lang['ad_mcreation']}</a></td></tr>");
$menu .= $Skin->view_block("{$this->lang['ad_mcont']}", "<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_contents\">
		{$this->lang['ad_mmanage']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_contents&amp;op=contents_new\">
		{$this->lang['ad_mcreation']}</a></td></tr>");
$menu .= $Skin->view_block("{$this->lang['ad_mmod']}", "<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_news\">
		{$this->lang['news']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_boardnews\">
		{$this->lang['ad_bnews']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_blog\">
  		{$this->lang['blog']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_chat\">
		{$this->lang['chat']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_urlo\">
		{$this->lang['urlobox']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_gallery\">
		{$this->lang['gallery']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_download\">
		{$this->lang['download']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_topsite\">
		{$this->lang['topsite']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_poll\">
		{$this->lang['ad_mpoll']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_review\">
		{$this->lang['ad_review']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_quote\">
		{$this->lang['ad_quote']}</a></td></tr>
		");
$menu .= $Skin->view_block("{$this->lang['ad_skin']}", "<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_skin\">
		{$this->lang['ad_skinm']}</a></td></tr>");
$menu .= $Skin->view_block("{$this->lang['ad_navl']}", "<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_nav\">
		{$this->lang['ad_navlbar']}</a></td></tr>
		<tr><td width=\"100%\" class=\"tdblock\"><img src=\"$this->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php?ind=ad_nav&amp;op=menu\">
		{$this->lang['ad_navlmenu']}</a></td></tr>");

?>
