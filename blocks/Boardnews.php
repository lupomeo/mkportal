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


$out = $mklib_board->get_board_news();

$content = "
				<tr>
				  <td class=\"contents\">
				    <div class=\"taburlo\">
				      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
					<tr>
					  <td class=\"taburlo\" valign=\"top\">
					    {$out}
					  </td>
					</tr>
				      </table>
				    </div>
				  </td>
				</tr>
 ";


?>
