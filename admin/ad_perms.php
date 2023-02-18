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

$idx = new mk_ad_perms;
class mk_ad_perms {


	function mk_ad_perms() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'save_main':
    			$this->save_main();
    		break;
			case 'sel_group':
    			$this->save_main();
    		break;
			default:
    			$this->perms_show();
    		break;
    		}
	}

	function perms_show() {
	global $mkportals, $mklib, $Skin, $DB, $mklib_board;

		if ($mkportals->input['mode'] == "saved") {
		$checksave = "{$mklib->lang['ad_saved']}<br /><br />";
   		}

		if ($mkportals->input['idg']) {

			for ($i = 1; $i <= 23; $i++) {
   				$n[$i] = "checked";
			}

			$DB->query( "SELECT * FROM mkp_pgroups where g_id = '{$mkportals->input['idg']}'");
			while( $row = $DB->fetch_row() ) {
				if ($row['g_send_news'] == 1) {
					$y[1] = "checked";
					$n[1] = "";
				}
				if ($row['g_mod_news'] == 1) {
					$y[2] = "checked";
					$n[2] = "";
				}
				if ($row['g_access_download'] == 1) {
					$y[3] = "checked";
					$n[3] = "";
				}
				if ($row['g_send_download'] == 1) {
					$y[4] = "checked";
					$n[4] = "";
				}
				if ($row['g_mod_download'] == 1) {
					$y[5] = "checked";
					$n[5] = "";
				}
				if ($row['g_access_gallery'] == 1) {
					$y[6] = "checked";
					$n[6] = "";
				}
				if ($row['g_send_gallery'] == 1) {
					$y[7] = "checked";
					$n[7] = "";
				}
				if ($row['g_mod_gallery'] == 1) {
					$y[8] = "checked";
					$n[8] = "";
				}
				if ($row['g_access_urlobox'] == 1) {
					$y[9] = "checked";
					$n[9] = "";
				}
				if ($row['g_send_urlobox'] == 1) {
					$y[10] = "checked";
					$n[10] = "";
				}
				if ($row['g_mod_urlobox'] == 1) {
					$y[11] = "checked";
					$n[11] = "";
				}
				if ($row['g_access_chat'] == 1) {
					$y[12] = "checked";
					$n[12] = "";
				}
				if ($row['g_access_cpa'] == 1) {
					$y[13] = "checked";
					$n[13] = "";
				}
				if ($row['g_access_blog'] == 1) {
					$y[14] = "checked";
					$n[14] = "";
				}
				if ($row['g_send_blog'] == 1) {
					$y[15] = "checked";
					$n[15] = "";
				}
				if ($row['g_access_topsite'] == 1) {
					$y[16] = "checked";
					$n[16] = "";
				}
				if ($row['g_send_topsite'] == 1) {
					$y[17] = "checked";
					$n[17] = "";
				}
				if ($row['g_send_ecard'] == 1) {
					$y[18] = "checked";
					$n[18] = "";
				}
				if ($row['g_send_quote'] == 1) {
					$y[19] = "checked";
					$n[19] = "";
				}
				if ($row['g_send_comments'] == 1) {
					$y[20] = "checked";
					$n[20] = "";
				}
				if ($row['g_access_reviews'] == 1) {
					$y[21] = "checked";
					$n[21] = "";
				}
				if ($row['g_send_reviews'] == 1) {
					$y[22] = "checked";
					$n[22] = "";
				}
				if ($row['g_mod_reviews'] == 1) {
					$y[23] = "checked";
					$n[23] = "";
				}
			}
			$content2 = "			
			<form action=\"admin.php?ind=ad_perms&amp;op=save_main\" name=\"sa_m\" method=\"post\">
			<input type=\"hidden\" name=\"idg\" value=\"{$mkportals->input['idg']}\" />
       			<table width=\"100%\" border=\"0\">
			  <tr>
			    <td class=\"titadmin\" colspan=\"2\">{$mklib->lang['ad_permcho']}:<br /></td>
			  </tr>
			  
			  <tr><td><br /></td></tr>
			  
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_sendnews']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p1\" $y[1] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p1\" $n[1] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_modnews']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p2\" $y[2] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p2\" $n[2] /></td>
			  </tr>
			  
			  <tr><td><br /></td></tr>
			  
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_accdown']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p3\" $y[3] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p3\" $n[3] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_senddown']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p4\" $y[4] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p4\" $n[4] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_moddown']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p5\" $y[5] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p5\" $n[5] /></td>
			  </tr>
			  
			  <tr><td><br /></td></tr>
			
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_accgal']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p6\" $y[6] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p6\" $n[6] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_sendgal']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p7\" $y[7] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p7\" $n[7] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_ecard']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p18\" $y[18] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p18\" $n[18] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_modgal']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p8\" $y[8] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p8\" $n[8] /></td>
			  </tr>
			  
			  <tr><td><br /></td></tr>
			  
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_accurlo']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p9\" $y[9] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p9\" $n[9] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_sendurlo']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p10\" $y[10] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p10\" $n[10] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_modurlo']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p11\" $y[11] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p11\" $n[11] /></td>
			  </tr>
			  
			  <tr><td><br /></td></tr>
			
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_accreviews']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p21\" $y[21] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p21\" $n[21] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_sendreviews']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p22\" $y[22] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p22\" $n[22] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_modreviews']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p23\" $y[23] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p23\" $n[23] /></td>
			  </tr>
			  
			  <tr><td><br /></td></tr>
			  
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_accblog']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p14\" $y[14] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p14\" $n[14] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_sendblog']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p15\" $y[15] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p15\" $n[15] /></td>
			  </tr>
			  
			  <tr><td><br /></td></tr>

			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_acctop']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p16\" $y[16] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p16\" $n[16] /></td>
			  </tr>
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_sendtop']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p17\" $y[17] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p17\" $n[17] /></td>
			  </tr>
			  
			  <tr><td><br /></td></tr>

			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_accchat']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p12\" $y[12] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p12\" $n[12] /></td>
			  </tr>

			  <tr><td><br /></td></tr>

			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_quote']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p19\" $y[19] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p19\" $n[19] /></td>
			  </tr>
			  
			  <tr><td><br /></td></tr>
			
			  <tr>
			    <td width=\"250\" class=\"tdblock\">{$mklib->lang['ad_p_comments']}</td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p20\" $y[20] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p20\" $n[20] /></td>
			  </tr>

			  <tr><td><br /></td></tr>
			  
			  <tr>
			    <td width=\"250\" class=\"tdblock\"><span class=\"mktxtcontr\">{$mklib->lang['ad_p_admin']}</span></td>
			    <td> {$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"p13\" $y[13] />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"p13\" $n[13] /></td>
			  </tr>
			  <tr>
			    <td><br /><input type=\"submit\" name=\"Salva\" value=\"{$mklib->lang['ad_perm_save']}\" class=\"bgselect\" /></td>
			  </tr>
			</table>			  
			</form>		     
			";
   		}
/*
		$DB->query( "SELECT g_id, g_title FROM ibf_groups ORDER BY `g_id`");
		while( $row = $DB->fetch_row() ) {
			if($row['g_id'] == 4) {
				continue;
			}
			$g_id= $row['g_id'];
			$g_title = $row['g_title'];
			$selected = "";
			if($g_id == $mkportals->input['idg']) {
				$selected = "selected";
			}
			$cselect.= "<option value=\"$g_id\" $selected>$g_title</option>\n";
		}
*/
/*
		switch($mkportals->input['idg']) {
			case '2':
    			$select2 = "selected";
    		break;
			case '3':
    			$select3 = "selected";
    		break;
			default:
    			$select9 = "selected";
    		break;
    		}
		$cselect.= "<option value=\"9\" $select9>Guests</option>\n";
		$cselect.= "<option value=\"2\" $select2>Moderators</option>\n";
		$cselect.= "<option value=\"3\" $select3>Members</option>\n";
*/

		$cselect = $mklib_board->build_grouplist($mkportals->input['idg']);

		$content  = "
		    <tr>
		      <td>
		      
			<form action=\"admin.php?ind=ad_perms\" name=\"sel_g\" method=\"post\">
			<table width=\"100%\" border=\"0\">
			  <tr>
			    <td>$checksave</td>
			  </tr>
			  <tr>
			    <td class=\"titadmin\">{$mklib->lang['ad_permset']}</td>
			  </tr>
			  
			  <tr><td><br /></td></tr>

			  <tr>			  
			    <td width=\"10%\">
			      <select name=\"idg\" size=\"1\" class=\"bgselect\">
			      {$cselect}
			      </select>   
			      <input type=\"submit\" name=\"Vai\" value=\"{$mklib->lang['ad_go']}\" class=\"bgselect\" />
			    </td>
			  </tr>
			</table>			  
			</form>

		      </td>
		    </tr>
		    <tr>
		      <td>			
		      {$content2}
		      </td>
		    </tr>
		";

		$output = $Skin->view_block("{$mklib->lang['ad_permtitle']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function save_main() {
    	global $mkportals, $DB, $mklib_board;
		$g_id = $mkportals->input['idg'];

		$g_title = $mklib_board->update_groupperms($g_id);
		//$query = $DB->query( "SELECT g_title FROM ibf_groups WHERE g_id = '$g_id'");
		//$row = $DB->fetch_row($query);
		//$g_title = $row['g_title'];

		$DB->query("select g_id FROM mkp_pgroups WHERE g_id = '$g_id'");
		if ($DB->fetch_row()){
			$DB->query("UPDATE mkp_pgroups SET g_title ='$g_title', g_send_news ='{$mkportals->input['p1']}', g_mod_news ='{$mkportals->input['p2']}', g_access_download ='{$mkportals->input['p3']}', g_send_download ='{$mkportals->input['p4']}', g_mod_download ='{$mkportals->input['p5']}',  g_access_gallery ='{$mkportals->input['p6']}', g_send_gallery ='{$mkportals->input['p7']}', g_mod_gallery ='{$mkportals->input['p8']}', g_access_urlobox ='{$mkportals->input['p9']}', g_send_urlobox ='{$mkportals->input['p10']}', g_mod_urlobox ='{$mkportals->input['p11']}', g_access_chat ='{$mkportals->input['p12']}', g_access_cpa ='{$mkportals->input['p13']}', g_access_blog ='{$mkportals->input['p14']}', g_send_blog ='{$mkportals->input['p15']}', g_access_topsite='{$mkportals->input['p16']}', g_send_topsite='{$mkportals->input['p17']}', g_send_ecard='{$mkportals->input['p18']}', g_send_quote='{$mkportals->input['p19']}', g_send_comments='{$mkportals->input['p20']}', g_access_reviews ='{$mkportals->input['p21']}', g_send_reviews ='{$mkportals->input['p22']}', g_mod_reviews ='{$mkportals->input['p23']}'  WHERE g_id = '$g_id' ");
		} else {
			$DB->query("INSERT INTO mkp_pgroups(g_id, g_title, g_send_news, g_mod_news, g_access_download, g_send_download,  g_mod_download, g_access_gallery, g_send_gallery, g_mod_gallery, g_access_urlobox, g_send_urlobox, g_mod_urlobox,  g_access_chat, g_access_cpa, g_access_blog, g_send_blog, g_access_topsite, g_send_topsite, g_send_ecard, g_send_quote, g_send_comments, g_access_reviews, g_send_reviews, g_mod_reviews)VALUES('$g_id', '$g_title', '{$mkportals->input['p1']}', '{$mkportals->input['p2']}', '{$mkportals->input['p3']}', '{$mkportals->input['p4']}', '{$mkportals->input['p5']}', '{$mkportals->input['p6']}', '{$mkportals->input['p7']}', '{$mkportals->input['p8']}', '{$mkportals->input['p9']}', '{$mkportals->input['p10']}', '{$mkportals->input['p11']}', '{$mkportals->input['p12']}', '{$mkportals->input['p13']}', '{$mkportals->input['p14']}', '{$mkportals->input['p15']}', '{$mkportals->input['p16']}', '{$mkportals->input['p17']}', '{$mkportals->input['p18']}', '{$mkportals->input['p19']}', '{$mkportals->input['p20']}', '{$mkportals->input['p21']}', '{$mkportals->input['p22']}', '{$mkportals->input['p23']}') ");
		}

		$DB->close_db();
		Header("Location: admin.php?ind=ad_perms&mode=saved");
		exit;
  	}



}

?>
