<?php
/*
+--------------------------------------------------------------------------
|   MkPortal
|   ========================================
|   by Meo <Amedeo de longis>
|   (c) 2003 - 2004 mkportal.it
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

class tpl_downloads {


function downloads_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $pages, $utonline) {
global $mkportals, $mklib;
return <<<EOF
<tr align="center">
<td>

<script type="text/javascript">
      <!--
	function selChd(jumpsection) {
         var selIdx = jumpsection.selectedIndex;
		 var newSel = jumpsection.options[selIdx].value;
         location.href='index.php?ind=downloads&op=section_view&idev=' + newSel;
    }
	function selChoc(jumpsection) {
         var selIdx = jumpsection.selectedIndex;
		 var newSel = jumpsection.options[selIdx].value;
         location.href='index.php?ind=downloads&order=' + newSel;
    }
	function selChoe(jumpsection, idev) {
         var selIdx = jumpsection.selectedIndex;
		 var newSel = jumpsection.options[selIdx].value;
         location.href='index.php?ind=downloads&op=section_view&idev=' + idev + '&order=' + newSel;
    }
      //-->
</script>

<br />
<table width="98%" border="0" cellspacing="0" cellpadding="0" style="text-align:left;" align="center">
  <tr>
    <td width="25">
    <img src="$mklib->images/locbar.gif" alt="" />
    </td>
    <td width="60%">
    {$navbar}
    </td>
	<td width="*" align="right" style="text-align:right;" class="modulelite">
    $submit  <a href="index.php?ind=downloads&amp;op=search">[ {$mklib->lang['dw_search']} ]</a>
    </td>
  </tr>
</table>
<br />
<table width="98%" border="0" cellspacing="1" cellpadding="0" style="text-align:left;" class="moduleborder">
  <tr>
    <td>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" class="modulebg">
        <tr>
          <td width="100%" height="25" class="tdblock"> <img src="$mklib->images/arrow.gif" alt="" />{$maintit}</td>
        </tr>
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                  <table width="100%" border="0" cellspacing="1" cellpadding="5">
		  {$content}
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
{$toolbar}
<br />
<table width="98%" border="0" cellspacing="1" cellpadding="0" style="text-align:left;" class="moduleborder">
  <tr>
    <td>
      <table width="100%" border="0" cellpadding="0" cellspacing="2" class="modulebg">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                  <table width="100%" border="0" cellspacing="1" cellpadding="5">
                    <tr>
                      <td class="modulex" colspan="2">
                        {$mklib->lang['dw_stat']}
                      </td>
                    </tr>
                    <tr>
                      <td width="40" align="center" class="modulecell"><img src="$mklib->images/stats.gif" alt="" /></td>
                      <td class="modulecell">{$stat}</td>
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
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="modulebg">
      <table width="100%" border="0" cellspacing="0" cellpadding="4" align="right">
        <tr>
          <td width="*" align="left" class="start">
            {$pages}
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<table width="98%" class="moduleborder" border="0" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td class="modulebg">
      <table width="100%" border="0" cellspacing="0" cellpadding="4" align="right">
        <tr>
          <td class="modulex" width="*" align="left">
            {$utonline}
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<table width="98%" align="center">
  <tr>
    <td align="center">
      <br /><br /><div align="center"><a href="http://www.mkportal.it" target="_blank">MKPDownloads - ©2004 Tutti i diritti riservati</a></div>
    </td>
  </tr>
</table>
</td>
</tr>
EOF;
}

function row_main_category() {
global $mkportals, $mklib;
return <<<EOF
<tr>
  <th class="modulex" width="40">&nbsp;</th>
  <th class="modulex" width="*" colspan="2">{$mklib->lang['dw_mcat']}</th>
  <th class="modulex" width="100" align="center">{$mklib->lang['dw_subcat']}</th>
  <th class="modulex" width="100" align="center">{$mklib->lang['dw_file']}</th>
  <th class="modulex" width="150" align="center">{$mklib->lang['dw_lastentry']}</th>
</tr>
EOF;
}
function row_main_category_content($name, $description, $totfile, $lastentry, $link, $cecksub) {
global $mkportals, $mklib;
return <<<EOF
<tr>
  <td class="modulecell" width="40" align="center">$link</td>
  <td class="modulecell" width="*" colspan="2"><b>{$name}</b><br /><span class="modulelite">{$description}</span></td>
  <td class="modulecell" width="100" align="center">{$cecksub}</td>
  <td class="modulecell" width="100" align="center">{$totfile}</td>
  <td class="modulecell" width="150" align="center">{$lastentry}</td>
</tr>
EOF;
}

function row_main_entries() {
global $mkportals, $mklib;
return <<<EOF
<tr>
  <th class="modulex" width="40">&nbsp;</th>
  <th class="modulex" width="*">{$mklib->lang['dw_name']}</th>
  <th class="modulex" width="75" align="center">{$mklib->lang['dw_votes']}</th>
  <th class="modulex" width="75" align="center">{$mklib->lang['dw_ptitle']}</th>
  <th class="modulex" width="75" align="center">{$mklib->lang['dw_clicks']}</th>
  <th class="modulex" width="150" align="center">{$mklib->lang['dw_insdate']}</th>
</tr>
EOF;
}

function row_main_entries_content($name, $trate, $downloads, $click, $data) {
global $mkportals, $mklib;
return <<<EOF
<tr>
  <td class="modulecell" width="40" align="center"><img src="$mklib->images/entry.gif" alt="" /></td>
  <td class="modulecell" width="*">{$name}</td>
  <td class="modulecell" width="75" align="center">{$trate}</td>
  <td class="modulecell" width="75" align="center">{$downloads}</td>
  <td class="modulecell" width="75" align="center">{$click}</td>
  <td class="modulecell" width="150" align="center">{$data}</td>
</tr>
EOF;
}


function row_entry($id, $name, $description, $file, $trate, $rate, $width2, $width, $screens, $demo, $autore, $peso) {
global $mkportals, $mklib;

if($mklib->member['g_send_comments'] || $mkportals->member['g_access_cp']) {
    $comment_pic = "<a href=\"index.php?ind=downloads&amp;op=submit_comment&amp;ide={$id}\"><img src=\"$mklib->images/comment.gif\" border=\"0\" alt=\"\" /></a>";
    $comment_text = "<a href=\"index.php?ind=downloads&amp;op=submit_comment&amp;ide={$id}\">{$mklib->lang['dw_insertcomm']}</a>";
}
else {
    $comment_pic = "";
    $comment_text = "";
}
if ($width > 0) {
    $bar = "<img src=\"$mklib->images/bar-start.gif\" height=\"11\" alt=\"\" /><img src=\"$mklib->images/bar.gif\" width=\"{$width}\" height=\"11\" alt=\"\" /><img src=\"$mklib->images/bar-end.gif\" height=\"11\" alt=\"\" />";
    $scala = "<img src=\"$mklib->images/spacer.gif\" width=\"{$width2}\" height=\"5\" alt=\"\" /><br /><img src=\"$mklib->images/scale.gif\" width=\"129\" alt=\"\" />";
}
return <<<EOF

<tr>
  <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['dw_name']}</td>
  <td class="modulecell" width="80%" align="left"><b>{$name}</b></td>
</tr>
<tr>
  <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['dw_description']}</td>
  <td class="modulecell" width="80%" align="left">{$description}</td>
</tr>

<tr>
  <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['dw_sendby']}</td>
  <td class="modulecell" width="80%" align="left">{$autore}</td>
</tr>

<tr>
  <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['dw_dim']}</td>
  <td class="modulecell" width="80%" align="left">{$peso}</td>
</tr>

<tr>
  <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['dw_score']}</td>
  <td class="modulecell" width="80%" align="left">{$mklib->lang['dw_votes']}: {$trate} - {$mklib->lang['dw_average']}: {$rate} $scala<br />$bar</td>
</tr>

<tr>
  <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['dw_screens']}</td>
  <td class="modulecell" width="80%" align="left">$screens</td>
</tr>

<tr>
  <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['dw_demourl']}</td>
  <td class="modulecell" width="80%" align="left">$demo</td>
</tr>

<tr>
  <td class="modulecell" colspan="2">
    <table width="50%" align="center">
      <tr>
        <td align="center" class="functions" width="200"><a href="index.php?ind=downloads&amp;op=download_file&amp;ide={$id}&amp;file={$file}"><img src="$mklib->images/view.gif" border="0" alt="" /></a></td>
	<td align="center" class="functions" width="200">$comment_pic</td>
	<td align="center" class="functions" width="200"><a href="index.php?ind=downloads&amp;op=submit_rate&amp;ide={$id}"><img src="$mklib->images/rate.gif" border="0" alt="" /></a></td>
      </tr>
      <tr>
        <td align="center" class="functions" width="200"><a href="index.php?ind=downloads&amp;op=download_file&amp;ide={$id}&amp;file={$file}">{$mklib->lang['dw_dwfile']}</a></td>
	<td align="center" class="functions" width="200">$comment_text</td>
	<td align="center" class="functions" width="200"><a href="index.php?ind=downloads&amp;op=submit_rate&amp;ide={$id}">{$mklib->lang['dw_sendvote']}</a></td>
      </tr>
    </table>
  </td>
</tr>

EOF;
}

function row_toolbar($jump, $sort) {
global $mkportals, $mklib;
return <<<EOF
<table width="98%" border="0" cellspacing="4" cellpadding="0" align="center">
  <tr>
    <td>
      <table width="320" border="0" cellpadding="3" cellspacing="1" class="moduleborder" align="right">
	<tr>
     	  <td align="right" class="modulex">
       	    {$jump}
	    &nbsp;
       	    {$sort}
    	  </td>
	</tr>
      </table>
    </td>
  </tr>
</table>
EOF;
}



}
?>
