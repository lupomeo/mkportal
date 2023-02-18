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

$idx = new mk_search;
class mk_search {

	var $tpl       = "";

	function mk_search() {

		global $mkportals, $mklib, $Skin;

		$mklib->load_lang("lang_search.php");

    		switch($mkportals->input['op']) {
    			case 'result_search':
    				$this->result_search();
    			break;
    			default:
    				$this->search();
    			break;
    		}
	}

	function search() {
		global $mkportals, $DB, $mklib, $Skin;

		$cselect.= "<option value=\"1\">{$mklib->lang['sh_pcontent']}</option>\n";
		$cselect.= "<option value=\"2\">{$mklib->lang['sh_ptitle']}</option>\n";
		$content .= "
<tr>
  <td>
  
    <form action=\"index.php?ind=search&amp;op=result_search\" name=\"search\" method=\"post\">
    <table width=\"100%\" border=\"0\">
      <tr>
	<td>{$mklib->lang['sh_searchon']}</td>
	<td>
	  <select class=\"bgselect\" name=\"campo\" size=\"1\">
	  {$cselect}
	  </select>
	</td>
      </tr>
      <tr>
	<td width=\"20%\"><br /><br />{$mklib->lang['sh_texttofind']}</td>
	<td width=\"80%\"><br /><br /><input class=\"bgselect\" type=\"text\" name=\"testo\" size=\"52\" /><br /></td>
      </tr>
      <tr>
	<td colspan=\"2\"><br /><br /><input class=\"bgselect\" type=\"submit\" value=\"{$mklib->lang['sh_start']}\" /></td>
      </tr>
    </table>
    </form>
    
  </td>
</tr>
		";
		$output = "
<tr>
  <td>
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
      {$content}
    </table>    
    &nbsp;{$show_pages}
  </td>
</tr>    
<tr>
  <td align=\"center\"><br /><br />
    <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\"></a></div>
  </td>
</tr>
	";
	$blocks .= $Skin->view_block("{$mklib->lang['sh_titlesub']}", $output);
	$mklib->printpage("1", "1", "{$mklib->lang['sh_titlepage']}", $blocks);
	}


	function result_search() {
		global $mkportals, $DB, $mklib, $Skin;
		$campo = $mkportals->input['campo'];
		$testo = $mkportals->input['testo'];
		$campo = "content";
		if ($mkportals->input['campo'] == 2) {
			$campo = "title";
		}
		if (!$testo) {
			$message = "{$mklib->lang['sh_textreq']}";
			$mklib->error_page($message);
			exit;
		}
		$content = "
<tr>
  <td colspan=\"2\" class=\"titadmin\">{$mklib->lang['sh_result']}</td>
</tr>
<tr>
  <th class=\"modulex\" width=\"80%\" align=\"left\"><b>{$mklib->lang['sh_resultpt']}</b></td>
  <th class=\"modulex\" width=\"20%\" align=\"center\"><b>{$mklib->lang['sh_show']}</b></td>
</tr>
";
		$query = $DB->query( "SELECT id, title FROM mkp_pages where $campo LIKE '%$testo%'");
		while( $row = $DB->fetch_row($query) ) {
			$iden = $row['id'];
			$title = $row['title'];
			$content .= "
<tr>
  <td class=\"modulecell\" align=\"left\">$title</td>
  <td class=\"modulecell\" align=\"center\"><a href=\"index.php?pid=$iden\">{$mklib->lang['sh_go']}</a></td>
			";
		}
		if (!$title) {
			$content = "
  <td class=\"modulecell\" align=\"center\" width=\"100%\"><br />{$mklib->lang['sh_noresult']}<br /><br /><br /></td>";
		}
		$output = "

</tr>
<tr>
  <td>
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
      <tr>
        <td valign=\"top\">{$content}</td>
      </tr>
    </table> 
    &nbsp;{$show_pages}
  </td>
</tr>
<tr>
  <td align=\"center\"><br /><br />
    <div align=\"center\"><a href=\"http://www.mkportal.it\" target=\"_blank\"></a></div>
  </td>
</tr>
	";
	$blocks .= $Skin->view_block("{$mklib->lang['sh_titresult']}", $output);
	$mklib->printpage("1", "1", "{$mklib->lang['sh_titlepage']}", $blocks);
	}
}
?>
