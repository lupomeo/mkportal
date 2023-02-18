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


$limit = $this->config['news_block'];
if (!$limit) {
	$limit = 5;
}

$cont = "";
$content = "";
$link_user = $mklib_board->forum_link("profile");

$query = $DB->query( "SELECT id, titolo, icona FROM mkp_news_sections ORDER BY `id` DESC");
		while( $row = $DB->fetch_row($query) ) {
			$icona = $row['icona'];
			$idcat = $row['id'];
			$categoria[$idcat]['titolo'] = $row['titolo'];
			switch($icona) {
			case '1':
				$image = "$this->images/icona_news.gif";
    		break;
			case '2':
    			$image = "$this->images/icona_help.gif";
    			break;
			case '3':
				$image = "$this->images/icona_star.gif";
    		break;
			case '4':
				$image = "$this->images/icona_pc.gif";
    		break;
			case '5':
				$image = "$this->images/icona_world.gif";
    		break;
    		default:
    			$image = $icona;
    		break;
    		}
			$categoria[$idcat]['icona'] = $image;
		}



	$query1 = $DB->query( "SELECT id, idcategoria, idautore, titolo, autore, testo, data FROM mkp_news WHERE validate = '1' ORDER BY `id` DESC LIMIT $limit");
	while( $row = $DB->fetch_row($query1) ) {
		$idnt = $row['id'];
		$query2 = $DB->query( "SELECT id FROM mkp_news_comments where identry = '$idnt'");
		$totcomments = $DB->get_num_rows($query2);
		$id_orig_name = $row['idautore'];
		$idcategoria = $row['idcategoria'];
		$titolo = stripslashes($row['titolo']);
		$name = $row['autore'];
		$testo = stripslashes($row['testo']);
		if ($this->mkeditor == "BBCODE") {
			$testo = $this->decode_bb($testo);
			$testo = $mklib_board->decode_smilies($testo);
		}
		$sezione = $categoria[$idcategoria]['titolo'];
		$icona = $categoria[$idcategoria]['icona'];
		$cdata = $this->create_date($row['data']);
		$news_words= $this->config['news_words'];
		if ($this->config['news_html']) {
			$testo = str_replace ("<br />", " ", $testo);
			$testo = strip_tags ($testo);
   		}
		if ($news_words) {
			$testo = substr ($testo, 0, $news_words);
			$testo .= " ...";
   		}

		$cont .= "
					  <table class=\"tabnews\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\">
					    <tbody>
					    <tr>
					      <td class=\"tdblock\" align=\"center\" width=\"5%\">
					      <img hspace=\"0\" src=\"$icona\" align=\"bottom\" border=\"0\" alt=\"\" />
					      </td>
					      <td class=\"tdblock\" valign=\"top\" width=\"95%\">
					      <b>$sezione<br /><a href=\"index.php?ind=news&amp;op=news_show_single&amp;ide={$row['id']}\">$titolo</a></b>
					      </td>
					    </tr>
					    <tr>
					      <td colspan=\"2\"><br />
					      $testo
					      </td>
					    </tr>
					    <tr>
					      <td align=\"right\" colspan=\"2\">
					      <br /><i>{$this->lang['from']}<b> <a href=\"$link_user=$id_orig_name\">$name</a></b>, $cdata <a href=\"index.php?ind=news&amp;op=submit_comment&amp;idnews={$row['id']}\">{$this->lang['comments']}</a>($totcomments), <a href=\"index.php?ind=news&amp;op=news_show_single&amp;ide={$row['id']}\">{$this->lang['readall']}</a></i>
					      </td>
					    </tr>
					    </tbody>
					  </table>
		";
	}
	$content = "
				<tr>
				  <td class=\"contents\">
				  <div class=\"taburlo\">
				    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
				      <tr>
					<td class=\"taburlo\" valign=\"top\">
					{$cont}
					</td>
				      </tr>
				    </table>
				  </div>
				  </td>
			      	</tr>
				  ";

		unset($cont);
		unset($row);
		unset($icona);
		unset($idcat);
		unset($categoria);
		unset($idnt);
		unset($query);
		unset($query2);
		unset($totcomments);
		unset($id_orig_name);
		unset($idcategoria);
		unset($titolo);
		unset($name);
		unset($testo);
		unset($sezione);
		unset($icona);
		unset($cdata);
		unset($news_words);




?>
