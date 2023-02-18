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
	$users= $mklib_board->get_onlinehome($this->lang['guest']);

	$content = "";
	$logged_visible_online = $users[0];
	$logged_hidden_online = $users[1];
	$guests_online = $users[2];
	$online['portale'] = $users[3];
	$online['blog'] = $users[4];
	$online['gallery'] = $users[5];
	$online['urlobox'] = $users[6];
	$online['downloads'] = $users[7];
	$online['news'] = $users[8];
	$online['chat'] = $users[9];
	$online['topsite'] = $users[10];
	$online['reviews'] = $users[11];
	$online['forum'] = $users[12];
	unset ($users);

	
			$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;

			$content = "
				<tr>
				  <td width=\"100%\">
				    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" align=\"center\" border=\"0\">
				      <tr>
					<td class=\"tdblock\">
					&nbsp;<span class=\"mktxtcontr\">$total_online_users</span> {$this->lang['onlineusers']}: $guests_online &nbsp;{$this->lang['guests']}, $logged_hidden_online &nbsp;{$this->lang['anons']}, $logged_visible_online &nbsp;{$this->lang['noanons']}
					</td>
				      </tr>

				      <tr>
					<td>
					  <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\" align=\"center\" border=\"0\">
					    <tr>
					      <td class=\"modulecell\" width=\"20%\" ><b>{$this->lang['portal_home']}</b></td>
					      <td class=\"modulecell\" width=\"80%\">{$online['portale']}</td>
					    </tr>
					    <tr>
					      <td class=\"modulecell\" width=\"20%\" >{$this->lang['forum']}</td>
					      <td class=\"modulecell\" width=\"80%\">{$online['forum']}</td>
					    </tr>
					    <tr>
					      <td class=\"modulecell\" width=\"20%\" >{$this->lang['blog']}</td>
					      <td class=\"modulecell\" width=\"80%\">{$online['blog']}</td>
					    </tr>
					    <tr>
					      <td class=\"modulecell\" width=\"20%\" >{$this->lang['gallery']}</td>
					      <td class=\"modulecell\" width=\"80%\">{$online['gallery']}</td>
					    </tr>
					    <tr>
					      <td class=\"modulecell\" width=\"20%\" >{$this->lang['urlobox']}</td>
					      <td class=\"modulecell\" width=\"80%\">{$online['urlobox']}</td>
					    </tr>
					    <tr>
					      <td class=\"modulecell\" width=\"20%\" >{$this->lang['download']}</td>
					      <td class=\"modulecell\" width=\"80%\">{$online['downloads']}</td>
					    </tr>
					    <tr>
					      <td class=\"modulecell\" width=\"20%\" >{$this->lang['news']}</td>
					      <td class=\"modulecell\" width=\"80%\">{$online['news']}</td>
					    </tr>
					    <tr>
					      <td class=\"modulecell\" width=\"20%\" >{$this->lang['chat']}</td>
					      <td class=\"modulecell\" width=\"80%\">{$online['chat']}</td>
					    </tr>
					    <tr>
					      <td class=\"modulecell\" width=\"20%\" >{$this->lang['topsite']}</td>
					      <td class=\"modulecell\" width=\"80%\">{$online['topsite']}</td>
					    </tr>
					    <tr>
					      <td class=\"modulecell\" width=\"20%\" >{$this->lang['reviews']}</td>
					      <td class=\"modulecell\" width=\"80%\">{$online['reviews']}</td>
					    </tr>			
					  </table>		
					</td>
				      </tr>
				      <tr>
					<td class=\"tdblock\">
					&nbsp;<img src=\"$this->images/atb_members.gif\" align=\"middle\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$lonlinelist\">{$this->lang['lastclick']}</a>
					</td>
				      </tr>		  
				    </table>
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
