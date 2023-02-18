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

$idx = new mk_downloads;
class mk_downloads {

	var $tpl       = "";

	function mk_downloads() {

		global $mkportals, $mklib,  $Skin, $DB, $mklib_board;
/*
$message = "Download Area in maintenance";
$mklib->error_page($message);
exit;
*/

		$mklib->load_lang("lang_download.php");

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_access_download']) {
			$message = "{$mklib->lang['dw_unauth']}";
			$mklib->error_page($message);
			exit;
		}

		//location
		$mklib_board->store_location("downloads");

		if ($mklib->config['mod_downloads']) {
		$message = "{$mklib->lang['dw_mnoactive']}";
			$mklib->error_page($message);
			exit;
		}

		require "mkportal/modules/downloads/tpl_downloads.php";
		$this->tpl = new tpl_downloads();

    		switch($mkportals->input['op']) {
    			case 'section_view':
    				$this->section_view();
    			break;
			case 'submit_file':
    				$this->submit_file();
    			break;
			case 'add_file':
    				$this->add_file();
    			break;
			case 'edit_file':
    				$this->edit_file();
    			break;
			case 'update_file':
    				$this->update_file();
    			break;
			case 'del_file':
    				$this->del_file();
    			break;
			case 'entry_view':
    				$this->entry_view();
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
			case 'download_file':
    				$this->download_file();
    			break;
			case 'submit_rate':
    				$this->submit_rate();
    			break;
			case 'add_rate':
    				$this->add_rate();
    			break;
			case 'search':
    				$this->search();
    			break;
			case 'result_search':
    				$this->result_search();
    			break;
			case 'show_emoticons':
    				$this->show_emoticons();
    			break;
				default:
    				$this->downloads_show();
    			break;
    		}
	}

	function downloads_show() {
    global $mkportals, $DB, $mklib, $Skin, $mklib_board;

	$navbar = "<a href=\"index.php?ind=downloads\">{$mklib->lang['dw_ptitle2']}</a>";
	$maintit = "Downloads";
	$content = $this->tpl->row_main_category();
	switch($mkportals->input['order']) {
		case '2':
			$order = "ORDER BY `evento`";
    	break;
		case '3':
			$order = "ORDER BY `id` DESC";
    	break;
		default:
    		$order = "ORDER BY `position`";
    	break;
	}
	//pagine
	$query = $DB->query( "SELECT id FROM mkp_download_sections WHERE father = '0'");
	$countpage = mysql_num_rows ($query);
	$per_page = $mklib->config['download_sec_page'];
	if ($per_page=="" or $per_page <= 0) {
			$per_page	=	10;
	}

	$start = $mkportals->input['start'];
	$q_page		=	$mkportals->input['st'];
		if ($q_page=="" or $q_page <= 0) {
			$q_page	=	0;
		}
	$start = $q_page;
	$show_pages = $mklib->build_pages( array( TOTAL_POSS  => $countpage,
							PER_PAGE    => $per_page,
							CUR_ST_VAL  => $q_page,
							L_SINGLE    => '',
							L_MULTI     => 'pagine',
						    BASE_URL    => 'index.php?ind=downloads&amp;order='.$mkportals->input['order'],
										  )
	);
	$query = $DB->query( "SELECT id, evento, descrizione, position FROM mkp_download_sections  WHERE father = '0'  $order LIMIT $start, $per_page");
    while( $row = $DB->fetch_row($query) ) {
		$count = 0;
		$idevento = $row['id'];
		$evento = $row['evento'];
		$descrizione = $row['descrizione'];
		$query1 = $DB->query("SELECT id FROM mkp_download_sections  WHERE father = '$idevento' ORDER BY `id`");
		$countsub = $DB->get_num_rows($query1);
		while( $row1 = $DB->fetch_row($query1) ) {
			$idce = $row1['id'];
			$query2 = $DB->query("SELECT name FROM mkp_download where idcategoria = '$idce' AND validate = '1' ORDER BY `id` DESC");
			$count = $count + $DB->get_num_rows($query2);
			$entry2 = $DB->fetch_row($query2);
		}
		$query1 = $DB->query("SELECT name FROM mkp_download where idcategoria = '$idevento' AND validate = '1' ORDER BY `id` DESC");
		$entry = $DB->fetch_row($query1);
		$lastentry = $entry['name'];
		if(!$lastentry) {
			$lastentry = $entry2['name'];
		}
		$count = $count + $DB->get_num_rows($query1);
		$name ="<a href=\"index.php?ind=downloads&amp;op=section_view&amp;idev=$idevento\">$evento</a>";
		$link = "<a href=\"index.php?ind=downloads&amp;op=section_view&amp;idev=$idevento\"><img src=\"$mklib->images/category.gif\" border=\"0\" alt=\"\" /></a>";
		$content .= $this->tpl->row_main_category_content($name, $descrizione, $count, $lastentry, $link, $countsub);
	}
	$submit = " <a href=\"index.php?ind=downloads&amp;op=submit_file\">[ {$mklib->lang['dw_send']} ]</a> ";
	if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_download']) {
			$submit ="";
	}
	$stat = $this->retrieve_stat();
	$jump1 = $this->row_select_event("1");
	$jump = "
	<select name=\"jumpsection\" size=\"1\" onchange=\"selChd(this)\" class=\"bgselect\">
       	$jump1
	</select>
	 ";
	 $sort = "
	<select name=\"order\" size=\"1\" onchange=\"selChoc(this)\" class=\"bgselect\">
	  <option value=\"0\">{$mklib->lang['dw_order']}</option>\n
	  <option value=\"1\">{$mklib->lang['dw_ordpos']}</option>\n
	  <option value=\"2\">{$mklib->lang['dw_ordnamec']}</option>\n
	  <option value=\"3\">{$mklib->lang['dw_ordcrea']}</option>\n
      	</select>
	 ";
	$toolbar = $this->tpl->row_toolbar($jump, $sort);
	$utonline = $mklib_board->get_active_users("downloads");
	$output  = $this->tpl->downloads_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
	$blocks = $Skin->view_block("{$mklib->lang['dw_pagetitle']}", $output);
	$mklib->printpage("1", "1", "{$mklib->lang['dw_pagetitle']}", $blocks);
	}

	function section_view() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;
		$content = "";
		$idev = $mkportals->input['idev'];
		$even = $this->retrieve_event($idev);
		$navbar = "<a href=\"index.php?ind=downloads\">{$mklib->lang['dw_ptitle2']}</a>";
		$navfather = $this->retrieve_father($idev);
		if($navfather[1]) {
			$navbar .= "-><a href=\"index.php?ind=downloads&amp;op=section_view&amp;idev=$navfather[0]\">$navfather[1]</a>";
		}
		$navbar .= "-><a href=\"#\">$even</a>";
		$maintit = $even;
// prova
		$query = $DB->query( "SELECT id, evento, descrizione, position FROM mkp_download_sections  WHERE father = '$idev'  ORDER by 'position'");
		$cecksub = mysql_num_rows ($query);
		if($cecksub) {
			$content = $this->tpl->row_main_category();
			while( $row = $DB->fetch_row($query) ) {
			$idevento = $row['id'];
			$query1 = $DB->query("SELECT id FROM mkp_download_sections  WHERE father = '$idevento'");
			$countsub = $DB->get_num_rows($query1);
			$evento = $row['evento'];
			$descrizione = $row['descrizione'];
			$query1 = $DB->query("SELECT name FROM mkp_download where idcategoria = $idevento AND validate = '1' ORDER BY `id` DESC");
			$entry = $DB->fetch_row($query1);
			$lastentry = $entry['name'];
			$count = $DB->get_num_rows($query1);
			$name ="<a href=\"index.php?ind=downloads&amp;op=section_view&amp;idev=$idevento\">$evento</a>";
			$link = "<a href=\"index.php?ind=downloads&amp;op=section_view&amp;idev=$idevento\"><img src=\"$mklib->images/category.gif\" border=\"0\" alt=\"\" /></a>";
			$content .= $this->tpl->row_main_category_content($name, $descrizione, $count, $lastentry, $link, $countsub);
			}
		}

//fine prova

		switch($mkportals->input['order']) {
		case '1':
			$order = "ORDER BY `name`";
    	break;
		default:
    		$order = "ORDER BY `id` DESC";
    	break;
		}
		//pagine
		$query = $DB->query( "SELECT id FROM mkp_download where idcategoria = '$idev' AND validate = '1'");
		$countpage = mysql_num_rows ($query);

		if($countpage) {
			$content .= $this->tpl->row_main_entries();
		}

		$per_page = $mklib->config['download_file_page'];
		if ($per_page=="" or $per_page <= 0) {
			$per_page	=	10;
		}
		$start = $mkportals->input['start'];
		$q_page		=	$mkportals->input['st'];
		if ($q_page=="" or $q_page <= 0) {
			$q_page	=	0;
		}
		$start = $q_page;
		$show_pages = $mklib->build_pages( array( TOTAL_POSS  => $countpage,
							PER_PAGE    => $per_page,
							CUR_ST_VAL  => $q_page,
							L_SINGLE    => '',
							L_MULTI     => 'pagine',
						    BASE_URL    => 'index.php?ind=downloads&amp;op=section_view&amp;idev='.$idev.'&amp;order='.$mkportals->input['order'],
										  )
		);
		$query = $DB->query( "SELECT id, name, downloads, click, data, trate FROM mkp_download where idcategoria = '$idev' AND validate = '1' $order LIMIT $start, $per_page");
		while( $row = $DB->fetch_row($query) ) {
			$iden = $row['id'];
			$name = $row['name'];
			$trate = $row['trate'];
			$downloads = $row['downloads'];
			$click = $row['click'];
			$data = $mklib->create_date($row['data'], "short");
			$name ="<a href=\"index.php?ind=downloads&amp;op=entry_view&amp;iden=$iden\">$name</a>";
			$content .= $this->tpl->row_main_entries_content($name, $trate, $downloads, $click, $data);
		}
		$submit = " <a href=\"index.php?ind=downloads&amp;op=submit_file\">[ {$mklib->lang['dw_send']} ]</a> ";
		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_download']) {
			$submit ="";
		}
		$stat = $this->retrieve_stat();
		$jump1 = $this->row_select_event("1");
		$jump = "
		<select name=\"jumpsection\" size=\"1\" onchange=\"selChd(this)\"  class=\"bgselect\">
       		$jump1
		</select>
	 	";
	 	$sort = "
		<select name=\"order\" size=\"1\" onchange=\"selChoe(this, '$idev')\"  class=\"bgselect\">
		  <option value=\"0\">{$mklib->lang['dw_order']}</option>\n
		  <option value=\"1\">{$mklib->lang['dw_ordnamef']}</option>\n
		  <option value=\"2\">{$mklib->lang['dw_ordinsert']}</option>\n
		</select>
		 ";
		$toolbar = $this->tpl->row_toolbar($jump, $sort);
		$utonline = $mklib_board->get_active_users("downloads");
		$output  = $this->tpl->downloads_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['dw_pagetitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['dw_pagetitle']}", $blocks);
	}

	function entry_view() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;
		$iden = $mkportals->input['iden'];
		$query = $DB->query( "SELECT id, idcategoria, name, description, file, click, trate, rate, screen1, screen2, demo, autore, peso FROM mkp_download where id = '$iden'");
		$row = $DB->fetch_row($query);
		$id = $row['id'];
		$click = $row['click'];
		$idcategoria = $row['idcategoria'];
		$name = $row['name'];
		$description = $row['description'];
		$file = $row['file'];
		$trate = $row['trate'];
		$rate = $row['rate'];
		$autore = $row['autore'];
		$peso = round(($row['peso']/1024),2)." Kb";
		$even = $this->retrieve_event($idcategoria);
		$width = round(($rate*100)/4) - 6;
	 	$width2 = $width - 4;
		$screens = "-";
		$demo = "-";
		if ($row['screen1'])  {
			$screens = "<a href=\"{$row['screen1']}\" target=\"_new\">{$mklib->lang['dw_prev1']}</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if ($row['screen2'])  {
			$screens .= " <a href=\"{$row['screen2']}\" target=\"_new\">{$mklib->lang['dw_prev2']}</a>";
		}
		if ($row['demo'])  {
			$demo = " <a href=\"{$row['demo']}\" target=\"_new\">{$row['demo']}</a>";
		}
	 	$content .= $this->tpl->row_entry($id, $name, $description, $file, $trate, $rate, $width2, $width, $screens, $demo, $autore, $peso);
		$content .= "
		<tr>
		  <td class=\"tdblock\" colspan=\"2\">
		  {$mklib->lang['dw_comments']}
		  </td>
		</tr>
		";
		$query = $DB->query( "SELECT id, autore, testo, data FROM mkp_download_comments where identry = '$id' ORDER BY `id` DESC");
		while( $row = $DB->fetch_row($query) ) {
			$idcomm = $row['id'];
			$autorec = $row['autore'];
			$testo = $row['testo'];
			$data = $mklib->create_date($row['data'], "short");
			$delete = "
			<script type=\"text/javascript\">

			function makesure() {
			if (confirm('{$mklib->lang[dw_delcommconf]}')) {
			return true;
			} else {
			return false;
			}
			}

			</script><a href=\"index.php?ind=downloads&amp;op=del_comment&amp;idcomm=$idcomm&amp;iden=$iden\" onclick=\"return makesure()\">[ {$mklib->lang['dw_delete']} ]</a>
			";

			if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_download']) {
				$delete = "";
			}
			$content .= "
			<tr>
                          <td class=\"modulecell\" width=\"20%\" valign=\"top\">{$autorec}<br />{$data}<br />{$delete}</td>
                          <td class=\"modulecell\" width=\"80%\" valign=\"middle\">{$testo}</td>
			</tr>
			";
		}
		++$click;
		$DB->query("UPDATE mkp_download SET click ='$click'  where id = '$iden'");
		$navbar = "<a href=\"index.php?ind=downloads\">{$mklib->lang['dw_ptitle2']}</a>-><a href=\"index.php?ind=downloads&amp;op=section_view&amp;idev=$idcategoria\">$even</a>-><a href=\"#\">$name</a>";
		$maintit = $name;
		$submit = "<script type=\"text/javascript\">
			function makesure2() {
			if (confirm('{$mklib->lang[dw_delfileconf]}')) {
			return true;
			} else {
			return false;
			}
			}
			</script><a href=\"index.php?ind=downloads&amp;op=edit_file&amp;iden=$id\">[ {$mklib->lang['dw_edit']} ]</a>  <a href=\"index.php?ind=downloads&amp;op=del_file&amp;iden=$id\" onclick=\"return makesure2()\">[ {$mklib->lang['dw_delete']} ]</a> ";

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_download'] && $mkportals->member['name'] != $autore) {
			$submit = "";
		}
		$stat = $this->retrieve_stat();
		$toolbar = "";
		$utonline = $mklib_board->get_active_users("downloads");
		$output  = $this->tpl->downloads_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['dw_pagetitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['dw_pagetitle']}", $blocks);
	}

	function submit_file() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_download']) {
			$message = "{$mklib->lang['dw_nosend']}";
			$mklib->error_page($message);
			exit;
		}

		$navbar = "<a href=\"index.php?ind=downloads\">{$mklib->lang['dw_ptitle2']}</a>-><a href=\"#\">{$mklib->lang['dw_send']}</a>";
		$maintit = "Downloads";
		/*
		$query = $DB->query( "SELECT id, evento FROM mkp_download_sections ORDER BY `id` DESC");
		while( $row = mysql_fetch_array($query) ) {
				$idevento = $row['id'];
				$evento = $row['evento'];
				$cselect.= "<option value='$idevento'>$evento</option>\n";
		}
		*/
		$cselect = $this->row_select_event();
		$content .= "
		<tr>
		  <td>
		  
		    <form action=\"index.php?ind=downloads&amp;op=add_file\" name=\"UPDOWN\" method=\"post\" enctype=\"multipart/form-data\">
		    <table width=\"100%\" border=\"0\">
		      <tr>
			<td class=\"titadmin\" colspan=\"2\">{$mklib->lang['dw_send']}</td>
		      </tr>
		      <tr>
			<td>{$mklib->lang['dw_section']}</td>
			<td>
			  <select class=\"bgselect\" name=\"evento\" size=\"1\">
			  {$cselect}
			  </select>
			</td>
		      </tr>
		      <tr>
			<td width=\"10%\">{$mklib->lang['dw_title']}</td>
			<td width=\"90%\"><input type=\"text\" name=\"titolo\" size=\"52\" class=\"bgselect\" /></td>
		      </tr>
		      <tr>
			<td width=\"10%\" valign=\"top\">{$mklib->lang['dw_description']}</td>
			<td width=\"90%\"><textarea cols=\"50\" rows=\"10\" name=\"descrizione\" class=\"bgselect\"></textarea></td>
		      </tr>
		      <tr>
			<td width=\"10%\">{$mklib->lang['dw_file']}</td>
			<td width=\"90%\"><input type=\"file\" name=\"FILE_UPLOAD\" size=\"50\" class=\"bgselect\" /></td>
		      </tr>
		      <tr>
			<td width=\"10%\">{$mklib->lang['dw_screen1']}</td>
			<td width=\"90%\"><input type=\"text\" name=\"screen1\" size=\"52\" class=\"bgselect\" /></td>
		      </tr>
		      <tr>
			<td width=\"10%\">{$mklib->lang['dw_screen2']}</td>
			<td width=\"90%\"><input type=\"text\" name=\"screen2\" size=\"52\" class=\"bgselect\" /></td>
		      </tr>
		      <tr>
			<td width=\"10%\">{$mklib->lang['dw_demourl']}</td>
			<td width=\"90%\"><input type=\"text\" name=\"demo\" size=\"52\" class=\"bgselect\" /></td>
		      </tr>
		      <tr>
			<td colspan=\"2\">
			<input type=\"submit\" value=\"{$mklib->lang['dw_insert']}\" class=\"bgselect\" />
			</td>
		      </tr>
		    </table>
		    </form>
		  </td>
		</tr>
		";

		$submit = " <a href=\"index.php?ind=downloads&amp;op=submit_file\">[ {$mklib->lang['dw_send']} ]</a> ";
		$stat = $this->retrieve_stat();
		$toolbar = "";
		$utonline = $mklib_board->get_active_users("downloads");
		$output  = $this->tpl->downloads_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['dw_titlepage']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['dw_titlepage']}", $blocks);
	}

	function edit_file() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;


		$maintit = "{$mklib->lang['dw_ptitle']}";
		$iden = $mkportals->input['iden'];
		$query = $DB->query( "SELECT idcategoria, name, description, screen1, screen2, demo, autore FROM mkp_download where id = '$iden'");
		$row = $DB->fetch_row($query);
		$idcategoria = $row['idcategoria'];
		$nav_ev = $this->retrieve_event($idcategoria);
		$name = $row['name'];
		$screen1 = $row['screen1'];
		$screen2 = $row['screen2'];
		$demo = $row['demo'];
		$autore = $row['autore'];
		$description = $row['description'];
		$description = str_replace("<br />", "\n", $description);

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_download'] && $mkportals->member['name'] != $autore) {
			$message = "{$mklib->lang['dw_noedit']}";
			$mklib->error_page($message);
			exit;
		}
/*
		$query = $DB->query( "SELECT id, evento FROM mkp_download_sections ORDER BY `id` DESC");
  		while( $row = mysql_fetch_array($query) ) {
			$idevento = $row['id'];
			$evento = $row['evento'];
			$selected = "";
			if($idevento == $idcategoria) {
				$selected = "selected=\"selected\"";
			}
			$cselect.= "<option value='$idevento' $selected>$evento</option>\n";
		}
*/


			$query = $DB->query( "SELECT id, evento, father FROM mkp_download_sections ORDER BY `id`");
			while( $row = mysql_fetch_array($query) ) {
				$idevento = $row['id'];
				$selected = "";
				if($idevento == $idcategoria) {
					$selected = "selected=\"selected\"";
				}
				$evento = $row['evento'];
				$father = $row['father'];
				if(!$listall[$idevento]) {
					$cselect.= "<option value='$idevento' $selected>$evento</option>\n";
				}
				$listall[$idevento] = 1;
				$query1 = $DB->query( "SELECT id, evento, father FROM mkp_download_sections where father = '$idevento' ORDER BY `id`");
				while( $row2 = mysql_fetch_array($query1) ) {
					$idevento = $row2['id'];
					$selected = "";
					if($idevento == $idcategoria) {
						$selected = "selected=\"selected\"";
					}
					$evento = $row2['evento'];
					if(!$listall[$idevento]) {
						$cselect.= "<option value='$idevento' $selected>- $evento</option>\n";
					}
					$listall[$idevento] = 1;
				}
			}

		$content .= "
		<tr>
		  <td>
		  
		    <form action=\"index.php?ind=downloads&amp;op=update_file&amp;iden=$iden\" name=\"UPDATE\" method=\"post\" enctype='multipart/form-data'>
		    <table width=\"100%\" border=\"0\">
		      <tr>
			<td class=\"titadmin\" colspan=\"2\">{$mklib->lang['dw_editf']}</td>
		      </tr>
		      <tr>
			<td>{$mklib->lang['dw_section']}</td>
			<td>
			  <select class=\"bgselect\" name=\"evento\" size=\"1\">
			  {$cselect}
			  </select>
			</td>
		      </tr>
		      <tr>
			<td width=\"10%\">{$mklib->lang['dw_title']}</td>
			<td width=\"90%\"><input type=\"text\" name=\"titolo\" value=\"$name\" size=\"52\" class=\"bgselect\" /></td>
		      </tr>
		      <tr>
			<td width=\"10%\" valign=\"top\">{$mklib->lang['dw_description']}</td>
			<td width=\"90%\"><textarea cols=\"50\" rows=\"10\" name=\"descrizione\" class=\"bgselect\">$description</textarea></td>
		      </tr>
			  <tr>
                 <td width=\"10%\">{$mklib->lang['dw_file_update']}</td>
                 <td width=\"90%\"><input type=\"file\" name=\"FILE_UPLOAD\" size=\"52\" class=\"bgselect\" /></td>
               </tr>
		      <tr>
			<td width=\"10%\">{$mklib->lang['dw_screen1']}</td>
			<td width=\"90%\"><input type=\"text\" name=\"screen1\" value=\"$screen1\" size=\"52\" class=\"bgselect\" /></td>
		      </tr>
		      <tr>
			<td width=\"10%\">{$mklib->lang['dw_screen2']}</td>
			<td width=\"90%\"><input type=\"text\" name=\"screen2\" value=\"$screen2\" size=\"52\" class=\"bgselect\" /></td>
		      </tr>
		      <tr>
			<td width=\"10%\">{$mklib->lang['dw_demourl']}</td>
			<td width=\"90%\"><input type=\"text\" name=\"demo\" value=\"$demo\" size=\"52\" class=\"bgselect\" /></td>
		      </tr>
		      <tr>
			<td colspan=\"2\">
			<input class=\"bgselect\" type=\"submit\" value=\"{$mklib->lang['dw_save']}\" />
			</td>
		      </tr>
		    </table>
		    </form>
		  </td>
		</tr>
		";

		//$submit = " <a href=\"index.php?ind=downloads&amp;op=del_file&amp;iden=$iden\">[ Elimina ]</a> ";
		$navbar = "<a href=\"index.php?ind=downloads\">{$mklib->lang['dw_ptitle2']}</a>-><a href=\"index.php?ind=downloads&amp;op=section_view&amp;idev=$idcategoria\">$nav_ev</a>-><a href=\"index.php?ind=downloads&amp;op=entry_view&amp;iden=$iden\">$name</a>-><a href=\"#\">{$mklib->lang['dw_editf']}</a>";
		$stat = $this->retrieve_stat();
		$toolbar = "";
		$utonline = $mklib_board->get_active_users("downloads");
		$output  = $this->tpl->downloads_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['dw_pagetitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['dw_pagetitle']}", $blocks);
	}


	function add_file() {

    	global $mkportals, $DB,  $_FILES, $mklib, $mklib_board;
		$evento = $mkportals->input['evento'];
		$titolo = $mkportals->input['titolo'];
		$screen1 = $mkportals->input['screen1'];
		$screen2 = $mkportals->input['screen2'];
		$demo = $mkportals->input['demo'];
		$descrizione = $mkportals->input['descrizione'];
		$FILE_UPLOAD = $mkportals->input['FILE_UPLOAD'];
		$file =  $_FILES['FILE_UPLOAD']['tmp_name'];
		$file_name =  $_FILES['FILE_UPLOAD']['name'];
		$file_type =  $_FILES['FILE_UPLOAD']['type'];
		$peso =  $_FILES['FILE_UPLOAD']['size'];

		$file_ext = preg_replace("`.*\.(.*)`", "\\1", $file_name);

		if (!$mklib->check_attach($file_type, $file_ext))  {
			$message = $file_type;
			$message .= " - {$mklib->lang['error_filetype']}";
			$mklib->error_page($message);
			exit;
		}

		$autore = $mkportals->member['name'];

		if (!$evento || !$titolo || !$descrizione || !$file) {
			$message = "{$mklib->lang['dw_reqtcd']}";
			$mklib->error_page($message);
			exit;
		}

		if ($mklib->config['upload_file_max'] > 0 && $peso > ($mklib->config['upload_file_max']*1024)) {
			$message = "{$mklib->lang['dw_toobig']}";
			$mklib->error_page($message);
			exit;
		}

		$validat = "1";
		$approval = $mklib->config['approval_download'];
		if ($approval == "2" || $approval == "3") {
			$validat = 0;
		}
		if($mkportals->member['g_access_cp']) {
			$validat = "1";
		}

		$query="INSERT INTO mkp_download(idcategoria, name, description, file, data, screen1, screen2, demo, autore, peso, validate)VALUES('$evento', '$titolo', '$descrizione', '$file_name', '".(time())."', '$screen1', '$screen2', '$demo', '$autore', '$peso', '$validat')";
		$DB->query($query);
        $insert_id = $DB->get_insert_id();
        $real_file = $MK_PATH."mkportal/modules/downloads/file/mk_".$insert_id."_".$file_name;
        $real_file = preg_replace("`(.*)\..*`", "\\1", $real_file);
        $real_file .= ".mk";
		if (is_file ($real_file)) {
    		$DB->query("DELETE FROM mkp_download WHERE id='$insert_id'");
    		$DB->close_db();
			$message = "{$mklib->lang['dw_fexists']}";
			$mklib->error_page($message);
			exit;
		}
		if (is_file ($MK_PATH."mkportal/modules/downloads/file/$file_name")) {
    		$DB->query("DELETE FROM mkp_download WHERE id='$insert_id'");
    		$DB->close_db();
			$message = "{$mklib->lang['dw_fexists']}";
			$mklib->error_page($message);
			exit;
		}
        @move_uploaded_file("$file", $real_file);

		if (!is_file ($real_file)) {
    		$DB->query("DELETE FROM mkp_download WHERE id='$insert_id'");
    		$DB->close_db();
			$message = "{$mklib->lang['dw_chperms']}";
			$mklib->error_page($message);
			exit;
		}

		if ($approval == "1") {
			$mailsubj = $mklib->lang['01mail'].$mklib->lang['download'];
			$mailmess = $mklib->lang['02mail'].$mklib->lang['module'].$mklib->lang['download']."\n".$mklib->lang['sender'].$autore."\n\n\n".$mklib->lang['from']." ".$mklib->sitename;
			$mklib_board->admin_mail($mailsubj, $mailmess);
		}
		if ($approval == "2") {
			$mailsubj = $mklib->lang['01mail'].$mklib->lang['download'];
			$mailmess = $mklib->lang['03mail'].$mklib->lang['module'].$mklib->lang['download']."\n".$mklib->lang['sender'].$autore."\n\n\n".$mklib->lang['from']." ".$mklib->sitename;
			$mklib_board->admin_mail($mailsubj, $mailmess);
		}

  		$DB->close_db();
	 	Header("Location: index.php?ind=downloads");
		exit;
  }
  function update_file() {
    	global $mkportals, $DB,  $_FILES, $mklib, $mklib_board;
		$iden= $mkportals->input['iden'];
		$insert_id = $iden;
		$idcategoria = $mkportals->input['evento'];
		$titolo = $mkportals->input['titolo'];
		$descrizione = $mkportals->input['descrizione'];
		$screen1 = $mkportals->input['screen1'];
		$screen2 = $mkportals->input['screen2'];
		$demo = $mkportals->input['demo'];
		$query = $DB->query( "SELECT file, data, peso FROM mkp_download WHERE id = $iden");
		$row = $DB->fetch_row($query);
		$file = $row['file'];
		$oldfile = $file;
		$data = $row['data'];
		$peso = $row['peso'];

		if (!empty($_FILES['FILE_UPLOAD']['tmp_name'])) {
			$FILE_UPLOAD = $mkportals->input['FILE_UPLOAD'];
			$file =  $_FILES['FILE_UPLOAD']['tmp_name'];
			$file_name =  $_FILES['FILE_UPLOAD']['name'];
			$file_type =  $_FILES['FILE_UPLOAD']['type'];
			$peso =  $_FILES['FILE_UPLOAD']['size'];
			$data = time();
			$file_ext = preg_replace("`.*\.(.*)`", "\\1", $file_name);
			if (!$mklib->check_attach($file_type, $file_ext))  {
				$message = $file_type;
				$message .= " - {$mklib->lang['error_filetype']}";
				$mklib->error_page($message);
				exit;
			}
			if (is_file ($MK_PATH."mkportal/modules/downloads/file/$oldfile")) {
				@unlink($MK_PATH."mkportal/modules/downloads/file/$oldfile");
			}
			$oldfile = $MK_PATH."mkportal/modules/downloads/file/mk_".$insert_id."_".$oldfile;
        	$oldfile = preg_replace("`(.*)\..*`", "\\1", $oldfile);
        	$oldfile .= ".mk";
			if (is_file ($oldfile)) {
    			@unlink($oldfile);
			}
			$real_file = $MK_PATH."mkportal/modules/downloads/file/mk_".$insert_id."_".$file_name;
        	$real_file = preg_replace("`(.*)\..*`", "\\1", $real_file);
        	$real_file .= ".mk";
        	@move_uploaded_file("$file", $real_file);
			if (!is_file ($real_file)) {
    			$DB->query("DELETE FROM mkp_download WHERE id='$insert_id'");
    			$DB->close_db();
				$message = "{$mklib->lang['dw_chperms']}";
				$mklib->error_page($message);
				exit;
			}
			$file = $file_name;
		}

		$DB->query("UPDATE mkp_download SET idcategoria ='$idcategoria', name ='$titolo', description ='$descrizione', file ='$file', data='$data', screen1='$screen1', screen2='$screen2', demo='$demo', peso='$peso' where id = '$iden'");
		$DB->close_db();
		Header("Location: index.php?ind=downloads&op=entry_view&iden=$iden");
		exit;
  		}
	function del_file() {
    	global $mkportals, $DB, $mklib, $mklib_board;

		$iden= $mkportals->input['iden'];
		$query = $DB->query( "SELECT file, autore FROM mkp_download WHERE id = $iden");
		$row = $DB->fetch_row($query);
		$file = $row['file'];
		$autore = $row['autore'];
		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_download'] && $mkportals->member['name'] != $autore) {
			$message = "{$mklib->lang['dw_nodel']}";
			$mklib->error_page($message);
			exit;
		}
		@unlink("mkportal/modules/downloads/file/$file");
        $real_file = "mkportal/modules/downloads/file/mk_".$iden."_".$file;
        $real_file = preg_replace("`(.*)\..*`", "\\1", $real_file);
        $real_file .= ".mk";
		@unlink($real_file);
		$DB->query("DELETE FROM mkp_download WHERE id = $iden");
		$DB->query("DELETE FROM mkp_download_comments WHERE identry = $iden");
		$DB->close_db();
	 	Header("Location: index.php?ind=downloads");
		exit;
  		}

  function submit_comment() {
		global $mkportals, $mklib, $Skin, $DB, $mklib_board;
		$ide= $mkportals->input['ide'];
		$query = $DB->query( "SELECT id, idcategoria, name FROM mkp_download where id = '$ide'");
		$row = $DB->fetch_row($query);
		$t_id = $row['id'];
		$t_t = $row['name'];
		$t_ev1 = $row['idcategoria'];
		$t_ev2 = $this->retrieve_event($t_ev1);
		$navbar = "<a href=\"index.php?ind=downloads\">{$mklib->lang['dw_ptitle2']}</a>-><a href=\"index.php?ind=downloads&amp;op=section_view&amp;idev=$t_ev1\">$t_ev2</a>-><a href=\"index.php?ind=downloads&amp;op=entry_view&amp;iden=$t_id\">$t_t</a>-><a href=\"#\">{$mklib->lang['dw_commfile']}</a>";
		$content = "		
		<tr>
		  <td>
		
		    <script type=\"text/javascript\">
		    function emo_pop()
		    {
			  window.open('{$mkportals->base_url}act=legends&amp;CODE=emoticons&amp;s={$mkportals->session_id}','Legends','width=250,height=500,resizable=yes,scrollbars=yes');
		    }
		    </script>
		      
		    <form action=\"index.php?ind=downloads&amp;op=add_comment&amp;ide={$ide}\" name=\"editor\" method=\"post\" >
		    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"8\">        
		      <tr>
			<td rowspan=\"3\" align=\"center\" height=\"100%\">
			  <iframe src=\"index.php?ind=downloads&amp;op=show_emoticons\" frameborder=\"0\"  width=\"200\" align=\"middle\" height=\"200\" scrolling=\"auto\"></iframe>
			</td>
			<td>{$mklib->lang['dw_writecomm']}</td>
		      </tr>
		      <tr>
			<td width=\"70%\" align=\"left\"><textarea cols=\"10\" style=\"width:95%\" rows=\"4\" name=\"ta\"></textarea></td>
		      </tr>
		      <tr>
			<td>
			<input type=\"submit\" name=\"submit\" value=\"{$mklib->lang['dw_sendcomm']}\" class=\"mkbutton\" accesskey=\"s\" /><br />
			</td>
		      </tr>		
		    </table>
		    </form>
		    
		  </td>
		</tr>
	";
	$maintit = "<a href=\"index.php?ind=downloads&amp;op=entry_view&amp;iden=$t_id\">{$mklib->lang['dw_file']}: $t_t</a>";
	$stat = $this->retrieve_stat();
	$toolbar = "";
	$utonline = $mklib_board->get_active_users("downloads");
	$output  = $this->tpl->downloads_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
	$blocks = $Skin->view_block("{$mklib->lang['dw_insertcomm']}", $output);
	$mklib->printpage("1", "1", "{$mklib->lang['dw_pagetitle']}", $blocks);
	}

	function submit_rate() {
    	global $mkportals, $mklib, $Skin, $DB, $mklib_board;
		$ide= $mkportals->input['ide'];
		$iduser = $mkportals->member['id'];
		$ipuser = $_SERVER['REMOTE_ADDR'];
		$module = "downloads";

		$query = $DB->query( "SELECT id FROM mkp_votes where module = '$module' and id_entry = '$ide' and id_member = '$iduser'");
		$checkuser = mysql_num_rows ($query);
		$query = $DB->query( "SELECT id FROM mkp_votes where module = '$module' and id_entry = '$ide' and ip = '$ipuser'");
		$checkip = mysql_num_rows ($query);

		if($checkuser || $checkip) {
			$message = "{$mklib->lang['dw_justvote']}";
			$mklib->error_page($message);
			exit;
		}

		$query = $DB->query( "SELECT id, idcategoria, name FROM mkp_download where id = '$ide'");
		$row = $DB->fetch_row($query);
		$t_id = $row['id'];
		$t_t = $row['name'];
		$t_ev1 = $row['idcategoria'];
		$t_ev2 = $this->retrieve_event($t_ev1);
		$navbar = "<a href=\"index.php?ind=downloads\">MKPDownloads</a>-><a href=\"index.php?ind=downloads&amp;op=section_view&amp;idev=$t_ev1\">$t_ev2</a>-><a href=\"index.php?ind=downloads&amp;op=entry_view&amp;iden=$t_id\">$t_t</a>-><a href=\"#\">{$mklib->lang['dw_vote']}</a>";
	   $content .= "
		<tr>
		  <td class=\"modulecell\">
  
		    <form action=\"index.php?ind=downloads&amp;op=add_rate&amp;ide={$ide}\" method=\"post\" id=\"ratea\" name=\"ratea\">
		    <table width=\"100%\">
		      <tr>
			<td class=\"modulex\" width=\"50%\" valign=\"top\">{$mklib->lang['dw_maxvote']}
			</td>
			<td class=\"modulex\" width=\"*\">
			  <input class=\"mkradio\" type=\"radio\" tabindex=\"3\" name=\"rating\" value=\"1\" checked=\"checked\" />1
			  <input class=\"mkradio\" type=\"radio\" tabindex=\"4\" name=\"rating\" value=\"2\" />2
			  <input class=\"mkradio\" type=\"radio\" tabindex=\"5\" name=\"rating\" value=\"3\" />3
			  <input class=\"mkradio\" type=\"radio\" tabindex=\"6\" name=\"rating\" value=\"4\" />4
			  <input class=\"mkradio\" type=\"radio\" tabindex=\"7\" name=\"rating\" value=\"5\" />5
			</td>
		      </tr>
		      <tr>
			<td class=\"modulex\" colspan=\"2\">
			  <input type=\"submit\" name=\"ok\" value=\" {$mklib->lang['dw_sendvote']}  \" />
			</td>
		      </tr>		
		    </table>
		    </form>
    
		  </td>
		</tr>
	";
	$maintit = "<a href=\"index.php?ind=downloads&amp;op=entry_view&amp;iden=$t_id\">{$mklib->lang['dw_file']}: $t_t</a>";
	$stat = $this->retrieve_stat();
	$toolbar = "";
	$utonline = $mklib_board->get_active_users("downloads");
	$output  = $this->tpl->downloads_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
	$blocks = $Skin->view_block("{$mklib->lang['dw_sendvote']}", $output);
	$mklib->printpage("1", "1", "{$mklib->lang['dw_pagetitle']}", $blocks);
		}

	function add_comment() {
    	global $mkportals, $DB, $mklib, $mklib_board;


		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_comments']) {
			$message = "{$mklib->lang['dw_nosendcom']}";
			$mklib->error_page($message);
			exit;
		}

		$ide= $mkportals->input['ide'];
		$testo = $mkportals->input['ta'];
		$autore = $mkportals->member['name'];
        $cdata = time();
		if (!$testo) {
			$message = "{$mklib->lang['dw_reqtext']}";
			$mklib->error_page($message);
			exit;
		}

		$testo = $mklib_board->decode_smilies($testo);

		//$testo = addslashes($testo);
		$query="INSERT INTO mkp_download_comments(identry, autore, testo, data)VALUES('$ide', '$autore', '$testo', '$cdata')";
		$DB->query($query);
		$DB->close_db();
	 	Header("Location: index.php?ind=downloads&op=entry_view&iden=$ide");
		exit;
  	}
	function del_comment() {
    	global $mkportals, $DB, $mklib, $mklib_board;

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_download']) {
			$message = "{$mklib->lang['dw_nodelcomm']}";
			$mklib->error_page($message);
			exit;
		}

		$ide= $mkportals->input['iden'];
		$idcomm= $mkportals->input['idcomm'];
		$DB->query("DELETE FROM mkp_download_comments WHERE id = $idcomm");
		$DB->close_db();
	 	Header("Location: index.php?ind=downloads&op=entry_view&iden=$ide");
		exit;
  	}



  		function add_rate() {
    	global $mkportals, $DB, $mklib, $mklib_board;
		$ide= $mkportals->input['ide'];
		$rating = $mkportals->input['rating'];
		$iduser = $mkportals->member['id'];
		$ipuser = $_SERVER['REMOTE_ADDR'];
		$module = "downloads";

		$query="INSERT INTO mkp_votes(id_entry, module, id_member, ip)VALUES('$ide', '$module', '$iduser', '$ipuser')";
		$DB->query($query);

		$query = $DB->query( "SELECT rate, trate FROM mkp_download where id = '$ide'");
		$row = $DB->fetch_row($query);
		$rate = $row['rate'];
		$trate = $row['trate'];
		$votes = ($trate +1);
		if ( $rating != 0 ) {
				$rate = round ((($trate*$rate)+$rating)/($votes), 2);
		}
		$DB->query("UPDATE mkp_download SET rate ='$rate', trate ='$votes' where id = '$ide'");
		$DB->close_db();
	 	Header("Location: index.php?ind=downloads&op=entry_view&iden=$ide");
		exit;
  		}
		function download_file() {
			global $mkportals, $DB, $mklib, $mklib_board;
			$file= $mkportals->input['file'];
			$ide= $mkportals->input['ide'];
			$query = $DB->query( "SELECT downloads FROM mkp_download where id = '$ide'");
			$row = $DB->fetch_row($query);
			$downloads = $row['downloads'];
			++$downloads;
			$DB->query("UPDATE mkp_download SET downloads ='$downloads'  where id = '$ide'");
			$DB->close_db();
			$real_file = "mkportal/modules/downloads/file/mk_".$ide."_".$file;
            $real_file = preg_replace("`(.*)\..*`", "\\1", $real_file);
            $real_file .= ".mk";
            if (is_file("mkportal/modules/downloads/file/".$file)) {
                rename("mkportal/modules/downloads/file/".$file, $real_file);
            }
			@header( "Content-Type: application/octet-stream\nContent-Disposition: inline; filename=\"".$file."\"\nContent-Length: ".(string)(filesize( $real_file ) ) );
            $fh = fopen( $real_file, 'rb' );
            fpassthru( $fh );
            @fclose( $fh );
            exit();
		}
		function search() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;
		$maintit = "{$mklib->lang['dw_searchf']}";
		$cselect.= "<option value='1'>{$mklib->lang['dw_title']}</option>\n";
		$cselect.= "<option value='2'>{$mklib->lang['dw_description']}</option>\n";
		$content .= "
		<tr>
		  <td>
		  
		    <form action=\"index.php?ind=downloads&amp;op=result_search\" name=\"search\" method=\"post\">
		    <table width=\"100%\" border=\"0\">
		      <tr>
			<td>{$mklib->lang['dw_searchin']}:</td>
			<td>
			  <select class=\"bgselect\" name=\"campo\" size=\"1\">
			  {$cselect}
			  </select>
			</td>
		      </tr>
		      <tr>
			<td width=\"20%\">{$mklib->lang['dw_searchtext']}</td>
			<td width=\"80%\"><input type=\"text\" name=\"testo\" size=\"52\" class=\"bgselect\" /></td>
		      </tr>
		      <tr>
			<td colspan=\"2\"><input type=\"submit\" value=\"{$mklib->lang['dw_searchstart']}\" class=\"bgselect\" /></td>
		      </tr>
		    </table>
		    </form>
		    
		</td>
	      </tr>
		";
		$navbar = "<a href=\"index.php?ind=downloads\">MKPDownloads</a>-><a href=\"#\">{$mklib->lang['dw_searchf']}</a>";
		$stat = $this->retrieve_stat();
		$toolbar = "";
		$utonline = $mklib_board->get_active_users("downloads");
		$output  = $this->tpl->downloads_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['dw_pagetitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['dw_pagetitle']}", $blocks);
	}

	function result_search() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;
		$campo = $mkportals->input['campo'];
		$testo = $mkportals->input['testo'];
		$campo = "name";
		if ($mkportals->input['campo'] == 2) {
			$campo = "description";
		}
		if (!$testo) {
			$message = "{$mklib->lang['dw_reqstring']}";
			$mklib->error_page($message);
			exit;
		}
		$navbar = "<a href=\"index.php?ind=downloads\">MKPDownloads</a>-><a href=\"#\">{$mklib->lang['dw_searchresult']}</a>";
		$maintit = "{$mklib->lang['dw_searchresult']}";
		$content = $this->tpl->row_main_entries();
		$query = $DB->query( "SELECT id, name, downloads, click, data, trate FROM mkp_download where $campo LIKE '%$testo%'");
		while( $row = $DB->fetch_row($query) ) {
			$iden = $row['id'];
			$name = $row['name'];
			$trate = $row['trate'];
			$downloads = $row['downloads'];
			$click = $row['click'];
			$data = $mklib->create_date($row['data'], "short");
			$name ="<a href=\"index.php?ind=downloads&amp;op=entry_view&amp;iden=$iden\">$name</a>";
			$content .= $this->tpl->row_main_entries_content($name, $trate, $downloads, $click, $data);
		}
		if (!$name) {
			$content = "<td align=\"center\" width=\"100%\" class=\"modulecell\"><br />{$mklib->lang['dw_searchnot']}<br /><br /><br /></td>";
		}
		$submit = "";
		$stat = $this->retrieve_stat();
		$toolbar = "";
		$utonline = $mklib_board->get_active_users("downloads");
		$output  = $this->tpl->downloads_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['dw_pagetitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['dw_pagetitle']}", $blocks);
	}




		function row_select_event($jump="") {
			global $mkportals, $DB, $mklib, $mklib_board;

			if($jump) {
				$cselect = "<option value=\"0\">{$mklib->lang['dw_jumpcat']}</option>\n";
			}
			$query = $DB->query( "SELECT id, evento, father FROM mkp_download_sections ORDER BY `id`");
			while( $row = mysql_fetch_array($query) ) {
				$idevento = $row['id'];
				$evento = $row['evento'];
				$father = $row['father'];
				if(!$listall[$idevento]) {
					$cselect.= "<option value=\"$idevento\">$evento</option>\n";
				}
				$listall[$idevento] = 1;
				$query1 = $DB->query( "SELECT id, evento, father FROM mkp_download_sections where father = '$idevento' ORDER BY `id`");
				while( $row2 = mysql_fetch_array($query1) ) {
					$idevento = $row2['id'];
					$evento = $row2['evento'];
					if(!$listall[$idevento]) {
						$cselect.= "<option value=\"$idevento\">- $evento</option>\n";
					}
					$listall[$idevento] = 1;
				}
			}
			return $cselect;
		}
		function retrieve_event($idevento) {
			global $mkportals, $DB;
			$query = $DB->query( "SELECT evento FROM mkp_download_sections WHERE id = '$idevento'");
			$evento = mysql_fetch_array($query);
			return $evento[0];
		}
		function retrieve_father($idevento) {
			global $mkportals, $DB;
			$query = $DB->query( "SELECT father FROM mkp_download_sections WHERE id = '$idevento'");
			$row = $DB->fetch_row($query);
			if($row['father']) {
				$evento = $this->retrieve_event($row['father']);
			}
			return array ($row['father'], $evento);
		}
		function retrieve_stat() {
			global $mkportals, $DB, $mklib, $mklib_board;
			$query = $DB->query( "SELECT id, name FROM mkp_download ORDER BY `downloads` DESC");
			$row = mysql_fetch_array($query);
			$id = $row['id'];
			$name = $row['name'];
			$scaricato = "<a href=\"index.php?ind=downloads&amp;op=entry_view&amp;iden=$id\">$name</a>";
			$count = $DB->get_num_rows($query1);
			$query = $DB->query( "SELECT id, name FROM mkp_download ORDER BY `click` DESC LIMIT 1");
			$row = mysql_fetch_array($query);
			$id = $row['id'];
			$name = $row['name'];
			$visitato = "<a href=\"index.php?ind=downloads&amp;op=entry_view&amp;iden=$id\">$name</a>";
			$query = $DB->query( "SELECT id, name FROM mkp_download ORDER BY `trate` DESC LIMIT 1");
			$row = mysql_fetch_array($query);
			$id = $row['id'];
			$name = $row['name'];
			$votato = "<a href=\"index.php?ind=downloads&amp;op=entry_view&amp;iden=$id\">$name</a>";
			$output = "{$mklib->lang['dw_have']} $count {$mklib->lang['dw_totfile']}<br />{$mklib->lang['dw_mostd']} $scaricato<br />{$mklib->lang['dw_mosts']} $visitato<br />{$mklib->lang['dw_mostv']} $votato";
			return $output;
		}

		function show_emoticons()
 	{
		global $mklib_board;
		$mklib_board->show_emoticons();
 	}

}
?>
