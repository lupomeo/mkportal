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

$idx = new mk_review;
class mk_review {

	var $tpl       = "";

	function mk_review() {

		global $mkportals, $mklib,  $Skin, $DB, $mklib_board;

		$mklib->load_lang("lang_review.php");

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_access_reviews']) {
			$message = "{$mklib->lang['re_unauth']}";
			$mklib->error_page($message);
			exit;
		}

		if ($mklib->config['mod_reviews']) {
		$message = "{$mklib->lang['re_mnoactive']}";
			$mklib->error_page($message);
			exit;
		}

		//location
		$mklib_board->store_location("reviews");

		require "mkportal/modules/reviews/tpl_reviews.php";
		$this->tpl = new tpl_reviews();

    		switch($mkportals->input['op']) {
    			case 'section_view':
    				$this->section_view();
    			break;
			case 'submit_file':
    				$this->submit_file();
    			break;
			case 'submit_file1':
    				$this->submit_file1();
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
    				$this->reviews_show();
    			break;
    		}
	}

	function reviews_show() {
    global $mkportals, $DB, $mklib, $Skin, $mklib_board;

	$navbar = "<a href=\"index.php?ind=reviews\">{$mklib->lang['re_ptitle2']}</a>";
	$maintit = "{$mklib->lang['re_ptitle']}";
	$content = $this->tpl->row_main_category();
	switch($mkportals->input['order']) {
		case '2':
			$order = "ORDER BY `title`";
    	break;
		case '3':
			$order = "ORDER BY `id` DESC";
    	break;
		default:
    		$order = "ORDER BY `position`";
    	break;
	}
	//pagine
	$query = $DB->query( "SELECT id FROM mkp_reviews_sections");
	$countpage = mysql_num_rows ($query);
	$per_page = $mklib->config['review_sec_page'];
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
						    BASE_URL    => 'index.php?ind=reviews&amp;order='.$mkportals->input['order'],
										  )
	);
	$query = $DB->query( "SELECT id, title, description, position FROM mkp_reviews_sections  $order LIMIT $start, $per_page");

	while( $row = $DB->fetch_row($query) ) {
		$idevento = $row['id'];
		$query1 = $DB->query("SELECT title FROM mkp_reviews where id_cat = '$idevento' and validate = '1' ORDER BY `id` DESC");
		$count = $DB->get_num_rows($query1);
		$entry = $DB->fetch_row($query1);
		$lastentry = $entry['title'];
		$evento = $row['title'];
		$descrizione = $row['description'];
		$name ="<a href=\"index.php?ind=reviews&amp;op=section_view&amp;idev=$idevento\">$evento</a>";
		$link = "<a href=\"index.php?ind=reviews&amp;op=section_view&amp;idev=$idevento\"><img src=\"$mklib->images/category.gif\" border=\"0\" alt=\"\" /></a>";
		$content .= $this->tpl->row_main_category_content($name, $descrizione, $count, $lastentry, $link);
	}
	$submit = " <a href=\"index.php?ind=reviews&amp;op=submit_file\">[ {$mklib->lang['re_send']} ]</a> ";
	if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_reviews']) {
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
	<select name=\"order\" size=\"1\" onchange=\"selChoc(this)\" class=\"bgselect\">
	  <option value=\"0\">{$mklib->lang['re_order']}</option>\n
	  <option value=\"1\">{$mklib->lang['re_ordpos']}</option>\n
	  <option value=\"2\">{$mklib->lang['re_ordnamec']}</option>\n
	  <option value=\"3\">{$mklib->lang['re_ordcrea']}</option>\n
      	</select>
	 ";
	$toolbar = $this->tpl->row_toolbar($jump, $sort);
	$utonline = $mklib_board->get_active_users("reviews");
	$output  = $this->tpl->review_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
	$blocks = $Skin->view_block("{$mklib->lang['re_pagetitle']}", $output);
	$mklib->printpage("1", "1", "{$mklib->lang['re_pagetitle']}", $blocks);
	}

	function section_view() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;
		$content = "";
		$idev = $mkportals->input['idev'];
  		$even = $this->retrieve_event($idev);
  		$navbar = "<a href=\"index.php?ind=reviews\">{$mklib->lang['re_ptitle2']}</a>";
		$navbar .= "-><a href=\"#\">$even</a>";
  		$maintit = $even;

		switch($mkportals->input['order']) {
		case '1':
			$order = "ORDER BY `title`";
    	break;
		default:
    		$order = "ORDER BY `id` DESC";
    	break;
		}
		//pagine
		$query = $DB->query( "SELECT id FROM mkp_reviews where id_cat = '$idev' AND validate = '1'");
		$countpage = mysql_num_rows ($query);

		if($countpage) {
			$content .= $this->tpl->row_main_entries();
		}

		$per_page = $mklib->config['rev_file_page'];
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
						    BASE_URL    => 'index.php?ind=reviews&amp;op=section_view&amp;idev='.$idev.'&amp;order='.$mkportals->input['order'],
										  )
		);
		$query = $DB->query( "SELECT id, title, description, click, date, trate FROM mkp_reviews where id_cat = '$idev' AND validate = '1' $order LIMIT $start, $per_page");
		while( $row = $DB->fetch_row($query) ) {
			$iden = $row['id'];
			$name = $row['title'];
			$trate = $row['trate'];
			$description = $row['description'];
			$click = $row['click'];
			$data = $mklib->create_date($row['date'], "short");
			$name ="<a href='index.php?ind=reviews&amp;op=entry_view&amp;iden=$iden'>$name</a>";
			$content .= $this->tpl->row_main_entries_content($name, $trate, $description, $click, $data);
		}
		$submit = " <a href=\"index.php?ind=reviews&amp;op=submit_file\">[ {$mklib->lang['re_send']} ]</a> ";
		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_reviews']) {
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
		  <option value=\"0\">{$mklib->lang['re_order']}</option>\n
		  <option value=\"1\">{$mklib->lang['re_ordnamef']}</option>\n
		  <option value=\"2\">{$mklib->lang['re_ordinsert']}</option>\n
		</select>
		 ";
		$toolbar = $this->tpl->row_toolbar($jump, $sort);
		$utonline = $mklib_board->get_active_users("reviews");
		$output  = $this->tpl->review_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['re_pagetitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['re_pagetitle']}", $blocks);
	}

	function entry_view() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;

		$iden = $mkportals->input['iden'];
		$link_user = $mklib_board->forum_link("profile");

		$query = $DB->query( "SELECT id_cat, title, description, field1, field2, field3, field4, field5, field6, field7, image, review, author, idauth, click, rate, trate FROM mkp_reviews where id = '$iden'");
		$row = $DB->fetch_row($query);

		$click = $row['click'];
		$idcategoria = $row['id_cat'];
		$name = $row['title'];
		$description = $row['description'];
		$trate = $row['trate'];
		$rate = $row['rate'];
		$autore = $row['author'];
		$image = $row['image'];
		$review = $row['review'];
		$review = stripslashes($review);
		if ($mklib->mkeditor == "BBCODE") {
			$review = $mklib->decode_bb($review);
			$review = $mklib_board->decode_smilies($review);
		}
		$even = $this->retrieve_event($idcategoria);
		$width = round(($rate*100)/4) - 6;
	 	$width2 = $width - 4;

		$query = $DB->query( "SELECT field1, field2, field3, field4, field5, field6, field7 FROM mkp_reviews_sections WHERE id = '$idcategoria'");
		$rowt = $DB->fetch_row($query);

		if ($rowt['field1']) {
			$field1 = "
			<tr>
                            <td class=\"modulecell\" width=\"5%\" valign=\"top\" align=\"left\">{$rowt['field1']}</td>
                            <td colspan=\"2\" class=\"modulecell\" width=\"95%\" align=\"left\">{$row['field1']}</td>
			</tr>
			";
		}
		if ($rowt['field2']) {
			$field2 = "
			<tr>
                            <td class=\"modulecell\" width=\"5%\" valign=\"top\" align=\"left\">{$rowt['field2']}</td>
                            <td colspan=\"2\" class=\"modulecell\" width=\"95%\" align=\"left\">{$row['field2']}</td>
			</tr>
			";
		}
		if ($rowt['field3']) {
			$field3 = "
			<tr>
                            <td class=\"modulecell\" width=\"5%\" valign=\"top\" align=\"left\">{$rowt['field3']}</td>
                            <td colspan=\"2\" class=\"modulecell\" width=\"95%\" align=\"left\">{$row['field3']}</td>
			</tr>
			";
		}
		if ($rowt['field4']) {
			$field4 = "
			<tr>
                            <td class=\"modulecell\" width=\"5%\" valign=\"top\" align=\"left\">{$rowt['field4']}</td>
                            <td colspan=\"2\" class=\"modulecell\" width=\"95%\" align=\"left\">{$row['field4']}</td>
			</tr>
			";
		}
		if ($rowt['field5']) {
			$field5 = "
			<tr>
                            <td class=\"modulecell\" width=\"5%\" valign=\"top\" align=\"left\">{$rowt['field5']}</td>
                            <td colspan=\"2\" class=\"modulecell\" width=\"95%\" align=\"left\">{$row['field5']}</td>
			</tr>
			";
		}
		if ($rowt['field6']) {
			$field6 = "
			<tr>
                            <td class=\"modulecell\" width=\"5%\" valign=\"top\" align=\"left\">{$rowt['field6']}</td>
                            <td colspan=\"2\" class=\"modulecell\" width=\"95%\" align=\"left\">{$row['field6']}</td>
			</tr>
			";
		}
		if ($rowt['field7']) {
			$field7 = "
			<tr>
                            <td class=\"modulecell\" width=\"5%\" valign=\"top\" align=\"left\">{$rowt['field7']}</td>
                            <td colspan=\"2\" class=\"modulecell\" width=\"95%\" align=\"left\">{$row['field7']}</td>
			</tr>
			";
		}


		if ($image) {
			$image = "
			<tr>
			<td class=\"modulecell\" align=\"center\" colspan=\"3\"><img src=\"mkportal/modules/reviews/images/$image\" align=\"middle\" border=\"0\" alt=\"\" /></td>
			</tr>
			";
		}
	 	$content .= $this->tpl->row_entry($iden, $name, $description, $trate, $rate, $width2, $width, $autore, $image, $field1, $field2, $field3, $field4, $field5, $field6, $field7, $review);

		$content .= "
		<tr>
		  <td class=\"tdblock\" colspan=\"3\">
		  {$mklib->lang['re_comments']}
		  </td>
		</tr>
		";
		$query = $DB->query( "SELECT id, autore, testo, data, scambio, id_autore FROM mkp_reviews_comments where identry = '$iden' ORDER BY `id` DESC");
		while( $row = $DB->fetch_row($query) ) {
			$idcomm = $row['id'];
			$autorec = $row['autore'];
			$testo = $row['testo'];
			$data = $mklib->create_date($row['data'], "short");
			$scambio = $row['scambio'];
			$id_autore = $row['id_autore'];
			$icons = "<img src='$mklib->images/rev.gif' border='0' alt=\"\" />";
			if($scambio) {
				$icons = "<img src=\"$mklib->images/rev1.gif\" border=\"0\" alt=\"\" />";
			}
			$delete = "
			<script type=\"text/javascript\">

			function makesure() {
			if (confirm('{$mklib->lang[re_delcommconf]}')) {
			return true;
			} else {
			return false;
			}
			}

			</script><a href=\"index.php?ind=reviews&amp;op=del_comment&amp;idcomm=$idcomm&amp;iden=$iden\" onclick=\"return makesure()\">[ {$mklib->lang['re_delete']} ]</a>
			";

			if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_reviews']) {
				$delete = "";
			}
			$content .= "
			<tr>
                          <td class=\"modulecell\" width=\"5%\" valign=\"top\"><a href=\"$link_user={$id_autore}\" class=\"uno\">{$autorec}</a><br />{$data}<br />{$delete}</td>
			  <td class=\"modulecell\" width=\"5\" valign=\"middle\">$icons</td>
                          <td class=\"modulecell\" width=\"75%\" valign=\"middle\">{$testo}</td>
			</tr>
			";
		}
		++$click;
		$DB->query("UPDATE mkp_reviews SET click ='$click'  where id = '$iden'");
		$navbar = "<a href=\"index.php?ind=reviews\">{$mklib->lang['re_ptitle2']}</a>-><a href=\"index.php?ind=reviews&amp;op=section_view&amp;idev=$idcategoria\">$even</a>-><a href=\"#\">$name</a>";
		$maintit = $name;
		$submit = "<script type=\"text/javascript\">
			function makesure2() {
			if (confirm('{$mklib->lang[re_delfileconf]}')) {
			return true;
			} else {
			return false;
			}
			}
			</script><a href=\"index.php?ind=reviews&amp;op=edit_file&amp;iden=$iden\">[ {$mklib->lang['re_edit']} ]</a>  <a href=\"index.php?ind=reviews&amp;op=del_file&amp;iden=$iden\" onclick=\"return makesure2()\">[ {$mklib->lang['re_delete']} ]</a> ";

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_reviews'] && $mkportals->member['name'] != $autore) {
			$submit = "";
		}
		$stat = $this->retrieve_stat();
		$toolbar = "";
		$utonline = $mklib_board->get_active_users("reviews");
		$output  = $this->tpl->review_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['re_pagetitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['re_pagetitle']}", $blocks);
	}

	function submit_file() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_reviews']) {
			$message = "{$mklib->lang['re_nosend']}";
			$mklib->error_page($message);
			exit;
		}

		$navbar = "<a href=\"index.php?ind=reviews\">{$mklib->lang['re_ptitle2']}</a>-><a href=\"#\">{$mklib->lang['re_send']}</a>";
		$maintit = "{$mklib->lang['re_ptitle']}";

		$cselect = $this->row_select_event();
		$content .= "
		<tr>
		  <td class=\"modulex\">
		  
		    <form action=\"index.php?ind=reviews&amp;op=submit_file1\"  method=\"post\">
		      <table width=\"100%\" border=\"0\">
			<tr>
			  <td class=\"titadmin\">{$mklib->lang['re_send']}</td>
			</tr>
			<tr>
			  <td width=\"15\">{$mklib->lang['re_select']}</td>
			</tr>
			<tr>
			<td>
			  <select class=\"bgselect\" name=\"evento\" size=\"1\">
			  {$cselect}
			  </select>
			</td>
		      </tr>
		      <tr>
			<td><br /></td>
		      </tr>
		      <tr>
			<td>
			  <input type=\"submit\" value=\"{$mklib->lang['re_go']}\" class=\"bgselect\" />
			</td>
		      </tr>
		    </table>
		    </form>
		    
		  </td>
		</tr>
		";

		$submit = " <a href=\"index.php?ind=reviews&amp;op=submit_file\">[ {$mklib->lang['re_send']} ]</a> ";
		$stat = $this->retrieve_stat();
		$toolbar = "";
		$utonline = $mklib_board->get_active_users("reviews");
		$output  = $this->tpl->review_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['re_ptitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['re_pagetitle']}", $blocks);
	}

	function submit_file1() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board, $editorscript;

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
		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_reviews']) {
			$message = "{$mklib->lang['re_nosend']}";
			$mklib->error_page($message);
			exit;
		}
		$idev = $mkportals->input['evento'];
		$navbar = "<a href=\"index.php?ind=reviews\">{$mklib->lang['re_ptitle2']}</a>-><a href=\"#\">{$mklib->lang['re_send']}</a>";
		$maintit = "{$mklib->lang['re_ptitle']}";

		$query = $DB->query( "SELECT field1, field2, field3, field4, field5, field6, field7 FROM mkp_reviews_sections WHERE id = '$idev'");
		$row = $DB->fetch_row($query);
		$content = "
		<tr>
		  <td class=\"modulex\">
		    <form action=\"index.php?ind=reviews&amp;op=add_file\" name=\"editor\" method=\"post\" enctype=\"multipart/form-data\">
		    <table width=\"100%\" border=\"0\">
		      <tr>
			<td class=\"titadmin\" colspan=\"2\">{$mklib->lang['re_send']}<br />&nbsp;
			  <input type=\"hidden\" value=\"$idev\" name=\"evento\" />
			</td>	   
		      </tr>
		      <tr>
			<td width=\"5%\">{$mklib->lang['re_title']}</td>
			<td width=\"95%\">
			  <input type=\"text\" name=\"titolo\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      <tr>
			<td width=\"5%\" valign=\"top\">{$mklib->lang['re_description']}</td>
			<td width=\"95%\">
			  <input type=\"text\" name=\"descrizione\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		";
		if ($row['field1']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$row['field1']}</td>
			<td width=\"95%\">
			  <input type=\"text\" name=\"field1\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      ";
		}
		if ($row['field2']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$row['field2']}</td>
			<td width=\"95%\">
			  <input type=\"text\" name=\"field2\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      ";
		}
		if ($row['field3']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$row['field3']}</td>
			<td width=\"95%\">
			  <input type=\"text\" name=\"field3\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      ";
		}
		if ($row['field4']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$row['field4']}</td>
			<td width=\"95%\">
			  <input type=\"text\" name=\"field4\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      ";
		}
		if ($row['field5']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$row['field5']}</td>
			<td width=\"95%\">
			  <input type=\"text\" name=\"field5\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      ";
		}
		if ($row['field6']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$row['field6']}</td>
			<td width=\"95%\">
			  <input type=\"text\" name=\"field6\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      ";
		}
		if ($row['field7']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$row['field7']}</td>
			<td width=\"95%\">
			  <textarea cols=\"50\" rows=\"3\" name=\"field7\" class=\"bgselect\"></textarea>
			</td>
		      </tr>
			";
		}
		$content .= "
		      <tr>
			<td><br /></td>
		      </tr>
		      <tr>
			<td colspan=\"2\" valign=\"top\">{$mklib->lang['re_review']}</td>
			</tr>
			<tr>
			<td width=\"100%\" colspan=\"2\">
			$bbeditor
 			<textarea id=\"ta\" name=\"ta\" $textarepar style=\"width: $textarew\" rows=\"14\" cols=\"40\"></textarea>
			</td>
		      </tr>
		      <tr>
			<td width=\"5%\">{$mklib->lang['re_image']}</td>
			<td width=\"95%\"><input type=\"file\" name=\"FILE_UPLOAD\" size=\"50\" class=\"bgselect\" /></td>
		      </tr>
		      <tr>
			<td><br /></td>
		      </tr>
		      <tr>
			<td width=\"5%\"></td>
			<td  width=\"95%\" align=\"left\">
			  <input type=\"submit\" value=\"{$mklib->lang['re_insert']}\" class=\"bgselect\" />
			</td>
		      </tr>
		    </table>
		    </form>
		  </td>
		</tr>
		";
		$submit = " <a href=\"index.php?ind=reviews&amp;op=submit_file\">[ {$mklib->lang['re_send']} ]</a> ";
		$stat = $this->retrieve_stat();
		$toolbar = "";
		$utonline = $mklib_board->get_active_users("reviews");
		$output  = $this->tpl->review_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['re_ptitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['re_pagetitle']}", $blocks);
	}

	function edit_file() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board, $editorscript;

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
		$maintit = "{$mklib->lang['re_ptitle']}";
		$iden = $mkportals->input['iden'];

		$query = $DB->query( "SELECT id_cat, title, description, field1, field2, field3, field4, field5, field6, field7, review, author FROM mkp_reviews where id = '$iden'");
		$row = $DB->fetch_row($query);
		$idcategoria = $row['id_cat'];

		$query1 = $DB->query( "SELECT id, title FROM mkp_reviews_sections ORDER BY `id` DESC");
		while( $row2 = mysql_fetch_array($query1) ) {
			$idevento = $row2['id'];
			$evento = $row2['title'];
			$selected = "";
			if($idevento == $idcategoria) {
				$selected = "selected=\"selected\"";
			}
			$cselect.= "<option value='$idevento' $selected>$evento</option>\n";
		}

		$name = $row['title'];
		$description = $row['description'];
		$description = str_replace("<br />", "\n", $description);
		$review = $row['review'];
		$review = stripslashes($review);
		$review = str_replace("<br />", "\n", $review);
		$row7 = $row['field7'];
		$row7 = str_replace("<br />", "\n", $row7);
		$autore = $row['author'];
		$nav_ev = $this->retrieve_event($idcategoria);

		$query1 = $DB->query( "SELECT field1, field2, field3, field4, field5, field6, field7 FROM mkp_reviews_sections WHERE id = '$idcategoria'");
		$rowt = $DB->fetch_row($query1);

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_reviews'] && $mkportals->member['name'] != $autore) {
			$message = "{$mklib->lang['re_noedit']}";
			$mklib->error_page($message);
			exit;
		}
		$content = "
		<tr>
		  <td class=\"modulex\">
		  
		    <form action=\"index.php?ind=reviews&amp;op=update_file&amp;iden=$iden\" name=\"editor\" method=\"post\">
		    <table width=\"100%\" border=\"0\">
		      <tr>
			<td class=\"titadmin\" colspan=\"2\">{$mklib->lang['re_editf']}</td>
		      </tr>
		      <tr>
			<td>{$mklib->lang['re_section']}</td>
			<td>
			  <select class=\"bgselect\" name=\"evento\" size=\"1\">
			  {$cselect}
			  </select>
			</td>
		      </tr>
		      <tr>
			<td width=\"10%\">{$mklib->lang['re_title']}</td>
			<td width=\"90%\">
			  <input type=\"text\" name=\"titolo\" value=\"$name\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      <tr>
			<td width=\"10%\" valign=\"top\">{$mklib->lang['re_description']}</td>
			<td width=\"90%\">
			  <textarea cols=\"50\" rows=\"3\" name=\"descrizione\" class=\"bgselect\">$description</textarea>
			</td>
		      </tr>
		";
		if ($rowt['field1']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$rowt['field1']}</td>
			<td width=\"95%\">
			  <input type=\"text\" value=\"{$row['field1']}\" name=\"field1\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      ";
		}
		if ($rowt['field2']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$rowt['field2']}</td>
			<td width=\"95%\">
			  <input type=\"text\" value=\"{$row['field2']}\" name=\"field2\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      ";
		}
		if ($rowt['field3']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$rowt['field3']}</td>
			<td width=\"95%\">
			  <input type=\"text\" value=\"{$row['field3']}\" name=\"field3\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      ";
		}
		if ($rowt['field4']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$rowt['field4']}</td>
			<td width=\"95%\">
			  <input type=\"text\" value=\"{$row['field4']}\" name=\"field4\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      ";
		}
		if ($rowt['field5']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$rowt['field5']}</td>
			<td width=\"95%\">
			  <input type=\"text\" value=\"{$row['field5']}\" name=\"field5\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      ";
		}
		if ($rowt['field6']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$rowt['field6']}</td>
			<td width=\"95%\">
			  <input type=\"text\" value=\"{$row['field6']}\" name=\"field6\" size=\"52\" class=\"bgselect\" />			      </td>
		      </tr>
		      ";
		}
		if ($rowt['field7']) {
			$content .= "
		      <tr>
			<td width=\"5%\">{$rowt['field7']}</td>
			<td width=\"95%\">
			  <textarea cols=\"50\" rows=\"3\" name=\"field7\" class=\"bgselect\"> $row7</textarea>
			</td>
		      </tr>
		      ";
		}
		$content .= "
		      <tr>
			<td><br /></td>
		      </tr>
		      <tr>
			<td colspan=\"2\" align=\"left\">{$mklib->lang['re_review']}</td>
			</tr>
			<tr>
			<td width=\"100%\" colspan=\"2\">
			$bbeditor
 			<textarea id=\"ta\" name=\"ta\" $textarepar style=\"width: $textarew\" rows=\"14\" cols=\"40\">$review</textarea>
			</td>
		      </tr>
		      <tr>
			<td><br /></td>
		      </tr>
		      <tr>
			<td width=\"5%\"></td>
			<td width=\"95%\" align=\"left\"><input type=\"submit\" value=\"{$mklib->lang['re_save']}\" class=\"bgselect\" /></td>
		      </tr>
		    </table>
		    </form>
		
		  </td>
		</tr>
		";
		//$submit = " <a href=\"index.php?ind=reviews&amp;op=del_file&amp;iden=$iden\">[ Elimina ]</a> ";
		$navbar = "<a href=\"index.php?ind=reviews\">{$mklib->lang['re_ptitle2']}</a>-><a href=\"index.php?ind=reviews&amp;op=section_view&amp;idev=$idcategoria\">$nav_ev</a>-><a href=\"index.php?ind=reviews&amp;op=entry_view&amp;iden=$iden\">$name</a>-><a href=\"#\">{$mklib->lang['re_editf']}</a>";
		$stat = $this->retrieve_stat();
		$toolbar = "";
		$utonline = $mklib_board->get_active_users("reviews");
		$output  = $this->tpl->review_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['re_pagetitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['re_pagetitle']}", $blocks);
	}


	function add_file() {

    	global $mkportals, $DB,  $_FILES, $mklib, $mklib_board;
		$evento = $mkportals->input['evento'];
		$title = $mkportals->input['titolo'];
		$description = $mkportals->input['descrizione'];
		$field1 = $mkportals->input['field1'];
		$field2 = $mkportals->input['field2'];
		$field3 = $mkportals->input['field3'];
		$field4 = $mkportals->input['field4'];
		$field5 = $mkportals->input['field5'];
		$field6 = $mkportals->input['field6'];
		$field7 = $mkportals->input['field7'];
		$review =  $mkportals->input['ta'];
		$review = $mklib->convert_savedb($review);
		$review = addslashes($review);
		$FILE_UPLOAD = $mkportals->input['FILE_UPLOAD'];
		$file =  $_FILES['FILE_UPLOAD']['tmp_name'];
		$file_name =  $_FILES['FILE_UPLOAD']['name'];
		$file_type =  $_FILES['FILE_UPLOAD']['type'];
		$author = $mkportals->member['name'];
		$idauth = $mkportals->member['id'];


        $file_ext = preg_replace("`.*\.(.*)`", "\\1", $file_name);

		if ($file_name) {
			if (!$mklib->check_attach($file_type, $file_ext))  {
				$message = $file_type;
				$message .= " - {$mklib->lang['error_filetype']}";
				$mklib->error_page($message);
				exit;
			}
		}

		if (!$evento || !$title || !$description) {
			$message = "{$mklib->lang['re_reqtcd']}";
			$mklib->error_page($message);
			exit;
		}

		if ($mklib->config['upload_file_max'] > 0 && $peso > ($mklib->config['upload_file_max']*1024)) {
			$message = "{$mklib->lang['re_toobig']}";
			$mklib->error_page($message);
			exit;
		}

		if ($file_name){
			$file_ext = substr ($file_name, (strlen($file_name)-3), 3);
			$file_ext = strtolower($file_ext);

			switch($file_ext)
			{
				case 'gif':
					$ext = 'gif';
					break;
				case 'jpg':
					$ext = 'jpg';
					break;
				case 'png':
					$ext = 'png';
					break;
				case 'tif':
					$ext = 'tif';
					break;
				case 'bmp':
					$ext = 'bmp';
					break;
				default:
					$ext = 'not_supported';
					break;
			}

			if ($ext == "not_supported")  {
				$message = "{$mklib->lang['re_notsup']}";
				$mklib->error_page($message);
				exit;
			}
			@copy("$file", "mkportal/modules/reviews/images/$file_name");
		}

        $cdata = time();

		$validat = "1";
		$approval = $mklib->config['approval_review'];
		if ($approval == "2" || $approval == "3") {
			$validat = 0;
		}
		if($mkportals->member['g_access_cp']) {
			$validat = "1";
		}

		$query="INSERT INTO mkp_reviews(id_cat, title, description, field1, field2, field3, field4, field5, field6, field7, image, review, author, idauth, date, validate)VALUES('$evento', '$title', '$description', '$field1', '$field2', '$field3', '$field4', '$field5', '$field6', '$field7', '$file_name', '$review', '$author', '$idauth', '$cdata', '$validat')";
		$DB->query($query);

		if ($approval == "1") {
			$mailsubj = $mklib->lang['01mail'].$mklib->lang['reviews'];
			$mailmess = $mklib->lang['02mail'].$mklib->lang['module'].$mklib->lang['reviews']."\n".$mklib->lang['sender'].$author."\n\n\n".$mklib->lang['from']." ".$mklib->sitename;
			$mklib_board->admin_mail($mailsubj, $mailmess);
		}
		if ($approval == "2") {
			$mailsubj = $mklib->lang['01mail'].$mklib->lang['reviews'];
			$mailmess = $mklib->lang['03mail'].$mklib->lang['module'].$mklib->lang['reviews']."\n".$mklib->lang['sender'].$author."\n\n\n".$mklib->lang['from']." ".$mklib->sitename;
			$mklib_board->admin_mail($mailsubj, $mailmess);
		}

		$DB->close_db();
	 	Header("Location: index.php?ind=reviews");
		exit;
  }
  function update_file() {
    	global $mkportals, $DB,  $mklib, $mklib_board;
		$iden= $mkportals->input['iden'];
		$evento = $mkportals->input['evento'];
		$title = $mkportals->input['titolo'];
		$description = $mkportals->input['descrizione'];
		$field1 = $mkportals->input['field1'];
		$field2 = $mkportals->input['field2'];
		$field3 = $mkportals->input['field3'];
		$field4 = $mkportals->input['field4'];
		$field5 = $mkportals->input['field5'];
		$field6 = $mkportals->input['field6'];
		$field7 = $mkportals->input['field7'];
		$review =  $mkportals->input['ta'];
		$review = $mklib->convert_savedb($review);
		$review = addslashes($review);
		$DB->query("UPDATE mkp_reviews SET id_cat ='$evento', title ='$title', description ='$description', field1='$field1', field2='$field2', field3='$field3', field4='$field4', field5='$field5', field6='$field6', field7='$field7', review='$review' where id = '$iden'");
		$DB->close_db();
		Header("Location: index.php?ind=reviews&op=entry_view&iden=$iden");
		exit;
  		}
	function del_file() {
    	global $mkportals, $DB, $mklib, $mklib_board;

		$iden= $mkportals->input['iden'];
		$query = $DB->query( "SELECT image, author FROM mkp_reviews WHERE id = $iden");
		$row = $DB->fetch_row($query);
		$file = $row['image'];
		$autore = $row['author'];
		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_reviews'] && $mkportals->member['name'] != $autore) {
			$message = "{$mklib->lang['re_nodel']}";
			$mklib->error_page($message);
			exit;
		}
		@unlink("mkportal/modules/reviews/images/$file");
		$DB->query("DELETE FROM mkp_reviews WHERE id = $iden");
		$DB->query("DELETE FROM mkp_reviews_comments WHERE identry = $iden");
		$DB->close_db();
	 	Header("Location: index.php?ind=reviews");
		exit;
  		}

  function submit_comment() {
		global $mkportals, $mklib, $Skin, $DB, $mklib_board;
		$ide= $mkportals->input['ide'];
		$query = $DB->query( "SELECT id, id_cat, title FROM mkp_reviews where id = '$ide'");
		$row = $DB->fetch_row($query);
		$t_id = $row['id'];
		$t_t = $row['title'];
		$t_ev1 = $row['id_cat'];
		$t_ev2 = $this->retrieve_event($t_ev1);
		$navbar = "<a href=\"index.php?ind=reviews\">{$mklib->lang['re_ptitle2']}</a>-><a href=\"index.php?ind=reviews&amp;op=section_view&amp;idev=$t_ev1\">$t_ev2</a>-><a href=\"index.php?ind=reviews&amp;op=entry_view&amp;iden=$t_id\">$t_t</a>-><a href=\"#\">{$mklib->lang['re_commfile']}</a>";
		$content = "
		
		<tr>
		  <td class=\"modulex\">
		  
		    <script type=\"text/javascript\">
		    function emo_pop()
		    {
			  window.open('{$mkportals->base_url}act=legends&amp;CODE=emoticons&amp;s={$mkportals->session_id}','Legends','width=250,height=500,resizable=yes,scrollbars=yes');
		    }
		    </script>

		    <form action=\"index.php?ind=reviews&amp;op=add_comment&amp;ide={$ide}\" name=\"editor\" method=\"post\" >
		    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"8\">
		      <tr>
			<td rowspan=\"3\" align=\"center\" height=\"100%\">
			  <iframe src=\"index.php?ind=reviews&amp;op=show_emoticons\" frameborder=\"0\"  width=\"200\" align=\"middle\" height=\"200\" scrolling=\"auto\"></iframe>
			</td>
			<td>{$mklib->lang['re_writecomm']}</td>
		      </tr>
		      <tr>
			<td width=\"70%\" align=\"left\"><textarea cols=\"10\" style=\"width:95%\" rows=\"4\" name=\"ta\"></textarea></td>
		      </tr>
		      <tr>
		      <td>{$mklib->lang['re_havetitle']} 
			<input type=\"checkbox\" name=\"scambio\" value=\"1\" /><br />
		      </td>
		    </tr>
		    <tr>
		      <td>
			<input type=\"submit\" name=\"submit\" value=\"{$mklib->lang['re_sendcomm']}\" class=\"button2\" accesskey=\"s\" /><br />
		      </td>
		    </tr>		
		  </table>
		  </form>
		
		</td>
	      </tr>
	";
	$maintit = "<a href=\"index.php?ind=reviews&amp;op=entry_view&amp;iden=$t_id\">{$mklib->lang['re_file']}: $t_t</a>";
	$stat = $this->retrieve_stat();
	$toolbar = "";
	$utonline = $mklib_board->get_active_users("reviews");
	$output  = $this->tpl->review_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
	$blocks = $Skin->view_block("{$mklib->lang['re_insertcomm']}", $output);
	$mklib->printpage("1", "1", "{$mklib->lang['re_pagetitle']}", $blocks);
	}

	function submit_rate() {
    	global $mkportals, $mklib, $Skin, $DB, $mklib_board;
		$ide= $mkportals->input['ide'];
		$iduser = $mkportals->member['id'];
		$ipuser = $_SERVER['REMOTE_ADDR'];
		$module = "reviews";

		$query = $DB->query( "SELECT id FROM mkp_votes where module = '$module' and id_entry = '$ide' and id_member = '$iduser'");
		$checkuser = mysql_num_rows ($query);
		$query = $DB->query( "SELECT id FROM mkp_votes where module = '$module' and id_entry = '$ide' and ip = '$ipuser'");
		$checkip = mysql_num_rows ($query);

		if($checkuser || $checkip) {
			$message = "{$mklib->lang['re_justvote']}";
			$mklib->error_page($message);
			exit;
		}

		$query = $DB->query( "SELECT id, id_cat, title FROM mkp_reviews where id = '$ide'");
		$row = $DB->fetch_row($query);
		$t_id = $row['id'];
		$t_t = $row['title'];
		$t_ev1 = $row['id_cat'];
		$t_ev2 = $this->retrieve_event($t_ev1);
		$navbar = "<a href=\"index.php?ind=reviews\">MKPReviews</a>-><a href=\"index.php?ind=reviews&amp;op=section_view&amp;idev=$t_ev1\">$t_ev2</a>-><a href=\"index.php?ind=reviews&amp;op=entry_view&amp;iden=$t_id\">$t_t</a>-><a href=\"#\">{$mklib->lang['re_vote']}</a>";
	   $content .= "
		<tr>
		  <td class=\"modulecell\">
		  
		    <form action=\"index.php?ind=reviews&amp;op=add_rate&amp;ide={$ide}\" method=\"post\" id=\"ratea\" name=\"ratea\">
		    <table width=\"100%\">
		      <tr>
			<td class=\"modulex\" width=\"50%\" valign=\"top\">{$mklib->lang['re_maxvote']}
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
			  <input type=\"submit\" name=\"ok\" value=\"  {$mklib->lang['re_sendvote']}  \" />
			</td>
		      </tr>		
		    </table>
		    </form>
		    
		  </td>
		</tr>
	";
	$maintit = "<a href=\"index.php?ind=reviews&amp;op=entry_view&amp;iden=$t_id\">{$mklib->lang['re_file']}: $t_t</a>";
	$stat = $this->retrieve_stat();
	$toolbar = "";
	$utonline = $mklib_board->get_active_users("reviews");
	$output  = $this->tpl->review_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
	$blocks = $Skin->view_block("{$mklib->lang['re_sendvote']}", $output);
	$mklib->printpage("1", "1", "{$mklib->lang['re_pagetitle']}", $blocks);
		}

	function add_comment() {
    	global $mkportals, $DB, $mklib, $mklib_board;


		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_comments']) {
			$message = "{$mklib->lang['re_nosendcom']}";
			$mklib->error_page($message);
			exit;
		}

		$ide= $mkportals->input['ide'];
		$testo = $mkportals->input['ta'];
		$autore = $mkportals->member['name'];
		$id_autore = $mkportals->member['id'];
		$scambio = $mkportals->input['scambio'];
        $cdata = time();
		if (!$testo) {
			$message = "{$mklib->lang['re_reqtext']}";
			$mklib->error_page($message);
			exit;
		}

		$testo = $mklib_board->decode_smilies($testo);
		
		//$testo = addslashes($testo);
		$query="INSERT INTO mkp_reviews_comments(identry, autore, testo, data, scambio, id_autore)VALUES('$ide', '$autore', '$testo', '$cdata', '$scambio', '$id_autore')";
		$DB->query($query);
		$DB->close_db();
	 	Header("Location: index.php?ind=reviews&op=entry_view&iden=$ide");
		exit;
  	}
	function del_comment() {
    	global $mkportals, $DB, $mklib, $mklib_board;

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_mod_reviews']) {
			$message = "{$mklib->lang['re_nodelcomm']}";
			$mklib->error_page($message);
			exit;
		}

		$ide= $mkportals->input['iden'];
		$idcomm= $mkportals->input['idcomm'];
		$DB->query("DELETE FROM mkp_reviews_comments WHERE id = $idcomm");
		$DB->close_db();
	 	Header("Location: index.php?ind=reviews&op=entry_view&iden=$ide");
		exit;
  	}



  		function add_rate() {
    	global $mkportals, $DB, $mklib, $mklib_board;
		$ide= $mkportals->input['ide'];
		$rating = $mkportals->input['rating'];
		$iduser = $mkportals->member['id'];
		$ipuser = $_SERVER['REMOTE_ADDR'];
		$module = "reviews";

		$query="INSERT INTO mkp_votes(id_entry, module, id_member, ip)VALUES('$ide', '$module', '$iduser', '$ipuser')";
		$DB->query($query);

		$query = $DB->query( "SELECT rate, trate FROM mkp_reviews where id = '$ide'");
		$row = $DB->fetch_row($query);
		$rate = $row['rate'];
		$trate = $row['trate'];
		$votes = ($trate +1);
		if ( $rating != 0 ) {
				$rate = round ((($trate*$rate)+$rating)/($votes), 2);
		}
		$DB->query("UPDATE mkp_reviews SET rate ='$rate', trate ='$votes' where id = '$ide'");
		$DB->close_db();
	 	Header("Location: index.php?ind=reviews&op=entry_view&iden=$ide");
		exit;
  		}

		function search() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;
		$maintit = "{$mklib->lang['re_searchf']}";
		$cselect.= "<option value=\"1\">{$mklib->lang['re_title']}</option>\n";
		$cselect.= "<option value=\"2\">{$mklib->lang['re_description']}</option>\n";
		$cselect.= "<option value=\"3\">{$mklib->lang['re_revtext']}</option>\n";
		$content .= "
		<tr>
		  <td class=\"modulex\">
		  
		    <form action=\"index.php?ind=reviews&amp;op=result_search\" name=\"search\" method=\"post\">
		    <table width=\"100%\" border=\"0\">
		      <tr>
			<td>{$mklib->lang['re_searchin']}:</td>
			<td>
			  <select class=\"bgselect\" name=\"campo\" size=\"1\">
			  {$cselect}
			  </select>
			</td>
		      </tr>
		      <tr>
			<td width=\"5%\">{$mklib->lang['re_searchtext']}</td>
			<td width=\"95%\">
			  <input type=\"text\" name=\"testo\" size=\"52\" class=\"bgselect\" />
			</td>
		      </tr>
		      <tr>
			<td colspan=\"2\"><input type=\"submit\" value=\"{$mklib->lang['re_searchstart']}\" class=\"bgselect\" /></td>
		      </tr>
		    </table>
		    </form>
		  </td>
		</tr>
		";
		$navbar = "<a href=\"index.php?ind=reviews\">MKPReviews</a>-><a href=\"#\">{$mklib->lang['re_searchf']}</a>";
		$stat = $this->retrieve_stat();
		$toolbar = "";
		$utonline = $mklib_board->get_active_users("reviews");
		$output  = $this->tpl->review_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['re_pagetitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['re_pagetitle']}", $blocks);
	}

	function result_search() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;
		$campo = $mkportals->input['campo'];
		$testo = $mkportals->input['testo'];
		$campo = "title";
		if ($mkportals->input['campo'] == 2) {
			$campo = "description";
		}
		if ($mkportals->input['campo'] == 3) {
			$campo = "review";
		}
		if (!$testo) {
			$message = "{$mklib->lang['re_reqstring']}";
			$mklib->error_page($message);
			exit;
		}
		$navbar = "<a href=\"index.php?ind=reviews\">MKPReviews</a>-><a href=\"#\">{$mklib->lang['re_searchresult']}</a>";
		$maintit = "{$mklib->lang['re_searchresult']}";
		$content = $this->tpl->row_main_entries();
		$query = $DB->query( "SELECT id, title, description, click, date, trate FROM mkp_reviews where $campo LIKE '%$testo%'");
		while( $row = $DB->fetch_row($query) ) {
			$iden = $row['id'];
			$name = $row['title'];
			$description = $row['description'];
			$trate = $row['trate'];
			$click = $row['click'];
			$data = $mklib->create_date($row['date'], "short");
			$name ="<a href=\"index.php?ind=reviews&amp;op=entry_view&amp;iden=$iden\">$name</a>";
			$content .= $this->tpl->row_main_entries_content($name, $trate, $description, $click, $data);
		}
		if (!$name) {
			$content = "<td align=\"center\" width=\"100%\" class=\"modulecell\"><br />{$mklib->lang['re_searchnot']}<br /><br /><br /></td>";
		}
		$submit = "";
		$stat = $this->retrieve_stat();
		$toolbar = "";
		$utonline = $mklib_board->get_active_users("reviews");
		$output  = $this->tpl->review_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $show_pages, $utonline);
		$blocks = $Skin->view_block("{$mklib->lang['re_pagetitle']}", $output);
		$mklib->printpage("1", "1", "{$mklib->lang['re_pagetitle']}", $blocks);
	}


		function row_select_event($jump="") {
			global $mkportals, $DB, $mklib, $mklib_board;

			if($jump) {
				$cselect = "<option value=\"0\">{$mklib->lang['re_jumpcat']}</option>\n";
			}

			$query = $DB->query( "SELECT id, title FROM mkp_reviews_sections ORDER BY `id` DESC");
			while( $row = $DB->fetch_row($query) ) {
				$idevento = $row['id'];
				$evento = $row['title'];
				$cselect.= "<option value=\"$idevento\">$evento</option>\n";
				$cselects.= "<option value=\"$idevento\">$evento</option>\n";
			}
			return $cselect;
		}
		function retrieve_event($idevento) {
			global $mkportals, $DB;
			$query = $DB->query( "SELECT title FROM mkp_reviews_sections WHERE id = '$idevento'");
			$evento = mysql_fetch_array($query);
			return $evento[0];
		}
		function retrieve_father($idevento) {
			global $mkportals, $DB;
			$query = $DB->query( "SELECT father FROM mkp_reviews_sections WHERE id = '$idevento'");
			$row = $DB->fetch_row($query);
			if($row['father']) {
				$evento = $this->retrieve_event($row['father']);
			}
			return array ($row['father'], $evento);
		}
		function retrieve_stat() {
			global $mkportals, $DB, $mklib, $mklib_board;
			$query = $DB->query( "SELECT id FROM mkp_reviews");
			$count = $DB->get_num_rows($query);
			$query = $DB->query( "SELECT id, title FROM mkp_reviews ORDER BY `click` DESC LIMIT 1");
			$row = mysql_fetch_array($query);
			$id = $row['id'];
			$name = $row['title'];
			$visitato = "<a href=\"index.php?ind=reviews&amp;op=entry_view&amp;iden=$id\">$name</a>";
			$query = $DB->query( "SELECT id, title FROM mkp_reviews ORDER BY `trate` DESC LIMIT 1");
			$row = mysql_fetch_array($query);
			$id = $row['id'];
			$name = $row['title'];
			$votato = "<a href=\"index.php?ind=reviews&amp;op=entry_view&amp;iden=$id\">$name</a>";
			$output = "{$mklib->lang['re_have']} $count {$mklib->lang['re_totfile']}<br />{$mklib->lang['re_mosts']} $visitato<br />{$mklib->lang['re_mostv']} $votato";
			return $output;
		}


		function show_emoticons()
 	{
		global $mklib_board;
		$mklib_board->show_emoticons();
 	}

}
?>
