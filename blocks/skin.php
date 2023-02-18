<?php
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

$content = $mklib_board->skinselect();

if (!$content) {
	$content = "
				<tr>
				  <td id=\"tdblock\" align=\"center\">
				  {$this->lang['no_selectskin']}
				  </td>
				</tr>
		    ";
}

?>
