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


	$limit = 5;
	$cut = 60;

$content = "";

	$query = $DB->query( "SELECT id, name, description FROM mkp_download WHERE validate = '1' ORDER BY `id` DESC LIMIT $limit");

	while( $row = $DB->fetch_row() ) {
		$idu = $row['id'];
		$umes = "";
		$message = substr($row['description'], 0, $cut);
		$message = str_replace("<br>", " ", $message);
		$message = explode(" ", $message);
		foreach ($message as $value) {
			if (strlen($value) > 20) {
				 $value = substr($value, 0, 22);
			}
   			$umes .= $value." ";
		}

		$content.= "
				<tr>
				  <td class=\"tdblock\"><a href=\"$this->siteurl/index.php?ind=downloads&amp;op=entry_view&amp;iden=$idu\" class=\"uno\">{$row['name']}</a>
				  </td>
				</tr>";
		$content .= "
				<tr>
				  <td class=\"tdglobal\">$umes ...
				  </td>
				</tr>";
	}

	if($idu == NULL) {
			$content = "
				<tr>
				  <td class=\"tdblock\" align=\"center\">
				  {$this->lang['down_not']}
				  </td>
				</tr>
			";
	}

	if(!$mkportals->member['g_access_cp'] && !$this->member['g_access_download']) {
			$content = "
				<tr>
				  <td class=\"tdblock\" align=\"center\">
				  {$this->lang['down_noallow']}
				  </td>
				</tr>
			";
	}
	unset($row);
	unset($umes);
	unset($message);
	unset($idu);

?>
