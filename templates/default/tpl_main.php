<?
/*
+--------------------------------------------------------------------------
|   MkPortal "default" Portal Template
|   ========================================
|   by Meo aka Luponero <Amedeo de longis>
|      visiblesoul <Don K. Colburn>	
|   (c) 2004-2005 mkportal.it
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

class tpl_main {

function view_header($title, $css, $js, $pmk_js, $board_header) {
global $mklib, $mklib_board;
//$css = $mklib_board->import_css();
return <<<EOF

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<!-- begin document head -->

<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <meta name="generator" content="MKPortal" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta content="no-cache" http-equiv="no-cache" />
  <meta http-equiv="Cache-Control" content="no-cache" />
  {$title}
  {$css}
  {$board_header}
  <script type="text/javascript" src="{$js}"></script>
   {$pmk_js}
</head>

<body onload="javascript:GetPos()">

<!-- end document head -->

EOF;
}

function open_main($mainwidth) {
global $mklib;
return <<<EOF

<!-- begin open main table -->

<div id="mkwrapper" style="width: {$mainwidth};">
<table class="tabmain" width="100%" align="center" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td width="100%" align="center">

      <table border="0" width="100%" cellpadding="0" cellspacing="0">

<!-- end open main table -->

EOF;
}

function view_logo() {
global $mklib;
return <<<EOF

<!-- begin logostrip -->
  
	<tr>
	  <td id="mklogostrip" style="background-image: url('$mklib->images/sf_logo.jpg')" width="100%">
          <a href="$mklib->siteurl/index.php"><img src="$mklib->images/logo.gif" border="0" alt="" /></a>
          </td>
	</tr>
	
<!-- end logostrip -->

EOF;
}

function view_linkbar($row_link) {
global $mklib, $mkportals;
return <<<EOF

<!-- begin linkbar -->

	<tr>
	  <td>
	    <table width="100%" align="center" cellspacing="0" cellpadding="2" border="0">
	      <tr>
		<td class="navigatore" style="padding: 4px;">		  
		  $row_link&nbsp;		  
		</td>
	      </tr>
	    </table>
	  </td>
	</tr>

<!-- end linkbar -->

EOF;
}

function view_urlo($urlo1, $urlo2) {
global $mklib;
return <<<EOF

<!-- begin shoutbox -->

	<tr align="left">
	  <td>	  
	    <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
	      <tr>
		<td class="urlo" style="background-image: url('$mklib->images/m_sf.gif')" width="100%" valign="bottom" nowrap="nowrap">
		{$mklib->lang['urlolast']} - $urlo1
		</td>		
	      </tr>
	      <tr>
		<td class="urlo2" colspan="2">$urlo2
		</td>
	      </tr>
	    </table>         
	  </td>
	</tr>

<!-- end shoutbox -->
	
EOF;
}

function view_separator_h() {
global $mklib;
return <<<EOF

<!-- begin horizontal spacer -->

<!-- separatore orizzontale 
	<tr align="center">
	  <td class="trattini"><img src="$mklib->images/punto_or.gif" width="1" height="1" alt="" />
	  </td>
	</tr> -->

<!-- end horizontal spacer -->

EOF;
}

function open_body() {
global $mklib;
return <<<EOF

<!-- begin open portal body -->

	<tr align="center">
	  <td width="100%">
	    <table border="0" width="100%" cellspacing="0" cellpadding="0">
	      <tr>

<!-- end open portal body -->
	      
EOF;
}

function view_column_left($blocks) {
global $mklib;

return <<<EOF

<!-- begin left column -->

		<td id="menusx" valign="top" align="left">
		<div id="menucontents" style="$mklib->menucontents">
		<div style="text-align:right;"><a href="javascript:ColumnClose('menusx');MemoPos('MKmenusx', '1');"><img src="$mklib->images/f2.gif" border="0" alt="" /></a>&nbsp;</div>
		  <table cellpadding="0" cellspacing="2" border="0" style="width: {$mklib->columnwidth}px;">
		  {$blocks}
		  </table>
		</div>
		<div id="menucloseds" style="$mklib->menucloseds">
		<div style="text-align:right;"><a href="javascript:ColumnOpen('menusx');MemoPos('MKmenusx', '0');"><img src="$mklib->images/f1.gif" border="0"  alt="" /></a></div>
		</div>
		</td>

<!-- end left column -->

EOF;
}


function view_separator_v() {
global $mklib;
return <<<EOF

<!-- begin column spacer -->

		<td class="vspacer" width="0%" align="left" style="background-image: url('$mklib->images/punto_vert.gif')"><img src="$mklib->images/punto_vert.gif" width="6" height="3" alt="" />
		</td>

<!-- end column spacer -->

EOF;
}

function view_column_center($blocks) {
global $mklib;
return <<<EOF

<!-- begin center column -->

		<td valign="top" align="left" width="100%">
		  <table cellpadding="0" cellspacing="3" border="0" width="100%">
		  {$blocks}
		  </table>
		</td>

<!-- end center column -->
		
EOF;
}

function view_column_right($blocks) {
global $mklib;
return <<<EOF

<!-- begin right column -->

		<td id="menudx" valign="top" align="left">
		<div id="menucontentr" style="$mklib->menucontentr">
		<div style="text-align:left;">&nbsp;<a href="javascript:ColumnClose('menudx');MemoPos('MKmenudx', '1')"><img src="$mklib->images/f1.gif" border="0" alt="" /></a></div>
		  <table cellpadding="0" cellspacing="2" border="0" style="width: {$mklib->columnwidth}px;">
		  {$blocks}
		  </table>
		</div>
		<div id="menuclosedr" style="$mklib->menuclosedr">
		<div style="text-align:left;"><a href="javascript:ColumnOpen('menudx');MemoPos('MKmenudx', '0')"><img src="$mklib->images/f2.gif" border="0" alt="" /></a></div>
		</div>
		</td>
		
<!-- end right column -->

EOF;
}

function close_body() {
global $mklib;
return <<<EOF

<!-- begin close portal body -->

	      </tr>
	    </table>
	  </td>
	</tr>
	
<!-- end close portal body -->

EOF;
}

function close_main() {
global $mklib;
return <<<EOF

<!-- begin close main table -->

      </table>

    </td>
  </tr>
</table>
</div>

<!-- end close main table -->

EOF;
}


function view_footer($block) {
global $mklib;
return <<<EOF

<!-- begin footer -->
<!-- you can add your credits here  -->

<!-- end footer -->
  <p align="center">{$block}</p>

</body>
</html>

<!-- end footer -->

EOF;
}

function view_block($title, $content) {
global $mklib;
return <<<EOF

<!-- begin block template -->

		    <tr>
		      <td valign="top">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			  <tr>
			    <td>
			      <table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
				  <td class="tdmenblock" width="1%"><img src="$mklib->images/m_sx.gif" border="0" class="tdmenblock" alt="" />
				  </td>
				  <td class="sottotitolo" width="99%" style="background-image: url('$mklib->images/m_sf.gif')" valign="middle" nowrap="nowrap">{$title}
				  </td>
				  <td class="tdmenblock" width="1%"><img src="$mklib->images/m_dx.gif" border="0" class="tdmenblock" alt="" />
				  </td>
				</tr>
			      </table>
			    </td>
			  </tr>
			  <tr>
			    <td class="tablemenu" width="100%">
			      <table border="0" width="100%" cellpadding="1" cellspacing="1">
			      {$content}
			      </table>
			    </td>
			  </tr>
			  <tr>
			    <td>
			      <table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
				  <td class="tdmenblock" width="1%" align="right" valign="top"><img src="$mklib->images/m_sx2.gif" class="tdmenblock" alt="" />
				  </td>
				  <td class="tdmenblock" width="99%" style="background-image: url('$mklib->images/m_sf2.gif')"><img src="$mklib->images/m_sf2.gif" border="0" class="tdmenblock" alt="" />
				  </td>
				  <td class="tdmenblock" width="1%"><img src="$mklib->images/m_dx2.gif" class="tdmenblock" alt="" />
				  </td>
				</tr>
			      </table>
			    </td>
			  </tr>
			</table>
		      </td>
		    </tr>
		    <tr>
		      <td class="tdspacer">&nbsp;
		      </td>
		    </tr>

<!-- end block template -->		    

EOF;
}

function row_link( $icon, $url, $text) {
global $mklib;
return <<<EOF

<!-- begin link template -->

		&nbsp;<img src="$icon" border="0" style="vertical-align: middle;" alt="" />&nbsp;<a class="uno" $url>$text</a>

<!-- end link template -->

EOF;
}

function view_quote($content, $author) {
global $mklib;
return <<<EOF
<!-- begin mkportal quote -->
<table class="mkquotetable" style="margin-top: 5px; margin-bottom: 5px; width: auto;" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">	
	<tr>
	  <td valign="bottom">
	    <table border="0" cellpadding="0" cellspacing="0">	      
	      <tr>
		<td valign="top" width="26"><img src="$mklib->images/quote/mkquote_balloon_l.gif" height="23" width="26" alt="" /></td>
		<td style="background-image: url($mklib->images/quote/mkquote_balloon_bg.gif); background-position: center; padding-bottom: 3px;" valign="middle" nowrap="nowrap">
		  <span class="mkquoteball"><b>{$mklib->lang['editor_quote']}</b> $author</span>
		</td>
		<td valign="top"><img src="$mklib->images/quote/mkquote_balloon_r.gif" height="23" width="26" alt="" /></td>
	      </tr>	      
	    </table>
	  </td>	  
        
	  <td align="right" valign="bottom" width="100%">
	    <table border="0" cellpadding="0" cellspacing="0" width="100%">	      
	      <tr>
		<td width="100%">
		  <table border="0" cellpadding="0" cellspacing="0" width="100%">		    
		    <tr>
		      <td style="background-image: url($mklib->images/quote/mkquote_top_bg.gif);" valign="middle" width="100%"></td>
		      <td align="left" valign="top"><img src="$mklib->images/quote/mkquote_top_r.gif" height="23" width="13" alt="" /></td>
		    </tr>		    
		  </table>
		</td>
	      </tr>	      
	    </table>
	  </td>
	</tr>	
      </table>

      <table border="0" cellpadding="0" cellspacing="0" width="100%">	
	<tr>
	  <td style="background-image: url($mklib->images/quote/mkquote_left_bg.gif);" width="13"></td>
	  <td class="mkquotetext" bgcolor="#ffffff" valign="top" width="100%">
	    <i>$content</i>
	  </td>
	  <td style="background-image: url($mklib->images/quote/mkquote_right_bg.gif);" width="13"></td>
	</tr>
	<tr>
	  <td valign="bottom" height="9" width="13"><img src="$mklib->images/quote/mkquote_bot_l.gif" alt="" /></td>
	  <td style="background-image: url($mklib->images/quote/mkquote_bot_bg.gif);" width="100%"></td>
	  <td valign="bottom" height="9" width="13"><img src="$mklib->images/quote/mkquote_bot_r.gif" alt="" /></td>
	</tr>	
      </table>
    </td>
  </tr>  
</table>
<!-- end mkportal quote -->
EOF;
}

}

$Skin = new tpl_main;

?>
