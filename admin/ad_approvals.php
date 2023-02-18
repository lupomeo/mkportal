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

$idx = new mk_ad_approvals;
class mk_ad_approvals {


	function mk_ad_approvals() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'list_news':
    			$this->list_news();
    		break;
			case 'list_blog':
    			$this->list_blog();
    		break;
			case 'list_gallery':
    			$this->list_gallery();
    		break;
			case 'list_download':
    			$this->list_download();
    		break;
			case 'list_topsite':
    			$this->list_topsite();
    		break;
			case 'list_reviews':
    			$this->list_reviews();
    		break;
			case 'list_quote':
    			$this->list_quote();
    		break;
			case 'activate':
    			$this->activate();
    		break;
			case 'delete_inc':
    			$this->delete_inc();
    		break;
			default:
    			$this->approvals_show();
    		break;
    		}
	}

	function approvals_show() {
	global $mkportals, $mklib, $Skin, $DB;

		if ($mkportals->input['mode'] == "saved") {
		$checksave = "{$mklib->lang['ad_saved']}<br /><br />";
   		}
	 	$content  = $this->get_modules_list();
		$output = $Skin->view_block("{$mklib->lang['ad_apprmenu']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function get_modules_list() {
		global $mkportals, $mklib, $Skin, $DB;

		$query = $DB->query("SELECT id FROM mkp_news WHERE validate = '0'");
		$cnews = $DB->get_num_rows($query);
		$query = $DB->query("SELECT id FROM mkp_blog WHERE validate = '0'");
		$cblog = $DB->get_num_rows($query);
		$query = $DB->query("SELECT id FROM mkp_gallery WHERE validate = '0'");
		$cgal = $DB->get_num_rows($query);
		$query = $DB->query("SELECT id FROM mkp_download WHERE validate = '0'");
		$cdown = $DB->get_num_rows($query);
		$query = $DB->query("SELECT id FROM mkp_topsite WHERE validate = '0'");
		$ctop = $DB->get_num_rows($query);
		$query = $DB->query("SELECT id FROM mkp_reviews WHERE validate = '0'");
		$crew = $DB->get_num_rows($query);
		$query = $DB->query("SELECT id FROM mkp_quotes WHERE validate = '0'");
		$cquot = $DB->get_num_rows($query);

		return "
	<tr>
	  <td>
	  <script type=\"text/javascript\">

			function makesureinc() {
			if (confirm('{$mklib->lang[ad_delgenconfirm]}')) {
			return true;
			} else {
			return false;
			}
			}

	    </script>
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>$checksave</td>
	      </tr>
	      <tr class=\"modulex\">
		<td width=\"20%\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=list_news\">{$mklib->lang['news']}</a></td><td width=\"80%\">$cnews</td>
	      </tr>
		  <tr>
		<td width=\"20%\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=list_blog\">{$mklib->lang['blog']}</a></td><td width=\"80%\">$cblog</td>
	      </tr>
		 <tr class=\"modulex\">
		<td width=\"20%\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=list_gallery\">{$mklib->lang['gallery']}</a></td><td width=\"80%\">$cgal</td>
	      </tr>
		  <tr>
		<td width=\"20%\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=list_download\">{$mklib->lang['download']}</a></td><td width=\"80%\">$cdown</td>
	      </tr>
		  <tr class=\"modulex\">
		<td width=\"20%\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=list_topsite\">{$mklib->lang['topsite']}</a></td><td width=\"80%\">$ctop</td>
	      </tr>
		  <tr>
		<td width=\"20%\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=list_reviews\">{$mklib->lang['reviews']}</a></td><td width=\"80%\">$crew</td>
	      </tr>
		  <tr class=\"modulex\">
		<td width=\"20%\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=list_quote\">{$mklib->lang['quote']}</a></td><td width=\"80%\">$cquot</td>
	      </tr>
	    </table>
	  </td>
	</tr>
		";

	}
	function list_news() {
	global $mkportals, $mklib, $Skin, $DB;
	 	$content = $this->get_modules_list();
		$content .= "
		<tr>
	  	<td>
		<table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"2\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td colspan=\"5\" class=\"titadmin\">{$mklib->lang['ad_newssubmitted']}</td>
	      </tr>
	      <tr>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_activeon']}</th>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_delete']}</th>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_title']}</th>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_author']}</th>
		<th class=\"modulex\" width=\"80%\" align=\"left\">{$mklib->lang['ad_submittext']}</th>
	      </tr>
	   ";
		$query = $DB->query( "SELECT id, titolo, autore, testo FROM mkp_news WHERE validate = '0' ORDER BY `id`");
		while( $row = $DB->fetch_row($query) ) {
			$idb = $row['id'];
			$titolo = $row['titolo'];
			$autore = $row['autore'];
			$testo = $row['testo'];
			$content .= "
	      <tr>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=activate&amp;mod=news&amp;ide=$idb\">{$mklib->lang['ad_activeon']}</a></td>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr\" href=\"admin.php?ind=ad_approvals&amp;op=delete_inc&amp;mod=news&amp;ide=$idb\" onclick=\"return makesureinc()\">{$mklib->lang['ad_delete']}</a></td>
		<td class=\"modulecell\" align=\"left\"><b>$titolo</b></td>
		<td class=\"modulecell\" align=\"left\">$autore</td>
		<td class=\"modulecell\" align=\"left\">$testo</td>
	      </tr>
			";
		}
	 $content  .= "
	    </table><br />
	  	</td>
		</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_apprmenu']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}
	function list_blog() {
	global $mkportals, $mklib, $Skin, $DB;
	 	$content = $this->get_modules_list();
		$content .= "
		<tr>
	  	<td>
		<table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"2\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td colspan=\"5\" class=\"titadmin\">{$mklib->lang['ad_blogsubmitted']}</td>
	      </tr>
	      <tr>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_activeon']}</th>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_delete']}</th>
		<th class=\"modulex\" width=\"20%\" align=\"left\">{$mklib->lang['ad_title']}</th>
		<th class=\"modulex\" width=\"20%\" align=\"left\">{$mklib->lang['ad_author']}</th>
		<th class=\"modulex\" width=\"50%\" align=\"left\">{$mklib->lang['ad_description']}</th>
	      </tr>
	   ";
		$query = $DB->query( "SELECT id, titolo, autore, descrizione FROM mkp_blog WHERE validate = '0' ORDER BY `id`");
		while( $row = $DB->fetch_row($query) ) {
			$idb = $row['id'];
			$titolo = $row['titolo'];
			$autore = $row['autore'];
			$testo = $row['descrizione'];
			$content .= "
	      <tr>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=activate&amp;mod=blog&amp;ide=$idb\">{$mklib->lang['ad_activeon']}</a></td>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr\" href=\"admin.php?ind=ad_approvals&amp;op=delete_inc&amp;mod=blog&amp;ide=$idb\" onclick=\"return makesureinc()\">{$mklib->lang['ad_delete']}</a></td>
		<td class=\"modulecell\" align=\"left\"><b>$titolo</b></td>
		<td class=\"modulecell\" align=\"left\">$autore</td>
		<td class=\"modulecell\" align=\"left\">$testo</td>
	      </tr>
			";
		}
	 $content  .= "
	    </table><br />
	  	</td>
		</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_apprmenu']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}
	function list_gallery() {
	global $mkportals, $mklib, $Skin, $DB;
	 	$content = $this->get_modules_list();
		$content .= "
		<tr>
	  	<td>
		<table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"2\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td colspan=\"5\" class=\"titadmin\">{$mklib->lang['ad_imagesubmitted']}</td>
	      </tr>
	      <tr>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_activeon']}</th>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_delete']}</th>
		<th class=\"modulex\" width=\"20%\" align=\"left\">{$mklib->lang['ad_show']}</th>
		<th class=\"modulex\" width=\"20%\" align=\"left\">{$mklib->lang['ad_author']}</th>
		<th class=\"modulex\" width=\"50%\" align=\"left\">{$mklib->lang['ad_title']}</th>
	      </tr>
	   ";
		$query = $DB->query( "SELECT id, titolo, autore, file FROM mkp_gallery WHERE validate = '0' ORDER BY `id`");
		while( $row = $DB->fetch_row($query) ) {
			$idb = $row['id'];
			$titolo = $row['titolo'];
			$autore = $row['autore'];
			$file = $row['file'];
			$content .= "
	      <tr>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=activate&amp;mod=gallery&amp;ide=$idb\">{$mklib->lang['ad_activeon']}</a></td>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr\" href=\"admin.php?ind=ad_approvals&amp;op=delete_inc&amp;mod=gallery&amp;ide=$idb\" onclick=\"return makesureinc()\">{$mklib->lang['ad_delete']}</a></td>
		<td class=\"modulecell\" align=\"left\"><b><a href=\"modules/gallery/album/$file\" target=\"_blank\">{$mklib->lang['ad_show']}</a></b></td>
		<td class=\"modulecell\" align=\"left\">$autore</td>
		<td class=\"modulecell\" align=\"left\">$titolo</td>
	      </tr>
			";
		}
	 $content  .= "
	    </table><br />
	  	</td>
		</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_apprmenu']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}
	function list_download() {
	global $mkportals, $mklib, $Skin, $DB;
	 	$content = $this->get_modules_list();
		$content .= "
		<tr>
	  	<td>
		<table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"2\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td colspan=\"5\" class=\"titadmin\">{$mklib->lang['ad_downsubmitted']}</td>
	      </tr>
	      <tr>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_activeon']}</th>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_delete']}</th>
		<th class=\"modulex\" width=\"20%\" align=\"left\">{$mklib->lang['ad_title']}</th>
		<th class=\"modulex\" width=\"20%\" align=\"left\">{$mklib->lang['ad_author']}</th>
		<th class=\"modulex\" width=\"50%\" align=\"left\">{$mklib->lang['files']}</th>
	      </tr>
	   ";
		$query = $DB->query( "SELECT id, name, autore, file FROM mkp_download WHERE validate = '0' ORDER BY `id`");
		while( $row = $DB->fetch_row($query) ) {
			$idb = $row['id'];
			$titolo = $row['name'];
			$autore = $row['autore'];
			$testo = $row['file'];
			$content .= "
	      <tr>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=activate&amp;mod=download&amp;ide=$idb\">{$mklib->lang['ad_activeon']}</a></td>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr\" href=\"admin.php?ind=ad_approvals&amp;op=delete_inc&amp;mod=download&amp;ide=$idb\" onclick=\"return makesureinc()\">{$mklib->lang['ad_delete']}</a></td>
		<td class=\"modulecell\" align=\"left\"><b>$titolo</b></td>
		<td class=\"modulecell\" align=\"left\">$autore</td>
		<td class=\"modulecell\" align=\"left\">$testo</td>
	      </tr>
			";
		}
	 $content  .= "
	    </table><br />
	  	</td>
		</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_apprmenu']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}
	function list_topsite() {
	global $mkportals, $mklib, $Skin, $DB;

	 	$content = $this->get_modules_list();
		$content .= "
		<tr>
	  	<td>
		<table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"2\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td colspan=\"7\" class=\"titadmin\">{$mklib->lang['ad_topsubmitted']}</td>
	      </tr>
	      <tr>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_activeon']}</th>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_delete']}</th>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_address']}</th>
		<th class=\"modulex\" width=\"10%\" align=\"left\">{$mklib->lang['ad_email']}</th>
		<th class=\"modulex\" width=\"10%\" align=\"left\">{$mklib->lang['ad_title']}</th>
		<th class=\"modulex\" width=\"30%\" align=\"left\">{$mklib->lang['ad_description']}</th>
		<th class=\"modulex\" width=\"35%\" align=\"left\">{$mklib->lang['ad_banner']}</th>
	      </tr>	      
	   ";
		$query = $DB->query( "SELECT id, title, description, link, banner, email FROM mkp_topsite WHERE validate = '0' ORDER BY `id`");
		while( $row = $DB->fetch_row($query) ) {
			$idb = $row['id'];
			$banner = $row['banner'];
			$link = $row['link'];
			$titolo = $row['title'];
			$descrizione = $row['description'];
			$email = $row['email'];

			$content .= "
	      <tr>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=activate&amp;mod=topsite&amp;ide=$idb\">{$mklib->lang['ad_activeon']}</a></td>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr\" href=\"admin.php?ind=ad_approvals&amp;op=delete_inc&amp;mod=topsite&amp;ide=$idb\" onclick=\"return makesureinc()\">{$mklib->lang['ad_delete']}</a></td>
		<td class=\"modulecell\" align=\"left\"><a href=\"$link\" target=\"_blank\"><b>{$mklib->lang['ad_show']}</b></a></td>
		<td class=\"modulecell\" align=\"left\"><a href=\"mailto:$email\">$email</a></td>
		<td class=\"modulecell\" align=\"left\">$titolo</td>
		<td class=\"modulecell\" align=\"left\">$descrizione</td>
		<td class=\"modulecell\" align=\"left\" ><img src=\"$banner\" border=\"0\" width=\"468\" height=\"60\" alt=\"\" /></td>
	      </tr>
			";
		}
	 $content  .= "
	    </table><br />
	  	</td>
		</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_apprmenu']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}
	function list_reviews() {
	global $mkportals, $mklib, $Skin, $DB;
	 	$content = $this->get_modules_list();
		$content .= "
		<tr>
	  	<td>
		<table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"2\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td colspan=\"5\" class=\"titadmin\">{$mklib->lang['ad_revsubmitted']}</td>
	      </tr>
	      <tr>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_activeon']}</th>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_delete']}</th>
		<th class=\"modulex\" width=\"20%\" align=\"left\">{$mklib->lang['ad_title']}</th>
		<th class=\"modulex\" width=\"20%\" align=\"left\">{$mklib->lang['ad_author']}</th>
		<th class=\"modulex\" width=\"50%\" align=\"left\">{$mklib->lang['ad_submittext']}</th>
	      </tr>
	   ";
		$query = $DB->query( "SELECT id, title, author, review FROM mkp_reviews WHERE validate = '0' ORDER BY `id`");
		while( $row = $DB->fetch_row($query) ) {
			$idb = $row['id'];
			$titolo = $row['title'];
			$autore = $row['author'];
			$testo = $row['review'];
			$content .= "
	      <tr>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=activate&amp;mod=reviews&amp;ide=$idb\">{$mklib->lang['ad_activeon']}</a></td>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr\" href=\"admin.php?ind=ad_approvals&amp;op=delete_inc&amp;mod=reviews&amp;ide=$idb\" onclick=\"return makesureinc()\">{$mklib->lang['ad_delete']}</a></td>
		<td class=\"modulecell\" align=\"left\"><b>$titolo</b></td>
		<td class=\"modulecell\" align=\"left\">$autore</td>
		<td class=\"modulecell\" align=\"left\">$testo</td>
	      </tr>
			";
		}
	 $content  .= "
	    </table><br />
	  	</td>
		</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_apprmenu']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}
	function list_quote() {
	global $mkportals, $mklib, $Skin, $DB;
	 	$content = $this->get_modules_list();
		$content .= "
		<tr>
	  	<td>
		<table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"2\" width=\"98%\" align=\"center\" border=\"0\">
	      <tr>
		<td colspan=\"5\" class=\"titadmin\">{$mklib->lang['ad_quotsubmitted']}</td>
	      </tr>
	      <tr>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_activeon']}</th>
		<th class=\"modulex\" width=\"5%\" align=\"left\">{$mklib->lang['ad_delete']}</th>
		<th class=\"modulex\" width=\"20%\" align=\"left\">{$mklib->lang['ad_author']}</th>
		<th class=\"modulex\" width=\"70%\" align=\"left\">{$mklib->lang['ad_submittext']}</th>
	      </tr>
	   ";
		$query = $DB->query( "SELECT id, member, quote FROM mkp_quotes WHERE validate = '0' ORDER BY `id`");
		while( $row = $DB->fetch_row($query) ) {
			$idb = $row['id'];
			$autore = $row['member'];
			$testo = $row['quote'];
			$content .= "
	      <tr>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_approvals&amp;op=activate&amp;mod=quote&amp;ide=$idb\">{$mklib->lang['ad_activeon']}</a></td>
		<td class=\"modulecell\" align=\"left\"><a class=\"mktxtcontr\" href=\"admin.php?ind=ad_approvals&amp;op=delete_inc&amp;mod=quote&amp;ide=$idb\" onclick=\"return makesureinc()\">{$mklib->lang['ad_delete']}</a></td>
		<td class=\"modulecell\" align=\"left\">$autore</td>
		<td class=\"modulecell\" align=\"left\">$testo</td>
	      </tr>
			";
		}
	 $content  .= "
	    </table><br />
	  	</td>
		</tr>
		";
		$output = $Skin->view_block("{$mklib->lang['ad_apprmenu']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}

	function activate() {
		global $mkportals, $DB;
		$ide = $mkportals->input['ide'];
		$mod = $mkportals->input['mod'];

		switch($mod) {
			case 'news':
				$DB->query("UPDATE mkp_news SET validate ='1' where id = '$ide'");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_news");
    		break;
			case 'blog':
    			$DB->query("UPDATE mkp_blog SET validate ='1' where id = '$ide'");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_blog");
    		break;
			case 'gallery':
    			$DB->query("UPDATE mkp_gallery SET validate ='1' where id = '$ide'");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_gallery");
    		break;
			case 'download':
    			$DB->query("UPDATE mkp_download SET validate ='1' where id = '$ide'");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_download");
    		break;
			case 'topsite':
    			$DB->query("UPDATE mkp_topsite SET validate ='1' where id = '$ide'");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_topsite");
    		break;
			case 'reviews':
    			$DB->query("UPDATE mkp_reviews SET validate ='1' where id = '$ide'");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_reviews");
    		break;
			case 'quote':
    			$DB->query("UPDATE mkp_quotes SET validate ='1' where id = '$ide'");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_quote");
    		break;
    		}
			exit;
	}

	function delete_inc() {
		global $mkportals, $DB;
		$ide = $mkportals->input['ide'];
		$mod = $mkportals->input['mod'];

		switch($mod) {
			case 'news':
				$DB->query("DELETE FROM mkp_news WHERE id = $ide");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_news");
    		break;
			case 'blog':
				$query = $DB->query("select autore from mkp_blog where id = '$ide'");
				$row = $DB->fetch_row($query);
				$usfile = "blog/{$row['autore']}.html";
 				$usfile = strtolower ($usfile);
 				$usfile = str_replace(" ", "", $usfile);
				$DB->query("delete from mkp_blog where id = '$ide'");
				@unlink($usfile);
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_blog");
    		break;
			case 'gallery':
    			$query = $DB->query( "SELECT file FROM mkp_gallery WHERE id = $ide");
				$row = $DB->fetch_row($query);
				$file = $row['file'];
				$thumb = "t_$file";
				@unlink("modules/gallery/album/$file");
				@unlink("modules/gallery/album/$thumb");
				$DB->query("DELETE FROM mkp_gallery WHERE id = $ide");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_gallery");
    		break;
			case 'download':
    			$query = $DB->query( "SELECT file FROM mkp_download WHERE id = $ide");
				$row = $DB->fetch_row($query);
				$file = $row['file'];
        		$real_file = "modules/downloads/file/mk_".$ide."_".$file;
        		$real_file = preg_replace("`(.*)\..*`", "\\1", $real_file);
        		$real_file .= ".mk";
				@unlink($real_file);
				$DB->query("DELETE FROM mkp_download WHERE id = $ide");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_download");
    		break;
			case 'topsite':
    			$DB->query("DELETE FROM mkp_topsite WHERE id = '$ide'");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_topsite");
    		break;
			case 'reviews':
    			$query = $DB->query( "SELECT image FROM mkp_reviews WHERE id = $ide");
				$row = $DB->fetch_row($query);
				$file = $row['image'];
				@unlink("modules/reviews/images/$file");
				$DB->query("DELETE FROM mkp_reviews WHERE id = $ide");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_reviews");
    		break;
			case 'quote':
    			$DB->query("DELETE FROM mkp_quotes where id = '$ide'");
				$DB->close_db();
				Header("Location: admin.php?ind=ad_approvals&op=list_quote");
    		break;
    		}
			exit;
	}





}

?>
