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
if (!defined("IN_MKP")) {
    die ("Sorry !! You cannot access this file directly.");
}
$idx = new mk_news;
class mk_news {

	var $tpl       = "";

	function mk_news() {

		global $mkportals, $mklib, $Skin, $mklib_board;

		$mklib->load_lang("lang_news.php");

		if ($mklib->config['mod_news']) {
		$message = "{$mklib->lang['ne_mnoactive']}";
			$mklib->error_page($message);
			exit;
		}
		//location
		$mklib_board->store_location("news");

    		switch($mkportals->input['op']) {
				case 'news_show_category':
    				$this->news_show_category();
    			break;
				case 'news_show_single':
    				$this->news_show_single();
    			break;
				case 'reg_data':
    				$this->reg_data();
    			break;
				case 'edit':
    				$this->edit_news();
    			break;
				case 'submit_news':
    				$this->submit_news();
    			break;
				case 'update_news':
    				$this->update_news();
    			break;
				case 'delete':
    				$this->delete_news();
    			break;
				case 'submit_comment':
    				$this->submit_comment();
    			break;
				case 'add_comment':
    				$this->add_comment();
    			break;
				case 'del_comment':
    				$this->del_comment();
    			break;
				case 'show_emoticons':
    				$this->show_emoticons();
    			break;
    			default:
    				$this->news_show();
    			break;
    		}
	}
	function news_show() {
		global $mkportals, $DB, $std, $print, $mklib, $Skin;


		$start = $mkportals->input['start'];

/*
		$query = $DB->query("SELECT id FROM mkp_news");
		$count = mysql_num_rows ($query);

		$q_page		=	$mkportals->input['st'];
		if ($q_page=="" or $q_page <= 0) {
			$q_page	=	0;
		}
		$per_page = $mklib->config['news_page'];
		if ($per_page=="" or $per_page <= 0) {
			$per_page	=	10;
		}

	    $start = $q_page;
		$show_pages = $mklib->build_pages( array( TOTAL_POSS  => $count,
							PER_PAGE    => $per_page,
							CUR_ST_VAL  => $q_page,
							L_SINGLE    => '',
							L_MULTI     => 'pagine',
						    BASE_URL    => 'index.php?ind=news',
										  )
								   );
*/
	$output = "
	<tr>
	  <td><br />
	    <table cellspacing=\"0\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td width=\"25\"><img src=\"$mklib->images/locbar.gif\" alt=\"\" /></td>
		<td width=\"60%\"><a href=\"index.php?ind=news\">{$mklib->lang[ne_mkpnews]}</a></td>
		<td class=\"modulelite\" align=\"right\">&nbsp;&nbsp;
	";
	if($mkportals->member['g_access_cp'] || $mklib->member['g_send_news']) {
		$output .= "<a href=\"index.php?ind=news&amp;op=submit_news\">[ {$mklib->lang['ne_insertn']} ]</a>&nbsp;&nbsp;";
	}
	$output .= "
		</td>
	      </tr>
	    </table>
	    <br />
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td>
		  <table class=\"modulebg\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" border=\"0\">
		    <tr>
		      <td class=\"tdblock\" width=\"100%\" height=\"25\"><img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$mklib->lang['ne_news']}</td>
		    </tr>
		    <tr>
		      <td>
			<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
			  <tr>
			    <td>
			      <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
				<tr>
				  <td>
				    <table cellspacing=\"1\" cellpadding=\"5\" width=\"100%\" border=\"0\">
				      <tr>
					<th class=\"modulex\" width=\"5%\">&nbsp;</th>
					<th class=\"modulex\" width=\"30%\" >{$mklib->lang['ne_category']}</th>
					<th class=\"modulex\" width=\"40%\">{$mklib->lang['ne_lastn']}</th>
					<th class=\"modulex\" width=\"20%\">{$mklib->lang['ne_date']}</th>
					<th class=\"modulex\" width=\"5%\" align=\"center\">{$mklib->lang['ne_numb']}</th>
				      </tr>
	";
	$query = $DB->query( "SELECT id, titolo, icona FROM mkp_news_sections ORDER BY `position`");
		while( $row = $DB->fetch_row($query) ) {
			$idcat = $row['id'];
			$titolo = $row['titolo'];
			$icona = $row['icona'];
			switch($icona) {
			case '1':
				$image = "$mklib->images/icona_news.gif";
    		break;
			case '2':
    			$image = "$mklib->images/icona_help.gif";
    			break;
			case '3':
				$image = "$mklib->images/icona_star.gif";
    		break;
			case '4':
				$image = "$mklib->images/icona_pc.gif";
    		break;
			case '5':
				$image = "$mklib->images/icona_world.gif";
    		break;
    		default:
    			$image = $icona;
    		break;
    		}
			$queryn = $DB->query( "SELECT id, titolo, data FROM mkp_news where idcategoria = '$idcat' AND validate = '1' ORDER BY 'id' DESC");
			$count = $DB->get_num_rows($queryn);
			$snew = $DB->fetch_row($queryn);
			$idnew = $snew['id'];
			$tit = stripslashes($snew['titolo']);
			$cdata = "";
			if($tit) {
				$cdata = $mklib->create_date($snew['data'], "short");
			}
			$output .= "
				      <tr>
					<td class=\"modulecell\" align=\"center\"><a href=\"index.php?ind=news&amp;op=news_show_category&amp;idc=$idcat\"><img src=\"$image\" border=\"0\" alt=\"\" /></a></td>
					<td class=\"modulecell\" ><a href=\"index.php?ind=news&amp;op=news_show_category&amp;idc=$idcat\">$titolo</a></td>
					<td class=\"modulecell\" >$tit</td>
					<td class=\"modulecell\" >$cdata</td>
					<td class=\"modulecell\" align=\"center\">$count</td>
				      </tr>
			";
	}
	$output .= "
				    </table>
				  </td>
				</tr>
			      </table>
			    </td>
			  </tr>
			</table>
		      </td>
		    </tr>
		  </table>
		</td>
	      </tr>
	    </table>
	  </td>
	</tr>

	<tr>
 	  <td>
	    <table>
	      <tr>
 		<td>
		</td>
	      </tr>
	    </table>
	  </td>
	</tr>
		
	<tr>
	  <td align=\"center\"><br /><br />
	    <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\">MKPNews - ©2004 Tutti i diritti riservati</a></div>
	  </td>
	</tr>
	";
	$blocks .= $Skin->view_block("{$mklib->lang['ne_archivie']}", $output);
	$mklib->printpage("1", "1", "{$mklib->lang['ne_archivie']}", $blocks);

 }

    function news_show_category() {
		global $mkportals, $DB, $std, $print, $mklib, $Skin, $mklib_board;

		$link_user = $mklib_board->forum_link("profile");
		$idc = $mkportals->input['idc'];
		$start = $mkportals->input['start'];
		$query = $DB->query("SELECT titolo FROM mkp_news_sections where id = '$idc'");
		$tc = $DB->fetch_row($query);
		$titolocat = $tc['titolo'];

		$query = $DB->query("SELECT id FROM mkp_news where idcategoria = '$idc'");
		$count = mysql_num_rows ($query);

		$q_page		=	$mkportals->input['st'];
		if ($q_page=="" or $q_page <= 0) {
			$q_page	=	0;
		}
		$per_page = $mklib->config['news_page'];
		if ($per_page=="" or $per_page <= 0) {
			$per_page	=	10;
		}

	    $start = $q_page;
		$show_pages = $mklib->build_pages( array( TOTAL_POSS  => $count,
							PER_PAGE    => $per_page,
							CUR_ST_VAL  => $q_page,
							L_SINGLE    => '',
							L_MULTI     => 'pagine',
						    BASE_URL    => 'index.php?ind=news&amp;op=news_show_category&amp;idc='.$idc,
										  )
								   );

	$query = $DB->query( "SELECT id, idautore, titolo, autore, testo, data FROM mkp_news where idcategoria = '$idc' AND validate = '1' ORDER BY `id` DESC LIMIT $start, $per_page");
	while( $row = $DB->fetch_row($query) ) {
		$idnt = $row['id'];
		$query1 = $DB->query( "SELECT id FROM mkp_news_comments where identry = '$idnt'");
		$totcomments = $DB->get_num_rows($query1);
		$titolo = stripslashes($row['titolo']);
		$name = $row['autore'];
		$id_orig_name = $row['idautore'];
		$cdata = $mklib->create_date($row['data']);
		$testo = stripslashes($row['testo']);
		if ($mklib->mkeditor == "BBCODE") {
			$testo = $mklib->decode_bb($testo);
			$testo = $mklib_board->decode_smilies($testo);
		}
		$news_words= $mklib->config['news_words'];
		if ($mklib->config['news_html']) {
			$testo = str_replace ("<br />", " ", $testo);
			$testo = strip_tags ($testo);
   		}
		if ($news_words) {
			$testo = substr ($testo, 0, $news_words);
			$testo = $testo." ...";
   		}
		$content .= "
		<script type=\"text/javascript\">
			function makesure2() {
			if (confirm('{$mklib->lang[ne_delneconfirm]}')) {
			return true;
			} else {
			return false;
			}
			}
			</script>
		<table class=\"tabnews\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\">
		  <tbody>
		  <tr>
		    <td class=\"tdblock\"><a class=\"mktxtcontr\" href=\"index.php?ind=news&amp;op=news_show_single&amp;ide={$row['id']}\">$titolo</a>
		    </td>		  
		";
		if($mkportals->member['g_access_cp'] || $mklib->member['g_mod_news']) {
			$content.= "
		    <td class=\"tdblock\" align=\"right\" width=\"20%\">
		      <div align=\"center\">
		      [<a href=\"index.php?ind=news&amp;op=edit&amp;idnews={$row['id']}\">{$mklib->lang['ne_modify']}</a>&nbsp;|&nbsp;<a href=\"index.php?ind=news&amp;op=delete&amp;idnews={$row['id']}\" onclick=\"return makesure2()\">{$mklib->lang['ne_delete']}</a>]
		      </div>
		    </td>
			";
		}
		$content .= "</tr>";
		$content .= "<tr><td colspan=\"2\"><br />$testo<br /><br /></td></tr>";
		$content.= "<tr><td align=\"right\" colspan=\"2\">";
		$content.= "<br /><i>{$mklib->lang['from']}<b> <a href=\"$link_user=$id_orig_name\">$name</a></b>, $cdata, <a href=\"index.php?ind=news&amp;op=submit_comment&amp;idnews={$row['id']}\">{$mklib->lang['ne_comments']}</a>($totcomments), <a href=\"index.php?ind=news&amp;op=news_show_single&amp;ide={$row['id']}\">{$mklib->lang['ne_readall']}</a></i>";
		$content .= "
		    </td>
		  </tr>
		  </tbody>
		</table>
		";
	}
	$output = "
	<tr>
	  <td><br />
	    <table cellspacing=\"0\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td width=\"25\"><img src=\"$mklib->images/locbar.gif\" alt=\"\" /></td>
		<td width=\"60%\"><a href=\"index.php?ind=news\">{$mklib->lang['ne_mkpnews']}</a>-><a href=\"#\">$titolocat</a></td>
		<td class=\"modulelite\" align=\"right\">&nbsp;&nbsp;
	";
	if($mkportals->member['g_access_cp'] || $mklib->member['g_send_news']) {
		$output .= "<a href=\"index.php?ind=news&amp;op=submit_news\">[ {$mklib->lang['ne_insertn']} ]</a>&nbsp;&nbsp;";
	}

	$output .= "
		</td>
	      </tr>
	
	      <!-- questa è la pagina di visualizzazione delle news -->
	      <tr>
		<td colspan=\"3\">
		
		  <div id=\"taburlo\">
		  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
		    <tr>
		      <td valign=\"top\">
			{$content}
		      </td>
		    </tr>
		  </table>		  
		  </div>
		  
		  &nbsp;{$show_pages}
		</td>
	      </tr>
	    </table>
	  </td>
	</tr>
	    
	<tr>
	  <td align=\"center\"><br /><br />
	    <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\">MKPNews - ©2004 Tutti i diritti riservati</a></div>
	  </td>
	</tr>	
	";
	$blocks .= $Skin->view_block("{$mklib->lang['ne_news']}", $output);
	$mklib->printpage("1", "1", "{$mklib->lang['ne_news']}", $blocks);

 }

 function news_show_single() {
		global $mkportals, $DB, $std, $print, $mklib, $Skin, $mklib_board;

		$ide = $mkportals->input['ide'];
		$link_user = $mklib_board->forum_link("profile");


	$query = $DB->query( "SELECT id, idautore, titolo, autore, testo, data FROM mkp_news where id = '$ide'");
	$query1 = $DB->query( "SELECT id, autore, testo, data FROM mkp_news_comments where identry = '$ide' ORDER BY `id` DESC");
	$totcomments = $DB->get_num_rows($query1);
	$row = $DB->fetch_row($query);
		$titolo = stripslashes($row['titolo']);
		$testo = stripslashes($row['testo']);
		if ($mklib->mkeditor == "BBCODE") {
				$testo = $mklib->decode_bb($testo);
				$testo = $mklib_board->decode_smilies($testo);
		}
		$name = $row['autore'];
		$id_orig_name = $row['idautore'];
		$cdata = $mklib->create_date($row['data']);
		$content .= "
		<script type=\"text/javascript\">
			function makesure2() {
			if (confirm('{$mklib->lang[ne_delneconfirm]}')) {
			return true;
			} else {
			return false;
			}
			}
			</script>
		<table class=\"tabnews\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\">
		  <tbody>
		    <tr>
		      <td class=\"tdblock\"><span class=\"mktxtcontr\">$titolo</span></td>
		";
		if($mkportals->member['g_access_cp'] || $mklib->member['g_mod_news']) {
			$content.= "
		      <td class=\"tdblock\" align=\"right\" width=\"20%\">
			<div align=\"center\">
			[<a href=\"index.php?ind=news&amp;op=edit&amp;idnews={$row['id']}\">{$mklib->lang['ne_modify']}</a> | <a href=\"index.php?ind=news&amp;op=delete&amp;idnews={$row['id']}\" onclick=\"return makesure2()\">{$mklib->lang['ne_delete']}</a>]
			</div>
		      </td>
			";
		}
		$content .= "</tr>";
		$content .= "<tr><td colspan=\"2\"><br />".$testo."<br /><br /></td></tr>";
		$content.= "<tr><td align=\"right\" colspan=\"2\">";
		$content.= "<br /><i>{$mklib->lang['from']}<b> <a href=\"$link_user=$id_orig_name\">$name</a></b>, $cdata, <a href=\"index.php?ind=news&amp;op=submit_comment&amp;idnews={$row['id']}\">{$mklib->lang['ne_comments']}</a>($totcomments)</i>";
		$content .= "
		    </td>
		  </tr>
		  </tbody>
		</table>
		";
	
	$content2 = "
        <tr>
        <td class=\"tdblock\" colspan=\"2\">
		{$mklib->lang['ne_comments']}

		<script type=\"text/javascript\">

			function makesure3() {
			if (confirm('{$mklib->lang[ne_delcommconf]}')) {
			return true;
			} else {
			return false;
			}
			}

			</script>
		</td>
		</tr>
		
		";
		while( $row = $DB->fetch_row($query1) ) {
			$idcomm = $row['id'];
			$autore = $row['autore'];
			$testo = stripslashes($row['testo']);
			$data = $mklib->create_date($row['data'], "short");
			$delete = "
			<a href=\"index.php?ind=news&amp;op=del_comment&amp;idcomm=$idcomm&amp;ide=$ide\" onclick=\"return makesure3()\">[ {$mklib->lang['ne_delete']} ]</a>
			";
			if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_news']) {
				$delete = "";
			}
			$content2 .= "
			<tr>
                            <td class=\"modulecell\" width=\"20%\" valign=\"top\">{$autore}<br />{$data}<br />{$delete}</td>
                            <td class=\"modulecell\" width=\"80%\" valign=\"middle\">{$testo}</td>
			</tr>
			";
		}
	$output = "
	<tr>
	  <td><br />
	    <table cellspacing=\"0\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td width=\"25\"><img src=\"$mklib->images/locbar.gif\" alt=\"\" /></td>
		<td width=\"60%\"><a href=\"index.php?ind=news\">{$mklib->lang['ne_mkpnews']}</a>-><a href=\"#\">$titolo</a></td>
		<td class=\"modulelite\" align=\"right\">&nbsp;&nbsp;
	";
	if($mkportals->member['g_access_cp'] || $mklib->member['g_send_news']) {
		$output .= "<a href=\"index.php?ind=news&amp;op=submit_news\">[ {$mklib->lang['ne_insertn']} ]</a>&nbsp;&nbsp;";
	}

	$output .= "
		</td>
	      </tr>
	      <!-- questa è la pagina di visualizzazione delle news -->
	      <tr>
		<td colspan=\"3\">
		
		  <div class=\"taburlo\">
		  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
		    <tr>
		      <td valign=\"top\">
			{$content}
		      </td>
		    </tr>
		    <tr>
		      <td>
			<table class=\"moduleborder\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
			{$content2}
			</table>
		      </td>
		    </tr>
		  </table>
		  </div>
		
		</td>
	      </tr>
	    </table>
	  </td>
	</tr>
		
	<tr>
	  <td align=\"center\"><br /><br />
	    <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\">MKPNews - ©2004 Tutti i diritti riservati</a></div>
	  </td>
	</tr>	
	";
	$blocks .= $Skin->view_block("{$mklib->lang['ne_news']}", $output);
	$mklib->printpage("1", "1", "{$mklib->lang['ne_news']}", $blocks);

 }

 	function submit_news() {
		global $mkportals, $DB, $mklib, $Skin, $editorscript;

		$editorscript = 1;
		$textarepar = "mce_editable=\"true\"";
		$textarew = "100%";
		$bbeditor= "";
		if ($mklib->mkeditor == "BBCODE") {
			$editorscript = "";
			$textarepar = "";
			$textarew = "75%";
			$bbeditor= $mklib->get_bbeditor();
		}

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_news']) {
			$message = "{$mklib->lang[ne_noautsendn]}";
			$mklib->error_page($message);
			exit;
		}
		$query = $DB->query( "SELECT id, titolo FROM mkp_news_sections ORDER BY `id`");
		while( $row = $DB->fetch_row($query) ) {
			$idevento = $row['id'];
			$evento = $row['titolo'];
			$cselect.= "<option value=\"$idevento\">$evento</option>\n";
		}
		$content = "
		<tr>
		  <td>
		    <form action=\"index.php?ind=news&amp;op=reg_data\" method=\"post\" class=\"editor\" name=\"editor\">
		    <table width=\"100%\">
		      <tr>
			<td class=\"tdblock\">
			{$mklib->lang[ne_title]}: <input type=\"text\" name=\"titlepage\"  size=\"40\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\">
			{$mklib->lang[ne_category]}: <select name=\"categoria\" size=\"1\" class=\"bgselect\">
			{$cselect}
			</select>
			</td>
		      </tr>
		      <tr>
   			<td class=\"tdblock\" valign=\"top\">
			$bbeditor
 			<textarea id=\"ta\" name=\"ta\" $textarepar style=\"width: $textarew\" rows=\"14\" cols=\"40\"></textarea>
			</td>
		      </tr>
		      <tr>
			<td>
			  <div align=\"left\">
			  <input type=\"submit\" name=\"ok\" value=\"{$mklib->lang[ne_save]}\" />
			  </div>		
			</td>
		      </tr>
		    </table>
		    </form>
		  </td>
		</tr>

	";
		$blocks = $Skin->view_block("{$mklib->lang[ne_insertn]}", $content);
		$mklib->printpage("1", "1", "{$mklib->lang[ne_insertn]}", $blocks);
	}
	function reg_data() {
    	global $mkportals, $DB, $std, $print, $mklib, $mklib_board;

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_news']) {
			$message = "{$mklib->lang[ne_noautsendn]}";
			$mklib->error_page($message);
			exit;
		}

		if (!$mkportals->input['ta']) {
			$message = "{$mklib->lang[ne_inserttx]}";
			$mklib->error_page($message);
			exit;
		}
		if (!$mkportals->input['titlepage']) {
			$message = "{$mklib->lang[ne_insterttit]}";
			$mklib->error_page($message);
			exit;
		}
		if (!$mkportals->input['categoria']) {
			$message = "{$mklib->lang[ne_createcat]}";
			$mklib->error_page($message);
			exit;
		}
		$idaut = $mkportals->member['id'];
		$categoria= $mkportals->input['categoria'];
		$testo = $_POST['ta'];
		$autore = $mkportals->member['name'];
		$titolo = $_POST['titlepage'];
		$testo = addslashes($testo);
		$titolo = addslashes($titolo);
		$cdata = time();

		$validat = "1";
		$approval = $mklib->config['approval_news'];
		if ($approval == "2" || $approval == "3") {
			$validat = 0;
		}
		if($mkportals->member['g_access_cp']) {
			$validat = "1";
		}

		$query="INSERT INTO mkp_news(idcategoria, idautore, titolo, autore, testo, data, validate)VALUES('$categoria', '$idaut', '$titolo', '$autore', '$testo', '$cdata', '$validat')";
		$DB->query($query);
		
		if ($approval == "1") {
			$mailsubj = $mklib->lang['01mail'].$mklib->lang['news'];
			$mailmess = $mklib->lang['02mail'].$mklib->lang['module'].$mklib->lang['news']."\n".$mklib->lang['sender'].$autore."\n\n\n".$mklib->lang['from']." ".$mklib->sitename;
			$mklib_board->admin_mail($mailsubj, $mailmess);
		}
		if ($approval == "2") {
			$mailsubj = $mklib->lang['01mail'].$mklib->lang['news'];
			$mailmess = $mklib->lang['03mail'].$mklib->lang['module'].$mklib->lang['news']."\n".$mklib->lang['sender'].$autore."\n\n\n".$mklib->lang['from']." ".$mklib->sitename;
			$mklib_board->admin_mail($mailsubj, $mailmess);
		}
		$DB->close_db();
	 	Header("Location: index.php?ind=news&op=news_show_category&idc=$categoria");
		exit;
  }
  function edit_news() {
		global $mkportals, $DB, $mklib, $Skin, $editorscript;
		$editorscript = 1;
		$textarepar = "mce_editable=\"true\"";
		$textarew = "100%";
		$bbeditor= "";
		if ($mklib->mkeditor == "BBCODE") {
			$editorscript = "";
			$textarepar = "";
			$textarew = "75%";
			$bbeditor= $mklib->get_bbeditor();
		}

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_news']) {
			$message = "{$mklib->lang[ne_noautmodn]}";
			$mklib->error_page($message);
			exit;
		}
		$idnews = $mkportals->input['idnews'];
		$query = $DB->query( "SELECT idcategoria, titolo, testo FROM mkp_news where id = '$idnews'");
		$row = $DB->fetch_row($query);
		$idcategoria = $row['idcategoria'];
		$titolo = stripslashes($row['titolo']);
		$testo = stripslashes($row['testo']);
		$query = $DB->query( "SELECT id, titolo FROM mkp_news_sections ORDER BY `id` DESC");
		while( $row = mysql_fetch_array($query) ) {
			$idevento = $row['id'];
			$evento = $row['titolo'];
			$selected = "";
			if($idevento == $idcategoria) {
				$selected = "selected=\"selected\"";
			}
			$cselect.= "<option value=\"$idevento\" $selected>$evento</option>\n";
		}
		$content = "
		<tr>
		  <td>
		    <form action=\"index.php?ind=news&amp;op=update_news&amp;idnews=$idnews\" method=\"post\" class=\"editor\" name=\"editor\">
		    <table width=\"100%\">
		      <tr>
			<td class=\"tdblock\">
			{$mklib->lang[ne_title]}:<input type=\"text\" name=\"titlepage\" value=\"$titolo\" size=\"40\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\">
			  {$mklib->lang[ne_category]}: <select name=\"categoria\" size=\"1\" class=\"bgselect\">
			  {$cselect}
			  </select>
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\">
			$bbeditor
 			<textarea id=\"ta\" name=\"ta\" $textarepar style=\"width: $textarew\" rows=\"14\" cols=\"40\">$testo</textarea>
			</td>
		      </tr>
		      <tr>
			<td>
			  <div align=\"left\">
			  <input type=\"submit\" name=\"ok\" value=\"{$mklib->lang[ne_save]}\" />
			  </div>		  
			</td>
		      </tr>
		    </table>
		    </form>
		  </td>
		</tr>
	";
		$blocks = $Skin->view_block("{$mklib->lang[ne_editn]}", $content);
		$mklib->printpage("1", "1", "{$mklib->lang[ne_modifyn]}", $blocks);
	}

	function update_news() {
    		global $mkportals, $DB, $std, $print, $mklib;

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_news']) {
			$message = "{$mklib->lang[ne_noautmodn]}";
			$mklib->error_page($message);
			exit;
		}

		if (!$mkportals->input['ta']) {
			$message = "{$mklib->lang[ne_inserttx]}";
			$mklib->error_page($message);
			exit;
		}
		if (!$mkportals->input['titlepage']) {
			$message = "{$mklib->lang[ne_inserttit]}";
			$mklib->error_page($message);
			exit;
		}
		if (!$mkportals->input['categoria']) {
			echo "{$mklib->lang[ne_createcat]}";
			exit;
		}
		$categoria= $mkportals->input['categoria'];
		$testo = $_POST['ta'];
		$titolo = $_POST['titlepage'];
		$testo = addslashes($testo);
		$titolo = addslashes($titolo);
		$idnews = $mkportals->input['idnews'];

		$DB->query("UPDATE mkp_news SET idcategoria = '$categoria', titolo ='$titolo', testo='$testo' WHERE id='$idnews'");
		$DB->close_db();
	 	Header("Location: index.php?ind=news&op=news_show_category&idc=$categoria");
		exit;
  }

  function delete_news() {
    		global $mkportals, $DB, $std, $mklib;

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_news']) {
			$message = "{$mklib->lang[ne_noautdeln]}";
			$mklib->error_page($message);
			exit;
		}

		$idnews = $mkportals->input['idnews'];

		$DB->query("DELETE FROM mkp_news WHERE id = $idnews");
		$DB->close_db();
	 	Header("Location: index.php?ind=news");
		exit;
	}
	function submit_comment() {
		global $mkportals, $mklib, $Skin, $DB;
		$ide= $mkportals->input['idnews'];
		$query = $DB->query( "SELECT titolo FROM mkp_news where id = '$ide'");
		$row = $DB->fetch_row($query);
		$content = "		
		<tr>
		  <td>

		    <script type=\"text/javascript\">
		    function emo_pop()
		    {
			  window.open('{$mkportals->base_url}act=legends&amp;CODE=emoticons&amp;s={$mkportals->session_id}','Legends','width=250,height=500,resizable=yes,scrollbars=yes');
		    }
		    </script>
		
		    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">

		      <tr>
			<td>
			  <table class=\"modulebg\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" border=\"0\">
			    <tr>
			      <td class=\"tdblock\" width=\"100%\" height=\"25\"><img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$mklib->lang['ne_commentnew']} <i>{$row['titolo']}</i></td>
			    </tr>
			    <tr>
			      <td>
			    
				<form action=\"index.php?ind=news&amp;op=add_comment\" name=\"editor\" method=\"post\" >
				<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"8\">		
				  <tr>
				    <td rowspan=\"3\" align=\"center\" height=\"100%\">
				      <input type=\"hidden\" name=\"ide\" value=\"$ide\" />
				      <iframe src=\"index.php?ind=news&amp;op=show_emoticons\" frameborder=\"0\" width=\"200\" align=\"middle\" height=\"200\" scrolling=\"auto\"></iframe>
				    </td>
				    <td>{$mklib->lang['ne_writecomm']}</td>
				  </tr>
				  <tr>
				    <td width=\"70%\" align=\"left\">
				      <textarea cols=\"10\" style=\"width:95%\" rows=\"4\" name=\"ta\"></textarea>
				    </td>
				  </tr>
				  <tr>
				    <td>
				      <input type=\"submit\" name=\"submit\" value=\"{$mklib->lang['ne_sendcomm']}\" class=\"button2\" accesskey=\"s\" /><br />
				    </td>
				  </tr>		
				</table>
				</form>
			      
			      </td>
			    </tr>
			  </table>
			</td>
		      </tr>
		    </table>
		  </td>
		</tr>
	";
	$blocks = $Skin->view_block("{$mklib->lang['ne_addcomment']}", $content);
	$mklib->printpage("1", "1", "{$mklib->lang['ne_addcomment']}", $blocks);
	}

	function add_comment() {
    	global $mkportals, $DB, $mklib, $mklib_board;
		$ide = $mkportals->input['ide'];
		$testo = $mkportals->input['ta'];
		$autore = $mkportals->member['name'];
		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_comments']) {
			$message = "{$mklib->lang['ne_nosendcom']}";
			$mklib->error_page($message);
			exit;
		}
        $cdata = time();
		if (!$testo) {
			$message = "{$mklib->lang['ga_inserttx']}";
			$mklib->error_page($message);
			exit;
		}
		$testo = $mklib_board->decode_smilies($testo);
		//$testo = addslashes($testo);
		$query="INSERT INTO mkp_news_comments(identry, autore, testo, data)VALUES('$ide', '$autore', '$testo', '$cdata')";
		$DB->query($query);
		$DB->close_db();
	 	Header("Location: index.php?ind=news&op=news_show_single&ide=$ide");
		exit;
  	}
	function del_comment() {
    	global $mkportals, $DB, $mklib;

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_news']) {
			$message = "{$mklib->lang['ne_nodelcomm']}";
			$mklib->error_page($message);
			exit;
		}

		$ide= $mkportals->input['ide'];
		$idcomm= $mkportals->input['idcomm'];
		$DB->query("DELETE FROM mkp_news_comments WHERE id = $idcomm");
		$DB->close_db();
	 	Header("Location: index.php?ind=news&op=news_show_single&ide=$ide");
		exit;
  	}

	function show_emoticons()
 	{
		global $mklib_board;
		$mklib_board->show_emoticons();
 	}


}
?>
