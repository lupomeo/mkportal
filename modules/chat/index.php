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

$idx = new mk_chat;
class mk_chat {

	var $tpl       = "";

	function mk_chat() {
		global $mkportals, $DB, $std, $print, $mklib, $Skin, $mklib_board;

		$mklib->load_lang("lang_chat.php");

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_access_chat']) {
			$message = "{$mklib->lang['ch_unauth']}";
			$mklib->error_page($message);
			exit;
		}

		//location
		$mklib_board->store_location("chat");

		if ($mklib->config['mod_chat']) {
		$message = "{$mklib->lang['ch_mnoactive']}";
			$mklib->error_page($message);
			exit;
		}
    	switch($mkportals->input['op']) {
    			case 'refresh_list':
    				$this->refresh_list();
    			break;
				default:
    				$this->run_chat();
    			break;
		}

 	}
	function run_chat() {
		global $mkportals, $DB, $mklib, $Skin;

    	require "mkportal/modules/chat/tpl_chat.php";
		$this->tpl = new tpl_mkchat();
		$id = $mkportals->member['id'];
		$nick = $mkportals->member['name'];
		if($mkportals->member['name']=="Guest") {
				$nick = $mklib->lang['ch_guest'];
		}
		$run_time = time();
		$DB->query("select nick FROM mkp_chat WHERE id = '$id'");
		if ($DB->fetch_row()){
			$DB->query("UPDATE mkp_chat SET run_time='$run_time' WHERE id='$id' ");
		} else {
			$query="INSERT INTO mkp_chat(id, nick, run_time)VALUES('$id', '$nick', '$run_time')";
			$DB->query($query);
		}
		$dead_users = time() - (60*3);
		$DB->query("DELETE FROM mkp_chat WHERE run_time < ".$dead_users." ");

		$chat_server = $mklib->config['chat_server'];
		$chat_port= $mklib->config['chat_port'];
		$chat_channel= $mklib->config['chat_channel'];
        $output  = $this->tpl->view_chat($chat_server, $chat_port, $chat_channel);
		$blocks .= $Skin->view_block("MKPortalChat", $output);
		$mklib->printpage("0", "0", "MKPortalChat", $blocks);

 	}
	function refresh_list() {
		global $mkportals, $DB, $mklib;
		print "<meta http-equiv=\"refresh\" content=\"120; url=$mklib->siteurl/index.php?ind=chat&op=refresh_list\">";
		$id = $mkportals->member['id'];
		$nick = $mkportals->member['name'];
		if($mkportals->member['name']=="Guest") {
				$nick = $mklib->lang['ch_guest'];
		}
		$run_time = time();
		$DB->query("select nick FROM mkp_chat WHERE id = '$id'");
		if ($DB->fetch_row()){
			$DB->query("UPDATE mkp_chat SET run_time='$run_time' WHERE id='$id' ");
		} else {
			$query="INSERT INTO mkp_chat(id, nick, run_time)VALUES('$id', '$nick', '$run_time')";
			$DB->query($query);
		}
		$dead_users = time() - (60*3);
		$DB->query("DELETE FROM mkp_chat WHERE run_time < ".$dead_users." ");
		$DB->close_db();
 	}



}
?>
