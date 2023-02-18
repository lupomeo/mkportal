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

$idx = new mk_ad_main;
class mk_ad_main {


	function mk_ad_main() {
		global $mkportals;
		switch($mkportals->input['op']) {
			case 'main_save':
    				$this->main_save();
    			break;
    			default:
    				$this->ad_show();
    			break;
    		}
	}

	function ad_show() {
	global $mkportals, $mklib, $Skin, $MK_BOARD, $MK_TIMEDIFF, $MK_OFFLINE, $MK_EDITOR;
	$mode = $mkportals->input['mode'];
	$sitename = $mklib->sitename;
	$siteurl = $mklib->siteurl;
	$template = $mklib->template;
	$mklang = $mklib->mklang;
	$forumpath = $mklib->forumpath;
	$forumpath = str_replace("/", "", "$forumpath");
	$forumpath = str_replace(".", "", "$forumpath");
	$forumview = $mklib->forumview;
	$portalview = $mklib->portalview;
	$forumcd = $mklib->forumcd;
	$forumcs = $mklib->forumcs;
	$portalwidth = $mklib->portalwidth;
	$columnwidth = $mklib->columnwidth;

	if ($dir = @opendir("templates/")) {
 		 while (($dirt = readdir($dir)) !== false) {
		 if ($MK_BOARD == "OXY" && $dirt == "Forum") {
			continue;
		 }
		 $selected = "";
		 if ($dirt != "." && $dirt != ".." && $dirt != "index.html") {
		 	$check = $mklib->sitepath."mkportal/templates/$dirt";
			if($template == "$check") {
				$selected = "selected=\"selected\"";
			}
   		 	$cselect.= "<option value=\"$dirt\" $selected>$dirt</option>\n";
		 }
  		}
  	closedir($dir);
	}
	if ($dir = @opendir("lang/")) {
 		 while (($dirt = readdir($dir)) !== false) {
		 $selected = "";
		 if ($dirt != "." && $dirt != ".." && $dirt != "index.html") {
		 	$check = $mklib->sitepath."mkportal/lang/$dirt";
			if($mklang == "$check") {
				$selected = "selected=\"selected\"";
			}
   		 	$cselect2.= "<option value=\"$dirt\" $selected>$dirt</option>\n";
		 }
  		}
  	closedir($dir);
	}
//time
$curtime = $mklib->create_date(time());
$timediff = $MK_TIMEDIFF;
switch($timediff) {
	case '1':
    	$se1t2="selected=\"selected\"";
    break;
	case '2':
    	$se1t3="selected=\"selected\"";
    break;
	case '-1':
    	$se1t4="selected=\"selected\"";
    break;
	case '-2':
    	$se1t5="selected=\"selected\"";
    break;
    default:
    	$se1t1="selected=\"selected\"";
    break;
}
$cselect4 = "<option value=\"0\" $se1t1>0</option>\n";
$cselect4 .= "<option value=\"1\" $se1t2>+1</option>\n";
$cselect4 .= "<option value=\"2\" $se1t3>+2</option>\n";
$cselect4 .= "<option value=\"-1\" $se1t4>-1</option>\n";
$cselect4 .= "<option value=\"-2\" $se1t5>-2</option>\n";

//Editor

	$mkeditor = $MK_EDITOR;
	$selected1 = "selected=\"selected\"";
	if ($MK_EDITOR == "BBCODE") {
		$selected1 = "";
		$selected2 = "selected=\"selected\"";
	}

	$cselect3 .= "<option value=\"HTML\" $selected1>HTML</option>\n";
	$cselect3 .= "<option value=\"BBCODE\" $selected2>BBcode</option>\n";

	if ($mode == "saved") {
		$checksave = "{$mklib->lang['ad_saved']}<br /><br />";
   	}
	$checkpv2 = "checked=\"checked\"";
	if ($portalview == "1") {
		$checkpv1 = "checked=\"checked\"";
		$checkpv2 = "";
   	}
	$checkfv2 = "checked=\"checked\"";
	if ($forumview == "1") {
		$checkfv1 = "checked=\"checked\"";
		$checkfv2 = "";
   	}
	$checkfcd1 = "checked=\"checked\"";
	if ($forumcd == "1") {
		$checkfcd1 = "";
		$checkfcd2 = "checked=\"checked\"";
   	}
	$checkfcs1 = "checked=\"checked\"";
	if ($forumcs == "1") {
		$checkfcs1 = "";
		$checkfcs2 = "checked=\"checked\"";
   	}
	$checkoff1 = "checked=\"checked\"";
	if ($MK_OFFLINE == "1") {
		$checkoff1 = "";
		$checkoff2 = "checked=\"checked\"";
   	}
	$subtitle = "{$mklib->lang['ad_preferences']}";

	$content = "
	<tr>
	  <td>

	    <form name=\"main1\" method=\"post\" action=\"admin.php?op=main_save\">
	    <table>
	      <tr>
		<td>
		$checksave
		</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\"><br />{$mklib->lang['ad_boardname']}</td>
	      </tr>
	      <tr>
		<td><input class=\"bgselect\" type=\"text\" name=\"board\" value=\"$MK_BOARD\" size=\"40\" readonly=\"readonly\" /></td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['sitename']}</td>
	      </tr>
	      <tr>
		<td><input class=\"bgselect\" type=\"text\" name=\"sitename\" value=\"$sitename\" size=\"40\" /></td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_siteurl']}</td>
	      </tr>
	      <tr>
		<td><input class=\"bgselect\" type=\"text\" name=\"siteurl\" value=\"$siteurl\" size=\"40\" readonly=\"readonly\" /></td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_skin']}</td>
	      </tr>
	      <tr>
		<td>
		  <select class=\"bgselect\" size=\"1\" name=\"template\">
		  {$cselect}
		  </select>
		</td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_lang']}</td>
	      </tr>
	      <tr>
		<td>
		  <select class=\"bgselect\" size=\"1\" name=\"mklang\">
		  {$cselect2}
		  </select>
		</td>
	      </tr>
		  <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_editor']}</td>
		</tr>
	<tr>
	<td>
	<select class=\"bgselect\" size=\"1\" name=\"mkeditor\">
	{$cselect3}
	</select>
	</td>
	</tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_fpath']}</td>
	      </tr>
	      <tr>
		<td><input class=\"bgselect\" type=\"text\" name=\"forumpath\"  value=\"$forumpath\" size=\"40\" readonly=\"readonly\" /></td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_mkview']}</td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_mkviewsmall']}<input type=\"radio\" value=\"1\" name=\"portalview\" $checkpv1 />{$mklib->lang['ad_mkviewlarge']}<input type=\"radio\" value=\"0\" name=\"portalview\" $checkpv2 /></td>
	      </tr>
		  <tr>
		<td>{$mklib->lang['ad_powidth']}</td>
	      </tr>
	      <tr>
		<td><input class=\"bgselect\" type=\"text\" name=\"portalwidth\"  value=\"$portalwidth\" size=\"5\" /></td>
	      </tr>
		  <tr>
		<td>{$mklib->lang['ad_cowidth']}</td>
	      </tr>
	      <tr>
		<td><input class=\"bgselect\" type=\"text\" name=\"columnwidth\"  value=\"$columnwidth\" size=\"5\" /></td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_forumview']}</td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_forumin']}<input type=\"radio\" value=\"1\" name=\"forumview\" $checkfv1 />{$mklib->lang['ad_forumout']}<input type=\"radio\" value=\"0\" name=\"forumview\" $checkfv2 /></td>
	      </tr>
		  <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_rightcolumn']}</td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_yes']}<input type=\"radio\" value=\"0\" name=\"forumcd\" $checkfcd1 />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"1\" name=\"forumcd\" $checkfcd2 /></td>
	      </tr>
	      <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_leftcolumn']}</td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_yes']}<input type=\"radio\" value=\"0\" name=\"forumcs\" $checkfcs1 />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"1\" name=\"forumcs\" $checkfcs2 /></td>
	      </tr>
		  <tr>
		<td class=\"titadmin\">{$mklib->lang['ad_sytime']}</td>
	      </tr>
	      <tr>
		 <td>{$mklib->lang['ad_curtime']} <b>$curtime</b></td>
	      </tr>
		  <tr>
		<td>
			{$mklib->lang['ad_diftime']}
		  <select class=\"bgselect\" size=\"1\" name=\"timediff\">
		  {$cselect4}
		  </select>
		</td>
	      </tr>
		<tr>
		<td class=\"titadmin\"><span class=\"mktxtcontr\">{$mklib->lang['putoff']}</span></td>
	      </tr>
	      <tr>
		<td>{$mklib->lang['ad_yes']}<input type=\"radio\" value=\"1\" name=\"offline\" $checkoff2 />{$mklib->lang['ad_no']}<input type=\"radio\" value=\"0\" name=\"offline\" $checkoff1 /></td>
	      </tr>
		  <tr>
		<td colspan=\"2\" class=\"titadmin\"><br />
		  <input type=\"submit\" value=\"{$mklib->lang['ad_save']}\" name=\"B1\" />
		</td>
	      </tr>
	    </table>
	    </form>

	  </td>
	</tr>
	";
	$output = $Skin->view_block("$subtitle", "$content");
	$mklib->printpage_admin("{$mklib->lang['ad_titlepage']}", $output);

	}
	function main_save() {
	global $mkportals, $mklib, $Skin, $DB, $MK_BOARD;
	$forumpath = $mkportals->input['forumpath'];
	$forumview = $mkportals->input['forumview'];
	$portalview = $mkportals->input['portalview'];
	$forumcd = $mkportals->input['forumcd'];
	$forumcs = $mkportals->input['forumcs'];
	$sitename = $mkportals->input['sitename'];
	$siteurl = $mkportals->input['siteurl'];
	$template = $mkportals->input['template'];
	$mklang = $mkportals->input['mklang'];
	$offline = $mkportals->input['offline'];
	$timediff = $mkportals->input['timediff'];
	$columnwidth = $mkportals->input['columnwidth'];
	$portalwidth = $mkportals->input['portalwidth'];
	$mkeditor = $mkportals->input['mkeditor'];

	$content = "<?php\n\n \$FORUM_PATH = \"$forumpath\"; \n \$FORUM_VIEW = \"$forumview\"; \n \$PORTAL_VIEW = \"$portalview\"; \n \$FORUM_CD = \"$forumcd\"; \n \$FORUM_CS = \"$forumcs\"; \n \$SITE_NAME = \"$sitename\";  \n \$SITE_URL = \"$siteurl\"; \n \$MK_TEMPLATE = \"$template\";\n \$MK_LANG = \"$mklang\";\n \$MK_EDITOR = \"$mkeditor\";\n \$MK_BOARD = \"$MK_BOARD\";\n \$MK_TIMEDIFF = \"$timediff\";\n \$MK_OFFLINE = \"$offline\";\n \$MK_PORTALWIDTH = \"$portalwidth\";\n \$MK_COLUMNWIDTH = \"$columnwidth\";\n ?>";
		$filename = "conf_mk.php";
   		if (!$handle = fopen($filename, 'w')) {
         	$message = "Non posso aprire il file conf_mk.php assicurati che abbia i permessi impostati in lettura e scrittura.";
			$mklib->error_page($message);
			exit;
   		}
   		if (!fwrite($handle, $content)) {
       		$message = "Non posso aprire il file conf_mk.php assicurati che abbia i permessi impostati in lettura e scrittura.";
			$mklib->error_page($message);
			exit;
   		}
		fclose($handle);
		$DB->close_db();
		Header("Location: admin.php?mode=saved");
		exit;

	}



}

?>
