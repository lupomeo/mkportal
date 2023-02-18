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

		global $MK_BOARD;
		$content = "";
		$extra2 = "";


 		$return = $this->siteurl;
		$cpaforum = $mklib_board->forum_link("cpaforum");
		$cpapers = $mklib_board->forum_link("cpapers");
		$pm = $mklib_board->forum_link("pm");
		$logout = $mklib_board->forum_link("logout");
		$postlink = $mklib_board->forum_link("postlink");
		$postlink2 = $mklib_board->forum_link("postlink2");
		$register = $mklib_board->forum_link("register");
		$login_user = $mklib_board->forum_link("login_user");
		$login_passw = $mklib_board->forum_link("login_passw");
		$extra = $mklib_board->forum_link("login_extra");

 		if ( $mkportals->member['id'] )
 		{
			$last_visit =  $mkportals->member['last_visit'];

        	$last_visit = $this->create_date($last_visit);

			$avatar_img = $mklib_board->get_avatar();
			$subtitle ="{$this->lang['welcome']} {$mkportals->member['name']}";
			$pm_string  = "(".$mkportals->member['user_new_privmsg'].")";
			if($mkportals->member['g_access_cp'] || $this->member['g_access_cpa']) {
				$admin_panel ="
				<tr>
				  <td width=\"100%\" class=\"tdblock\">
     	 			  <img src=\"$this->images/atb_cpap.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$this->mkurl/admin.php\">{$this->lang['cpap']}</a>
				  </td>
				</tr>
				";
			}
			if($mkportals->member['g_access_cp']) {
				$admin_panel .="
				<tr>
				  <td width=\"100%\" class=\"tdblock\">
				 <img src=\"$this->images/atb_cpaf.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\"  href=\"$cpaforum\">{$this->lang['cpaf']}</a>
				  </td>
				</tr>
				";
			}
			$content = "
				<tr>
				  <td width=\"100%\" class=\"tdblock\" align=\"center\">
				  $subtitle
				  </td>
				</tr>
				<tr>
				  <td width=\"100%\" class=\"tdblock\" align=\"center\">
				  $avatar_img
				  </td>
				</tr>
				<tr>
				  <td width=\"100%\" class=\"tdblock\" align=\"center\">
				  <span class=\"mktxtcontr\">{$this->lang['last_access']}:</span>
				  </td>
				</tr>
				<tr>
				  <td width=\"100%\" align=\"center\" class=\"tdglobal\">
				  $last_visit
				  </td>
				</tr>
				$admin_panel
				<tr>
				  <td width=\"100%\"  class=\"tdblock\">
				  <img src=\"$this->images/atb_cpapers.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$cpapers\">{$this->lang['cpape']}</a>
				  </td>
				</tr>
				<tr>
				  <td width=\"100%\" class=\"tdblock\">
				  <img src=\"$this->images/atb_mp.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$pm\">{$this->lang['pm_string']} $pm_string</a>
				  </td>
				</tr>
				<tr>
				  <td width=\"100%\" class=\"tdblock\">
				  <img src=\"$this->images/atb_exit.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$logout\">{$this->lang['logout']}</a>
				  </td>
				</tr>
     	 	";


 		}
 		else
 		{
 			$subtitle = $this->lang['welcome_guest'];

if($MK_BOARD == "IPB") {
$content = "
				<tr>
				  <td colspan=\"2\" align=\"left\">
				    <script language='JavaScript' type=\"text/javascript\">
				    <!--
				    function ValidateForm() {
				    var Check = 0;
				    if (document.LOGIN.UserName.value == '') { Check = 1; }
				    if (document.LOGIN.PassWord.value == '') { Check = 1; }
				    if (Check == 1) {
				    alert(\"Please enter your name and password before continuing\");
				    return false;
				    } else {
				    document.LOGIN.submit.disabled = true;
				    return true;
				    }
				    }
				    //-->
				    </script>
				  </td>
				</tr>
";
$extra2 = "
				<tr>
				  <td class=\"tdblock\" colspan=\"2\" align=\"left\">
				    <a class=\"uno\" href=\"{$mkportals->forum_url}/index.php?act=Reg&amp;CODE=10\">{$this->lang['forgot_pass']}</a>
				  </td>
				</tr>
				<tr>
				  <td class=\"tdblock\" colspan=\"2\" align=\"left\">
				    <a class=\"uno\" href=\"{$mkportals->forum_url}/index.php?act=Reg&amp;CODE=reval\">{$this->lang['revalidate']}</a>
				  </td>
				</tr>
";
}
			$content .= "
				<tr>
				  <td class=\"tdblock\">
				  $subtitle<br />
				  <form method=\"post\" action=\"$postlink\" $postlink2>
				    <table>
				      <tr>
					<td width=\"40%\" align=\"left\" class=\"tdblock\">
					<b>User:</b>
					</td>
					<td width=\"60%\" align=\"right\" class=\"tdblock\"><input class=\"mkblkinput\" type=\"text\" name=\"$login_user\" size=\"10\" /></td>
				      </tr>
				      <tr>
					<td width=\"40%\" align=\"left\" class=\"tdblock\"><b>Pass:</b></td>
					<td width=\"60%\" align=\"right\" class=\"tdblock\"><input class=\"mkblkinput\" type=\"password\" name=\"$login_passw\" size=\"10\" /></td>
				      </tr>
				      $extra
				      <tr>
					<td width=\"50%\" align=\"left\" class=\"tdblock\"></td>
					<td width=\"50%\" class=\"tdblock\"><input class=\"mkbutton\" type=\"submit\" value=\"Login\" name=\"submit\" />
					</td>
				      </tr>
				      <tr>
					<td width=\"100%\" colspan=\"2\" align=\"left\" class=\"tdblock\">
					<a class=\"uno\" href=\"$register\">{$this->lang['register']}!</a></td>
				      </tr>
					  $extra2
				    </table>
				  </form>
				</td>
			      </tr>
		";
 		}

		unset($return);
		unset($cpaforum);
		unset($cpapers);
		unset($pm);
		unset($logout);
		unset($postlink);
		unset($postlink2);
		unset($register);
		unset($login_user);
		unset($login_passw);
		unset($extra);

?>
