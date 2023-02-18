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


	$lonlinelist= $mklib_board->forum_link("onlinelist");
	$users= $mklib_board->get_onlineblock();

	$logged_visible_online = $users[0];
	$logged_hidden_online = $users[1];
	$guests_online = $users[2];
	$online_userlist = $users[3];
	unset ($users);


	$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;

			$content = "
				<tr>
				  <td width=\"100%\">
				    <table border=\"0\" width=\"100%\" cellpadding=\"1\" cellspacing=\"1\">
				      <tr>
					<td class=\"tdblock\">
					<span class=\"mktxtcontr\">$total_online_users</span> {$this->lang['onlineusers']}:
					</td>
				      </tr>
				      <tr>
					<td class=\"tdglobal\">
					<b>$guests_online</b> &nbsp;{$this->lang['guests']}<br /><b>$logged_hidden_online</b> &nbsp;{$this->lang['anons']}<br /><b>$logged_visible_online</b> &nbsp;{$this->lang['noanons']}:<br /> $online_userlist
					</td>
				      </tr>
				    </table>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdblock\">
				  <img src=\"$this->images/atb_members.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$lonlinelist\">{$this->lang['lastclick']}</a>
				  </td>
				</tr>	
     	 	";

		unset($lonlinelist);
		unset($logged_visible_online);
		unset($logged_hidden_online);
		unset($guests_online);
		unset($online);
		unset($total_online_users);

?>
