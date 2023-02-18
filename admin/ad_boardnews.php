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
$idx = new mk_ad_boardnews;
class mk_ad_boardnews {


	function mk_ad_boardnews() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'save_main':
    			$this->save_main();
    		break;
			default:
    			$this->boardnews_show();
    		break;
    		}
	}

	function boardnews_show() {
	global $mkportals, $mklib, $Skin, $DB, $mklib_board;

		$forum_active = $mklib->config['forum_active'];
		$news_block = $mklib->config['bnews_block'];
		$cselect = $mklib_board->get_forum_list();

		if (!$news_block) {
			$news_block = 3;
   		}

		if ($mkportals->input['mode'] == "saved") {
		$checksave = "{$mklib->lang['ad_saved']}<br /><br />";
   		}
	 	$content  = "
	<tr>
	  <td>
	    <form action=\"admin.php?ind=ad_boardnews&amp;op=save_main\" name=\"sel_g\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>$checksave</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_preferences']}</td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_bnewschose']}</td>
	      </tr>
	      <tr>
		<td width=\"10%\">
		  <select name=\"forum_active\" size=\"1\" class=\"bgselect\">
		  {$cselect}
		  </select>
		</td>
	      </tr>
		  <tr>
		<td>{$mklib->lang['ad_newsblockp']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"news_block\" value=\"$news_block\" size=\"10\" class=\"bgselect\" /></td>
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
		$output = $Skin->view_block("{$mklib->lang['ad_bnewstitle']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function save_main() {
    	global $mkportals, $DB;
		$forum_active = $mkportals->input['forum_active'];
		$news_block = $mkportals->input['news_block'];
		
		$DB->query("select valore FROM mkp_config where chiave = 'forum_active'");
		if ($DB->fetch_row()){
			$DB->query("UPDATE mkp_config SET valore ='$forum_active' where chiave = 'forum_active'");
			$DB->query("UPDATE mkp_config SET valore ='$news_block' where chiave = 'bnews_block'");
		} else {
			$DB->query("INSERT INTO mkp_config(chiave, valore)VALUES('forum_active', '$forum_active')");
			$DB->query("INSERT INTO mkp_config(chiave, valore)VALUES('bnews_block', '$news_block')");
		}

		$DB->close_db();
		Header("Location: admin.php?ind=ad_boardnews&mode=saved");
		exit;
  	}



}

?>
