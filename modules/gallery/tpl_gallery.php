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

class tpl_gallery {


function gallery_show($navbar, $maintit, $content, $submit, $stat, $toolbar, $pages, $utonline) {
global $mkportals, $mklib;
return <<<EOF

<tr>
  <td>
<script type="text/javascript">
      <!--
	function selChd(jumpsection) {
         var selIdx = jumpsection.selectedIndex;
		 var newSel = jumpsection.options[selIdx].value;
         location.href='index.php?ind=gallery&op=section_view&idev=' + newSel;
    }
	function selChoc(jumpsection) {
         var selIdx = jumpsection.selectedIndex;
		 var newSel = jumpsection.options[selIdx].value;
         location.href='index.php?ind=gallery&order=' + newSel;
    }
	function selChoe(jumpsection, idev) {
         var selIdx = jumpsection.selectedIndex;
		 var newSel = jumpsection.options[selIdx].value;
         location.href='index.php?ind=gallery&op=section_view&idev=' + idev + '&order=' + newSel;
    }
      //-->
</script>
  <br />
    <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
	<td width="1" align="left">
	<img src="$mklib->images/locbar.gif" alt="" />
	</td>
	<td align="left" style="text-align:left;">
	{$navbar}
	</td>
	<td align="right" style="text-align:right;" class="modulelite">
	$submit
	</td>
      </tr>
    </table>
    <br />
    <table width="98%" border="0" cellspacing="1" cellpadding="0" align="center" class="moduleborder">
      <tr>
	<td>
	  <table width="100%" border="0" cellpadding="0" cellspacing="2" class="modulebg">
            <tr>
              <td width="100%" height="25" class="tdblock"> <img src="$mklib->images/arrow.gif" alt="" />{$maintit}</td>
	    </tr>
            <tr>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="1" cellpadding="5" style="text-align:left;">
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
    <table width="98%" border="0" cellspacing="1" cellpadding="0" align="center" class="moduleborder">
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
                          <td class="modulex" colspan="2" style="text-align:left;">
                          {$mklib->lang['gat_stats']}
                          </td>
                        </tr>
                        <tr>
                          <td width="40" align="center" class="modulecell"><img src="$mklib->images/stats.gif" alt="" /></td>
                          <td class="modulecell" style="text-align:left;">{$stat}</td>
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
	    <td class="start" width="*" align="left">
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
      <td align="center"><br /><br />
      <div align="center"><a href="http://www.mkportal.it" target="_blank">MKPGallery - ©2004 Tutti i diritti riservati</a></div>
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

<!-- START explaincatparent START -->
                        <tr>
                          <th class="modulex" width="80">{$mklib->lang['gat_prev']}</th>
                          <th class="modulex" width="*" colspan="2" style="text-align:left;">{$mklib->lang['ga_category']}</th>
			  <th class="modulex" width="100" align="center">{$mklib->lang['gat_subcat']}</th>
                          <th class="modulex" width="100" align="center">{$mklib->lang['gat_images']}</th>
                          <th class="modulex" width="100" style="text-align:left;">{$mklib->lang['gat_lentry']}</th>
                        </tr>
EOF;
}
function row_main_category_content($name, $image, $description, $totfile, $lastentry, $checksub) {
global $mkportals;
return <<<EOF
			<tr>
                          <td class="modulecell" width="80" align="center">{$image}</td>
                          <td class="modulecell" width="*" colspan="2" style="text-align:left;"><b>{$name}</b><br /><span class="modulelite">{$description}</span></td>
			  <td class="modulecell" width="100" align="center">{$checksub}</td>
			  <td class="modulecell" width="100" align="center">{$totfile}</td>
                          <td class="modulecell" width="150" style="text-align:left;">{$lastentry}</td>
			</tr>
EOF;
}

function row_entry($id, $name, $description, $click, $trate, $rate, $width2, $width, $autore, $peso, $dimensioni, $cdata) {
global $mkportals, $mklib;

if($mklib->member['g_send_comments'] || $mkportals->member['g_access_cp']) {
    $comment_pic = "<a href=\"index.php?ind=gallery&amp;op=submit_comment&amp;ide={$id}\"><img src=\"$mklib->images/comment.gif\" border=\"0\" alt=\"\" /></a>";
    $comment_text = "<a href=\"index.php?ind=gallery&amp;op=submit_comment&amp;ide={$id}\">{$mklib->lang['ga_insertcom']}</a>";
}
else {
    $comment_pic = "";
    $comment_text = "";
}

return <<<EOF

			<tr>
                          <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['gat_name']}</td>
                          <td class="modulecell" width="80%" align="left"><b>{$name}</b></td>
			</tr>
			<tr>
                          <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['ga_des']}</td>
                          <td class="modulecell" width="80%" align="left">{$description}</td>
			</tr>
			<tr>
                          <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['gat_sendby']}</td>
                          <td class="modulecell" width="80%" align="left">{$autore}</td>
			</tr>
			<tr>
                          <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['gat_sdate']}</td>
                          <td class="modulecell" width="80%" align="left">{$cdata}</td>
			</tr>
			<tr>
                          <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['gat_wei']}</td>
                          <td class="modulecell" width="80%" align="left">{$peso}</td>
			</tr>
			<tr>
                          <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['gat_dim']}</td>
                          <td class="modulecell" width="80%" align="left">{$dimensioni}</td>
			</tr>
			<tr>
                            <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['gat_clicks']}</td>
                            <td class="modulecell" width="80%" align="left">{$click}</td>
			</tr>

			<tr>
                          <td class="modulecell" width="20%" valign="top" align="left">{$mklib->lang['gat_score']}</td>
                          <td class="modulecell" width="80%" align="left">{$mklib->lang['gat_votes']}: {$trate} - {$mklib->lang['gat_average']}: {$rate} <img src="$mklib->images/spacer.gif" width="{$width2}" height="5" alt="" /><br /><img src="$mklib->images/scale.gif" width="129" alt="" /><br /><img src="$mklib->images/bar-start.gif" height="11" alt="" /><img src="$mklib->images/bar.gif" width="{$width}" height="11" alt="" /><img src="$mklib->images/bar-end.gif" height="11" alt="" /></td>
			</tr>

			<tr>
			  <td class="modulecell" colspan="2">
                            <table width="50%" align="center">
                              <tr>
				<td align="center" class="functions" width="200"><a href="index.php?ind=gallery&amp;op=submit_postcard&amp;ide={$id}"><img src="$mklib->images/ecards.gif" border="0" alt="" /></a></td>
				<td align="center" class="functions" width="200">$comment_pic</td>
				<td align="center" class="functions" width="200"><a href="index.php?ind=gallery&amp;op=submit_rate&amp;ide={$id}"><img src="$mklib->images/rate.gif" border="0" alt="" /></a></td>
                              </tr>
                              <tr>
				<td align="center" class="functions" width="200"><a href="index.php?ind=gallery&amp;op=submit_postcard&amp;ide={$id}">{$mklib->lang['gat_pcard']}</a></td>
				<td align="center" class="functions" width="200">$comment_text</td>
				<td align="center" class="functions" width="200"><a href="index.php?ind=gallery&amp;op=submit_rate&amp;ide={$id}">{$mklib->lang['gat_votenow']}</a></td>
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
