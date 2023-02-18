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

$idx = new mk_blog;
class mk_blog {

	function mk_blog() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;

		$mklib->load_lang("lang_blog.php");

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_access_blog']) {
			$message = "{$mklib->lang['b_unauth']}";
			$mklib->error_page($message);
			exit;
		}
		if ($mklib->config['mod_blog']) {
		$message = "{$mklib->lang['b_mnoactive']}";
			$mklib->error_page($message);
			exit;
		}

		//location
		$mklib_board->store_location("blog");

		switch($mkportals->input['op']) {
    			case 'create':
    				$this->create();
    			break;
				case 'create_save':
    				$this->create_save();
    			break;
				case 'main_edit':
    				$this->main_edit();
    			break;
				case 'main_change':
    				$this->main_change();
    			break;
    			case 'show_preview':
    				$this->show_preview();
    			break;
				case 'insert_post':
    				$this->insert_post();
    			break;
				case 'update_post':
    				$this->update_post();
    			break;
				case 'del_post':
    				$this->del_post();
    			break;
				case 'show_comments':
    				$this->show_comments();
    			break;
				case 'insert_comments':
    				$this->insert_comments();
    			break;
				case 'del_comment':
    				$this->del_comment();
    			break;
				case 'del_blog':
    				$this->del_blog();
    			break;
				case 'edit_blog':
    				$this->edit_blog();
    			break;
				case 'edit_save':
    				$this->edit_save();
    			break;
				case 'edit_blog_link':
    				$this->edit_blog_link();
    			break;
				case 'add_link':
    				$this->add_link();
    			break;
				case 'rem_link':
    				$this->rem_link();
    			break;
				case 'edit_template':
    				$this->edit_template();
    			break;
				case 'save_template':
    				$this->save_template();
    			break;
				case 'show_gallery':
    				$this->show_gallery();
    			break;
				case 'home':
    				$this->home();
    			break;
				case 'preview_blog':
    				$this->preview_blog();
    			break;
				case 'submit_rate':
    				$this->submit_rate();
    			break;
				case 'add_rate':
    				$this->add_rate();
    			break;
				case 'chart':
    				$this->chart();
    			break;
				case 'edit_banner':
    				$this->edit_banner();
    			break;
				case 'save_banner':
    				$this->save_banner();
    			break;
				default:
    				$this->main_page();
    			break;
    		}

		}

	function main_page() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;

		$link_user = $mklib_board->forum_link("profile");
		$start = $mkportals->input['start'];
		$query = $DB->query("SELECT id FROM mkp_blog");
		$count = mysql_num_rows ($query);

		$q_page		=	$mkportals->input['st'];
		if ($q_page=="" or $q_page <= 0) {
			$q_page	=	0;
		}
		$per_page = $mklib->config['blog_page'];
		if ($per_page=="" or $per_page <= 0) {
			$per_page	=	10;
		}

	    $start = $q_page;
		$show_pages = $mklib->build_pages( array( TOTAL_POSS  => $count,
							PER_PAGE    => $per_page,
							CUR_ST_VAL  => $q_page,
							L_SINGLE    => '',
							L_MULTI     => 'pagine',
						    BASE_URL    => 'index.php?ind=blog',
										  )
								   );



		$utenti_in = $mklib_board->get_active_users("blog");

		$output = "
	<tr>
	  <td><br />
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td>
		  <table class=\"modulebg\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" border=\"0\">
		    <tr>
		      <td class=\"tdblock\" width=\"100%\" height=\"25\"><img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$mklib->lang['b_blog']}</td>
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
					<th class=\"modulex\" width=\"5%\">{$mklib->lang['b_vote']}</th>
					<th class=\"modulex\" width=\"20%\" >{$mklib->lang['b_title']}</th>
					<th class=\"modulex\" width=\"20%\">{$mklib->lang['b_author']}</th>
					<th class=\"modulex\" width=\"35%\">{$mklib->lang['b_description']}</th>
					<th class=\"modulex\" width=\"20%\" align=\"center\">{$mklib->lang['b_updated']}</th>
				      </tr>
	";

	$query = $DB->query( "SELECT id, autore, titolo, descrizione, aggiornato FROM mkp_blog WHERE validate='1' ORDER BY `aggiornato` DESC LIMIT $start, $per_page");
		while( $row = $DB->fetch_row($query) ) {
			$idb = $row['id'];
			$autore = $row['autore'];
			$titolo = $row['titolo'];
			$descrizione = $row['descrizione'];
			$aggiornato = $row['aggiornato'];
			$cdata = "[{$mklib->lang['b_nomsg']}]";
			if ($aggiornato) {
				$cdata = $mklib->create_date($aggiornato, "short");
			}
			if (!$descrizione) {
				$descrizione = "[{$mklib->lang['b_nodescrip']}]";
			}
			if (!$titolo) {
				$titolo = "[{$mklib->lang['b_notitle']}]";
			}
			$output .= "
				      <tr>
					<td class=\"modulecell\" align=\"center\"><a href=\"$mklib->siteurl/index.php?ind=blog&amp;op=submit_rate&amp;ide=$idb\"><img src=\"$mklib->images/rate.gif\" border=\"0\" alt=\"\" /></a></td>
					<td class=\"modulecell\" ><a href=\"$mklib->siteurl/index.php?ind=blog&amp;op=home&amp;idu=$idb\" target=\"_blank\">$titolo</a></td>
					<td class=\"modulecell\" ><a href=\"$link_user=$idb\" class=\"uno\">$autore</a></td>
					<td class=\"modulecell\" >$descrizione</td>
					<td class=\"modulecell\" align=\"center\">$cdata</td>
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
		&nbsp;&nbsp;{$show_pages}
		</td>
	      </tr>
	    </table>
	  </td>
	</tr>
	<tr>
 	  <td><br />
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"1\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td class=\"modulex\">
		  {$utenti_in}
		</td>
	      </tr>
	    </table>
	  </td>
	</tr>

	<tr>
	  <td align=\"center\"><br /><br />
	    <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\">MKPBlog - ©2004 Tutti i diritti riservati</a></div>
	  </td>
	</tr>	 
	";
	
		$mklib->printpage_blog("1", "1", "{$mklib->lang['b_pagetitle']}", $output, "");

	}

	function create() {
		global $mkportals, $DB, $mklib, $Skin;

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_blog']) {
			$message = "{$mklib->lang['b_unauthc']}";
			$mklib->error_page($message);
			exit;
		}

		$idu = $mkportals->member['id'];
		$urlb = $mkportals->member['name'];
		$urlb = strtolower ($urlb);
		$urlb = str_replace(" ", "", $urlb);
		$urlb = "$mklib->mkurl/blog/$urlb".".html";
		$query = mysql_query("select id from mkp_blog where id = '$idu'");
        $result = mysql_num_rows($query);
        if ($result) {
			$message = "{$mklib->lang['b_delbeforec']}";
			$mklib->error_page($message);
			exit;
		}
		if ($idu < 1) {
			$message = "{$mklib->lang['b_unauthv']}";
			$mklib->error_page($message);
			exit;
		}
		$subtitle = "{$mklib->lang['b_createtitle']}";
		$filename = "mkportal/modules/blog/disclaimer.txt";
		$fd = fopen ($filename, "r");
		$disclaimer = fread ($fd, filesize ($filename));
		fclose ($fd);

			$content = "
	<tr>
	  <td>
	  
	    <form name=\"main1\" method=\"post\" action=\"index.php?ind=blog&amp;op=create_save\">
	    <table>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['b_title']}</td>
	      </tr>
	      <tr>
		<td>
		  <input class=\"bgselect\" type=\"text\" name=\"titolo\" size=\"40\" />
		</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\"><br />{$mklib->lang['b_description']}</td>
	      </tr>
	      <tr>
		<td>
		  <textarea class=\"mkwrap1\" cols=\"40\" rows=\"5\" name=\"descrizione\"></textarea>
		</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\"><br />{$mklib->lang['b_url']}</td>
	      </tr>
	      <tr>
		<td><b>$urlb</b></td>
	      </tr>
	      <tr>
		<td class=\"titadmin\"><br />{$mklib->lang['b_disclaimer']}</td>
	      </tr>
	      <tr>
		<td>
		  <textarea class=\"mkwrap1\" cols=\"60\" rows=\"10\" name=\"disclaimer\" readonly=\"readonly\">$disclaimer</textarea>
		</td>
	      </tr>
	      
	      <tr>
		<td colspan=\"2\" class=\"titadmin\"><br />
		  <input type=\"submit\" value=\"{$mklib->lang['b_acceptdisc']}\" name=\"B1\" />
		</td>
	      </tr>
	    </table>
	    </form>
	    
	  </td>
	</tr>
			";
			$output = $Skin->view_block("$subtitle", "$content");
			$mklib->printpage_blog("1", "1", "{$mklib->lang['b_pagetitle']}", $output);

		}

		function create_save() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board, $MK_LANG;

		$idu = $mkportals->member['id'];
		$name = $mkportals->member['name'];
		//$home = $mkportals->input['indirizzo'];
		$titolo = $mkportals->input['titolo'];
		$descrizione = nl2br($mkportals->input['descrizione']);
		$data = time();
		$urlb = strtolower ($name);
		$urlb = str_replace(" ", "", $urlb);
		$urlb = "mkportal/blog/$urlb".".html";

		$filename = "mkportal/modules/blog/templates/template.html";
		if ($MK_LANG == "English") {
			$filename = "mkportal/modules/blog/templates/English/template.html";
		}
		$fd = fopen ($filename, "r");
		$contents = fread ($fd, filesize ($filename));
		fclose ($fd);

		$pos = strpos($contents, "<!-- template2 -->");
		$template2 = substr($contents, ($pos + 18));
		$template = substr($contents, 0, $pos);

		$data = time();
		$filename = "mkportal/blog/tpl_blog.html";

		$filename2 = $urlb;
		copy($filename, $filename2);
		$fp = fopen($filename2, "w") or die("error opening w");
        $testo = "<script type=\"text/javascript\">
         <!--
            location.href = \"$mklib->siteurl/index.php?ind=blog&amp;op=home&amp;idu=$idu\";
         //-->
        </script>";
        fwrite($fp, $testo);
        fclose($fp);

		$validat = "1";
		$approval = $mklib->config['approval_blog'];
		if ($approval == "2" || $approval == "3") {
			$validat = 0;
		}
		if($mkportals->member['g_access_cp']) {
			$validat = "1";
		}

		$query="insert into mkp_blog(id, autore, titolo, descrizione, template, template2, creato, validate) values ('$idu', '$name', '$titolo', '$descrizione', '$template', '$template2', '$data', '$validat')";
		$DB->query($query);

		if ($approval == "1") {
			$mailsubj = $mklib->lang['01mail'].$mklib->lang['blog'];
			$mailmess = $mklib->lang['02mail'].$mklib->lang['module'].$mklib->lang['blog']."\n".$mklib->lang['sender'].$name."\n\n\n".$mklib->lang['from']." ".$mklib->sitename;
			$mklib_board->admin_mail($mailsubj, $mailmess);
		}
		if ($approval == "2") {
			$mailsubj = $mklib->lang['01mail'].$mklib->lang['blog'];
			$mailmess = $mklib->lang['03mail'].$mklib->lang['module'].$mklib->lang['blog']."\n".$mklib->lang['sender'].$name."\n\n\n".$mklib->lang['from']." ".$mklib->sitename;
			$mklib_board->admin_mail($mailsubj, $mailmess);
		}

		$DB->close_db();
	 	Header("Location: index.php?ind=blog&op=edit_blog");
		exit;
		}

		function main_edit() {
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

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_blog']) {
			$message = "{$mklib->lang['b_unauthw']}";
			$mklib->error_page($message);
			exit;
		}
		$idu = $mkportals->member['id'];
		$curmese = $mkportals->input['curmese'];
		$query = mysql_query("select id, validate from mkp_blog where id = '$idu'");
        $result = mysql_num_rows($query);
        if (!$result) {
			$message = "{$mklib->lang['b_c_b_w']}";
			$mklib->error_page($message);
			exit;
		}
		list ($id, $validate) = mysql_fetch_row($query);
		if ($validate == 0) {
			$message = "{$mklib->lang['wait_valid']}";
			$mklib->error_page($message);
			exit;
		}
		$content = "
		<tr>
		  <td>
		  
		    <form action=\"index.php?ind=blog&amp;op=insert_post\" method=\"post\" id=\"editor\" name=\"editor\">
		    <table width=\"100%\">
		      <tr>
			<td id=\"tdblock\">
			$bbeditor
 			<textarea id=\"ta\" name=\"ta\" $textarepar style=\"width: $textarew\" rows=\"14\" cols=\"40\"></textarea>
		      </td>
		    </tr>
		    <tr>
		      <td>
			<input type=\"submit\" name=\"ok\" value=\"{$mklib->lang['b_writesave']}\" />		
		      </td>
		    </tr>
		  </table>
		  </form>
		  <table width=\"100%\">
		    <tr>
		      <td>
			<iframe src=\"index.php?ind=blog&amp;op=show_preview&amp;curmese=$curmese\" name=\"inferiore\" frameborder=\"0\"  width=\"100%\" align=\"middle\" height=\"600\" scrolling=\"auto\"></iframe>
		      </td>
		    </tr>		
		  </table>
		</td>
	      </tr>
	";
		$output = $Skin->view_block("{$mklib->lang['b_writetitle']}", "$content");
		$mklib->printpage_blog("0", "0", "MKBlog", $output);

		}
		function main_change () {
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
			if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_blog']) {
				$message = "{$mklib->lang['b_unauthw']}";
				$mklib->error_page($message);
				exit;
			}

			$idm = $mkportals->input['idm'];
			$query = mysql_query("select post from mkp_blog_post where id = '$idm'");
        	$result = mysql_fetch_array($query);
			$message = $result[0];
			$message = stripslashes($message);
			if ($mklib->mkeditor == "BBCODE") {
				$message = str_replace("<br />", "\n", $message);
			}
		$content = "
		<tr>
		  <td>
		  
		    <form action=\"index.php?ind=blog&amp;op=update_post\" method=\"post\" id=\"editor\" name=\"editor\">
		    <table width=\"100%\">
		      <tr>
			<td class=\"tdblock\">
			$bbeditor
 			<textarea id=\"ta\" name=\"ta\" $textarepar style=\"width: $textarew\" rows=\"14\" cols=\"40\">$message</textarea>
			</td>
		      </tr>
		      <tr>
			<td>
			  <input type=\"hidden\" name=\"idm\" value=\"$idm\" />
			  <input type=\"submit\" name=\"ok\" value=\"{$mklib->lang['b_writesave']}\" />
			</td>
		      </tr>		    
		    </table>
		    </form>
		    <table width=\"100%\">
		      <tr>
			<td>
			  <iframe src=\"index.php?ind=blog&amp;op=show_preview\" name=\"inferiore\" frameborder=\"0\" width=\"100%\" align=\"middle\" height=\"600\" scrolling=\"auto\"></iframe>
			</td>
		      </tr>
		    </table>
		  </td>
		</tr>
	";
		$output = $Skin->view_block("{$mklib->lang['b_writetitle']}", "$content");
		$mklib->printpage_blog("0", "0", "{$mklib->lang['b_pagetitle']}", $output);

		}

		function show_preview() {
 		global $mkportals, $DB, $Skin, $mklib;

		$curmese = $mkportals->input['curmese'];
		$template = "<BASE TARGET=\"_top\">";
		 $template .= $this->createmp($curmese);

		print $template;


 	}


	function insert_post () {
		global $mkportals, $DB, $Skin, $mklib;

		$idu = $mkportals->member['id'];
		$post = $mkportals->input['ta'];
		$post = $mklib->convert_savedb($post);
		$post = addslashes($post);
        	$data = time();
		if ($post) {
       		$DB->query("insert into mkp_blog_post(id_blog, post, data) values ('$idu', '$post', '$data')");
        	$DB->query("update mkp_blog set aggiornato = '$data'  where id = '$idu'");
		}
		$DB->close_db();
	 	Header("Location: index.php?ind=blog&op=main_edit");
		exit;

    }

	function update_post () {
		global $mkportals, $DB, $Skin, $mklib;

		$idm = $mkportals->input['idm'];
		$post = $mkportals->input['ta'];
		$post = $mklib->convert_savedb($post);
		$post = addslashes($post);
       		$DB->query("update mkp_blog_post set post = '$post'  where id = '$idm'");

		$DB->close_db();
	 	Header("Location: index.php?ind=blog&op=main_edit");
		exit;
    }
	function del_post () {
		global $mkportals, $DB, $Skin, $mklib;

		$idm = $mkportals->input['idm'];
		$query = $DB->query( "SELECT id_blog from mkp_blog_post where id = '$idm'");
		$row = $DB->fetch_row($query);

		if ($mkportals->member['id'] == $row['id_blog']) {
        	mysql_query("delete from mkp_blog_post where id = '$idm'");
			mysql_query("delete from mkp_blog_commenti where id_post = '$idm'");
		}
		$DB->close_db();
	 	Header("Location: index.php?ind=blog&op=main_edit");
		exit;

    }

	function show_comments () {
		global $mkportals, $DB, $Skin, $mklib;

		$idm = $mkportals->input['idm'];
		$mode = $mkportals->input['mode'];

		$query = mysql_query("select id, autore, home, commento from mkp_blog_commenti where id_post = '$idm' ORDER BY id DESC");
        while (list ($idcom, $autore, $home, $commento) = mysql_fetch_row ($query)) {
            $messaggi .= "<style type=\"text/css\" ><!--
                    .commenti {
                font-family: Tahoma, Arial, Verdana, Helvetica, Georgia, serif, \"Times New Roman\"; font-size:7pt; color:#000000;
                letter-spacing:1px;
                border-top: #FFB72F 1px solid;
                border-left: #FFB72F 1px solid;
                border-right: #EF8F0F 1px solid;
                border-bottom: #DF6700 1px solid;
                padding:1px;
                 text-align:left;
                }
                -->
                </style>";
            $messaggi .= "<table width=\"100%\" cellspacing=\"4\" cellpadding=\"4\" class=\"commenti\"><tr>";
			$messaggi .= "<td width=\"100%\" style=\"font-size: 9px; font-family: Verdana; font-style: italic\">";
			if ($mode) {
            	$messaggi .= "<a href=\"index.php?ind=blog&amp;op=del_comment&amp;idcom=$idcom&amp;idm=$idm\"><img src=\"$mklib->images/cancella.jpg\" border=\"0\" alt=\"elimina\" /></a><br /><br />";
			}
			$messaggi .= "$commento </td></tr>";
            $messaggi .= "<tr><td width=\"100%\" bgcolor=\"#F0A962\" style=\"font-family: Verdana; font-size: 9px\">{$mklib->lang['b_commentby']} $autore {$mklib->lang['b_commentvisit']} <a href=\"$home\" target=\"_new\">{$mklib->lang['b_blog']}</td>";
            $messaggi .= "</tr></table><br />";

        }
		$home = "$mklib->mkurl/blog/{$mkportals->member['name']}.html";
 		$home = strtolower ($home);
 		$home = str_replace(" ", "", $home);

		$autore = $mkportals->member['name'];
		$query = $DB->query( "SELECT autore FROM mkp_blog WHERE autore='$autore'");
		if ($DB->fetch_row($query)) {
			include("mkportal/modules/blog/popup/commenti.html");
		} elseif (!$DB->fetch_row($query)) {
			include("mkportal/modules/blog/popup/commenti1.html");
		} else  {
			include("mkportal/modules/blog/popup/commentino2.html");
		}
		$DB->close_db();
		exit;

	}
	function insert_comments () {
		global $mkportals, $DB, $Skin, $mklib;

		$idm = $mkportals->input['idm'];
		$autore = $mkportals->input['autore'];
		$home = $mkportals->input['home'];
		$commento = $mkportals->input['commento'];

		$query = $DB->query( "SELECT id_blog from mkp_blog_post where id = '$idm'");
		$row = $DB->fetch_row($query);
		$id_blog = $row['id_blog'];

		if ($commento) {
       	mysql_query("insert into mkp_blog_commenti(id_blog, id_post, autore, home, commento) values ('$id_blog', '$idm', '$autore', '$home', '$commento')");
        $query = mysql_query("select ncom from mkp_blog_post where id = '$idm'");
        $result = mysql_fetch_array($query);
        $count = "$result[0]";
        ++ $count;
        mysql_query("update mkp_blog_post set ncom = '$count'  where id = '$idm'");
		}
		$DB->close_db();
	 	Header("Location: index.php?ind=blog&op=show_comments&idm=$idm");
		exit;

    }
	function del_comment () {
		global $mkportals, $DB, $Skin, $mklib;
		$idm = $mkportals->input['idm'];
		$idcom = $mkportals->input['idcom'];

		$query = $DB->query( "SELECT id_blog from mkp_blog_post where id = '$idm'");
		$row = $DB->fetch_row($query);

		if ($mkportals->member['id'] == $row['id_blog']) {
			mysql_query("delete from mkp_blog_commenti where id = '$idcom'");
		}
		$query = mysql_query("select ncom from mkp_blog_post where id = '$idm'");
        $result = mysql_fetch_array($query);
        $count = "$result[0]";
        -- $count;
        mysql_query("update mkp_blog_post set ncom = '$count'  where id = '$idm'");

		$DB->close_db();
	 	Header("Location: index.php?ind=blog&op=show_comments&idm=$idm");
		exit;

    }
	function del_blog () {
		global $mkportals, $DB, $Skin, $mklib;
		$idb = $mkportals->member['id'];

		$query = mysql_query("select id from mkp_blog where id = '$idb'");
        $result = mysql_num_rows($query);
        if (!$result) {
			$message = "{$mklib->lang['b_c_b_d']}";
			$mklib->error_page($message);
			exit;
		}
		mysql_query("delete from mkp_blog_commenti where id_blog = '$idb'");
		mysql_query("delete from mkp_blog_post where id_blog = '$idb'");
        mysql_query("delete from mkp_blog where id = '$idb'");

		$usfile = "mkportal/blog/{$mkportals->member['name']}.html";
 		$usfile = strtolower ($usfile);
 		$usfile = str_replace(" ", "", $usfile);
        @unlink($usfile);
		$DB->close_db();
	 	Header("Location: index.php?ind=blog&op=create");
		exit;

    }

	function edit_blog () {
		global $mkportals, $DB, $Skin, $mklib;

		$mode = $mkportals->input['mode'];
		$idu = $mkportals->member['id'];
		$urlb = $mkportals->member['name'];
		$urlb = strtolower ($urlb);
		$urlb = str_replace(" ", "", $urlb);
		$urlb = "$mklib->mkurl/blog/$urlb".".html";
		$query = mysql_query("select id from mkp_blog where id = '$idu'");
        $result = mysql_num_rows($query);
        if (!$result) {
			$message = "{$mklib->lang['b_c_b_e']}";
			$mklib->error_page($message);
			exit;
		}
		$query = mysql_query("select titolo, descrizione, eta, segno, citta, libri, film, canzoni, amo, odio, citazione, maxmess from mkp_blog where id = '$idu'");
		list ($titolo, $descrizione, $eta, $segno, $citta, $libri, $film, $canzoni, $amo, $odio, $citazione, $maxmess) = mysql_fetch_row ($query);
		$libri = str_replace("<br />", "\n", $libri);
		$film = str_replace("<br />", "\n", $film);
		$canzoni = str_replace("<br />", "\n", $canzoni);
		$amo = str_replace("<br />", "\n", $amo);
		$odio = str_replace("<br />", "\n", $odio);
		$citazione = str_replace("<br />", "\n", $citazione);
		$subtitle = "{$mklib->lang['b_edittitle']}";
		if ($mode == "saved") {
			$checksave = "{$mklib->lang['b_saved']}<br /><br />";
   		}
		$home = "$mklib->mkurl/blog/{$mkportals->member['name']}.html";
 		$home = strtolower ($home);
 		$home = str_replace(" ", "", $home);

		$content = "
		<tr>
		  <td>
		  
		    <form name=\"conf1\" method=\"post\" action=\"index.php?ind=blog&amp;op=edit_save\">
		    <table>
		      <tr>
			<td>
			$checksave
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"><br />{$mklib->lang['b_url']}</td>
		      </tr>
		      <tr>
			<td><a href=\"$urlb\" target=\"_blank\" class=\"mktxtcontr\"><b>$home</b></a></td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"><br />{$mklib->lang['b_title']}</td>
		      </tr>
		      <tr>
			<td>
			  <input class=\"bgselect\" type=\"text\" name=\"titolo\" value=\"$titolo\" size=\"40\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"><br />{$mklib->lang['b_description']}</td>
		      </tr>
		      <tr>
		      <td>
			<textarea class=\"mkwrap1\" cols=\"40\" rows=\"5\" name=\"descrizione\">$descrizione</textarea>
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"> <br />{$mklib->lang['b_minusmsg']}</td>
		      </tr>
		      <tr>
			<td>
			  <select class=\"bgselect\" name=\"maxmess\" size=\"1\">
			    <option value=\"$maxmess\">$maxmess</option>
			    <option value=\"0\">0</option>
			    <option value=\"5\">5</option>
			    <option value=\"10\">10</option>
			    <option value=\"15\">15</option>
			    <option value=\"20\">20</option>
			    <option value=\"25\">25</option>
			    <option value=\"30\">30</option>
			  </select>
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"><br />{$mklib->lang['b_age']}</td>
		      </tr>
		      <tr>
			<td>
			  <input class=\"bgselect\" type=\"text\" name=\"eta\" value=\"$eta\" size=\"40\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\">{$mklib->lang['b_zodiac']}</td>
		      </tr>
		      <tr>
			<td>
			  <input class=\"bgselect\" type=\"text\" name=\"segno\" value=\"$segno\" size=\"40\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\">{$mklib->lang['b_city']}</td>
		      </tr>
		      <tr>
			<td>
			  <input class=\"bgselect\" type=\"text\" name=\"citta\" value=\"$citta\" size=\"40\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"><br />{$mklib->lang['b_links']}</td>
		      </tr>
		      <tr>
			<td class=\"bgselect\" align=\"center\"><br /><b><a href=\"index.php?ind=blog&amp;op=edit_blog_link\" class=\"mktxtcontr\"> [ {$mklib->lang['b_linksclick']} ] </a></b><br /></td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"><br /> {$mklib->lang['b_books']}</td>
		      </tr>
		      <tr>
			<td>
			  <textarea class=\"mkwrap1\" cols=\"40\" rows=\"5\" name=\"libri\">$libri</textarea>
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"><br />{$mklib->lang['b_movies']}</td>
		      </tr>
		      <tr>
			<td>
			  <textarea class=\"mkwrap1\" cols=\"40\" rows=\"5\" name=\"film\">$film</textarea>
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"><br />{$mklib->lang['b_songs']}</td>
		      </tr>
		      <tr>
			<td>
			  <textarea class=\"mkwrap1\" cols=\"40\" rows=\"5\" name=\"canzoni\">$canzoni</textarea>
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"><br />{$mklib->lang['b_love']}</td>
		      </tr>
		      <tr>
			<td>
			  <textarea class=\"mkwrap1\" cols=\"40\" rows=\"5\" name=\"amo\">$amo</textarea>
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"><br />{$mklib->lang['b_hate']}</td>
		      </tr>
		      <tr>
			<td>
			  <textarea class=\"mkwrap1\" cols=\"40\" rows=\"5\" name=\"odio\">$odio</textarea>
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\"><br />{$mklib->lang['b_cit']}</td>
		      </tr>
		      <tr>
			<td>
			  <textarea class=\"mkwrap1\" cols=\"40\" rows=\"5\" name=\"citazione\">$citazione</textarea>
			</td>
		      </tr>
		      <tr>
			<td colspan=\"2\" class=\"titadmin\"><br />
			  <input type=\"submit\" value=\"{$mklib->lang['b_savecfg']}\" name=\"B1\" />
			</td>
		      </tr>
		    </table>
		    </form>

		  </td>
		</tr>
			";
			$output = $Skin->view_block("$subtitle", "$content");
			$mklib->printpage_blog("1", "1", "{$mklib->lang['b_pagetitle']}", $output);

    }

	function edit_save () {
		global $mkportals, $DB, $Skin, $mklib;

		$idb = $mkportals->member['id'];

		$titolo = stripslashes($mkportals->input['titolo']);
		$descrizione = stripslashes($mkportals->input['descrizione']);
		$eta = stripslashes($mkportals->input['eta']);
		$segno = stripslashes($mkportals->input['segno']);
		$citta = stripslashes($mkportals->input['citta']);
		$libri = stripslashes($mkportals->input['libri']);
		$film = stripslashes($mkportals->input['film']);
		$canzoni = stripslashes($mkportals->input['canzoni']);
		$amo = stripslashes($mkportals->input['amo']);
		$odio = stripslashes($mkportals->input['odio']);
		$citazione = stripslashes($mkportals->input['citazione']);

		$maxmess = $mkportals->input['maxmess'];

		mysql_query("update mkp_blog set titolo = '$titolo', descrizione = '$descrizione', eta = '$eta', segno = '$segno', citta = '$citta', libri = '$libri', film = '$film', canzoni = '$canzoni', amo = '$amo', odio = '$odio', citazione = '$citazione', maxmess = '$maxmess'  where id = '$idb'");

		$DB->close_db();
	 	Header("Location: index.php?ind=blog&op=edit_blog&mode=saved");
		exit;

    }

	function edit_blog_link () {
		global $mkportals, $DB, $Skin, $mklib;

		$mode = $mkportals->input['mode'];
		$idu = $mkportals->member['id'];
		$query = mysql_query("select id from mkp_blog where id = '$idu'");
        $result = mysql_num_rows($query);
        if (!$result) {
			$message = "{$mklib->lang['b_c_b_e']}";
			$mklib->error_page($message);
			exit;
		}
		$query = mysql_query("select  link from mkp_blog where id = '$idu'");
		list ($link2) = mysql_fetch_row ($query);
		$cselect = "";
		$stringa=explode("§", $link2);
 		for($i=0;$i<count($stringa);$i++){
			if ($stringa[$i]) {
  				$cselect .= "<option value=\"$stringa[$i]\">$stringa[$i]</option>\n";
			}
		}

		$subtitle = "{$mklib->lang['b_linktitle']}";
		if ($mode == "saved") {
			$checksave = "{$mklib->lang['b_saved']}<br /><br />";
   		}
		$content .= "
		<tr>
		  <td>

		  <form action=\"index.php?ind=blog&amp;op=add_link\" name=\"ADD\" method=\"post\">		  
		  <table width=\"100%\">		
		    <tr>
		      <td>
		      $checksave
		      </td>
		    </tr>
		    <tr>
		      <td class=\"titadmin\"><br />{$mklib->lang['b_linkadd']}</td>
		    </tr>
		    <tr>
		      <td class=\"tdblock\">
			{$mklib->lang['b_title']}
			<input type=\"text\" value=\"{$mklib->lang['b_linkname']}\" name=\"link\" size=\"40\" />
		      </td>
		    </tr>
		    <tr>
		      <td class=\"tdblock\"> {$mklib->lang['b_linkurl']}
			<input type=\"text\" value=\"http://\" name=\"link2\"  size=\"60\" />
		      </td>
		    </tr>
		    <tr>
		      <td class=\"tdblock\">
			<input type=\"submit\" value=\"{$mklib->lang['b_linkadd2']}\" />
		      </td>
		    </tr>
		  </table>
		  </form>

		</td>
	      </tr>
		
	      <tr>
		<td>
		  
		
		  <form action=\"index.php?ind=blog&amp;op=rem_link\" name=\"Rem\" method=\"post\">
		  <table width=\"100%\">
		    <tr>
		      <td class=\"trattini\"><br />{$mklib->lang['b_linkrem']}</td>
		    </tr>
		    <tr>
		      <td class=\"tdblock\">
			{$mklib->lang['b_linkrem2']}
			<select class=\"bgselect\" name=\"vlink\" size=\"1\">
			{$cselect}
			</select>
		      </td>
		    </tr>
		    <tr>
		      <td class=\"tdblock\">
			<input type=\"submit\" name=\"ok\" value=\"{$mklib->lang['b_linkrem3']}\" />
		      </td>
		    </tr>
		  </table>
		  </form>
	
		</td>
	      </tr>

	";
			$output = $Skin->view_block("$subtitle", "$content");
			$mklib->printpage_blog("1", "1", "{$mklib->lang['b_pagetitle']}", $output);
	}

	function add_link () {
		global $mkportals, $DB, $Skin, $mklib;

		$idb = $mkportals->member['id'];
		$link = $mkportals->input['link'];
		$link2 = $mkportals->input['link2'];

		if ($link == $mklib->lang['b_linkname']) {
			$message = "{$mklib->lang['b_reqlinkn']}";
			$mklib->error_page($message);
			exit;
		}
		if ($link && $link2) {
				$query = mysql_query("select link from mkp_blog where id = '$idb'");
				$result = mysql_fetch_array($query);
				$outputs = $result[0];
				$outputs .= $link."|".$link2."§";
				mysql_query("update mkp_blog set link = '$outputs' where id = '$idb'");
		}
		$DB->close_db();
	 	Header("Location: index.php?ind=blog&op=edit_blog_link&mode=saved");
		exit;

    }
	function rem_link () {
		global $mkportals, $DB, $Skin, $mklib;

		$idb = $mkportals->member['id'];
		$link = $mkportals->input['vlink'];

		if ($link) {
				$stringa = $link."§";
				$query = mysql_query("select link from mkp_blog where id = '$idb'");
				$result = mysql_fetch_array($query);
				$outputs = str_replace ("$stringa", "", $result[0]);
				mysql_query("update mkp_blog set link = '$outputs' where id = '$idb'");
		}
		$DB->close_db();
	 	Header("Location: index.php?ind=blog&op=edit_blog_link&mode=saved");
		exit;

    }

	function edit_template () {
		global $mkportals, $DB, $Skin, $mklib, $MK_LANG;

		$mft = $mkportals->input['mft'];
		$mft = str_replace("../", "", $mft);
		$mft = str_replace("./", "", $mft);
		$mft = str_replace(".\/", "", $mft);
		$idu = $mkportals->member['id'];
		$query = mysql_query("select id from mkp_blog where id = '$idu'");
        $result = mysql_num_rows($query);
        if (!$result) {
			$message = "{$mklib->lang['b_c_b_et']}";
			$mklib->error_page($message);
			exit;
		}

		if ($mft) {
			$filename = "mkportal/modules/blog/templates/$mft";
			if ($MK_LANG == "English") {
				$filename = "mkportal/modules/blog/templates/English/$mft";
			}
			$fd = fopen ($filename, "r");
			if (!$fd) {
            	$message = "File not found";
				$mklib->error_page($message);
            	exit;
        	}
			$contents = fread ($fd, filesize ($filename));
			fclose ($fd);
			$pos = strpos($contents, "<!-- template2 -->");
			$template2 = substr($contents, ($pos + 18));
			$template = substr($contents, 0, $pos);
   		} else  {
			$query = mysql_query("select template, template2 from mkp_blog where id = '$idu'");
			list ($template, $template2) = mysql_fetch_row ($query);
		}

		$subtitle = "{$mklib->lang['b_ettitle']}";
		$content .= "
		<tr>
		  <td>

		    <form action=\"index.php?ind=blog&amp;op=save_template\" name=\"ADD\" method=\"post\">
		    <table width=\"100%\">		
		      <tr>
			<td>
		      <p align=\"center\"><b><a href=\"index.php?ind=blog&amp;op=show_gallery\" class=\"mktxtcontr\"> [ {$mklib->lang['b_seltempl']} ] </a></b></p>
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\" align=\"center\"><br />{$mklib->lang['b_templm']}</td>
		      </tr>
		      <tr>
			<td align=\"center\">
			  <textarea class=\"mkwrap2\" cols=\"70\" rows=\"25\" name=\"template\">$template</textarea>
			</td>
		      </tr>
		      <tr>
			<td class=\"titadmin\" align=\"center\"><br />{$mklib->lang['b_templp']}</td>
		      </tr>
		      <tr>
			<td align=\"center\"><textarea class=\"mkwrap2\" cols=\"70\" rows=\"6\" name=\"template2\">$template2</textarea>
			</td>
		      </tr>
		      <tr>
			<td><br /><br /></td>
		      </tr>
		      <tr>
			<td align=\"center\" class=\"tdblock\">
			  <input type=\"submit\" name=\"ok\" value=\"{$mklib->lang['b_templsave']}\" />
			</td>
		      </tr>		
		    </table>
		    </form>
		  </td>
		</tr>
	";
			$output = $Skin->view_block("$subtitle", "$content");
			$mklib->printpage_blog("1", "1", "{$mklib->lang['b_pagetitle']}", $output);
	}

	function save_template () {
		global $mkportals, $DB, $Skin, $mklib;

		$idb = $mkportals->member['id'];
		$template = $_POST['template'];
		$template = $this->clean_template($template);
		$template2 = $_POST['template2'];
		$template2 = $this->clean_template($template2);


		mysql_query("update mkp_blog set template = '$template', template2 = '$template2' where id = '$idb'");

		$DB->close_db();
		Header("Location: index.php?ind=blog&op=main_edit");
		exit;

    }


	function show_gallery () {
		global $mkportals, $DB, $Skin, $mklib;

		//$mode = $mkportals->input['mode'];

		$subtitle = "{$mklib->lang['b_galtitle']}";

		$content = "
		<tr>
		  <td width=\"100%\" class=\"titadmin\" align=\"center\">
		  <br />{$mklib->lang['b_seltgal']}<br /><br />
		  
		    <script type=\"text/javascript\">
		  <!--
		  function winnyg(doctoopen) {
		  window.open(doctoopen, 'winny', 'scrollbars=yes,height=561,width=745,top,left');
		  }
		  //-->
		  </script>
		  
		    <table cellpadding=\"3\" cellspacing=\"3\" width=\"100%\">		
		      <tr>
		";
		$cont = 0;
		if ($dir = @opendir("mkportal/modules/blog/templates/thumbnails")) {
       	while (($file = readdir($dir)) !== false) {
		   if ($file != ".." && $file != ".") {
		   	   $filehtml = str_replace(".jpg", ".html", $file);
			   $content .= "
			<td align=\"center\"><a href=\"javascript:winnyg('mkportal/modules/blog/templates/immagini/$file')\">			      <img src=\"mkportal/modules/blog/templates/thumbnails/$file\" border=\"0\" width=\"150\" height=\"100\" alt=\"{$mklib->lang['b_galzoom']}\" /></a><br /><br />";
			   $content .= "
			  <span class=\"mkbutton\"><a href=\"index.php?ind=blog&amp;op=edit_template&amp;mft=$filehtml\" style=\"text-decoration: none;\">{$mklib->lang['b_galuset']}</a></span>
			</td>
			";
			   ++ $cont;
			   if ($cont == 3) {
					$cont = 0;
					 $content .= "</tr><tr><td><br /><br /></td></tr><tr>";
			   }

		   }

	     }
        closedir($dir);
   	   }

		$content .= "";

		$content .= "
			<td><br /><br /></td>
		      </tr>
		    </table>
		  </td>
		</tr>
		";
			$output = $Skin->view_block("$subtitle", "$content");
			$mklib->printpage_blog("1", "1", "{$mklib->lang['b_pagetitle']}", $output);
	}

	function home () {
	global $mkportals, $DB, $Skin, $mklib, $_SERVER;

		$mid = $mkportals->input['idu'];
		$curmese = $mkportals->input['curmese'];
		$template = "
		<style>	#mentemp {position: absolute; top: 0px; left: 0px; width: 100%;} </style>
		
		<div id=\"mentemp\">
		  <table border=\"0\" width=\"100%\" bgcolor=\"#000000\" cellspacing=\"3\" cellpadding=\"0\">
		    <tr>
		      <td width=\"100%\">
			<div style=\"font-family: Verdana; font-size: 9px; color: #F0A962\"><b>{$mklib->lang['b_alsocreate']} </b><a href=\"index.php\" style=\"font-family: Verdana; font-size: 9px; color: #F0A962\"><b>$mklib->sitename</b></a> | <a href=\"index.php\" style=\"font-family: Verdana; font-size: 9px; color: #F0A962\"><b>HOME</b></a>
			</div>
		      </td>
		    </tr>
		  </table>
		</div>
		";

		$ip = $_SERVER["REMOTE_ADDR"];
		$query = mysql_query("select click, ip_address, validate from mkp_blog where id = '$mid'");
 		list ($conto, $ip_address, $validate) = mysql_fetch_row($query);

		if ($validate == 0) {
			$message = "{$mklib->lang['wait_valid']}";
			$mklib->error_page($message);
			exit;
		}
		if (strcmp($ip, $ip_address) != 0) {
			++ $conto;
		}

		mysql_query("update mkp_blog set click = '$conto', ip_address = '$ip' where id = '$mid'");


 		$template .= $this->crea_homearchivio($mid, $curmese);
		$DB->close_db();
		print $template;
		exit;

	}

	function preview_blog () {
		global $mkportals, $DB, $Skin, $mklib;

		$idu = $mkportals->member['id'];
		$query = mysql_query("select id from mkp_blog where id = '$idu'");
        $result = mysql_num_rows($query);
        if (!$result) {
			$message = "{$mklib->lang['b_c_b_se']}";
			$mklib->error_page($message);
			exit;
		}
		$DB->close_db();
		Header("Location: $mklib->siteurl/index.php?ind=blog&op=home&idu=$idu");
		exit;
	}


	function submit_rate() {
    	global $mkportals, $mklib, $Skin, $DB, $mklib_board;
		$ide= $mkportals->input['ide'];

		$iduser = $mkportals->member['id'];
		$ipuser = $_SERVER['REMOTE_ADDR'];
		$module = "blog";

		$query = $DB->query( "SELECT id FROM mkp_votes where module = '$module' and id_entry = '$ide' and id_member = '$iduser'");
		$checkuser = mysql_num_rows ($query);
		$query = $DB->query( "SELECT id FROM mkp_votes where module = '$module' and id_entry = '$ide' and ip = '$ipuser'");
		$checkip = mysql_num_rows ($query);

		if($checkuser || $checkip) {
			$message = "{$mklib->lang['b_jvote']}";
			$mklib->error_page($message);
			exit;
		}

		$query = $DB->query( "SELECT autore, titolo FROM mkp_blog where id = '$ide'");
		$row = $DB->fetch_row($query);
		$t_aut = $row['autore'];
		$t_t = $row['titolo'];
		$maintit = "{$mklib->lang['b_votetitle']} $t_t";

		$utenti_in = $mklib_board->get_active_users("blog");

	   $content .= "
	<tr>
   	  <td><br />
	    <table width=\"98%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" align=\"center\" class=\"moduleborder\">
  	      <tr>
   		<td>
		  <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\" class=\"modulebg\">
		    <tr>
		      <td width=\"100%\" height=\"25\" class=\"tdblock\"> <img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$maintit}</td>
		    </tr>
		    <tr>
		      <td>
			<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"moduleborder\">
			  <tr>
			    <td>
			      <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\">
				<tr>
				  <td bgcolor=\"#ffffff\">
				  
				    <form action=\"index.php?ind=blog&amp;op=add_rate&amp;ide={$ide}\" method=\"post\" id=\"ratea\" name=\"ratea\">
				    <table width=\"100%\">
				      <tr>
					<td class=\"modulex\" width=\"60%\" valign=\"top\">{$mklib->lang['b_voteof']} <b>$t_aut</b> ({$mklib->lang['b_votemax']})
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
					  <input type=\"submit\" name=\"ok\" value=\"{$mklib->lang['b_vote']}\" />
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
		  </table>
		</td>
	      </tr>
	    </table>
	    <br />
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"1\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td class=\"modulex\">
		  {$utenti_in}
		</td>
	      </tr>
	    </table>
	  </td>
	</tr>

	<tr>
	  <td align=\"center\"><br /><br />
	    <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\">MKPBlog - ©2004 Tutti i diritti riservati</a></div>
	  </td>
	</tr>	 
	";
	$blocks = $Skin->view_block("{$mklib->lang['b_vote']}", $content);
	$mklib->printpage("1", "1", "{$mklib->lang['b_votetitle']}", $blocks);
	}

	function add_rate() {
    	global $mkportals, $DB;
		$ide= $mkportals->input['ide'];
		$rating = $mkportals->input['rating'];
		$iduser = $mkportals->member['id'];
		$ipuser = $_SERVER['REMOTE_ADDR'];
		$module = "blog";

		$query="INSERT INTO mkp_votes(id_entry, module, id_member, ip)VALUES('$ide', '$module', '$iduser', '$ipuser')";
		$DB->query($query);

		$query = $DB->query( "SELECT rate, trate FROM mkp_blog where id = '$ide'");
		$row = $DB->fetch_row($query);
		$rate = $row['rate'];
		$trate = $row['trate'];
		$votes = ($trate +1);
		if ( $rating != 0 ) {
				$rate = round ((($trate*$rate)+$rating)/($votes), 2);
		}
		$DB->query("UPDATE mkp_blog SET rate ='$rate', trate ='$votes' where id = '$ide'");
		$DB->close_db();
	 	Header("Location: index.php?ind=blog");
		exit;
  	}


	function chart() {
		global $mkportals, $DB, $mklib, $Skin, $mklib_board;

		$iduser = $mkportals->member['id'];

		$utenti_in = $mklib_board->get_active_users("blog");


		$output = "
	<tr>
	  <td><br />
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td>
		  <table class=\"modulebg\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" border=\"0\">
		    <tr>
		      <td class=\"tdblock\" width=\"100%\" height=\"25\"><img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$mklib->lang['b_topten']}</td>
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
					<th class=\"modulex\" width=\"5%\" align=\"center\">{$mklib->lang['b_cpos']}</th>
					<th class=\"modulex\" width=\"5%\" align=\"center\">{$mklib->lang['b_votes']}</th>
					<th class=\"modulex\" width=\"80%\" align=\"center\">{$mklib->lang['b_blog']}</th>
					<th class=\"modulex\" width=\"5%\" align=\"center\">{$mklib->lang['b_clicks']}</th>
					<th class=\"modulex\" width=\"5%\" align=\"center\">{$mklib->lang['b_mrate']}</th>
				      </tr>
	";

	$query = $DB->query( "SELECT id, titolo, descrizione, click, rate, trate, banner FROM mkp_blog where trate > '0' ORDER BY `trate` DESC, `rate` DESC, `click` DESC LIMIT 10");
		$counterpos = 1;
		while( $row = $DB->fetch_row($query) ) {
			$idb = $row['id'];
			$banner = $row['banner'];
			$click = $row['click'];
			$link = "";
			if ($idb == $iduser || $mklib->member['g_access_cpa'] || $mkportals->member['g_access_cp']) {
				$link = "<a href=\"index.php?ind=blog&amp;op=edit_banner&amp;idb=$idb\"> [ {$mklib->lang['b_banchange']} ] </a>";
			}
			if (!$banner) {
				$banner = "$mklib->images/banner_blog.gif";
			}
			$titolo = $row['titolo'];
			$descrizione = $row['descrizione'];
			$rate = $row['rate'];
			$trate = $row['trate'];
			$width = round(($rate*100)/4) - 6;
	 		$width2 = $width - 4;
			if (!$descrizione) {
				$descrizione = "[{$mklib->lang['b_nodescrip']}]";
			}
			if (!$titolo) {
				$titolo = "[{$mklib->lang['b_notitle']}]";
			}
			switch($counterpos) {
				case '1':
					$counterimage = "<img src=\"$mklib->images/1.gif\" border=\"0\" alt=\"\" />";
    			break;
				case '2':
					$counterimage = "<img src=\"$mklib->images/2.gif\" border=\"0\" alt=\"\" />";
    			break;
				case '3':
					$counterimage = "<img src=\"$mklib->images/3.gif\" border=\"0\" alt=\"\" />";
    			break;
				default:
    				$counterimage = $counterpos;
    			break;
			}
			$output .= "
				      <tr>
					<td class=\"modulecell\" align=\"center\"><span class=\"mktxtcontr\">$counterimage</span></td>
					<td class=\"modulecell\" align=\"center\"><b>$trate</b></td>
					<td class=\"modulecell\" align=\"center\"><a href=\"$mklib->siteurl/index.php?ind=blog&amp;op=home&amp;idu=$idb\" target=\"_blank\">$titolo<br /><img src=\"$banner\" border=\"0\" width=\"468\" height=\"60\" alt=\"\" /></a><br />$descrizione<br />$link</td>
					<td class=\"modulecell\" align=\"center\"><b>$click</b></td>
					<td class=\"modulecell\" align=\"center\" ><span class=\"mktxtcontr\">  {$rate}</span>
					</td>
				      </tr>
			";
			++$counterpos;
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
 	  <td><br />
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"1\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td class=\"modulex\">
		  {$utenti_in}
		</td>
	      </tr>
	    </table>
	  </td>
	</tr>
		
	<tr>
	  <td align=\"center\"><br /><br />
	    <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\">MKPBlog - ©2004 Tutti i diritti riservati</a></div>
	  </td>
	</tr>	 
	";
		$mklib->printpage_blog("1", "1", "{$mklib->lang['b_charttitle']}", $output, "");

	}
	function edit_banner() {
		global $mkportals, $DB, $mklib, $Skin;

		$iduser = $mkportals->member['id'];
		$idb = $mkportals->input['idb'];

		if ($mklib->member['g_access_cpa'] || $mkportals->member['g_access_cp']) {
			$checkauth = 1;
		}
		if ($idb != $iduser && !$checkauth) {
			$message = "{$mklib->lang['b_unauthban']}";
			$mklib->error_page($message);
			exit;
		}
		$query = $DB->query( "SELECT banner FROM mkp_blog where id = '$idb'");
		$row = $DB->fetch_row($query);
		$link = $row['banner'];

		$output = "
	<tr>
	  <td><br />
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td>
		  <table class=\"modulebg\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" border=\"0\">
		    <tr>
		      <td class=\"tdblock\" width=\"100%\" height=\"25\"><img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$mklib->lang['b_banchange']}</td>
		    </tr>
		    <tr>
		      <td>
			<table class=\"moduleborder\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
			  <tr>
			    <td>
			      <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
				<tr>
				  <td class=\"modulex\">

				    <form action=\"index.php?ind=blog&amp;op=save_banner&amp;idb=$idb\" name=\"e_b\" method=\"post\">
				    <table width=\"100%\" border=\"0\">
				      <tr>
					<td><br />{$mklib->lang['b_bancwarn']}<br /><br /> </td>
				      </tr>
				      <tr>
					<td class=\"titadmin\">{$mklib->lang['b_banurl']}</td>
				      </tr>
				      <tr>
					<td>
					  <input type=\"text\" name=\"link\" value=\"$link\" size=\"52\" class=\"bgselect\" />
					</td>
				      </tr>
				      <tr>
					<td>
					  <input type=\"submit\" value=\"{$mklib->lang['b_bansave']}\" class=\"bgselect\" />
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
		  </table>
		</td>
	      </tr>
	    </table>
	  </td>
	</tr>
		
	<tr>
	  <td align=\"center\"><br /><br />
	    <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\">MKPBlog - ©2004 Tutti i diritti riservati</a></div>
	  </td>
	</tr>	
	";
		$mklib->printpage_blog("1", "1", "{$mklib->lang['b_bantitle']}", $output, "");

	}
	function save_banner() {
    	global $mkportals, $DB, $mklib;
		$link = $mkportals->input['link'];
		$ide = $mkportals->input['idb'];
		$iduser = $mkportals->member['id'];

		if ($mklib->member['g_access_cpa'] || $mkportals->member['g_access_cp']) {
			$checkauth = 1;
		}
		if ($ide != $iduser && !$checkauth) {
			$message = "{$mklib->lang['b_unauthban']}";
			$mklib->error_page($message);
			exit;
		}

			$DB->query("UPDATE mkp_blog SET banner ='$link' where id = '$ide'");

		$DB->close_db();
	 	Header("Location: index.php?ind=blog&op=chart");
		exit;
  	}

	function createmp ($idu, $curmese="0") {
		global $mkportals, $DB, $Skin, $mklib, $mklib_board;

		$idu = $mkportals->member['id'];
		 $username = $mkportals->member['name'];
		$lastpage = 0;

        if ($curmese == "0" || !$curmese) {
            $dat = time();
            $curmese = $mklib->create_date($dat, "small");
			$lastpage = 1;
        }


        $query = mysql_query("select autore, titolo, descrizione, template, template2, eta, segno, citta, libri, film, canzoni, link, amo, odio, umore, citazione, click, link_blog, maxmess from mkp_blog where id = '$idu'");
        $query1 = mysql_query("select id, post, data, ncom from mkp_blog_post where id_blog = '$idu' ORDER BY id DESC");

        list ($username, $titolo, $descrizione, $template, $template2, $eta, $segno, $citta, $libri2, $film2, $canzoni2, $link2, $amo2, $odio2, $umore, $citazione, $click, $bloglink2, $maxmess) = mysql_fetch_row($query);

            $libri = str_replace ("\n", "<br />", $libri2);
			$film = str_replace ("\n", "<br />", $film2);
            $canzoni = str_replace ("\n", "<br />", $canzoni2);
			$amo = str_replace ("\n", "<br />", $amo2);
			$odio = str_replace ("\n", "<br />", $odio2);
            $link = "";
            $stringa=explode("§", $link2);
             for($i=0;$i<count($stringa);$i++){
                if ($stringa[$i]) {
                    $stringa2=explode("|", $stringa[$i]);
                      $link .= "<a href=\"$stringa2[1]\" >$stringa2[0]</a><br />";
                }
            }
			/*
			$bloglink = "";
            $stringa=explode("§", $bloglink2);
             for($i=0;$i<count($stringa);$i++){
                if ($stringa[$i]) {
                    $stringa2=explode("|", $stringa[$i]);
                      $bloglink .= "<a href=\"$stringa2[1]\"  target=\"_blank\">$stringa2[0]</a><br />";
                }
            }
		*/
        $click.="<br /><script type=\"text/javascript\">
                    <!--
                    function winny(doctoopen) {
                    window.open(doctoopen, 'winny', 'scrollbars=yes,height=400,width=450');
                    }
                    //-->
                    </script>";
		//$linkbutton = "<img src=\"images/addblog.gif\" alt=\"\" /><br />";
        $template = str_replace("!BlogTitle!", $titolo, $template);
        $template = str_replace("!BlogDescription!", $descrizione, $template);
        $template = str_replace("!UtenteEta!", $eta, $template);
        $template = str_replace("!UtenteSegno!", $segno, $template);
        $template = str_replace("!UtenteCitta!", $citta, $template);
        $template = str_replace("!UtenteLibri!", $libri, $template);
        $template = str_replace("!UtenteFilm!", $film, $template);
        $template = str_replace("!UtenteCanzoni!", $canzoni, $template);
        $template = str_replace("!UtenteLink!", $link, $template);
        $template = str_replace("!UtenteAmo!", $amo, $template);
        $template = str_replace("!UtenteOdio!", $odio, $template);
        $template = str_replace("!UtenteCitazione!", nl2br($citazione), $template);
        //$template = str_replace("!UtenteUmore!", "<img src=\"images/$umore.gif\" alt=\"\" />", $template);
        $template = str_replace("!BlogCounter!", "$click", $template);
		//$template = str_replace("!LinkButton!", "$linkbutton", $template);
		//$template = str_replace("!BlogLink!", "$bloglink", $template);

        $archivio = "<a href=\"$mklib->siteurl/index.php?ind=blog&amp;op=main_edit\" target=\"_top\">{$mklib->lang['b_lastdays']}</a><br />";
		$contomess = 0;
        while (list ($idpost, $post, $data, $ncom) = mysql_fetch_row ($query1)) {
			$post = stripslashes($post);
			if ($mklib->mkeditor == "BBCODE") {
				$post = $mklib->decode_bb($post);
				$post = $mklib_board->decode_smilies($post);
			}
			$ora = $mklib->create_date($data, "time");
            $mese = $mklib->create_date($data, "small");
            $datam = $mklib->create_date($data, "normal");
            $messaggio2 = "";
            $checkm = strcmp($mese, $curmese);
			if (!strpos($archivio, $mese)) {
                    $archivio .= "<a href=\"$mklib->siteurl/index.php?ind=blog&amp;op=main_edit&amp;curmese=$mese\" target=\"_top\">$mese</a><br />";
                }
            if ($checkm != 0) {
				 if ($contomess >= $maxmess || $lastpage == 0) {
                	continue;
				 }
            }

            $checkd = strcmp($datam, $dataprec);
            $datains = "";
            if ($checkd != 0) {
                $datains= $datam;
            }
            if ($ncom > 0) {
                $ncom = "($ncom)";
            } else  {
                $ncom = "";
            }
            $messaggio2 .= "<a href=\"index.php?ind=blog&amp;op=main_change&amp;idm=$idpost\"><img src=\"mkportal/modules/blog/templates/images/aggiorna.jpg\" border=\"0\" alt=\"\" /></a>&nbsp;";
            $messaggio2 .= "<a href=\"index.php?ind=blog&amp;op=del_post&amp;idm=$idpost\"><img src=\"mkportal/modules/blog/templates/images/cancella.jpg\" border=\"0\" alt=\"\" /></a><br />";
            $messaggio2 .= $post;
            $messaggio = str_replace("!BlogPost!", $messaggio2, $template2);
            $messaggio = str_replace("!PostData!", $datains, $messaggio);
            $messaggio = str_replace("!BlogUtente!", $username, $messaggio);
            $messaggio = str_replace("!PostOra!", $ora, $messaggio);
            $messaggio = str_replace("!PostCommenti!", "<a href=\"javascript:winny('index.php?ind=blog&amp;op=show_comments&amp;idm=$idpost&amp;mode=1')\" target=\"_self\">{$mklib->lang['b_mcomments']} $ncom</a><br />", $messaggio);
            $messaggi .= $messaggio;
            $dataprec = $datam;
            ++$contomess;
        }

        $template = str_replace("!CorpoMessaggi!", $messaggi, $template);
        $template = str_replace("!UtenteArchivio!", "$archivio", $template);

        return $template;
    }


	function crea_homearchivio ($idu, $curmese="0") {
		global $mkportals, $DB, $Skin, $mklib, $mklib_board;

		$lastpage = 0;

        if ($curmese == "0" || !$curmese) {
            $dat = time();
            $curmese = $mklib->create_date($dat, "small");
			$lastpage = 1;
        }


        $query = mysql_query("select autore, titolo, descrizione, template, template2, eta, segno, citta, libri, film, canzoni, link, amo, odio, umore, citazione, click, link_blog, maxmess from mkp_blog where id = '$idu'");
        $query1 = mysql_query("select id, post, data, ncom from mkp_blog_post where id_blog = '$idu' ORDER BY id DESC");

        list ($username, $titolo, $descrizione, $template, $template2, $eta, $segno, $citta, $libri2, $film2, $canzoni2, $link2, $amo2, $odio2, $umore, $citazione, $click, $bloglink2, $maxmess) = mysql_fetch_row($query);

           $libri = str_replace ("\n", "<br />", $libri2);
			$film = str_replace ("\n", "<br />", $film2);
            $canzoni = str_replace ("\n", "<br />", $canzoni2);
			$amo = str_replace ("\n", "<br />", $amo2);
			$odio = str_replace ("\n", "<br />", $odio2);
            $link = "";
            $stringa=explode("§", $link2);
             for($i=0;$i<count($stringa);$i++){
                if ($stringa[$i]) {
                    $stringa2=explode("|", $stringa[$i]);
                      $link .= "<a href=\"$stringa2[1]\"  target=\"_blank\">$stringa2[0]</a><br />";
                }
            }
/*
			$bloglink = "";
            $stringa=explode("§", $bloglink2);
             for($i=0;$i<count($stringa);$i++){
                if ($stringa[$i]) {
                    $stringa2=explode("|", $stringa[$i]);
                      $bloglink .= "<a href=\"$stringa2[1]\"  target=\"_blank\">$stringa2[0]</a><br />";
                }
            }
*/

        $counter = str_pad($click, 6, "0", STR_PAD_LEFT);

		//$linkbutton = "<a href=\"$this->sitehome/linka_blog.php?mid=$idu\"><img src=\"images/addblog.gif\" alt=\"\" /></a><br />";

        $template = str_replace("!BlogTitle!", $titolo, $template);
        $template = str_replace("!BlogDescription!", $descrizione, $template);
        $template = str_replace("!UtenteEta!", $eta, $template);
        $template = str_replace("!UtenteSegno!", $segno, $template);
        $template = str_replace("!UtenteCitta!", $citta, $template);
        $template = str_replace("!UtenteLibri!", $libri, $template);
        $template = str_replace("!UtenteFilm!", $film, $template);
        $template = str_replace("!UtenteCanzoni!", $canzoni, $template);
        $template = str_replace("!UtenteLink!", $link, $template);
        $template = str_replace("!UtenteAmo!", $amo, $template);
        $template = str_replace("!UtenteOdio!", $odio, $template);
        $template = str_replace("!UtenteCitazione!", nl2br($citazione), $template);
        //$template = str_replace("!UtenteUmore!", "<img src=\"images/$umore.gif\" alt=\"\" />", $template);
        $template = str_replace("!BlogCounter!", "$counter", $template);
		//$template = str_replace("!LinkButton!", "$linkbutton", $template);
		//$template = str_replace("!BlogLink!", "$bloglink", $template);

        $archivio = "<a href=\"$mklib->siteurl/index.php?ind=blog&amp;op=home&amp;idu=$idu\">{$mklib->lang['b_lastdays']}</a><br />";
		$contomess = 0;
        while (list ($idpost, $post, $data, $ncom) = mysql_fetch_row ($query1)) {
			$post = stripslashes($post);
			if ($mklib->mkeditor == "BBCODE") {
				$post = $mklib->decode_bb($post);
				$post = $mklib_board->decode_smilies($post);
			}
			$ora = $mklib->create_date($data, "time");
            $mese = $mklib->create_date($data, "small");
            $datam = $mklib->create_date($data, "normal");
            $messaggio2 = "";
            $checkm = strcmp($mese, $curmese);

			if (!strpos($archivio, $mese)) {
                    $archivio .= "<a href=\"$mklib->siteurl/index.php?ind=blog&amp;op=home&amp;idu=$idu&amp;curmese=$mese\">$mese</a><br />";
            }
            if ($checkm != 0) {
				 if ($contomess >= $maxmess || $lastpage == 0) {
                	continue;
				 }
            }
            $checkd = strcmp($datam, $dataprec);
            $datains = "";
            if ($checkd != 0) {
                $datains= $datam;
            }
            if ($ncom > 0) {
                $ncom = "($ncom)";
            } else  {
                $ncom = "";
            }

            $messaggio2 .= $post;
            $messaggio = str_replace("!BlogPost!", $messaggio2, $template2);
            $messaggio = str_replace("!PostData!", $datains, $messaggio);
            $messaggio = str_replace("!BlogUtente!", $username, $messaggio);
            $messaggio = str_replace("!PostOra!", $ora, $messaggio);
			$messaggio = str_replace("!PostCommenti!", "<a href=\"javascript:winny('index.php?ind=blog&amp;op=show_comments&amp;idm=$idpost')\" target=\"_self\">{$mklib->lang['b_mcomments']} $ncom</a><br />", $messaggio);

            $messaggi .= $messaggio;
			//$messaggi .= "$contomess > $maxmess $lastpage $mese, $curmese";
            $dataprec = $datam;
            ++$contomess;
        }

        $template = str_replace("!CorpoMessaggi!", $messaggi, $template);
        $template = str_replace("!UtenteArchivio!", "$archivio", $template);
		$template.="\n<script type=\"text/javascript\">
                    <!--
                    function winny(doctoopen) {
                    window.open(doctoopen, 'winny', 'scrollbars=yes,height=400,width=450');
                    }
                    //-->
                    </script>\n";

        return $template;

	}
	function clean_template ($t="") {

		$t = str_replace( "<script"  , ""   , $t );
		$t = str_replace( "javascript" , "", $t );
		$t = str_replace( "alert"      , ""          , $t );
		$t = str_replace( "about"     , ""         , $t );
		$t = str_replace( "onmouseover", ""    , $t );
		$t = str_replace( "onclick"    , ""        , $t );
		$t = str_replace( "onload"     , ""         , $t );
		$t = str_replace( "onsubmit"   , ""       , $t );
		$t = str_replace( "<?"   , ""       , $t );
		$t = str_replace( "?"   , ""       , $t );

		return $t;
	}
}
?>
