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

$limit = $this->config['urlo_block'];
if (!$limit) {
	$limit = 5;
}
$content = "";

	$link_user = $mklib_board->forum_link("profile");

	$DB->query( "SELECT id, idaut, name, message FROM mkp_urlobox ORDER BY `id` DESC LIMIT $limit");
	while( $urlo = $DB->fetch_row() ) {
		$idu = $urlo['id'];
		$umes = "";
		$message = str_replace("<br />", " ", $urlo['message']);
		$message = str_replace("<br>", " ", $message);
		$message = $this->decode_bb($message);
		$message = str_replace("\n", " ", $message);
		$message = strip_tags($message);
		$message = explode(" ", $message);
		foreach ($message as $value) {
			if (strlen($value) > 20 && !strpos($value, "\'http") && !strpos($value, "\"http") && !strpos($value, "emo")) {
				 $value = substr($value, 0, 20);
			}
   			$umes .= $value." ";
		}
		$umes = $this->decode_bb($umes);
		$content.= "
				<tr>
				  <td class=\"tdblock\">{$this->lang['from']}: <a href=\"$link_user={$urlo['idaut']}\" class=\"uno\">{$urlo['name']}</a>
				  </td>
				</tr>
				";
		$content .= "
				<tr>
				  <td class=\"tdglobal\">$umes
				  </td>
				</tr>
				";
	}

	if($idu == NULL) {
			$content = "
				<tr>
				  <td class=\"tdblock\" align=\"center\">
				  {$this->lang['urlo_not']}
				  </td>
				</tr>
				";
	}

	if(!$mkportals->member['g_access_cp'] && !$this->member['g_access_urlobox']) {
			$content = "
				<tr>
				  <td class=\"tdblock\" align=\"center\">
				  {$this->lang['urlo_unauth']}
				  </td>
				</tr>
				";
	}
	unset($link_user);
	unset($urlo);
	unset($umes);
    	unset($message);

?>
