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

$idx = new mk_ad_blog;
class mk_ad_blog {


	function mk_ad_blog() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'save_main':
    			$this->save_main();
    		break;
			case 'del_blog':
    			$this->del_blog();
    		break;
			default:
    			$this->blog_show();
    		break;
    		}
	}

	function blog_show() {
	global $mkportals, $mklib, $Skin, $DB;

		$blog_page = $mklib->config['blog_page'];
		// Admin Approval combo
		$approval = $mklib->config['approval_blog'];
		switch($approval) {
			case '1':
    			$selap1="selected=\"selected\"";
    		break;
			case '2':
    			$selap2="selected=\"selected\"";
    		break;
			case '3':
    			$selap3="selected=\"selected\"";
    		break;
    		default:
    			$selap="selected=\"selected\"";
    		break;
		}
		$cselecta = "<option value=\"0\" $selap>{$mklib->lang['ad_approp_0']}</option>\n";
		$cselecta .= "<option value=\"1\" $selap1>{$mklib->lang['ad_approp_1']}</option>\n";
		$cselecta .= "<option value=\"2\" $selap2>{$mklib->lang['ad_approp_2']}</option>\n";
		$cselecta .= "<option value=\"3\" $selap3>{$mklib->lang['ad_approp_3']}</option>\n";

		if ($mklib->config['mod_blog']) {
		$checkactive =  "checked=\"checked\"";
   		}
		if ($mkportals->input['mode'] == "saved") {
		$checksave = "{$mklib->lang['ad_saved']}<br /><br />";
   		}
		if ($mkportals->input['mode'] == "deleted") {
		$checksave = "{$mklib->lang['ad_delblog']}<br /><br />";
   		}
		$query = $DB->query("SELECT id FROM mkp_blog");
		$count = mysql_num_rows ($query);

		$q_page		=	$mkportals->input['st'];
		if ($q_page=="" or $q_page <= 0) {
			$q_page	=	0;
		}
		$per_page = 30;
		if ($per_page=="" or $per_page <= 0) {
			$per_page	=	10;
		}

	    $start = $q_page;
		$show_pages = $mklib->build_pages( array( TOTAL_POSS  => $count,
							PER_PAGE    => $per_page,
							CUR_ST_VAL  => $q_page,
							L_SINGLE    => '',
							L_MULTI     => 'pagine',
						    BASE_URL    => 'admin.php?ind=ad_blog',
										  )
								   );
	 	$content  = "		
	<tr>
	  <td valign=\"top\">

	  <script type=\"text/javascript\">

			function makesureblog() {
			if (confirm('{$mklib->lang[ad_delblogconfirm]}')) {
			return true;
			} else {
			return false;
			}
			}

	  </script>
			
	    <form action=\"admin.php?ind=ad_blog&amp;op=save_main\" name=\"save_main\" method=\"post\">
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>$checksave</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\" valign=\"top\">{$mklib->lang['ad_preferences']}</td>
	      </tr>
	      <tr>
		<td><span class=\"mktxtcontr\">{$mklib->lang['ad_blogdisactive']}</span> <input type=\"checkbox\" name=\"stato\" value=\"1\" $checkactive /></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_blogpages']}</td>
	      </tr>
	      <tr>
		<td><input type=\"text\" name=\"blog_page\" value=\"$blog_page\" size=\"10\" class=\"bgselect\" /></td>
	      </tr>
		  <tr>
		<td>{$mklib->lang['ad_apprtit']}</td>
	      </tr>
	      <tr>
		<td>
		  <select class=\"bgselect\" size=\"1\" name=\"approvalc\">
		  {$cselecta}
		  </select>
		</td>
	      </tr>
	      <tr>
		<td><br /><input type=\"submit\" name=\"Salve\" value=\"{$mklib->lang['ad_save']}\" class=\"bgselect\" /></td>
	      </tr>
	    </table>
	    </form>

	  </td>
	</tr>
	<tr>
	  <td class=\"titadmin\"><br />	  
	   
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"2\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td colspan=\"5\" class=\"titadmin\">{$mklib->lang['ad_bloglist']}</td>
	      </tr>
	      <tr>
		<th class=\"modulex\" width=\"10%\" align=\"left\">{$mklib->lang['ad_delete']}</th>
		<th class=\"modulex\" width=\"10%\" align=\"left\">{$mklib->lang['ad_address']}</th>
		<th class=\"modulex\" width=\"20%\" align=\"left\">{$mklib->lang['ad_author']}</th>
		<th class=\"modulex\" width=\"20%\" align=\"left\">{$mklib->lang['ad_title']}</th>
		<th class=\"modulex\" width=\"40%\" align=\"left\">{$mklib->lang['ad_description']}</th>
	      </tr>	 
	   ";
		$query = $DB->query( "SELECT id, autore, titolo, descrizione FROM mkp_blog ORDER BY `autore` LIMIT $start, $per_page");
		while( $row = $DB->fetch_row($query) ) {
			$idb = $row['id'];
			$autore = $row['autore'];
			$titolo = $row['titolo'];
			$descrizione = $row['descrizione'];

			$content .= "
	      <tr>
		<td class=\"modulecell\" align=\"left\"><a href=\"admin.php?ind=ad_blog&amp;op=del_blog&amp;idb=$idb\" onclick=\"return makesureblog()\"><span class=\"mktxtcontr\">{$mklib->lang['ad_delete']}</span></a></td>
		<td class=\"modulecell\" align=\"left\"><a href=\"$mklib->siteurl/index.php?ind=blog&amp;op=home&amp;idu=$idb\" target=\"_blank\"><b>{$mklib->lang['ad_show']}</b></a></td>
		<td class=\"modulecell\" align=\"left\" ><b>$autore</b></td>
		<td class=\"modulecell\" align=\"left\">$titolo</td>
		<td class=\"modulecell\" align=\"left\">$descrizione</td>
	      </tr>
			";
		}
	   //<td>Numero di siti per ogni pagina</td>
	 $content  .= "
	   
	    </table>
	  </td>
	</tr>

	<tr>
 	  <td>
	  &nbsp;&nbsp;{$show_pages}
	  </td>
	</tr>

		";
		$output = $Skin->view_block("{$mklib->lang['ad_blogtitle']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function save_main() {
    	global $mkportals, $DB, $mklib;
		$blog_page = $mkportals->input['blog_page'];
		$mod_blog = $mkportals->input['stato'];
		$approval = $mkportals->input['approvalc'];
		if (!$blog_page) {
			$message = "{$mklib->lang['ad_all_rows']}";
			$mklib->error_page($message);
			exit;
		}
		$DB->query("UPDATE mkp_config SET valore ='$blog_page' where chiave = 'blog_page'");
		$DB->query("UPDATE mkp_config SET valore ='$mod_blog' where chiave = 'mod_blog'");
		$DB->query("UPDATE mkp_config SET valore ='$approval' where chiave = 'approval_blog'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_blog&mode=saved");
		exit;
  	}
	function del_blog () {
		global $mkportals, $DB, $Skin, $mklib;
		$idb = $mkportals->input['idb'];

		mysql_query("delete from mkp_blog_commenti where id_blog = '$idb'");
		mysql_query("delete from mkp_blog_post where id_blog = '$idb'");
        mysql_query("delete from mkp_blog where id = '$idb'");

		$usfile = "blog/{$mkportals->member['name']}.html";
        @unlink($usfile);
		$DB->close_db();
	 	Header("Location: admin.php?ind=ad_blog&mode=deleted");
		exit;

    }


}

?>
