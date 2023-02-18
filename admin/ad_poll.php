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
$idx = new mk_ad_poll;
class mk_ad_poll {


	function mk_ad_poll() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'save_main':
    			$this->save_main();
    		break;
			default:
    			$this->poll_show();
    		break;
    		}
	}

	function poll_show() {
	global $mkportals, $mklib, $Skin, $DB, $mklib_board;

		$poll_active = $mklib->config['poll_active'];

		$cselect.= $mklib_board->get_poll_list();

		if ($mkportals->input['mode'] == "saved") {
		$checksave = "{$mklib->lang['ad_saved']}<br /><br />";
   		}
	 	$content  = "
	<tr>
	  <td>
	  
	    <form action=\"admin.php?ind=ad_poll&amp;op=save_main\" name=\"sel_g\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>$checksave</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_preferences']}</td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_pollset']}</td>
	      </tr>
	      <tr>
		<td width=\"10%\">
		  <select name=\"poll_active\" size=\"1\" class=\"bgselect\">
		  {$cselect}
		  </select>
		</td>
	      </tr>
	      <tr>
		<td>
		  <input type=\"submit\" name=\"Salva\" value=\"{$mklib->lang['ad_save']}\" class=\"bgselect\" />
		</td>
	      </tr>
	    </table>
	    </form>
	    
	  </td>
	</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_polltitle']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function save_main() {
    	global $mkportals, $DB;
		$poll_active = $mkportals->input['poll_active'];

		$DB->query("UPDATE mkp_config SET valore ='$poll_active' where chiave = 'poll_active'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_poll&mode=saved");
		exit;
  	}



}

?>
