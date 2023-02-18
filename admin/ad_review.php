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
$idx = new mk_ad_review;
class mk_ad_review {


	function mk_ad_review() {
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
			case 'save_main':
    			$this->save_main();
    		break;
			default:
    			$this->review_show();
    		break;
    		}
	}

	function review_show() {
	global $mkportals, $mklib, $Skin, $DB;

	// Admin Approval combo
		$approval = $mklib->config['approval_review'];
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

		$rev_sec_page = $mklib->config['rev_sec_page'];
		$rev_file_page= $mklib->config['rev_file_page'];

		if ($mklib->config['mod_reviews']) {
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

	    <form action=\"admin.php?ind=ad_review&amp;op=save_main\" name=\"save_main\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>$checksave</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_preferences']}</td>
	      </tr>
	      <tr>
		<td><span class=\"mktxtcontr\">{$mklib->lang['ad_redisactive']}</span> <input type=\"checkbox\" name=\"stato\" value=\"1\" $checkactive /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_galspages']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"rev_sec_page\" value=\"$rev_sec_page\" size=\"20\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_refilepage']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"rev_file_page\" value=\"$rev_file_page\" size=\"20\" class=\"bgselect\" /></td>
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
	    
	    <form action=\"admin.php?ind=ad_review&amp;op=add_event\" name=\"a_ev\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_addsection']}</td>
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
		<td>{$mklib->lang['ad_reop']} 1</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field1\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 2</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field2\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 3</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field3\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 4</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field4\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 5</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field5\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 6</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field6\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 7 [{$mklib->lang['ad_reopextra']}]</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field7\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td><input type=\"submit\" name=\"Inserisci\" value=\"{$mklib->lang['ad_insert']}\" class=\"bgselect\" /></td>
	      </tr>
	    </table>
	    </form>
	    
	    <form action=\"admin.php?ind=ad_review&amp;op=edit_event\" name=\"m_ev\" method=\"post\">
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

	    <form action=\"admin.php?ind=ad_review&amp;op=delete_event\" name=\"e_ev\" method=\"post\">
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
	    
	  </td>
	</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_retitle']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}
	function add_event() {

		global $mkportals, $DB, $mklib;
		$evento = $mkportals->input['eventoa'];
		$descrizione = $mkportals->input['descrizione'];
		$field1 = $mkportals->input['field1'];
		$field2 = $mkportals->input['field2'];
		$field3 = $mkportals->input['field3'];
		$field4 = $mkportals->input['field4'];
		$field5 = $mkportals->input['field5'];
		$field6 = $mkportals->input['field6'];
		$field7 = $mkportals->input['field7'];

		if (!$evento || !$descrizione) {
			$message = "{$mklib->lang['ad_req_ndcat']}";
			$mklib->error_page($message);
			exit;
		}
		$DB->query("INSERT INTO  mkp_reviews_sections (title, description, field1, field2, field3, field4, field5, field6, field7) VALUES ('$evento', '$descrizione', '$field1', '$field2', '$field3', '$field4', '$field5', '$field6', '$field7')");
		$DB->close_db();
	 	Header("Location: admin.php?ind=ad_review&mode=saved");
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

		$query = $DB->query( "SELECT title, description, field1, field2, field3, field4, field5, field6, field7, position FROM mkp_reviews_sections  WHERE id = $idf");
		$row = $DB->fetch_row($query);
		$evento = $row['title'];
		$descrizione = $row['description'];
		$position =  $row['position'];
		$field1 = $row['field1'];
		$field2 = $row['field2'];
		$field3 = $row['field3'];
		$field4 = $row['field4'];
		$field5 = $row['field5'];
		$field6 = $row['field6'];
		$field7 = $row['field7'];


		$content = "
	<tr>
	  <td>
		
	    <form action=\"admin.php?ind=ad_review&amp;op=update_event\" name=\"EV_UPGRADE\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>
		  <input type=\"hidden\" name=\"idf\"  value = \"{$idf}\" />
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
		<td>{$mklib->lang['ad_reop']} 1</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field1\" value=\"$field1\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 2</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field2\" value=\"$field2\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 3</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field3\" value=\"$field3\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 4</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field4\" value=\"$field4\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 5</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field5\" value=\"$field5\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 6</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field6\" value=\"$field6\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_reop']} 7 [{$mklib->lang['ad_reopextra']}]</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"field7\" value=\"$field7\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_position']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"position\"  value = \"$position\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td><input type=\"submit\" value=\"{$mklib->lang['ad_edit']}\" class=\"bgselect\" /></td>
	      </tr>
	    </table>
	    </form>

	  </td>
	</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_reeditsec']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}
	function update_event() {
    	global $mkportals, $DB, $mklib;
		$idf = $mkportals->input['idf'];
		$evento = $mkportals->input['evento'];
		$position = $mkportals->input['position'];
		$descrizione = $mkportals->input['descrizione'];
		$field1 = $mkportals->input['field1'];
		$field2 = $mkportals->input['field2'];
		$field3 = $mkportals->input['field3'];
		$field4 = $mkportals->input['field4'];
		$field5 = $mkportals->input['field5'];
		$field6 = $mkportals->input['field6'];
		$field7 = $mkportals->input['field7'];

		if (!$evento || !$descrizione) {
			$message = "{$mklib->lang['ad_ad_req_ndcat']}";
			$mklib->error_page($message);
			exit;
		}

		$DB->query("UPDATE  mkp_reviews_sections set title = '$evento', description = '$descrizione', field1 = '$field1', field2 = '$field2', field3 = '$field3', field4 = '$field4', field5 = '$field5', field6 = '$field6', field7 = '$field7', position = '$position' where id = '$idf'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_review&mode=saved");
		exit;
  	}
	function save_main() {
    	global $mkportals, $DB, $mklib;
		$rev_sec_page = $mkportals->input['rev_sec_page'];
		$rev_file_page = $mkportals->input['rev_file_page'];
		$mod_reviews = $mkportals->input['stato'];
		$approval = $mkportals->input['approvalc'];
		if (!$rev_sec_page || !$rev_file_page) {
			$message = "{$mklib->lang['ad_all_rows']}";
			$mklib->error_page($message);
			exit;
		}
		$DB->query("UPDATE mkp_config SET valore ='$rev_sec_page' where chiave = 'rev_sec_page'");
		$DB->query("UPDATE mkp_config SET valore ='$rev_file_page' where chiave = 'rev_file_page'");
		$DB->query("UPDATE mkp_config SET valore ='$mod_reviews' where chiave = 'mod_reviews'");
		$DB->query("UPDATE mkp_config SET valore ='$approval' where chiave = 'approval_review'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_review&mode=saved");
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

		$DB->query("DELETE FROM mkp_reviews_sections WHERE id = $idevento");

		$query = $DB->query( "SELECT id, image FROM mkp_reviews WHERE id_cat = $idevento");
		while( $row = $DB->fetch_row($query) ) {
			$idf = $row['id'];
			$file = $row['image'];
			@unlink("modules/reviews/images/$file");
			$DB->query("DELETE FROM mkp_reviews WHERE id = $idf");
			$DB->query("DELETE FROM mkp_reviews_comments WHERE identry = $idf");
		}
		$DB->close_db();
	 	Header("Location: admin.php?ind=ad_review&mode=saved");
		exit;

	}

	function row_select_event() {
			global $mkportals, $DB, $mklib;


			$query = $DB->query( "SELECT id, title FROM mkp_reviews_sections ORDER BY `id` DESC");
			while( $row = $DB->fetch_row($query) ) {
				$idevento = $row['id'];
				$evento = $row['title'];
				$cselect.= "<option value=\"$idevento\">$evento</option>\n";
				$cselects.= "<option value=\"$idevento\">$evento</option>\n";
			}
			return $cselect;
		}


}

?>
