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

$idx = new mk_ad_urlo;
class mk_ad_urlo {


	function mk_ad_urlo() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'save_main':
    			$this->save_main();
    		break;
			default:
    			$this->urlo_show();
    		break;
    		}
	}

	function urlo_show() {
	global $mkportals, $mklib, $Skin, $DB;

		$urlo_page = $mklib->config['urlo_page'];
		$urlo_max= $mklib->config['urlo_max'];
		$urlo_block= $mklib->config['urlo_block'];
		if ($mklib->config['mod_urlobox']) {
		$checkactive =  "checked=\"checked\"";
   		}

		if ($mkportals->input['mode'] == "saved") {
		$checksave = "{$mklib->lang['ad_saved']}<br /><br />";
   		}
	 	$content  = "
	<tr>
	  <td>
	  
	    <form action=\"admin.php?ind=ad_urlo&amp;op=save_main\" name=\"save_main\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>$checksave</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_preferences']}</td>
	      </tr>
	      <tr>
		<td><span class=\"mktxtcontr\">{$mklib->lang['ad_urlodisactive']}</span> <input type=\"checkbox\" name=\"stato\" value=\"1\" $checkactive /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_urlopages']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"urlo_page\" value=\"$urlo_page\" size=\"10\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_urlomax']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"urlo_max\" value=\"$urlo_max\" size=\"10\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_urloblock']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"urlo_block\" value=\"$urlo_block\" size=\"10\" class=\"bgselect\" /></td>
	      </tr>
	      <tr>
		<td><br /><input type=\"submit\" name=\"Salve\" value=\"{$mklib->lang['ad_save']}\" class=\"bgselect\" /></td>
	      </tr>
	    </table>
	    </form>

	  </td>
	</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_urlotitle']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function save_main() {
    	global $mkportals, $DB, $mklib;
		$urlo_page = $mkportals->input['urlo_page'];
		$urlo_max = $mkportals->input['urlo_max'];
		$urlo_block = $mkportals->input['urlo_block'];
		if (!$urlo_page || !$urlo_max || !$urlo_block) {
			$message = "{$mklib->lang['ad_all_rows']}";
			$mklib->error_page($message);
			exit;
		}
		$mod_urlobox = $mkportals->input['stato'];
		$DB->query("UPDATE mkp_config SET valore ='$urlo_page' where chiave = 'urlo_page'");
		$DB->query("UPDATE mkp_config SET valore ='$urlo_max' where chiave = 'urlo_max'");
		$DB->query("UPDATE mkp_config SET valore ='$urlo_block' where chiave = 'urlo_block'");
		$DB->query("UPDATE mkp_config SET valore ='$mod_urlobox' where chiave = 'mod_urlobox'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_urlo&mode=saved");
		exit;
  	}



}

?>
