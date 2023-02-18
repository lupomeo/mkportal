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

$idx = new mk_ad_skin;
class mk_ad_skin {


	function mk_ad_skin() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'editt':
    			$this->editt();
    		break;
			case 'edits':
    			$this->edits();
    		break;
			case 'update_section':
    			$this->update_section();
    		break;
			case 'editc':
    			$this->editc();
    		break;
			case 'update_css':
    			$this->update_css();
    		break;
			default:
    			$this->skin_show();
    		break;
    		}
	}
	function skin_show() {
	global $mkportals, $mklib, $Skin, $DB;

		$mainltitle = "";

	 	$content  = "
	<tr>
	  <td>
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>
		  <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"2\" width=\"98%\" align=\"center\" border=\"0\">
		    <tr>
		      <td colspan=\"3\" class=\"titadmin\">{$mklib->lang['ad_skinm']}</td>
		    </tr>

		    <tr>

		      <th class=\"modulex\" width=\"80%\" align=\"left\">{$mklib->lang['ad_title']}</th>
		      <th class=\"modulex\" width=\"10%\" align=\"center\">{$mklib->lang['ad_skineditt']}</th>
		      <th class=\"modulex\" width=\"10%\" align=\"center\">{$mklib->lang['ad_skineditc']}</th>
		    </tr>


    ";
	if ($dir = @opendir("templates/")) {
 		while (($dirt = readdir($dir)) !== false) {
		  if ($dirt != "." && $dirt != "..") {
			$content .= "
		    <tr>
		      <td class=\"modulecell\" width=\"80%\" align=\"left\">$dirt</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=editt&amp;idl=$dirt\">{$mklib->lang['ad_skineditt']}</a></td>
			  <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=editc&amp;idl=$dirt\">{$mklib->lang['ad_skineditc']}</a></td>
		    </tr>
    		";
		  }
		}
  	closedir($dir);
	}

 $content  .= "		  		    
		  </table><br />
		</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\" colspan=\"2\"><br /></td>
	      </tr>
	    </table>
	  </td>
	</tr>
	   ";
		$output = $Skin->view_block("{$mklib->lang['ad_skin']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function editt() {
	global $mkportals, $mklib, $Skin, $DB;

		$file = "./templates/".$mkportals->input['idl']."/tpl_main.php";

		$fh = @fopen($file, "r");
    	if ($fh) {
        	$testo = fread($fh, filesize($file));
        	@fclose($fh);
		}
		$erros = "";
		$pos = strpos($testo, "<!-- begin document head -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end document head -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin open main table -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end open main table -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin logostrip -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end logostrip -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin linkbar -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end linkbar -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin shoutbox -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end shoutbox -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin open portal body -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end open portal body -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin left column -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end left column -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin center column -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end center column -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin right column -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end right column -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin close portal body -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end close portal body -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin close main table -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end close main table -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin footer -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end footer -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin block template -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end block template -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- begin link template -->");
		if (!$pos) {
			$erros = 1;
		}
		$pos = strpos($testo, "<!-- end link template -->");

		if ($erros) {
			$message = "{$mklib->lang['ad_skinnotok']}";
			$mklib->error_page($message);
			exit;
		}

		unset($testo);
		$file = $mkportals->input['idl'];
	 	$content  = "
	<tr>
	  <td>
	    <table width=\"100%\" border=\"0\">
	      <tr>
		<td>
		  <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"2\" width=\"98%\" align=\"center\" border=\"0\">
		    <tr>
		      <td colspan=\"3\" class=\"titadmin\">{$mklib->lang['ad_skinm']}: <span class=\"mktxtcontr\">{$mkportals->input['idl']}</span></td>
		    </tr>
		    <tr>
		      <th class=\"modulex\" width=\"90%\" align=\"left\">{$mklib->lang['ad_section']}</th>
		      <th class=\"modulex\" width=\"10%\" align=\"center\">{$mklib->lang['ad_editsection']}</th>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_hea']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=header\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_mto']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=mainopen\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_lo']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=logo\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_li']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=linkbar\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_sh']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=shout\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_pbo']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=openbody\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_lc']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=leftc\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_cs']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=cspace\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_cc']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=centerc\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_rc']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=rightc\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_pbc']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=closebody\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_mtc']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=closemain\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_fo']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=footer\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
			<tr>
		      <td class=\"modulecell\" width=\"90%\" align=\"left\">{$mklib->lang['ad_skin_bl']}</td>
		      <td class=\"modulecell\" width=\"10%\" align=\"center\"><a class=\"mktxtcontr2\" href=\"admin.php?ind=ad_skin&amp;op=edits&amp;idl=$file&amp;sec=blocks\">{$mklib->lang['ad_editsection']}</a></td>
		    </tr>
		  </table><br />
		</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\" colspan=\"2\"><br /></td>
	      </tr>
	    </table>
	  </td>
	</tr>
	   ";
		$output = $Skin->view_block("{$mklib->lang['ad_skin']}", "$content");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function edits() {
		global $mkportals, $DB, $mklib, $Skin;

		$file = "./templates/".$mkportals->input['idl']."/tpl_main.php";
		switch($mkportals->input['sec']) {
			case 'header':
    			$start = "<!-- begin document head -->";
				$end = "<!-- end document head -->";
				$sec = $mklib->lang['ad_skin_hea'];
    		break;
			case 'mainopen':
    			$start = "<!-- begin open main table -->";
				$end = "<!-- end open main table -->";
				$sec = $mklib->lang['ad_skin_mto'];
    		break;
			case 'logo':
    			$start = "<!-- begin logostrip -->";
				$end = "<!-- end logostrip -->";
				$sec = $mklib->lang['ad_skin_lo'];
    		break;
			case 'linkbar':
    			$start = "<!-- begin linkbar -->";
				$end = "<!-- end linkbar -->";
				$sec = $mklib->lang['ad_skin_li'];
    		break;
			case 'shout':
    			$start = "<!-- begin shoutbox -->";
				$end = "<!-- end shoutbox -->";
				$sec = $mklib->lang['ad_skin_sh'];
    		break;
			case 'openbody':
    			$start = "<!-- begin open portal body -->";
				$end = "<!-- end open portal body -->";
				$sec = $mklib->lang['ad_skin_pbo'];
    		break;
			case 'leftc':
    			$start = "<!-- begin left column -->";
				$end = "<!-- end left column -->";
				$sec = $mklib->lang['ad_skin_lc'];
    		break;
			case 'cspace':
    			$start = "<!-- begin column spacer -->";
				$end = "<!-- end column spacer -->";
				$sec = $mklib->lang['ad_skin_cs'];
    		break;
			case 'centerc':
    			$start = "<!-- begin center column -->";
				$end = "<!-- end center column -->";
				$sec = $mklib->lang['ad_skin_cc'];
    		break;
			case 'rightc':
    			$start = "<!-- begin right column -->";
				$end = "<!-- end right column -->";
				$sec = $mklib->lang['ad_skin_rc'];
    		break;
			case 'closebody':
    			$start = "<!-- begin close portal body -->";
				$end = "<!-- end close portal body -->";
				$sec = $mklib->lang['ad_skin_pbc'];
    		break;
			case 'closemain':
    			$start = "<!-- begin close main table -->";
				$end = "<!-- end close main table -->";
				$sec = $mklib->lang['ad_skin_mtc'];
    		break;
			case 'footer':
    			$start = "<!-- begin footer -->";
				$end = "<!-- end footer -->";
				$sec = $mklib->lang['ad_skin_fo'];
    		break;
			case 'blocks':
    			$start = "<!-- begin block template -->";
				$end = "<!-- end block template -->";
				$sec = $mklib->lang['ad_skin_bl'];
    		break;
		}


		$fh = @fopen($file, "r");
    	if ($fh) {
        	$testo = fread($fh, filesize($file));
        	@fclose($fh);
		}

		$pos1 = strpos($testo, $start);
		$pos1 = $pos1 + strlen($start);
		$pos2 = strpos($testo, $end);
		$testo = substr($testo, $pos1, ($pos2 - $pos1));

		$output = "
	<tr>
	  <td><br />
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" align=\"center\" border=\"0\">
	      <tr>
		<td>
		  <table class=\"modulebg\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" border=\"0\">
		    <tr>
		      <td class=\"tdblock\" width=\"100%\" height=\"25\"><img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$mklib->lang['ad_skin']}</td>
		    </tr>
		    <tr>
		      <td>
			<table class=\"moduleborder\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
			  <tr>
			    <td>
			      <table class=\"moduleborder\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
				<tr>
				  <td class=\"modulex\">
				    <form action=\"admin.php?ind=ad_skin&amp;op=update_section\" name=\"e_b\" method=\"post\">
				    <table width=\"100%\" border=\"0\">
				      <tr>
					<td class=\"titadmin\">{$mklib->lang['ad_section']}: $sec<br /></td>
				      </tr>
				      <tr>
					<td><textarea rows=\"20\" cols=\"80\" style=\"width: 100%\" name=\"testo\" class=\"bgselect\">$testo</textarea></td></td>
				      </tr>
				      <tr>
					  <input type=\"hidden\" name=\"sec\"  value = \"{$sec}\" />
					  <input type=\"hidden\" name=\"file\"  value = \"{$file}\" />
					  <input type=\"hidden\" name=\"start\"  value = \"{$start}\" />
					  <input type=\"hidden\" name=\"end\"  value = \"{$end}\" />
					<td><br /><input type=\"submit\" value=\"{$mklib->lang['ad_save']}\" class=\"bgselect\" /></td>
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
	";
		$output = $Skin->view_block("{$mklib->lang['ad_skin']}", "$output");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}

	function update_section() {
    	global $mkportals, $DB, $mklib, $Skin;

		$filename = $mkportals->input['file'];
		$start = trim($_POST['start']);
		$end = $_POST['end'];
		$mksubs = $_POST['testo'];
		$sec = $_POST['sec'];
		$magic = get_magic_quotes_gpc();
		if ($magic) {
			$mksubs = stripslashes($mksubs);
		}
		$fh = @fopen($filename, "r");
    	if ($fh) {
        	$testo = fread($fh, filesize($filename));
        	@fclose($fh);
		}
		$pos = strpos($testo, $start);
		$pos2 = strpos($testo, $end);
		$testo1 = substr($testo, 0, $pos);
		$testo2 = substr($testo, $pos2);
		$testo = $testo1.$start."\n".$mksubs.$testo2;

		//echo $testo;
		if (!$handle = @fopen($filename, 'w')) {
         	$message = "{$mklib->lang['ad_skin_nofile']}";
			$mklib->error_page($message);
			exit;
   		}
   		if (!fwrite($handle, $testo)) {
       		$message = "{$mklib->lang['ad_skin_nofile']}";
			$mklib->error_page($message);
			exit;
   		}
		fclose($handle);

		$output = "
	<tr>
	  <td><br />
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" align=\"center\" border=\"0\">
	      <tr>
		<td>
		  <table class=\"modulebg\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" border=\"0\">
		    <tr>
		      <td class=\"tdblock\" width=\"100%\" height=\"25\"><img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$mklib->lang['ad_skinm']}</td>
		    </tr>
		    <tr>
		      <td>
			<table class=\"moduleborder\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
			  <tr>
			    <td>
			      <table class=\"moduleborder\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
				<tr>
				  <td class=\"modulex\">
				    <table width=\"100%\" border=\"0\">
			      <tr>
					<td class=\"titadmin\" align=\"center\">
					<br /><br />{$mklib->lang['ad_section']}: [ $sec ] {$mklib->lang['ad_skin_updated']}<br /><br /><br />
					</td>
				      </tr>
				      <tr>
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
	    </table>
	  </td>
	</tr>
	";
		$output = $Skin->view_block("{$mklib->lang['ad_skin']}", "$output");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

  	}
	function editc() {
		global $mkportals, $DB, $mklib, $Skin;

		$file = "./templates/".$mkportals->input['idl']."/style.css";

		$fh = @fopen($file, "r");
    	if ($fh) {
        	$testo = fread($fh, filesize($file));
        	@fclose($fh);
		}


		$output = "
	<tr>
	  <td><br />
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" align=\"center\" border=\"0\">
	      <tr>
		<td>
		  <table class=\"modulebg\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" border=\"0\">
		    <tr>
		      <td class=\"tdblock\" width=\"100%\" height=\"25\"><img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$mklib->lang['ad_skinm']}</td>
		    </tr>
		    <tr>
		      <td>
			<table class=\"moduleborder\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
			  <tr>
			    <td>
			      <table class=\"moduleborder\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
				<tr>
				  <td class=\"modulex\">
				    <form action=\"admin.php?ind=ad_skin&amp;op=update_css\" name=\"e_b\" method=\"post\">
				    <table width=\"100%\" border=\"0\">
				      <tr>
					<td class=\"titadmin\">$file<br /></td>
				      </tr>
				      <tr>
					<td><textarea rows=\"26\" cols=\"80\" style=\"width: 100%\" name=\"testo\" class=\"bgselect\">$testo</textarea></td></td>
				      </tr>
				      <tr>
					  <input type=\"hidden\" name=\"sec\"  value = \"{$sec}\" />
					  <input type=\"hidden\" name=\"file\"  value = \"{$file}\" />
					<td><br /><input type=\"submit\" value=\"{$mklib->lang['ad_save']}\" class=\"bgselect\" /></td>
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
	";
		$output = $Skin->view_block("{$mklib->lang['ad_skin']}", "$output");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}
	function update_css() {
    	global $mkportals, $DB, $mklib, $Skin;

		$filename = $mkportals->input['file'];

		$testo = $_POST['testo'];
		$sec = $_POST['sec'];
		$magic = get_magic_quotes_gpc();
		if ($magic) {
			$testo = stripslashes($testo);
		}

		if (!$handle = @fopen($filename, 'w')) {
         	$message = "{$mklib->lang['ad_skin_nofilec']}";
			$mklib->error_page($message);
			exit;
   		}
   		if (!fwrite($handle, $testo)) {
       		$message = "{$mklib->lang['ad_skin_nofilec']}";
			$mklib->error_page($message);
			exit;
   		}
		fclose($handle);

		$output = "
	<tr>
	  <td><br />
	    <table class=\"moduleborder\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" align=\"center\" border=\"0\">
	      <tr>
		<td>
		  <table class=\"modulebg\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" border=\"0\">
		    <tr>
		      <td class=\"tdblock\" width=\"100%\" height=\"25\"><img src=\"$mklib->images/arrow.gif\" alt=\"\" />{$mklib->lang['ad_skinm']}</td>
		    </tr>
		    <tr>
		      <td>
			<table class=\"moduleborder\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
			  <tr>
			    <td>
			      <table class=\"moduleborder\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
				<tr>
				  <td class=\"modulex\">
				    <table width=\"100%\" border=\"0\">
			      <tr>
					<td class=\"titadmin\" align=\"center\">
					<br /><br />[ $filename ] {$mklib->lang['ad_skin_updated']}<br /><br /><br />
					</td>
				      </tr>
				      <tr>
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
	    </table>
	  </td>
	</tr>
	";
		$output = $Skin->view_block("{$mklib->lang['ad_skin']}", "$output");
		$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

  	}



}

?>
