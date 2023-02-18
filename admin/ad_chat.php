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
$idx = new mk_ad_chat;
class mk_ad_chat {


	function mk_ad_chat() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'save_main':
    			$this->save_main();
    		break;
			default:
    			$this->chat_show();
    		break;
    		}
	}

	function chat_show() {
	global $mkportals, $mklib, $Skin, $DB;


		$chat_server = $mklib->config['chat_server'];
		$chat_port= $mklib->config['chat_port'];
		$chat_channel= $mklib->config['chat_channel'];

		if ($mklib->config['mod_chat']) {
		$checkactive =  "checked=\"checked\"";
   		}
		if ($mkportals->input['mode'] == "saved") {
		$checksave = "{$mklib->lang['ad_saved']}<br /><br />";
   		}
	 	$content  = "
	<tr>
	  <td>
	  
	    <form action=\"admin.php?ind=ad_chat&amp;op=save_main\" name=\"save_main\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>$checksave</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_preferences']}</td>
	      </tr>
	      <tr>
		<td><span style=\"color: red; font-weight: bold;\">{$mklib->lang['ad_chatdisactive']}</span> <input type=\"checkbox\" name=\"stato\" value=\"1\" $checkactive /></td>
	      </tr>
	    <tr>
	      <td>{$mklib->lang['ad_chatserver']}</td>
	    </tr>
	    <tr>
	      <td><input type=\"text\" name=\"chat_server\" value=\"$chat_server\" size=\"50\" class=\"bgselect\" /></td>
	    </tr>
	    <tr>
	      <td>{$mklib->lang['ad_chatport']}</td>
	    </tr>
	    <tr>
	      <td><input type=\"text\" name=\"chat_port\" value=\"$chat_port\" size=\"50\" class=\"bgselect\" /></td>
	    </tr>
	    <tr>
	      <td>{$mklib->lang['ad_chatchan']}</td>
	    </tr>
	    <tr>
	      <td><input type=\"text\" name=\"chat_channel\" value=\"$chat_channel\" size=\"50\" class=\"bgselect\" /></td>
	    </tr>
	    <tr>
	      <td><br /><input type=\"submit\" name=\"Salve\" value=\"{$mklib->lang['ad_save']}\" class=\"bgselect\" /></td>
	    </tr>
	  </table>
	  </form>
	  
	</td>
      </tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_chattitle']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function save_main() {
    	global $mkportals, $DB, $mklib;
		$mod_chat = $mkportals->input['stato'];
		$chat_channel = $mkportals->input['chat_channel'];
		$chat_port = $mkportals->input['chat_port'];
		$chat_server = $mkportals->input['chat_server'];
		if (!$chat_server || !$chat_port || !$chat_channel) {
			$message = "{$mklib->lang['ad_all_rows']}";
			$mklib->error_page($message);
			exit;
		}
		$DB->query("UPDATE mkp_config SET valore ='$chat_channel' where chiave = 'chat_channel'");
		$DB->query("UPDATE mkp_config SET valore ='$chat_port' where chiave = 'chat_port'");
		$DB->query("UPDATE mkp_config SET valore ='$chat_server' where chiave = 'chat_server'");
		$DB->query("UPDATE mkp_config SET valore ='$mod_chat' where chiave = 'mod_chat'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_chat&mode=saved");
		exit;
  	}



}

?>
