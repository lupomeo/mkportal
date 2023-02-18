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

$idx = new mk_ad_download;
class mk_ad_download {


	function mk_ad_download() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'add_event':
    			$this->add_event();
    		break;
			case 'edit_event':
    			$this->edit_event();
    		break;
			case 'update_event':
    			$this->update_event();
    		break;
			case 'delete_event':
    			$this->delete_event();
    		break;
			case 'add_upped':
    			$this->add_upped();
    		break;
			case 'save_main':
    			$this->save_main();
    		break;
			default:
    			$this->download_show();
    		break;
    		}
	}

	function download_show() {
	global $mkportals, $mklib, $Skin, $DB;

		// Admin Approval combo
		$approval = $mklib->config['approval_download'];
		switch($approval) {
			case '1':
    			$selap1="selected=\"selected\"";
    		break;
			case '2':
    			$selap2="selected=\"selected\"";
    		break;
			case '3':
    			$selap3="selected=\"selected\"";
    		break;
    		default:
    			$selap="selected=\"selected\"";
    		break;
		}
		$cselecta = "<option value=\"0\" $selap>{$mklib->lang['ad_approp_0']}</option>\n";
		$cselecta .= "<option value=\"1\" $selap1>{$mklib->lang['ad_approp_1']}</option>\n";
		$cselecta .= "<option value=\"2\" $selap2>{$mklib->lang['ad_approp_2']}</option>\n";
		$cselecta .= "<option value=\"3\" $selap3>{$mklib->lang['ad_approp_3']}</option>\n";

		$cselect = $this->row_select_event();
		$cselects = "<option value=\"0\">{$mklib->lang['ad_dowpcat']}</option>\n";
		$cselects .= $cselect;
		/*
		$query = $DB->query( "SELECT id, evento FROM mkp_download_sections ORDER BY `id` DESC");
		while( $row = $DB->fetch_row($query) ) {
			$idevento = $row['id'];
			$evento = $row['evento'];
			$cselect.= "<option value=\"$idevento\">$evento</option>\n";
			$cselects.= "<option value=\"$idevento\">$evento</option>\n";
		}
		*/
		$download_sec_page = $mklib->config['download_sec_page'];
		$download_file_page= $mklib->config['download_file_page'];
		$upload_file_max= $mklib->config['upload_file_max'];
		if ($mklib->config['mod_downloads']) {
		$checkactive =  "checked=\"checked\"";
   		}
		if ($mkportals->input['mode'] == "saved") {
		$checksave = "{$mklib->lang['ad_saved']}<br /><br />";
   		}
		if ($mkportals->input['mode'] == "savedupped") {
		$checksave = "{$mklib->lang['ad_dowsfileup']}<br /><br />";
   		}
	 	$content  = "
		
	<tr>
	  <td>

	    <script type=\"text/javascript\">
			function makesure() {
			if (confirm('{$mklib->lang[ad_delsecconfirm]}')) {
			return true;
			} else {
			return false;
			}
			}
	    </script>

	    <form action=\"admin.php?ind=ad_download&amp;op=save_main\" name=\"save_main\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>$checksave</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_preferences']}</td>
	      </tr>
	      <tr>
		<td><span class=\"mktxtcontr\">{$mklib->lang['ad_dowdisactive']}</span> <input type=\"checkbox\" name=\"stato\" value=\"1\" $checkactive /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_galspages']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"download_sec_page\" value=\"$download_sec_page\" size=\"20\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_dowfilepage']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"download_file_page\" value=\"$download_file_page\" size=\"20\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>		
		<td>{$mklib->lang['ad_galmaxup']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"upload_file_max\" value=\"$upload_file_max\" size=\"20\" class=\"bgselect\" /></td>
	      </tr>
		  <tr>
		<td>{$mklib->lang['ad_apprtit']}</td>
	      </tr>
	      <tr>
		<td>
		  <select class=\"bgselect\" size=\"1\" name=\"approvalc\">
		  {$cselecta}
		  </select>
		</td>
	      </tr>
	      <tr>
		<td><input type=\"submit\" name=\"Salve\" value=\"{$mklib->lang['ad_save']}\" class=\"bgselect\" /></td>
	      </tr>
	    </table>
	    </form>
	    
	    <form action=\"admin.php?ind=ad_download&amp;op=add_event\" name=\"a_ev\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_addsection']}</td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_dowcat_scat']}</td>
	      </tr>
	      <tr>
		<td width=\"10%\">
		  <select name=\"father\" size=\"1\" class=\"bgselect\">
		  {$cselects}
		  </select>
		</td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_title']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"eventoa\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_description']}</td>
	      </tr>
	      <tr>
		<td><textarea cols=\"50\" rows=\"4\" name=\"descrizione\" class=\"bgselect\"></textarea></td>
	      </tr>
	      <tr>
		<td><input type=\"submit\" name=\"Inserisci\" value=\"{$mklib->lang['ad_insert']}\" class=\"bgselect\" /></td>
	      </tr>
	    </table>
	    </form>
	    
	    <form action=\"admin.php?ind=ad_download&amp;op=edit_event\" name=\"m_ev\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_editsection']}</td>
		</tr>
	      <tr>
		<td width=\"10%\">
		  <select name=\"eventoc\" size=\"1\" class=\"bgselect\">
		  {$cselect}
		  </select>   
		  <input type=\"submit\" name=\"Modifica\" value=\"{$mklib->lang['ad_edit']}\" class=\"bgselect\" />
		</td>
	      </tr>
	    </table>
	    </form>

	    <form action=\"admin.php?ind=ad_download&amp;op=delete_event\" name=\"e_ev\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_delsection']}
		</td>
	      </tr>
	      <tr>
		<td width=\"10%\">
		  <select name=\"eventoc\" size=\"1\" class=\"bgselect\">
		  {$cselect}
		  </select>   
		  <input type=\"submit\" name=\"Elimina\" value=\"{$mklib->lang['ad_delete']}\" onclick=\"return makesure()\" class=\"bgselect\" />
		</td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_dowwarn']}</td>
	      </tr>
	    </table>
	    </form>

	    <form action=\"admin.php?ind=ad_download&amp;op=add_upped\" name=\"add_up\" method=\"post\">
	    <table width=\"100%\" border=\"0\">		
	      <tr>
		<td class=\"titadmin\" colspan=\"2\">{$mklib->lang['ad_dowaddfile']}</td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_section']}</td>
		<td>
		  <select class=\"bgselect\" name=\"evento\" size=\"1\">
		  {$cselect}
		  </select>
		</td>
	      </tr>
	      <tr>
		<td width=\"10%\">{$mklib->lang['ad_title']}</td>
		<td width=\"90%\"><input type=\"text\" name=\"titolo\" size=\"52\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td width=\"10%\" valign=\"top\">{$mklib->lang['ad_description']}</td>
		<td width=\"90%\"><textarea cols=\"50\" rows=\"10\" name=\"descrizione\" class=\"bgselect\"></textarea></td>
	      </tr>
	      <tr>
		<td width=\"10%\">{$mklib->lang['ad_galaddname']}</td>
		<td width=\"90%\"><input type=\"text\" name=\"filename\" size=\"52\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td width=\"10%\">{$mklib->lang['ad_dowsc']}1</td>
		<td width=\"90%\"><input type=\"text\" name=\"screen1\" size=\"52\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td width=\"10%\">{$mklib->lang['ad_dowsc']}2</td>
		<td width=\"90%\"><input type=\"text\" name=\"screen2\" size=\"52\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td width=\"10%\">{$mklib->lang['ad_dowdurl']}</td>
		<td width=\"90%\"><input type=\"text\" name=\"demo\" size=\"52\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td colspan=\"2\"><input type=\"submit\" value=\"{$mklib->lang['ad_insert']}\" class=\"bgselect\" /></td>
	      </tr>	    
	    </table>
	    </form>
	    
	  </td>
	</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_dowtitle']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}
	function add_event() {

		global $mkportals, $DB, $mklib;
		$evento = $mkportals->input['eventoa'];
		$father = $mkportals->input['father'];
		$descrizione = $mkportals->input['descrizione'];
		if (!$evento || !$descrizione) {
			$message = "{$mklib->lang['ad_req_ndcat']}";
			$mklib->error_page($message);
			exit;
		}
		$DB->query("INSERT INTO  mkp_download_sections (evento, descrizione, father) VALUES ('$evento', '$descrizione', '$father')");
		$DB->close_db();
	 	Header("Location: admin.php?ind=ad_download&mode=saved");
		exit;
  }
	function edit_event() {
   		global $mkportals, $mklib, $Skin, $DB;

		$idf = $mkportals->input['eventoc'];
		if (!$idf) {
			$message = "{$mklib->lang['ad_req_cat']}";
			$mklib->error_page($message);
			exit;
		}

		$query = $DB->query( "SELECT evento, descrizione, position, father FROM mkp_download_sections  WHERE id = $idf");
		$row = $DB->fetch_row($query);
		$evento = $row['evento'];
		$descrizione = $row['descrizione'];
		$descrizione = str_replace("<br />", "\n", $descrizione);
		$position =  $row['position'];
		$father =  $row['father'];

		$cselect = "<option value=\"0\">{$mklib->lang['ad_dowpcat']}</option>\n";
		$query = $DB->query( "SELECT id, evento FROM mkp_download_sections ORDER BY `id` DESC");
		while( $row = $DB->fetch_row($query) ) {
			$ideventot = $row['id'];
			$eventot = $row['evento'];
			$selected = "";
			if($ideventot == $father) {
				$selected = "selected=\"selected\"";
			}
			$cselect.= "<option value=\"$ideventot\" $selected>$eventot</option>\n";
		}


		$content = "
	<tr>
	  <td>
	  
	    <form action=\"admin.php?ind=ad_download&amp;op=update_event\" name=\"EV_UPGRADE\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>
		  <input type=\"hidden\" name=\"idf\"  value = \"{$idf}\" />
		</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_dowfcat']}</td>
	      </tr>
	      <tr>
		<td width=\"10%\">
		  <select name=\"father\" size=\"1\" class=\"bgselect\">
		  {$cselect}
		  </select>
		</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_title']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"evento\"  value = \"{$evento}\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_description']}</td>
	      </tr>
	      <tr>
		<td><textarea cols=\"50\" rows=\"4\" name=\"descrizione\" class=\"bgselect\">{$descrizione}</textarea></td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_position']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"position\"  value = \"{$position}\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td><input type=\"submit\" value=\"{$mklib->lang['ad_edit']}\" class=\"bgselect\" /></td>
	      </tr>
	    </table>
	    </form>
	    
	  </td>
	</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_doweditsec']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}
	function update_event() {
    	global $mkportals, $DB, $mklib;
		$idf = $mkportals->input['idf'];
		$evento = $mkportals->input['evento'];
		$position = $mkportals->input['position'];
		$descrizione = $mkportals->input['descrizione'];
		$father = $mkportals->input['father'];
		if (!$evento || !$descrizione) {
			$message = "{$mklib->lang['ad_ad_req_ndcat']}";
			$mklib->error_page($message);
			exit;
		}
		if ($father == $idf) {
			$father = 0;
		}
		$DB->query("UPDATE  mkp_download_sections set evento = '$evento', descrizione = '$descrizione', position = '$position', father = '$father' where id = '$idf'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_download&mode=saved");
		exit;
  	}
	function save_main() {
    	global $mkportals, $DB;
		$download_sec_page = $mkportals->input['download_sec_page'];
		$download_file_page = $mkportals->input['download_file_page'];
		$upload_file_max = $mkportals->input['upload_file_max'];
		$mod_downloads = $mkportals->input['stato'];
		$approval = $mkportals->input['approvalc'];
		if (!$download_sec_page || !$download_file_page) {
			$message = "{$mklib->lang['ad_all_rows']}";
			$mklib->error_page($message);
			exit;
		}
		$DB->query("UPDATE mkp_config SET valore ='$download_sec_page' where chiave = 'download_sec_page'");
		$DB->query("UPDATE mkp_config SET valore ='$download_file_page' where chiave = 'download_file_page'");
		$DB->query("UPDATE mkp_config SET valore ='$upload_file_max' where chiave = 'upload_file_max'");
		$DB->query("UPDATE mkp_config SET valore ='$mod_downloads' where chiave = 'mod_downloads'");
		$DB->query("UPDATE mkp_config SET valore ='$approval' where chiave = 'approval_download'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_download&mode=saved");
		exit;
  	}

	function delete_event() {
    	global $mkportals, $DB, $mklib;

		$idevento = $mkportals->input['eventoc'];
		if (!$idevento) {
			$message = "{$mklib->lang['ad_nodelcat']}";
			$mklib->error_page($message);
			exit;
		}
		$query = $DB->query( "SELECT evento FROM mkp_download_sections WHERE father = '$idevento'");
		while( $row = $DB->fetch_row($query) ) {
			$eventerror = $row['evento'];
		}

		if ($eventerror) {
			$message = "{$mklib->lang['ad_nodelcat']}";
			$mklib->error_page($message);
			exit;
		}

		$DB->query("DELETE FROM mkp_download_sections WHERE id = $idevento");
		$query = $DB->query( "SELECT id, file FROM mkp_download WHERE idcategoria = $idevento");
		while( $row = $DB->fetch_row($query) ) {
			$idf = $row['id'];
			$file = $row['file'];
			$file = preg_replace("`(.*)\..*`", "\\1", $file);
			$file = "mk_".$idf."_".$file.".mk";
			@unlink("modules/downloads/file/$file");
			$DB->query("DELETE FROM mkp_download WHERE id = $idf");
			$DB->query("DELETE FROM mkp_download_comments WHERE identry = $idf");
		}
		$DB->close_db();
	 	Header("Location: admin.php?ind=ad_download&mode=saved");
		exit;

	}
	function add_upped() {

    	global $mkportals, $DB, $mklib;
		$evento = $mkportals->input['evento'];
		$titolo = $mkportals->input['titolo'];
		$screen1 = $mkportals->input['screen1'];
		$screen2 = $mkportals->input['screen2'];
		$demo = $mkportals->input['demo'];
		$descrizione = $mkportals->input['descrizione'];
		$file_name =  $mkportals->input['filename'];
		$autore = $mkportals->member['name'];


		if (!$evento || !$titolo || !$descrizione || !$file_name) {
			$message = "{$mklib->lang['ad_dowreq3']}";
			$mklib->error_page($message);
			exit;
		}


		if (!is_file ("modules/downloads/file/$file_name")) {
			$message = "{$mklib->lang['ad_downofile']}";
			$mklib->error_page($message);
			exit;
		}
		$peso = filesize("modules/downloads/file/$file_name");
        $cdata = time();
		$query="INSERT INTO mkp_download(idcategoria, name, description, file, data, screen1, screen2, demo, autore, peso)VALUES('$evento', '$titolo', '$descrizione', '$file_name', '$cdata', '$screen1', '$screen2', '$demo', '$autore', '$peso')";
		$DB->query($query);
		$DB->close_db();
	 	Header("Location: admin.php?ind=ad_download&mode=savedupped");
		exit;
  }
	function row_select_event() {
			global $mkportals, $DB, $mklib;


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


}

?>
