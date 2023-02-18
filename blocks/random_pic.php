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


	$query = $DB->query("SELECT id  FROM mkp_gallery");
	$count = $DB->get_num_rows ($query);
	$start	=	rand(0, ($count -1));
	$query = $DB->query("SELECT id, titolo, file FROM mkp_gallery where validate = '1' LIMIT $start, 1");
	$foto = $DB->fetch_row($query);
	$id = $foto['id'];
	$titolo = $foto['titolo'];
	$file = $foto['file'];
	$thumb = "t_$file";


	if (!file_exists("$this->sitepath/mkportal/modules/gallery/album/$thumb")) {
  		$thumb_mes = $this->ResizeImage(120,"$this->sitepath/mkportal/modules/gallery/album/$file");
		$content = "
				<tr>
				  <td align=\"center\"><a href=\"$this->siteurl/index.php?ind=gallery&amp;op=foto_show&amp;ida=$id\"><img src=\"$this->siteurl/mkportal/modules/gallery/album/$file\" border=\"0\" width=\"$thumb_mes[0]\" height=\"$thumb_mes[1]\" alt=\"{$this->lang['gallery_zoom']}\" /></a>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdblock\" align=\"center\">$titolo<br />
				  </td>
				</tr>
				";
	} else {
		$content = "
				<tr>
				  <td align=\"center\"><a href=\"$this->siteurl/index.php?ind=gallery&amp;op=foto_show&amp;ida=$id\"><img src=\"$this->siteurl/mkportal/modules/gallery/album/$thumb\" border=\"0\" alt=\"{$this->lang['gallery_zoom']}\" /></a>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdblock\" align=\"center\">$titolo<br />
				  </td>
				</tr>
				";
	}

	if(!$id) {
			$content = "
				<tr>
				  <td class=\"tdblock\" align=\"center\">
				  {$this->lang['no_galleryim']}
				  </td>
				</tr>
				";
	}

	if(!$mkportals->member['g_access_cp'] && !$this->member['g_access_gallery']) {
			$content = "
				<tr>
				  <td class=\"tdblock\" align=\"center\">
				  {$this->lang['gallery_noallow']}
				  </td>
				</tr>
				";
	}

	unset($query);
	unset($count);
	unset($start);
	unset($foto);
	unset($id);
	unset($titolo);
	unset($file);
	unset($thumb);

?>
