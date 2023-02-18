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


	$query = $DB->query("SELECT id  FROM mkp_topsite WHERE validate = '1'");
	$count = $DB->get_num_rows ($query);
	$start	=	rand(0, ($count -1));
	$query = $DB->query("SELECT id, title, link, banner, banner2 FROM mkp_topsite WHERE validate = '1' LIMIT $start, 1");
	$foto = $DB->fetch_row($query);
	$id = $foto['id'];
	$title = $foto['title'];
	$link = $foto['link'];
	$banner = $foto['banner'];
	$banner2 = $foto['banner2'];

	if(!$banner2) {
		$banner2 = $banner;
	}

	$content = "
				<tr>
				  <td align=\"center\"><a href=\"$link\" target=\"_blank\"><img src=\"$banner2\" border=\"0\" width=\"120\" height=\"60\" alt=\"{$this->lang['rsite_link']}\" /></a>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdblock\" align=\"center\">$title<br />
				  </td>
				</tr>
				";




	if(!$id) {
			$content = "
				<tr>
				  <td class=\"tdblock\" align=\"center\">
				  {$this->lang['no_rsite']}
				  </td>
				</tr>
				";
	}

	if(!$mkportals->member['g_access_cp'] && !$this->member['g_access_topsite']) {
			$content = "
				<tr>
				  <td class=\"tdblock\" align=\"center\">
				  {$this->lang['rsite_noallow']}
				  </td>
				</tr>
				";
	}
	unset($query);
	unset($count);
	unset($start);
	unset($query);
	unset($foto);
	unset($id);
	unset($title);
	unset($link);
	unset($banner);
	unset($banner2);

?>
