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
$idx = new mk_ad_contents;
class mk_ad_contents {


	function mk_ad_contents() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'contents_edit':
    			$this->contents_edit($mkportals->input['idc']);
    		break;
			case 'contents_new':
    			$this->contents_new();
    		break;
			case 'contents_save':
    			$this->contents_save($mkportals->input['idc']);
    		break;
			case 'contents_savenew':
    			$this->contents_savenew();
    		break;
			case 'contents_delete':
    			$this->contents_delete($mkportals->input['idc']);
    		break;
			default:
    			$this->contents_show();
    		break;
    		}
	}

	function contents_show() {
	global $mkportals, $mklib, $Skin, $DB;
	$myquery = $DB->query("SELECT id, title FROM mkp_pages");
	  $content = "
	  <tr>
	    <td>
	      <table width=\"100%\" cellspacing=\"3\">
		<tr>
		  <td width=\"30%\" class=\"tdblock\">{$mklib->lang['ad_title']}</td>
		  <td width=\"50%\" class=\"tdblock\">{$mklib->lang['ad_addresspage']}</td>
		  <td width=\"20%\" colspan=\"2\" class=\"tdblock\">{$mklib->lang['ad_actions']}</td>
		</tr>
		";

		$content .= "
		<tr>
		  <td>
			<script type=\"text/javascript\">

			function makesure() {
			if (confirm('{$mklib->lang[ad_delpageconfirm]}')) {
			return true;
			} else {
			return false;
			}
			}

			</script>
		  </td>
		</tr>
		";

	  while( $row = $DB->fetch_row($myquery) ) {
		$titlep = stripslashes($row['title']);
		$content .= "
		<tr>
		  <td width=\"30%\" class=\"tabnews\">
		    <img src=\"$mklib->images/frec.gif\" align=\"left\" alt=\"\" />
		    &nbsp;<a href=\"admin.php?ind=ad_contents&amp;op=contents_edit&amp;idc={$row['id']}\">
		    $titlep</a>
		  </td>
		  <td width=\"54%\" class=\"tabnews\">
		    <a href=\"$mklib->siteurl/index.php?pid={$row['id']}\">$mklib->siteurl/index.php?pid={$row['id']}</a>
		  </td>
		  <td width=\"8%\" class=\"tabnews\" align=\"center\" nowrap=\"nowrap\">
		    [<a href=\"admin.php?ind=ad_contents&amp;op=contents_edit&amp;idc={$row['id']}\">
		    {$mklib->lang['ad_edit']}</a>]
		  </td>
		  <td width=\"8%\" class=\"tabnews\" align=\"center\" nowrap=\"nowrap\">
		    [<a href=\"admin.php?ind=ad_contents&amp;op=contents_delete&amp;idc={$row['id']}\" onclick=\"return makesure()\">
		    {$mklib->lang['ad_delete']}</a>]
		  </td>
		</tr>
		";
	  }
	$content .= "
	      </table>
	    </td>
	  </tr>
	  ";
	$output = $Skin->view_block("{$mklib->lang['ad_contentslist']}", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}
	function contents_edit($id) {
	global $mkportals, $mklib, $Skin, $DB, $editorscript;
		$editorscript = 1;
		$textarepar = "mce_editable=\"true\"";
		$textarew = "100%";
		$bbeditor= "";
		if ($mklib->mkeditor == "BBCODE") {
			$editorscript = "";
			$textarepar = "";
			$textarew = "75%";
			$bbeditor= $mklib->get_bbeditor();
		}
		$myquery = $DB->query("SELECT title, content FROM mkp_pages WHERE id='$id'");
		$row = $DB->fetch_row($myquery);
		$titlep = $row['title'];
		$testo = $row['content'];
		$titlep = stripslashes($titlep);
		$testo = stripslashes($testo);
	   $content = "
		<tr>
		  <td>
		  
		    <form action=\"admin.php?ind=ad_contents&amp;op=contents_save&amp;idc=$id\" method=\"post\" id=\"editor\" name=\"editor\">
		    <table width=\"100%\">
		      <tr>
			<td class=\"tdblock\">
			  {$mklib->lang['ad_title']}:	<input type=\"text\" name=\"titlepage\" value=\"$titlep\" size=\"40\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\">
			$bbeditor
 			<textarea id=\"ta\" name=\"ta\" $textarepar style=\"width: $textarew\" rows=\"14\" cols=\"40\">$testo</textarea>
			</td>
		      </tr>
		      <tr>
			<td>
			  <div align=\"center\"><input type=\"submit\" name=\"ok\" value=\"  {$mklib->lang['ad_save']}  \" /></div>		
			</td>
		      </tr>
		    </table>
		    </form>
		    
		  </td>
		</tr>

	";
	$output = $Skin->view_block("{$mklib->lang['ad_contentsedit']}", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}
	function contents_new() {
	global $mkportals, $mklib, $Skin, $DB, $editorscript;
	   $editorscript = 1;
		$textarepar = "mce_editable=\"true\"";
		$textarew = "100%";
		$bbeditor= "";
		if ($mklib->mkeditor == "BBCODE") {
			$editorscript = "";
			$textarepar = "";
			$textarew = "75%";
			$bbeditor= $mklib->get_bbeditor();
		}
	   $content = "
		<tr>
		  <td>
		    <form action=\"admin.php?ind=ad_contents&amp;op=contents_savenew\" method=\"post\" id=\"editor\" name=\"editor\">
		    <table width=\"100%\">
		      <tr>
			<td class=\"tdblock\" valign=\"top\">
			{$mklib->lang['ad_title']}:	<input type=\"text\" name=\"titlepage\"  size=\"40\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\">
			$bbeditor
 			<textarea id=\"ta\" name=\"ta\" $textarepar style=\"width: $textarew\" rows=\"14\" cols=\"40\"></textarea>
			</td>
		      </tr>
		      <tr>
			<td>
			  <div align=\"center\"><input type=\"submit\" name=\"ok\" value=\"  {$mklib->lang['ad_save']}  \" /></div>		
			</td>
		      </tr>
		    </table>
		    </form>
		  </td>
		</tr>
	";
	$output = $Skin->view_block("{$mklib->lang['ad_contentsnew']}", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}
	function contents_save($id) {
	global $mkportals, $mklib, $Skin,  $DB;
		$content = $mklib->convert_savedbadmin($_POST['ta']);
		$titlepage = $mklib->convert_savedbadmin($_POST['titlepage']);
		$DB->query("UPDATE mkp_pages SET content ='$content', title='$titlepage' WHERE id='$id'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_contents");
		exit;
	}
	function contents_savenew() {
	global $mkportals, $mklib, $Skin, $DB, $_POST;
		$content = $mklib->convert_savedbadmin($_POST['ta']);
		$titlepage = $mklib->convert_savedbadmin($_POST['titlepage']);
		$DB->query("INSERT INTO mkp_pages (content, title) VALUES ('$content', '$titlepage')");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_contents");
		exit;


	}
	function contents_delete($id) {
	global $mkportals, $mklib, $Skin,  $DB;
		$DB->query("DELETE FROM mkp_pages WHERE id='$id'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_contents");
		exit;

	}

}

?>
