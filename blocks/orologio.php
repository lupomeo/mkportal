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


/*
			$content = "
			<tr>
			    <td class=\"tdglobal\" align=\"center\">
			    <object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"100\" height=\"100\" id=\"musica\" align=\"middle\">
			    <param name=\"allowScriptAccess\" value=\"sameDomain\" />
			    <param name=\"movie\" value=\"$this->mkurl/addon/orologio.swf\" />
			    <param name=\"quality\" value=\"high\" />
			    <param name=\"bgcolor\" value=\"#ffffff\" />
			    <embed src=\"$this->mkurl/addon/orologio.swf\" quality=\"high\" bgcolor=\"#ffffff\" width=\"100\" height=\"100\" name=\"musica\" align=\"middle\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />
			    </object>
			    </td>
			</tr>
			";
*/

			$content = "
				<tr>
				  <td class=\"tdglobal\" align=\"center\">
				    <object type=\"application/x-shockwave-flash\" data=\"$this->mkurl/addon/orologio.swf\" width=\"100\" height=\"100\" id=\"musica\" align=\"middle\">				
				    <param name=\"allowscriptaccess\" value=\"samedomain\" />
				    <param name=\"movie\" value=\"$this->mkurl/addon/orologio.swf\" />
				    <param name=\"quality\" value=\"high\" />
				    <param name=\"bgcolor\" value=\"#ffffff\" />
				    </object>
				  </td>
				</tr>
			";


?>
