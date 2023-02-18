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
$idx = new mk_ad_blocks;
class mk_ad_blocks {


	function mk_ad_blocks() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'blocks_save':
    			$this->blocks_save();
    		break;
			case 'blocks_list':
    			$this->blocks_list();
    		break;
			case 'blocks_main_new':
    			$this->blocks_main_new();
    		break;
			case 'blocks_new':
    			$this->blocks_new();
    		break;
			case 'blocks_new_php':
    			$this->blocks_new_php();
    		break;
			case 'blocks_new_link':
    			$this->blocks_new_link();
    		break;
			case 'blocks_savenew':
    			$this->blocks_savenew();
    		break;
			case 'blocks_save_php':
    			$this->blocks_save_php();
    		break;
			case 'blocks_save_link':
    			$this->blocks_save_link();
    		break;
			case 'blocks_edit':
    			$this->blocks_edit($mkportals->input['idc'], $mkportals->input['personal']);
    		break;
			case 'blocks_edit_php':
    			$this->blocks_edit_php($mkportals->input['idblock']);
    		break;
			case 'blocks_edit_link':
    			$this->blocks_edit_link($mkportals->input['idblock']);
    		break;
			case 'blocks_update':
    			$this->blocks_update($mkportals->input['idc']);
    		break;
			case 'blocks_update_php':
    			$this->blocks_update_php();
    		break;
			case 'blocks_update_link':
    			$this->blocks_update_link($mkportals->input['idblock']);
    		break;
			case 'blocks_delete':
    			$this->blocks_delete($mkportals->input['idc']);
    		break;
			case 'show_code':
    			$this->show_code();
    		break;
			case 'show_codelink':
    			$this->show_codelink();
    		break;
    		default:
    			$this->blocks_show();
    		break;
    		}
	}
	function blocks_show() {
	global $mkportals, $mklib, $Skin, $DB;
	$mode = $mkportals->input['mode'];
	if ($mode == "saved") {
		$checksave = "{$mklib->lang['ad_saved']}<br /><br />";
   	}
	$myquery = $DB->query("SELECT file FROM mkp_blocks");
	while( $row = $DB->fetch_row($myquery) ) {
		$listfile .= $row['file'];
	}
	$dirb = $mklib->sitepath."mkportal/blocks/";
	if ($handle = opendir($dirb)) {
   		while (false !== ($file = readdir($handle))) {
       		if ($file != "." && $file != ".." && $file != "index.html") {
				$pos = strpos($listfile, $file);
          		 if ($pos === false) {
				 	$title = str_replace (".php", "", $file);
					$DB->query("INSERT INTO mkp_blocks(file, title) VALUES('$file', '$title')");
				}
			$listfile2 .= $file;
			}
       	}
		closedir($handle);
   	}
   $myquery = $DB->query("SELECT file FROM mkp_blocks WHERE personal='0'");
	while( $row = $DB->fetch_row($myquery) ) {
		$checkdel = $row['file'];
		$pos = strpos($listfile2, $checkdel);
			if ($pos === false) {
			$DB->query("DELETE FROM mkp_blocks WHERE file='$checkdel'");
		}
	}

	$subtitle = "{$mklib->lang['ad_blcfg']}";

	$content = "
      <tr>
	<td>

	  $checksave

	  <form name=\"config_blocks\" method=\"post\" action=\"admin.php?ind=ad_blocks&amp;op=blocks_save\">
	  <table width=\"100%\" >
	    <tr>
	    	<td colspan=\"3\">{$mklib->lang['ad_blchangetit']}</td>
	    </tr>
	    <tr>
	      <!-- apre colonna sx -->
	      <td width=\"33%\"align=\"center\" valign=\"top\" class=\"trattini2\">
	 ";
	$progoption = "";
	$myquery = $DB->query("SELECT * FROM mkp_blocks WHERE position ='sinistra' order by progressive");
	$totprog = $DB->get_num_rows($myquery);
	for ($i = 1; $i <= $totprog; $i++) {
   		$progoption .= "<option value=\"$i\">$i</option>";
	}

	while( $row = $DB->fetch_row($myquery) ) {
		$id = $row['id'];
		$title = $row['title'];
		//$position = $row['position'];
    	$position = $mklib->lang['ad_left'];
		$progressive = $row['progressive'];
		if ($progressive == 100) {
   			$progressive = $totprog;
		}
		$active = $row['active'];
		$title_form = $id."_title";
		$position_form = $id."_position";
		$progressive_form = $id."_progressive";
		$active_form = $id."_active";
		$content .= "
		<!-- tabella blocco -->
		<table class=\"tablemenu\" width=\"98%\">
		  <tr>
		    <td width=\"43%\" align=\"left\">
		      <select class=\"bgselect\" size=\"1\" name=\"$position_form\">
			<option value=\"sinistra\">$position</option>\n
			<option value=\"sinistra\">{$mklib->lang['ad_left']}</option>\n
			<option value=\"centro\">{$mklib->lang['ad_center']}</option>\n
			<option value=\"destra\">{$mklib->lang['ad_right']}</option>\n
		      </select>
		    </td>
		    <td width=\"23%\" align=\"left\">
		      <select class=\"bgselect\" size=\"1\" name=\"$progressive_form\">
			<option value=\"$progressive\">$progressive</option>
			$progoption
		      </select>
		    </td>
		    <td width=\"33%\" align=\"left\">{$mklib->lang['ad_active']}
		      <input type=\"checkbox\" name=\"$active_form\" value=\"checked\" $active />
		    </td>
		  </tr>
		  <tr>
		    <td colspan=\"3\" class=\"bgselect\" align=\"left\"><input type=\"text\" name=\"$title_form\" size=\"40\" value=\"$title\" class=\"bgselect\" style=\"border: 0;\" />
		    </td>
		  </tr>
        	</table>
        	<!-- fine tabella blocco -->
		<br /><br />
	 	";
	}
	$content .= "
	      <!-- chiude colonna sx -->
	      </td>    

	      <!-- apre colonna centro -->
	      <td width=\"33%\" align=\"center\" valign=\"top\" class=\"trattini2\">
	";
	$progoption = "";
	$myquery = $DB->query("SELECT * FROM mkp_blocks WHERE position ='centro' order by progressive");
	$totprog = $DB->get_num_rows($myquery);
	for ($i = 1; $i <= $totprog; $i++) {
   		$progoption .= "<option value=\"$i\">$i</option>";
	}

	while( $row = $DB->fetch_row($myquery) ) {
		$id = $row['id'];
		$title = $row['title'];
		//$position = $row['position'];
		$position = $mklib->lang['ad_center'];
		$progressive = $row['progressive'];
		if ($progressive == 100) {
   			$progressive = $totprog;
		}
		$active = $row['active'];
		$title_form = $id."_title";
		$position_form = $id."_position";
		$progressive_form = $id."_progressive";
		$active_form = $id."_active";
		$content .= "
		<!-- tabella blocco -->
		<table class=\"tablemenu\" width=\"98%\" >
		  <tr>
		    <td width=\"43%\" align=\"left\">
		      <select class=\"bgselect\" size=\"1\" name=\"$position_form\">
			<option value=\"centro\">$position</option>
			<option value=\"sinistra\">{$mklib->lang['ad_left']}</option>\n
			<option value=\"centro\">{$mklib->lang['ad_center']}</option>\n
			<option value=\"destra\">{$mklib->lang['ad_right']}</option>\n
		      </select>
		    </td>
		    <td width=\"23%\" align=\"left\">
		      <select class=\"bgselect\" size=\"1\" name=\"$progressive_form\">
			<option value=\"$progressive\">$progressive</option>
			$progoption
		      </select>
		    </td>
		    <td width=\"33%\" align=\"left\">{$mklib->lang['ad_active']}<input type=\"checkbox\" name=\"$active_form\" value=\"checked\" $active />
		    </td>
		  </tr>
		  <tr>
		    <td colspan=\"3\" class=\"bgselect\"  align=\"left\"><input type=\"text\" name=\"$title_form\" size=\"40\" value=\"$title\" class=\"bgselect\" style=\"border: 0; \" /></td>
		  </tr>
		</table>
        	<!-- fine tabella blocco -->
		<br /><br />
	 	";
	}
	$content .= "
	      <!-- chiude colonna centro -->
	      </td>
	      
	      <!-- apre colonna dx -->
	      <td width=\"33%\" align=\"center\" valign=\"top\">
	    
	";
	$progoption = "";
	$myquery = $DB->query("SELECT * FROM mkp_blocks WHERE position ='destra' order by progressive");
	$totprog = $DB->get_num_rows($myquery);
	for ($i = 1; $i <= $totprog; $i++) {
   		$progoption .= "<option value=\"$i\">$i</option>";
	}

	while( $row = $DB->fetch_row($myquery) ) {
		$id = $row['id'];
		$title = $row['title'];
		//$position = $row['position'];
		$position = $mklib->lang['ad_right'];
		$progressive = $row['progressive'];
		if ($progressive == 100) {
   			$progressive = $totprog;
		}
		$active = $row['active'];
		$title_form = $id."_title";
		$position_form = $id."_position";
		$progressive_form = $id."_progressive";
		$active_form = $id."_active";
		$content .= "
		<!-- tabella blocco -->
		<table class=\"tablemenu\" width=\"98%\" >
		  <tr>
		    <td width=\"43%\" align=\"left\">
		      <select class=\"bgselect\" size=\"1\" name=\"$position_form\">
			<option value=\"destra\">$position</option>
			<option value=\"sinistra\">{$mklib->lang['ad_left']}</option>\n
			<option value=\"centro\">{$mklib->lang['ad_center']}</option>\n
			<option value=\"destra\">{$mklib->lang['ad_right']}</option>\n
		      </select>
		    </td>
		    <td width=\"23%\" align=\"left\">
		      <select class=\"bgselect\" size=\"1\" name=\"$progressive_form\">
			<option value=\"$progressive\">$progressive</option>
			$progoption
		      </select>
		    </td>
		    <td width=\"33%\" align=\"left\">{$mklib->lang['ad_active']}<input type=\"checkbox\" name=\"$active_form\" value=\"checked\" $active /></td>
		  </tr>
		  <tr>
		    <td colspan=\"3\" class=\"bgselect\" align=\"left\">
		      <input type=\"text\" name=\"$title_form\" size=\"40\" value=\"$title\" class=\"bgselect\" style=\"border: 0; \" />
		    </td>
		  </tr>
        	</table>
        	<!-- fine tabella blocco -->
		<br /><br />
	 	";
		}
	$content .= "
	      <!-- chiude colonna dx -->
	      </td>
	    </tr>
	    
	    <!-- riga bottone invio -->
	    <tr>
	      <td colspan=\"3\" class=\"trattini\" align=\"center\"><input type=\"submit\" value=\"{$mklib->lang['ad_save']}\" name=\"B1\" /></td>
	    </tr>
	  </table>
	  </form>
	  
	</td>
      </tr>
	";
	$output = $Skin->view_block("$subtitle", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}
	function blocks_save() {
	global $mkportals, $mklib, $Skin,  $DB;
		$myquery = $DB->query("SELECT id FROM mkp_blocks");
 		while( $row = $DB->fetch_row($myquery) ) {
		$id = $row['id'];
		$title_form = $id."_title";
		$position_form = $id."_position";
		$progressive_form = $id."_progressive";
		$active_form = $id."_active";
		$DB->query("UPDATE mkp_blocks SET title ='{$mkportals->input[$title_form]}', position ='{$mkportals->input[$position_form]}', progressive ='{$mkportals->input[$progressive_form]}', active ='{$mkportals->input[$active_form]}'  WHERE id='$id'");
		}

		$DB->close_db();
		Header("Location: admin.php?ind=ad_blocks&mode=saved");
		exit;

	}
	function blocks_list() {
	global $mkportals, $mklib, $Skin, $DB;
	$myquery = $DB->query("SELECT id, title, personal FROM mkp_blocks WHERE personal > '0'");

	$content = "
	<tr>
	  <td>
	    <script type=\"text/javascript\">

		    function makesure() {
		    if (confirm('{$mklib->lang[ad_delblockconfirm]}')) {
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
	    $personal = $row['personal'];
		$content .= "
		<tr><td width=\"70%\"><img src=\"$mklib->images/frec.gif\" align=\"left\" alt=\"\" />&nbsp;
		";
		$content .= "
		<a href=\"admin.php?ind=ad_blocks&amp;op=blocks_edit&amp;idc={$row['id']}&amp;personal=$personal\">{$row['title']}</a>
		";
		$content .= "
		</td><td width=\"15%\" align=\"right\">
		";
		$content .= "
		<a href=\"admin.php?ind=ad_blocks&amp;op=blocks_edit&amp;idc={$row['id']}&amp;personal=$personal\">{$mklib->lang['ad_edit']}</a>
		";
		$content .= "
		</td><td width=\"15%\" align=\"right\">
		";
		$content .= "
		<a href=\"admin.php?ind=ad_blocks&amp;op=blocks_delete&amp;idc={$row['id']}\" onclick=\"return makesure()\">{$mklib->lang['ad_delete']}</a>
		";
		$content .= "
		</td></tr>
		";
	  }

	$output = $Skin->view_block("{$mklib->lang['ad_bllist']}", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function blocks_edit($id, $personal) {
		switch($personal) {
			case '2':
			$this->blocks_edit_link($id);
    		break;
			case '3':
			$this->blocks_edit_php($id);
    		break;
    		default:
    			$this->blocks_edit_html($id);
    		break;
		}
		exit;
	}
	function blocks_edit_html($id) {
	global $mkportals, $mklib, $Skin, $DB, $editorscript;
		$editorscript = 1;
		$textarepar = "mce_editable=\"true\"";
		$textarew = "100%";
		$bbeditor= "";
		if ($mklib->mkeditor == "BBCODE") {
			$editorscript = "";
			$textarepar = "";
			$textarew = "75%";
			$bbeditor= $mklib->get_bbeditor("1");
		}
		$myquery = $DB->query("SELECT title, content FROM mkp_blocks WHERE id='$id'");
		$row = $DB->fetch_row($myquery);
		$testo = $row['content'];
		$testo = stripslashes($testo);
		$title = $row['title'];
		$title = stripslashes($title);
	   $content = "
		<tr>
		  <td>
		  
		    <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_update&amp;idc=$id\" method=\"post\" id=\"editor\" name=\"editor\">
		    <table width=\"100%\">
		      <tr>
			<td class=\"tdblock\">
			  {$mklib->lang['ad_title']}:
			  <input type=\"text\" name=\"titleblock\" value=\"{$title}\" size=\"40\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\">
			$bbeditor
 			<textarea id=\"ta\" name=\"ta\" $textarepar style=\"width: $textarew\" rows=\"14\" cols=\"40\">$testo</textarea>
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\">
			  <input type=\"submit\" name=\"ok\" value=\"  {$mklib->lang['ad_save']}  \" />		
			</td>
		      </tr>
		    </table>
		    </form>
		    
		  </td>
		</tr>

	";
	$output = $Skin->view_block("{$mklib->lang['ad_blpedit']}", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}

	function blocks_main_new() {
	global $mkportals, $mklib, $Skin, $DB;
	   $content .= "		
		  <tr align=\"center\">
		    <td><br /><a href=\"admin.php?ind=ad_blocks&amp;op=blocks_new\"><img src=\"admin/images/block.gif\" border=\"0\" alt=\"\" /></a><br />
		    </td>
		  </tr>
		  <tr align=\"center\">
		    <td>{$mklib->lang['ad_blcreateh']}<br /><br /><br /><br /></td>
		  </tr>
		  <tr align=\"center\">
		    <td><a href=\"admin.php?ind=ad_blocks&amp;op=blocks_new_php\"><img src=\"admin/images/block3.gif\" border=\"0\" alt=\"\" /></a><br /></td>
		  </tr>
		  <tr align=\"center\">
		    <td>{$mklib->lang['ad_blcreatep']}<br /><br /><br /><br /></td>
		  </tr>
		  <tr align=\"center\">
		    <td><a href=\"admin.php?ind=ad_blocks&amp;op=blocks_new_link\"><img src=\"admin/images/block2.gif\" border=\"0\" alt=\"\" /></a><br /></td>
		  </tr>
		  <tr align=\"center\">
		    <td>{$mklib->lang['ad_blcreatel']}<br />  <br /><br /></td>
		  </tr>		
	";
	$output = $Skin->view_block("{$mklib->lang['ad_blcreatetit']}", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}

	function blocks_new() {
	global $mkportals, $mklib, $Skin, $DB, $editorscript;
		$editorscript = 1;
		$textarepar = "mce_editable=\"true\"";
		$textarew = "100%";
		$bbeditor= "";
		if ($mklib->mkeditor == "BBCODE") {
			$editorscript = "";
			$textarepar = "";
			$textarew = "75%";
			$bbeditor= $mklib->get_bbeditor("1");
		}
	   $content = "
		<tr>
		  <td>
		  
		    <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_savenew\" method=\"post\" id=\"editor\" name=\"editor\">
		    <table width=\"100%\">
		      <tr>
			<td class=\"tdblock\">
			  {$mklib->lang['ad_title']}:
			  <input type=\"text\" name=\"titleblock\"  size=\"40\" />
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
			  <input type=\"submit\" name=\"ok\" value=\"  {$mklib->lang['ad_save']}  \" />
			</td>
		      </tr>		
		    </table>
		    </form>
		    
		  </td>
		</tr>

	";
	$output = $Skin->view_block("{$mklib->lang['ad_blcreateh']}", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}

	function blocks_new_link() {
	global $mkportals, $mklib, $Skin, $DB;
		$titleblock = $mkportals->input['titleblock'];
		$filename = "cache/tmp_block.php";
		$link = $mkportals->input['vlink'];
		$filetext = " ";
		if ($link && $mkportals->input['mode'] == "add") {
			$tpage = $this->retr_title($link);
			$handle = fopen($filename, "r");
			$filetext = fread($handle, filesize($filename));
			fclose($handle);
			$filetext .= "<tr><td width=\"100%\" class=\"tdblock\"><img src=\"frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$mklib->siteurl/index.php?pid=$link\">$tpage</a></td></tr>\n";
		}
		if ($link && $mkportals->input['mode'] == "remove") {
			$tpage = $this->retr_title($link);
			$handle = fopen($filename, "r");
			$filetext = fread($handle, filesize($filename));
			fclose($handle);
			$remove = "<tr><td width=\"100%\" class=\"tdblock\"><img src=\"frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$mklib->siteurl/index.php?pid=$link\">$tpage</a></td></tr>\n";
			$filetext = str_replace($remove, "", $filetext);
		}
		if (!$filetext) {
			$filetext = " ";
		}
		if (!$handle = fopen($filename, 'w')) {
   			$message = "{$mklib->lang['ad_blnofile']}";
			$mklib->error_page($message);
			exit;
   		}
   		if (!fwrite($handle, $filetext)) {
       		$message = "{$mklib->lang['ad_blnofile']}";
			$mklib->error_page($message);
			exit;
   		}
		fclose($handle);
		$query = $DB->query("SELECT id, title FROM mkp_pages");
	  	while( $row = $DB->fetch_row($query) ) {
			$idpage = $row['id'];
			$page = $row['title'];
			$cselect.= "<option value='$idpage'>$page</option>\n";
		}
	   $content .= "
		<tr>
		  <td>

		    <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_new_link&amp;mode=add\" name=\"ADD\" method=\"post\">
		    <table width=\"100%\">
		
		    <tr>
		      <td class=\"tdblock\">
			{$mklib->lang['ad_title']}:
			<input type=\"text\" value=\"$titleblock\" name=\"titleblock\"  size=\"40\" />
		      </td>
		    </tr>
		    <tr>
		      <td class=\"tdblock\"> {$mklib->lang['ad_blavpages']}
			<select class=\"bgselect\" name=\"vlink\" size=\"1\">
			{$cselect}
			</select>
		      </td>
		    </tr>
		    <tr>
		      <td class=\"tdblock\">
			<input type=\"submit\" value=\"  {$mklib->lang['ad_bladdlink']}  \" />
		      </td>
		    </tr>
		  </table>
		  </form>
		  
		</td>
	      </tr>
		  
	      <tr>
		<td>		    
		
		  <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_new_link&amp;mode=remove\" name=\"Rem\" method=\"post\">
		  <table class=\"trattini\" width=\"100%\">
		    <tr>
		      <td class=\"tdblock\"> {$mklib->lang['ad_bllremlink']}
			<select class=\"bgselect\" name=\"vlink\" size=\"1\">
			{$cselect}
			</select>
			<input type=\"hidden\" value=\"$titleblock\" name=\"titleblock\" />
		      </td>
		    </tr>
		    <tr>
		      <td class=\"tdblock\">
			<input type=\"submit\" name=\"ok\" value=\"  {$mklib->lang['ad_blremlink']}  \" />
		      </td>
		    </tr>		
		  </table>
		  </form>
		    
		</td>
		</tr>
		    
		<tr>
		  <td align=\"left\" height=\"100%\">
		    <table width=\"150\">
		      <tr>
			<td>		      
			  <iframe src=\"admin.php?ind=ad_blocks&amp;op=show_codelink&amp;titleblock=$titleblock\" frameborder=\"0\"  width=\"150\" align=\"middle\" height=\"200\" scrolling=\"auto\"></iframe>
			</td>
		      </tr>
		    </table>
		  </td>
		</tr>
		<tr>
		  <td  align=\"left\">
		    
		    <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_save_link\" method=\"post\" name=\"s_block\">
		      <input type=\"hidden\" value=\"$titleblock\" name=\"titleblock\" />
		      <input type=\"submit\" name=\"oks\" value=\"  {$mklib->lang['ad_blocksave']}  \" />
		    </form>
		      
		  </td>
		</tr>	

	";

	$output = $Skin->view_block("{$mklib->lang['ad_blcreatel']}", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}

	function blocks_new_php() {
	global $mkportals, $mklib, $Skin, $DB;
		$titleblock = $mkportals->input['titleblock'];
		$titleblock = stripslashes($titleblock);
		$testo = $_POST['ta'];
		$testo = stripslashes($testo);
		if (!$titleblock) {
			$titleblock = "{$mklib->lang['ad_title']}??";
   		}
		$testo =  trim ($testo);
		if (!$testo) {
		  $testo = $mklib->lang['ad_blphpcode'];
	 	}
		
		$filename = "cache/tmp_block.php";
		$css = "$mklib->template/style.css";
 		$filetext = "<head>\n<link href=\"{$css}\" rel=\"stylesheet\" type=\"text/css\">\n</head>\n";
		$filetext .= $testo;
		if (!$handle = fopen($filename, 'w')) {
         	$message = "";
			$mklib->error_page($message);
			exit;
   		}
   		if (!fwrite($handle, $filetext)) {
       		$message = "{$mklib->lang['ad_blnofile']}";
			$mklib->error_page($message);
			exit;
   		}
		fclose($handle);

	   $content .= "
		<tr>
		  <td>
		  
		    <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_new_php\" method=\"post\" id=\"editor\" name=\"editor\">
		    <table width=\"300\">
		      <tr>
			<td class=\"tdblock\">
			  {$mklib->lang['ad_title']}:
			  <input type=\"text\" value=\"$titleblock\" name=\"titleblock\" size=\"40\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\">
			  <textarea id=\"ta\" name=\"ta\"  rows=\"20\" cols=\"75\">$testo</textarea>
			  <input type=\"submit\" name=\"ok\" value=\"  {$mklib->lang['ad_blpreview']}  \" />
			</td>
		      </tr>
		    </table>
		    </form>

		  </td>
		</tr>		    		    
		<tr>
		  <td align=\"left\" height=\"100%\">
		    <table width=\"150\">
		      <tr>
			<td>
			  <iframe src=\"admin.php?ind=ad_blocks&amp;op=show_code&amp;titleblock=$titleblock\" frameborder=\"0\"  width=\"150\" align=\"middle\" height=\"200\" scrolling=\"auto\"></iframe>
			</td>
		      </tr>
		    </table>
		  </td>
		</tr>		
		<tr align=\"left\">
		  <td>		    
		    <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_save_php\" method=\"post\" name=\"s_block\">
		      <input type=\"hidden\" value=\"$titleblock\" name=\"titleblock\" />
		      <input type=\"submit\" name=\"oks\" value=\"  {$mklib->lang['ad_blocksave']}  \" />		
		    </form>
		  </td>
		</tr>
	";

	$output = $Skin->view_block("{$mklib->lang['ad_blcreatep']}", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}

	function blocks_edit_php($idblock, $check="") {
	global $mkportals, $mklib, $Skin, $DB;
		$titleblock = $mkportals->input['titleblock'];
		$titleblock = stripslashes($titleblock);
		$testo = $_POST['ta'];
		$testo = stripslashes($testo);
		$query = $DB->query("SELECT file, title FROM mkp_blocks WHERE id = '$idblock'");
		$row = $DB->fetch_row($query);
		if (!$titleblock) {
			$titleblock = $row['title'];
		}
		$magic = get_magic_quotes_gpc();
		if ($magic) {
			$testo = stripslashes($testo);
		}
		if (!$testo) {
			$filename = $row['file'];
			$handle = fopen($filename, "r");
			$testo = fread($handle, filesize($filename));
			fclose($handle);
		}
		$testo =  trim ($testo);
		if (!$testo) {
		  $testo = $mklib->lang['ad_blphpcode'];
	 	}

		$filename = "cache/tmp_block.php";
		$css = "$mklib->template/style.css";
 		$filetext = "<head>\n<link href=\"{$css}\" rel=\"stylesheet\" type=\"text/css\">\n</head>\n";
		$filetext .= $testo;
		if (!$handle = fopen($filename, 'w')) {
         	$message = "{$mklib->lang['ad_blnofile']}";
			$mklib->error_page($message);
			exit;
   		}
   		if (!fwrite($handle, $filetext)) {
       		$message = "{$mklib->lang['ad_blnofile']}";
			$mklib->error_page($message);
			exit;
   		}
		fclose($handle);

	   $content .= "
		<tr>
		  <td>
		  
		    <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_edit_php&amp;idblock=$idblock\" method=\"post\" id=\"editor\" name=\"editor\">
		    <table width=\"300\">
		      <tr>
			<td class=\"tdblock\">
			  {$mklib->lang['ad_title']}:
			  <input type=\"text\" value = \"$titleblock\" name=\"titleblock\"  size=\"40\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\">
			  <textarea id=\"ta\" name=\"ta\"  rows=\"20\" cols=\"75\">$testo</textarea>
			  <input type=\"submit\" name=\"ok\" value=\"  {$mklib->lang['ad_blpreview']}  \" />
			</td>
		      </tr>
		    </table>
		    </form>
		    
		  </td>
		</tr>
		
		<tr>
		  <td align=\"left\" height=\"100%\">
		    <table width=\"150\">
		      <tr>
			<td>
			  <iframe src=\"admin.php?ind=ad_blocks&amp;op=show_code&amp;titleblock=$titleblock\" frameborder=\"0\"  width=\"150\" align=\"middle\" height=\"200\" scrolling=\"auto\"></iframe>
			</td>
		      </tr>
		    </table>
		  </td>
		</tr>
		
		<tr>
		  <td>
		    <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_update_php&amp;idblock=$idblock&amp;titleblock=$titleblock\" method=\"post\" name=\"s_block\">
		      <input type=\"submit\" name=\"oks\" value=\"  {$mklib->lang['ad_blocksave']}  \" />
		    </form>
		  </td>
		</tr>	
	";

	$output = $Skin->view_block("{$mklib->lang['ad_bleditp']}", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}

	function blocks_edit_link($idblock) {
	global $mkportals, $mklib, $Skin, $DB;
		$titleblock = $mkportals->input['titleblock'];
		$filename = "cache/tmp_block.php";
		$link = $mkportals->input['vlink'];

		if (!$mkportals->input['mode']) {
			$query = $DB->query("SELECT title, content FROM mkp_blocks WHERE id = '$idblock'");
			$row = $DB->fetch_row($query);
			$titleblock = $row['title'];
			$filetext = $row['content']."\n";
		}
		if ($link && $mkportals->input['mode'] == "add") {
			$tpage = $this->retr_title($link);
			$handle = fopen($filename, "r");
			$filetext = fread($handle, filesize($filename));
			fclose($handle);
			$filetext .= "<tr><td width=\"100%\" class=\"tdblock\"><img src=\"frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$mklib->siteurl/index.php?pid=$link\">$tpage</a></td></tr>\n";
		}
		if ($link && $mkportals->input['mode'] == "remove") {
			$tpage = $this->retr_title($link);
			$handle = fopen($filename, "r");
			$filetext = fread($handle, filesize($filename));
			fclose($handle);
			$remove = "<tr><td width=\"100%\" class=\"tdblock\"><img src=\"frec.gif\" align=\"left\" alt=\"\" />&nbsp;<a class=\"uno\" href=\"$mklib->siteurl/index.php?pid=$link\">$tpage</a></td></tr>\n";
			$filetext = str_replace($remove, "", $filetext);
		}
		if (!$filetext) {
			$filetext = " ";
		}
		if (!$handle = fopen($filename, 'w')) {
         	$message = "{$mklib->lang['ad_blnofile']}";
			$mklib->error_page($message);
			exit;
   		}
   		if (!fwrite($handle, $filetext)) {
       		$message = "{$mklib->lang['ad_blnofile']}";
			$mklib->error_page($message);
			exit;
   		}
		fclose($handle);
		$query = $DB->query("SELECT id, title FROM mkp_pages");
	  	while( $row = $DB->fetch_row($query) ) {
			$idpage = $row['id'];
			$page = $row['title'];
			$cselect.= "<option value=\"$idpage\">$page</option>\n";
		}
	   $content .= "
		<tr>
		  <td>
		
		    <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_edit_link&amp;mode=add'&amp;idblock='$idblock\" name=\"ADD\" method=\"post\">
		    <table width=\"100%\">
		      <tr>
			<td class=\"tdblock\">
			  {$mklib->lang['ad_title']}:
			  <input type=\"text\" value=\"$titleblock\" name=\"titleblock\" size=\"40\" />
			  <input type=\"hidden\" value=\"$idblock\" name=\"idblock\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\"> {$mklib->lang['ad_blavpages']}:
			  <select class=\"bgselect\" name=\"vlink\" size=\"1\">
			  {$cselect}
			  </select>
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\">
			  <input type=\"submit\" value=\"  {$mklib->lang['ad_bladdlink']}  \" />
			</td>
		      </tr>
		    </table>
		    </form>
		    
		  </td>
		</tr>
		<tr>
		  <td>
		
		    <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_edit_link&amp;mode=remove'&amp;idblock='$idblock\" name=\"Rem\" method=\"post\">
		    <table class=\"trattini\" width=\"100%\">
		      <tr>
			<td class=\"tdblock\"> {$mklib->lang['ad_bllremlink']}
			  <select class=\"bgselect\" name=\"vlink\" size=\"1\">
			  {$cselect}
			  </select>
			  <input type=\"hidden\" value=\"$titleblock\" name=\"titleblock\" />
			  <input type=\"hidden\" value=\"$idblock\" name=\"idblock\" />
			</td>
		      </tr>
		      <tr>
			<td class=\"tdblock\">
			  <input type=\"submit\" name=\"ok\" value=\"  {$mklib->lang['ad_blremlink']}  \" />
			</td>
		      </tr>		
		    </table>
		    </form>

		  </td>
		</tr>
		<tr>
		  <td align=\"left\" height=\"100%\">
		    <table width=\"150\">
		      <tr>
			<td>
			  <iframe src=\"admin.php?ind=ad_blocks&amp;op=show_codelink&amp;titleblock=$titleblock\" frameborder=\"0\"  width=\"150\" align=\"middle\" height=\"200\" scrolling=\"auto\"></iframe>
			</td>
		      </tr>
		    </table>
		  </td>
		</tr>
		<tr>
		  <td  align=\"left\">
		    <form action=\"admin.php?ind=ad_blocks&amp;op=blocks_update_link&amp;idblock=$idblock&amp;titleblock=$titleblock\" method=\"post\" name=\"s_block\">
		      <input type=\"hidden\" value=\"$titleblock\" name=\"titleblock\" />
		      <input type=\"hidden\" value=\"$idblock\" name=\"idblock\" />
		      <input type=\"submit\" name=\"oks\" value=\"  {$mklib->lang['ad_blocksave']}  \" />
		    </form>
		  </td>
		</tr>
	";

	$output = $Skin->view_block("{$mklib->lang['ad_bleditl']}", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);
	}

	function blocks_savenew() {
	global $mkportals, $mklib, $Skin,  $DB;
		$content = $_POST['ta'];
		$content = $mklib->convert_savedbadmin($content);
		$titleblock = $_POST['titleblock'];
		if (!$titleblock) {
			$titleblock = "{$mklib->lang['ad_title']}??";
   		}
		$titleblock = stripslashes($titleblock);
		$titleblock = $mklib->convert_savedbadmin($titleblock);
		$DB->query("INSERT INTO mkp_blocks (title, personal, content) VALUES ('$titleblock', '1', '$content')");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_blocks&op=ad_blocks");
		exit;
	}
	function blocks_save_link() {
	global $mkportals, $mklib, $Skin,  $DB;
		$filename = "cache/tmp_block.php";
		$titleblock = $_POST['titleblock'];
		if (!$titleblock) {
			$titleblock = "{$mklib->lang['ad_title']}??";
   		}
		$titleblock = stripslashes($titleblock);
		$titleblock = $mklib->convert_savedbadmin($titleblock);
		$handle = fopen($filename, "r");
		$content = fread($handle, filesize($filename));
		fclose($handle);
		$content =  trim ($content);
		$content = $mklib->convert_savedbadmin($content);
		$DB->query("INSERT INTO mkp_blocks (title, personal, content) VALUES ('$titleblock', '2', '$content')");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_blocks&op=ad_blocks");
		exit;
	}
	function blocks_update($id) {
	global $mkportals, $mklib, $Skin,  $DB;
		$content = $_POST['ta'];
		$content = stripslashes($content);
		$content = $mklib->convert_savedbadmin($content);
		$titleblock = $_POST['titleblock'];
		$titleblock = stripslashes($titleblock);
		$titleblock = $mklib->convert_savedbadmin($titleblock);
		$DB->query("UPDATE mkp_blocks SET content ='$content', title='$titleblock' WHERE id='$id'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_blocks&op=blocks_list");
		exit;
	}

	function blocks_update_link() {
	global $mkportals, $mklib, $Skin,  $DB;
		$idblock = $mkportals->input['idblock'];
		$titleblock = stripslashes($titleblock);
		$titleblock = $mklib->convert_savedbadmin($titleblock);
		$filename = "cache/tmp_block.php";
		if (!$titleblock) {
			$titleblock = "{$mklib->lang['ad_title']}??";
   		}
		$handle = fopen($filename, "r");
		$content = fread($handle, filesize($filename));
		fclose($handle);
		$content =  trim ($content);
		$content = stripslashes($content);
		$content = $mklib->convert_savedbadmin($content);
		$DB->query("UPDATE mkp_blocks SET content ='$content', title='$titleblock' WHERE id='$idblock'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_blocks&op=blocks_list");
		exit;
	}

	function blocks_delete($id) {
	global $mkportals, $mklib, $Skin,  $DB;
		if ($id != 1) {
			$query = $DB->query("SELECT file, personal FROM mkp_blocks WHERE id = '$id'");
			$row = $DB->fetch_row($query);
			$personal = $row['personal'];
			$filename = $row['file'];
			if ($personal == 3) {
				@unlink("$filename");	
			}
			$DB->query("DELETE FROM mkp_blocks WHERE id='$id'");
		}
		$DB->close_db();
		Header("Location: admin.php?ind=ad_blocks&op=blocks_list");
		exit;
	}

	function show_code()
 	{
 		global $mkportals, $DB, $Skin, $mklib, $std;
		$title = $mkportals->input['titleblock'];
		if (!$title) {
			$title = "{$mklib->lang['ad_blpreview']}";
   		}
		@require "cache/tmp_block.php";
		$output = $Skin->view_block("$title", "$content");

		print $output;


 	}
	function show_codelink()
 	{
 		global $mkportals, $DB, $Skin, $mklib, $std;
		$titleblock = $mkportals->input['titleblock'];
		if (!$titleblock) {
			$titleblock = "{$mklib->lang['ad_blpreview']}";
   		}
		$css = "$mklib->template/style.css";
 		$content = "<head>\n<link href=\"{$css}\" rel=\"stylesheet\" type=\"text/css\">\n</head>\n";
		$filename = "cache/tmp_block.php";
		$handle = fopen($filename, "r");
		$content .= fread($handle, filesize($filename));
		$content = str_replace ("frec.gif", "$mklib->images/frec.gif", $content);
		fclose($handle);
		$output = $Skin->view_block("$titleblock", "$content");

		print $output;


 	}

	function blocks_save_php() {
	global $mkportals, $mklib, $Skin, $DB;
		$titleblock = $_POST['titleblock'];
		$titleblock = stripslashes($titleblock);
		$titleblock = $mklib->convert_savedbadmin($titleblock);  
		if (!$titleblock) {
			$titleblock = "{$mklib->lang['ad_title']}??";
   		}
		$filename = "cache/tmp_block.php";
		$query = $DB->query("SELECT id FROM mkp_blocks order by 'id' DESC LIMIT 1");
		$row = $DB->fetch_row($quey);
		$filename2 = "cache/pblock_";
		$filename2 .= ++$row['id'];
		$filename2 .= ".php";
		copy($filename, $filename2);

		$handle = fopen($filename, "r");
		$testo = fread($handle, filesize($filename));
		fclose($handle);
		$start = strpos($testo, "<?");
		$testo = substr($testo, $start);

		if (!$handle = fopen($filename2, 'w')) {
         	$message = "{$mklib->lang['ad_blnofile']}";
			$mklib->error_page($message);
			exit;
   		}
   		if (!fwrite($handle,$testo)) {
       		$message = "{$mklib->lang['ad_blnofile']}";
			$mklib->error_page($message);
			exit;
   		}
		fclose($handle);

		$DB->query("INSERT INTO mkp_blocks (file, title, personal) VALUES ('$filename2', '$titleblock', '3')");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_blocks&op=ad_blocks");
		exit;
	}
	function blocks_update_php() {
	global $mkportals, $mklib, $Skin, $DB;
		$idblock = $mkportals->input['idblock'];
		$titleblock = $_GET['titleblock'];
		$titleblock = stripslashes($titleblock);
		$titleblock = $mklib->convert_savedbadmin($titleblock);
		if (!$titleblock) {
			$titleblock = "{$mklib->lang['ad_title']}??";
   		}
		$filename = "cache/tmp_block.php";
		$handle = fopen($filename, "r");
		$testo = fread($handle, filesize($filename));
		fclose($handle);
		$start = strpos($testo, "<?");
		$testo = substr($testo, $start);
		$query = $DB->query("SELECT file FROM mkp_blocks WHERE id = '$idblock'");
		$row = $DB->fetch_row($query);
		$filename2 = $row['file'];
		copy($filename, $filename2);

		if (!$handle = fopen($filename2, 'w')) {
         	$message = "{$mklib->lang['ad_blnofile']}";
			$mklib->error_page($message);
			exit;
   		}
   		if (!fwrite($handle,$testo)) {
       		$message = "{$mklib->lang['ad_blnofile']}";
			$mklib->error_page($message);
			exit;
   		}
		fclose($handle);

		$DB->query("UPDATE mkp_blocks SET title='$titleblock' WHERE id='$idblock'");
		$DB->close_db();
		Header("Location: admin.php?ind=ad_blocks&op=blocks_list");
		exit;
	}

	function retr_title($id) {
		global $DB;
		$query = $DB->query("SELECT title FROM mkp_pages where id = '$id'");
		$row = $DB->fetch_row($query);
		return $row['title'];
	}



}

?>
