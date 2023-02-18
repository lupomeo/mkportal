<?php

global $MK_TEMPLATE;
	
$content = "";

	$content = "
<tr align=\"center\">
<td>
<a href=\"http://validator.w3.org/check?uri=referer\"><img width=\"88\" height=\"31\" border=\"0\" src=\"http://www.w3.org/Icons/valid-xhtml10\" alt=\"valid\" /></a><br /><br /><a href=\"http://jigsaw.w3.org/css-validator/validator?uri=$this->siteurl/mkportal/templates/".$MK_TEMPLATE."/style.css\"><img style=\"border: 0pt none ; width: 88px; height: 31px;\" src=\"http://jigsaw.w3.org/css-validator/images/vcss\" alt=\"Valid CSS!\" /></a>
</td>
</tr>

	";

?>


