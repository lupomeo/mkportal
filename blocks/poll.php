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
$content = "";
$poll_active = $this->config['poll_active'];
if ($poll_active) {
	$content = $mklib_board->get_poll_active($poll_active);
}

if (!$content) {
	$content = "
				<tr>
				  <td class=\"tdblock\" align=\"center\">
				  {$this->lang['no_activepoll']}
				  </td>
				</tr>
		   ";
}

unset ($poll_active);
?>
