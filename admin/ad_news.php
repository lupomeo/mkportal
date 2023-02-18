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

$idx = new mk_ad_news;
class mk_ad_news {


	function mk_ad_news() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'add_event':
    			$this->add_event();
    		break;
			case 'edit_event':
    			$this->edit_event();
    		break;
			case 'save_main':
    			$this->save_main();
    		break;
			case 'update_event':
    			$this->update_event();
    		break;
			case 'delete_event':
    			$this->delete_event();
    		break;
			default:
    			$this->news_show();
    		break;
    		}
	}

	function news_show() {
	global $mkportals, $mklib, $Skin, $DB;

		// Admin Approval combo
		$approval = $mklib->config['approval_news'];
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

		$query = $DB->query( "SELECT id, titolo FROM mkp_news_sections ORDER BY `id` DESC");
		while( $row = $DB->fetch_row($query) ) {
			$idevento = $row['id'];
			$evento = $row['titolo'];
			$cselect.= "<option value='$idevento'>$evento</option>\n";
		}
		$news_page = $mklib->config['news_page'];
		$news_block= $mklib->config['news_block'];
		$news_words= $mklib->config['news_words'];
		
		if ($mklib->config['mod_news']) {
		$checkactive =  "checked=\"checked\"";
   		}

		if ($mklib->config['news_html']) {
		$checkactive2 =  "checked=\"checked\"";
   		}

		if ($mkportals->input['mode'] == "saved") {
		$checksave = "{$mklib->lang['ad_saved']}<br /><br />";
   		}
	 	$content  = "
		
	<tr>
	  <td>

	    <script type=\"text/javascript\">

			function makesurenew() {
			if (confirm('{$mklib->lang[ad_delsecconfirm]}')) {
			return true;
			} else {
			return false;
			}
			}

	    </script>
			
	    <form action=\"admin.php?ind=ad_news&amp;op=save_main\" name=\"save_main\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>$checksave</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_preferences']}</td>
	      </tr>
	      <tr>
		<td><span class=\"mktxtcontr\">{$mklib->lang['ad_newdisactive']}</span> <input type=\"checkbox\" name=\"stato\" value=\"1\" $checkactive /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_newspages']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"news_page\" value=\"$news_page\" size=\"10\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_newsblockp']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"news_block\" value=\"$news_block\" size=\"10\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_newsmaxwords']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"news_words\" value=\"$news_words\" size=\"10\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td><b>{$mklib->lang['ad_newshtmldisac']}</b> <input type=\"checkbox\" name=\"news_html\" value=\"1\" $checkactive2 /></td>
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
		<td><br /><input type=\"submit\" name=\"Salve\" value=\"{$mklib->lang['ad_save']}\" class=\"bgselect\" /></td>
	      </tr>
	    </table>
	    </form>

	    <form action=\"admin.php?ind=ad_news&amp;op=add_event\" name=\"a_ev\" method=\"post\">
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
		<td>{$mklib->lang['ad_addiconimage']}<br /></td>
	      </tr>
	      <tr>
		<td>
		  <select size=\"1\" name=\"icona\" class=\"bgselect\">
		    <option value=\"1\">icon_news</option>
		    <option value=\"2\">icon_help</option>
		    <option value=\"3\">icon_star</option>
		    <option value=\"4\">icon_pc</option>
		    <option value=\"5\">icon_world</option>
		  </select>
		  {$mklib->lang['ad_newsaddressicon']}: <input class=\"bgselect\" size=\"50\" name=\"iconalt\" />
		</td>
	      </tr>
	      <tr>
		<td><input type=\"submit\" name=\"Inserisci\" value=\"{$mklib->lang['ad_insert']}\" class=\"bgselect\" /></td>
	      </tr>
	    </table>
	    </form>
	    
	    <form action=\"admin.php?ind=ad_news&amp;op=edit_event\" name=\"m_ev\" method=\"post\">
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

	    <form action=\"admin.php?ind=ad_news&amp;op=delete_event\" name=\"e_ev\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_delsection']}</td>
	      </tr>
	      <tr>
		<td width=\"10%\">
		  <select name=\"eventoc\" size=\"1\" class=\"bgselect\">
		  {$cselect}
		  </select>   
		  <input type=\"submit\" name=\"Elimina\" value=\"{$mklib->lang['ad_delete']}\" onclick=\"return makesurenew()\" class=\"bgselect\" />
		</td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_newswarning']}</td>
	      </tr>
	    </table>
	    </form>
	    
	  </td>
	</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_newstitle']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function save_main() {
    	global $mkportals, $DB, $mklib;
		$news_page = $mkportals->input['news_page'];
		$news_block = $mkportals->input['news_block'];
		$news_words = $mkportals->input['news_words'];
		$news_html = $mkportals->input['news_html'];
		$approval = $mkportals->input['approvalc'];
		if (!$news_page || !$news_block) {
			$message = "{$mklib->lang['ad_all_rows']}";
			$mklib->error_page($message);
			exit;
		}
		$mod_news = $mkportals->input['stato'];

		$DB->query("UPDATE mkp_config SET valore ='$news_page' where chiave = 'news_page'");
		$DB->query("UPDATE mkp_config SET valore ='$news_block' where chiave = 'news_block'");
		$DB->query("UPDATE mkp_config SET valore ='$mod_news' where chiave = 'mod_news'");
		$DB->query("UPDATE mkp_config SET valore ='$news_words' where chiave = 'news_words'");
		$DB->query("UPDATE mkp_config SET valore ='$news_html' where chiave = 'news_html'");
		$DB->query("UPDATE mkp_config SET valore ='$approval' where chiave = 'approval_news'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_news&mode=saved");
		exit;
  	}
	function add_event() {

		global $mkportals, $DB, $mklib;
		$evento = $mkportals->input['eventoa'];
		$icona = $mkportals->input['icona'];
		$iconalt = $mkportals->input['iconalt'];
		if (!$evento) {
			$message = "{$mklib->lang['ad_req_ncat']}";
			$mklib->error_page($message);
			exit;
		}
		if (strlen($iconalt) > 5) {
			$icona = $iconalt;
		}
		$DB->query("INSERT INTO  mkp_news_sections (titolo, icona) VALUES ('$evento', '$icona')");
		$DB->close_db();
	 	Header("Location: admin.php?ind=ad_news&mode=saved");
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
		$query = $DB->query( "SELECT titolo, icona, position FROM mkp_news_sections  WHERE id = $idf");
		$row = $DB->fetch_row($query);
		$evento = $row['titolo'];
		$icona = $row['icona'];
		$position =  $row['position'];
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


		$content = "
	<tr>
	  <td>
	  
	    <form action=\"admin.php?ind=ad_news&amp;op=update_event\" name=\"EV_UPGRADE\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td class=\"titadmin\">
		{$mklib->lang['ad_title']}
		<input type=\"hidden\" name=\"idf\"  value = \"{$idf}\" />
		</td>		  
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"evento\"  value = \"{$evento}\" size=\"50\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_icon']}:</td>
	      </tr>
	      <tr>
		<td>&nbsp;&nbsp; <img src=\"$image\" border=\"1\" alt=\"\" />&nbsp;&nbsp; <input type=\"text\" name=\"icona\"  value = \"{$image}\" size=\"50\" class=\"bgselect\" /></td>
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
		$output = $Skin->view_block("{$mklib->lang['ad_newsedittitle']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}
	function update_event() {
    	global $mkportals, $DB, $mklib;
		$idf = $mkportals->input['idf'];
		$evento = $mkportals->input['evento'];
		$position = $mkportals->input['position'];
		$icona = $mkportals->input['icona'];
		if (!$evento || !$icona) {
			$message = "{$mklib->lang['ad_req_nicat']}";
			$mklib->error_page($message);
			exit;
		}
		$DB->query("UPDATE  mkp_news_sections set titolo = '$evento', icona = '$icona', position = '$position' where id = '$idf'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_news&mode=saved");
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
		$DB->query("DELETE FROM mkp_news_sections WHERE id = $idevento");
		$DB->query("DELETE FROM mkp_news WHERE idcategoria = $idevento");
		$DB->close_db();
	 	Header("Location: admin.php?ind=ad_news&mode=saved");
		exit;

	}


}

?>
