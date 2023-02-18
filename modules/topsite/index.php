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

$idx = new mk_topsite;
class mk_topsite {

	var $tpl       = "";

	function mk_topsite() {
	global $mkportals, $DB, $mklib, $Skin, $mklib_board;

	$mklib->load_lang("lang_topsite.php");

	if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_access_topsite']) {
			$message = "{$mklib->lang['to_unauth']}";
			$mklib->error_page($message);
			exit;
		}
		if ($mklib->config['mod_topsite']) {
		$message = "{$mklib->lang['to_mnoactive']}";
			$mklib->error_page($message);
			exit;
		}

		//location
		$mklib_board->store_location("topsite");

    		switch($mkportals->input['op']) {
    			case 'reg_data':
    				$this->reg_data();
    			break;
				case 'submit_site':
    				$this->submit_site();
    			break;
    			case 'click_site':
    				$this->click_site();
    			break;
				case 'submit_rate':
    				$this->submit_rate();
    			break;
				case 'add_rate':
    				$this->add_rate();
    			break;
    			default:
    				$this->topsite_show();
    			break;
    		}
	}

	function topsite_show() {
		global $mkportals, $DB, $std, $print, $mklib, $Skin, $mklib_board;


		$start = $mkportals->input['start'];


		$query = $DB->query("SELECT id FROM mkp_topsite WHERE validate = '1'");
		$count = mysql_num_rows ($query);

		$q_page		=	$mkportals->input['st'];
		if ($q_page=="" or $q_page <= 0) {
			$q_page	=	0;
		}
		$per_page = $mklib->config['topsite_page'];
		if ($per_page=="" or $per_page <= 0) {
			$per_page	=	10;
		}

	    $start = $q_page;
		$show_pages = $mklib->build_pages( array( TOTAL_POSS  => $count,
							PER_PAGE    => $per_page,
							CUR_ST_VAL  => $q_page,
							L_SINGLE    => '',
							L_MULTI     => 'pagine',
						    BASE_URL    => 'index.php?ind=topsite',
										  )
								   );

	$iduser = $mkportals->member['id'];

	$utenti_in = $mklib_board->get_active_users("topsite");

	$submits = "<td align=\"right\"><a href=\"index.php?ind=topsite&amp;op=submit_site\"> [ {$mklib->lang['to_sign']} ]</a></td>";
	if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_topsite']) {
			$submits ="&nbsp;&nbsp;&nbsp;";
	}
		$output = "
<tr>
  <td>
    <table cellspacing=\"1\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">
      <tr>
      $submits
      </tr>
    </table>
    <br />
    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">
      <tr>
	<td>
	  <table class=\"modulebg\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" border=\"0\">
	    <tr>
	      <td class=\"tdblock\" width=\"100%\" height=\"25\"><img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$mklib->lang['to_title']}</td>
	    </tr>
	    <tr>
	      <td>
		<table class=\"moduleborder\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
		  <tr>
		    <td>
		      <table class=\"moduleborder\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
			<tr>
			  <td>
			    <table cellspacing=\"1\" cellpadding=\"5\" width=\"100%\" border=\"0\">
			      <tr>
				<th class=\"modulex\" width=\"5%\" align=\"center\">{$mklib->lang['to_pos']}</th>
				<th class=\"modulex\" width=\"5%\" align=\"center\">{$mklib->lang['to_votes']}</th>
				<th class=\"modulex\" width=\"80%\" align=\"center\">{$mklib->lang['to_site']}</th>
				<th class=\"modulex\" width=\"5%\" align=\"center\">{$mklib->lang['to_clicks']}</th>
				<th class=\"modulex\" width=\"5%\" align=\"center\">{$mklib->lang['to_mrate']}</th>
			      </tr>
	";

	$query = $DB->query( "SELECT id, title, description, link, banner, click, rate, trate FROM mkp_topsite WHERE validate = '1' ORDER BY `trate` DESC, `rate` DESC, `click` DESC  LIMIT $start, $per_page");
		$counterpos = $start +1;
		while( $row = $DB->fetch_row($query) ) {
			$idb = $row['id'];
			$banner = $row['banner'];
			$click = $row['click'];
			$link = $row['link'];
			$titolo = $row['title'];
			$descrizione = $row['description'];
			$rate = $row['rate'];
			$trate = $row['trate'];
			$width = round(($rate*100)/4) - 6;
	 		$width2 = $width - 4;
			switch($counterpos) {
				case '1':
					$counterimage = "<img src=\"$mklib->images/1.gif\" border=\"0\" alt=\"\" />";
    			break;
				case '2':
					$counterimage = "<img src=\"$mklib->images/2.gif\" border=\"0\" alt=\"\" />";
    			break;
				case '3':
					$counterimage = "<img src=\"$mklib->images/3.gif\" border=\"0\" alt=\"\" />";
    			break;
				default:
    				$counterimage = $counterpos;
    			break;
			}
			$output .= "
			      <tr>
				<td class=\"modulecell\" align=\"center\"><a href=\"$mklib->siteurl/index.php?ind=topsite&amp;op=submit_rate&amp;ide=$idb\"><span class=\"mktxtcontr\">$counterimage</span></a></td>
				<td class=\"modulecell\" align=\"center\"><a href=\"$mklib->siteurl/index.php?ind=topsite&amp;op=submit_rate&amp;ide=$idb\"><b>$trate</b></a></td>
				<td class=\"modulecell\" align=\"center\"><a href=\"$mklib->siteurl/index.php?ind=topsite&amp;op=click_site&amp;idb=$idb\" target=\"_blank\">$titolo<br /><img src=\"$banner\" border=\"0\" width=\"468\" height=\"60\" alt=\"\" /></a><br />$descrizione<br /></td>
				<td class=\"modulecell\" align=\"center\"><b>$click</b></td>
				<td class=\"modulecell\" align=\"center\" ><span class=\"mktxtcontr\">  {$rate}</span></td>
			      </tr>
			";
			++$counterpos;
	}



	$output .= "
			    </table>
			  </td>
			</tr>
		      </table>
		    </td>
		  </tr>
  		</table>
 	      </td>
 	    </tr>
 	  </table>
	</td>
      </tr>
    </table>    

    <table>
      <tr>
 	<td>
	&nbsp;&nbsp;{$show_pages}
	</td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td><br />
    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"1\" width=\"98%\" align=\"center\" border=\"0\">
      <tr>
    	<td class=\"modulex\">
	{$utenti_in}
	</td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td align=\"center\"><br /><br />
  <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\">MKPTopList - ©2004 Tutti i diritti riservati</a></div>
  </td>
</tr>
	";
		$mklib->printpage("1", "1", "{$mklib->lang['to_title']}", $output);


	}
	function submit_site() {
		global $mkportals, $DB, $mklib, $Skin;

		$iduser = $mkportals->member['id'];
		$mode = $mkportals->input['mode'];

		if(!$mkportals->member['g_access_cp'] && !$mklib->member['g_send_topsite']) {
			$message = "{$mklib->lang['to_nosign']}";
			$mklib->error_page($message);
			exit;
		}
		
		$output = "
<tr>
  <td><br />
    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">
      <tr>
	<td>
	  <table class=\"modulebg\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" border=\"0\">
	    <tr>
	      <td class=\"tdblock\" width=\"100%\" height=\"25\"><img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$mklib->lang['to_sign']}</td>
	    </tr>
	    <tr>
	      <td>
		<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
		  <tr>
		    <td>
		      <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
			<tr>			
			  <td class=\"modulex\">
			  
			    <form action=\"index.php?ind=topsite&amp;op=reg_data\" name=\"e_b\" method=\"post\">
			    <table width=\"100%\" border=\"0\">
			      <tr>
				<td class=\"titadmin\"><br />{$mklib->lang['to_instruction']}<br /><br /></td>
			      </tr>
			      <tr>
				<td>{$mklib->lang['to_sitename']}</td>
			      </tr>
			      <tr>
				<td><input type=\"text\" name=\"title\" size=\"70\" class=\"bgselect\" /></td>
			      </tr>
			      <tr>
				<td>{$mklib->lang['to_siteurl']}</td>
			      </tr>
			      <tr>
				<td><input type=\"text\" name=\"link\" size=\"70\" class=\"bgselect\" /></td>
			      </tr>
			      <tr>
				<td>{$mklib->lang['to_emailw']}</td>
			      </tr>
			      <tr>
				<td><input type=\"text\" name=\"email\" size=\"70\" class=\"bgselect\" /></td>
			      </tr>
			      <tr>			      
				<td>{$mklib->lang['to_sitedes']}</td>
			      </tr>
			      <tr>
				<td><input type=\"text\" name=\"description\" size=\"70\" class=\"bgselect\" /></td>
			      </tr>
			      <tr>
				<td>{$mklib->lang['to_bannerurl']}</td>
			      </tr>
			      <tr>
				<td><input type=\"text\" name=\"banner\" size=\"70\" class=\"bgselect\" /></td>
			      </tr>
			      <tr>
				<td>{$mklib->lang['to_bannerurl2']}</td>
			      </tr>
			      <tr>
				<td><input type=\"text\" name=\"banner2\" size=\"70\" class=\"bgselect\" /></td>
			      </tr>
			      <tr>
				<td><input type=\"submit\" value=\"{$mklib->lang['to_senddata']}\" class=\"bgselect\" /></td>
			      </tr>
			    </table>
			    </form>		
			
			  </td>
			</tr>
		      </table>
		    </td>
		  </tr>
  		</table>
 	      </td>
 	    </tr>
 	  </table>
	</td>
      </tr>
    </table>
  </td>
</tr>    
<tr>
  <td align=\"center\"><br /><br />
  <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\">MKPTopList - ©2004 Tutti i diritti riservati</a></div>
  </td>
</tr>
	";
	if ($mkportals->input['mode'] == "saved") {
		$output = "
<tr>
  <td>
    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"98%\" align=\"center\" border=\"0\">
      <tr>
 	<td class=\"titadmin\" width=\"100%\" align=\"center\">
	<br /><br />{$mklib->lang['to_signok']}<br /><br /><br />
	</td>
      </tr>
      <tr>
	<td align=\"center\" class=\"modulecell\">
	<br /><br /><div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\">MKPTopList - ©2004 Tutti i diritti riservati</a></div>
	</td>
      </tr>
    </table>
  </td>
</tr>
		";
   	}
		$mklib->printpage("1", "1", "{$mklib->lang['to_sign']}", $output);

	}

	function reg_data() {
		global $mkportals, $mklib, $Skin, $DB;

		$id_member = $mkportals->member['id'];
		$title = $mkportals->input['title'];
		$description = $mkportals->input['description'];
		$link = $mkportals->input['link'];
		$banner = $mkportals->input['banner'];
		$banner2 = $mkportals->input['banner2'];
		$email = $mkportals->input['email'];

		if (!$title || !$description || !$link || !$banner || !$email) {
			$message = "{$mklib->lang['to_reqall']}";
			$mklib->error_page($message);
			exit;
		}

		if (!preg_match("`^http\://`i", $link)) {
            $link = preg_replace("`^.*\://`i", "", $link);
            $link  = "http://".$link;
        }
        if (!preg_match("`^http\://`i", $banner)) {
            $banner = preg_replace("`^.*\://`i", "", $banner);
            $banner  = "http://".$banner;
        }
        if (!preg_match("`^http\://`i", $banner2)) {
            $banner2 = preg_replace("`^.*\://`i", "", $banner2);
            $banner2  = "http://".$banner2;
        }
        if (!preg_match("`^http\://`i", $banner2)) {
            $banner2 = preg_replace("`^.*\://`i", "", $banner2);
            $banner2  = "http://".$banner2;
        }

		$validat = "1";
		$approval = $mklib->config['approval_topsite'];
		if ($approval == "2" || $approval == "3") {
			$validat = 0;
		}
		if($mkportals->member['g_access_cp']) {
			$validat = "1";
		}

		$query="INSERT INTO mkp_topsite(id_member, title, description, link, banner, banner2, email, validate)VALUES('$id_member', '$title', '$description', '$link', '$banner', '$banner2', '$email', '$validat')";
		$DB->query($query);
		
		if ($approval == "1") {
			$mailsubj = $mklib->lang['01mail'].$mklib->lang['topsite'];
			$mailmess = $mklib->lang['02mail'].$mklib->lang['module'].$mklib->lang['topsite']."\n".$mklib->lang['sender'].$email."\n\n\n".$mklib->lang['from']." ".$mklib->sitename;
			$mklib_board->admin_mail($mailsubj, $mailmess);
		}
		if ($approval == "2") {
			$mailsubj = $mklib->lang['01mail'].$mklib->lang['topsite'];
			$mailmess = $mklib->lang['03mail'].$mklib->lang['module'].$mklib->lang['topsite']."\n".$mklib->lang['sender'].$email."\n\n\n".$mklib->lang['from']." ".$mklib->sitename;
			$mklib_board->admin_mail($mailsubj, $mailmess);
		}
		$DB->close_db();
	 	Header("Location: index.php?ind=topsite&amp;op=submit_site&amp;mode=saved");
		exit;

  	}
	function click_site() {
		global $mkportals, $mklib, $Skin, $DB;

		$idb = $mkportals->input['idb'];
		$query = $DB->query( "SELECT link, click FROM mkp_topsite WHERE id = '$idb'");
		$row = $DB->fetch_row($query);
		$link = $row['link'];
		$click = $row['click'];

		++$click;
		$DB->query("UPDATE mkp_topsite SET click ='$click'  where id = '$idb'");


		$DB->close_db();
	 	Header("Location: $link");
		exit;

  	}
	function submit_rate() {
    	global $mkportals, $mklib, $Skin, $DB, $mklib_board;
		$ide= $mkportals->input['ide'];

		$iduser = $mkportals->member['id'];
		$ipuser = $_SERVER['REMOTE_ADDR'];
		$module = "topsite";

		$query = $DB->query( "SELECT id FROM mkp_votes where module = '$module' and id_entry = '$ide' and id_member = '$iduser'");
		$checkuser = mysql_num_rows ($query);
		$query = $DB->query( "SELECT id FROM mkp_votes where module = '$module' and id_entry = '$ide' and ip = '$ipuser'");
		$checkip = mysql_num_rows ($query);

		if($checkuser || $checkip) {
			$message = "{$mklib->lang['to_justvote']}";
			$mklib->error_page($message);
			exit;
		}

		$query = $DB->query( "SELECT title FROM mkp_topsite where id = '$ide'");
		$row = $DB->fetch_row($query);
		$t_t = $row['title'];
		$maintit = "{$mklib->lang['to_vote']} $t_t";

		$utenti_in = $mklib_board->get_active_users("topsite");

	   $content .= "
<tr>
  <td><br />
    <table width=\"98%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" align=\"center\" class=\"moduleborder\">
      <tr>
	<td>
	  <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\" class=\"modulebg\">
	    <tr>
	      <td width=\"100%\" height=\"25\" class=\"tdblock\"> <img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$maintit}</td>
            </tr>
            <tr>
              <td>
                <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"moduleborder\">
                  <tr>
                    <td>
                      <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\">
			<tr>
			  <td style=\"background-color: #ffffff;\">

			    <form action=\"index.php?ind=topsite&amp;op=add_rate&amp;ide={$ide}\" method=\"post\" id=\"ratea\" name=\"ratea\">
			    <table width=\"100%\">
			      <tr>
				<td class=\"modulex\" width=\"60%\" valign=\"top\">{$mklib->lang['to_vote']} <b>$t_t</b> {$mklib->lang['to_maxvote']}
				</td>
				<td class=\"modulex\" width=\"*\">
				  <input class=\"mkradio\" type=\"radio\" tabindex=\"3\" name=\"rating\" value=\"1\" checked=\"checked\" />1
				  <input class=\"mkradio\" type=\"radio\" tabindex=\"4\" name=\"rating\" value=\"2\" />2
				  <input class=\"mkradio\" type=\"radio\" tabindex=\"5\" name=\"rating\" value=\"3\" />3
				  <input class=\"mkradio\" type=\"radio\" tabindex=\"6\" name=\"rating\" value=\"4\" />4
				  <input class=\"mkradio\" type=\"radio\" tabindex=\"7\" name=\"rating\" value=\"5\" />5
				</td>
			      </tr>
			      <tr>
				<td class=\"modulex\" colspan=\"2\">
				  <input type=\"submit\" name=\"ok\" value=\"{$mklib->lang['to_sendvote']}\" />
				</td>
			      </tr>		
			    </table>
			    </form>
			    
			  </td>
			</tr>
		      </table>
		    </td>
		  </tr>
	       </table>
	      </td>
	    </tr>
	  </table>
	</td>
      </tr>
    </table>
    <br />
    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"1\" width=\"98%\" align=\"center\" border=\"0\">
      <tr>
	<td class=\"modulex\">
      {$utenti_in}
	</td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td align=\"center\"><br /><br />
  <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\">MKPTopSite - ©2004 Tutti i diritti riservati</a></div>
  </td>
</tr>
	";
	$blocks = $Skin->view_block("{$mklib->lang['to_sendvote']}", $content);
	$mklib->printpage("1", "1", "{$mklib->lang['to_vote']}", $blocks);
	}

	function add_rate() {
    	global $mkportals, $DB;
		$ide= $mkportals->input['ide'];
		$rating = $mkportals->input['rating'];
		$iduser = $mkportals->member['id'];
		$ipuser = $_SERVER['REMOTE_ADDR'];
		$module = "topsite";

		$query="INSERT INTO mkp_votes(id_entry, module, id_member, ip)VALUES('$ide', '$module', '$iduser', '$ipuser')";
		$DB->query($query);

		$query = $DB->query( "SELECT rate, trate FROM mkp_topsite where id = '$ide'");
		$row = $DB->fetch_row($query);
		$rate = $row['rate'];
		$trate = $row['trate'];
		$votes = ($trate +1);
		if ( $rating != 0 ) {
				$rate = round ((($trate*$rate)+$rating)/($votes), 2);
		}
		$DB->query("UPDATE mkp_topsite SET rate ='$rate', trate ='$votes' where id = '$ide'");
		$DB->close_db();
	 	Header("Location: index.php?ind=topsite");
		exit;
  	}

}
?>
