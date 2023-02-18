<?

$m1 = str_replace("%20", " ", $_GET['m1']);
$m2 = str_replace("%20", " ", $_GET['m2']);
$m3 = str_replace("%20", " ", $_GET['m3']);
$m4 = str_replace("%20", " ", $_GET['m4']);
$u1 = $_GET['u1'];


$output = "<script language=\"javascript\" type=\"text/javascript\">
<!--
function jump_to_inbox()
{
	opener.document.location.href = \"$u1\";
	window.close();
}
//-->
</script>
<body>
  <table width=\"100%\" height=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" bgcolor=\"#F5F5F5\">
    <tr>
      <td>
	<table align=\"center\" width=\"95%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
	  <tr>
	    <td valign=\"top\" width=\"100%\" bgcolor=\"#DFE6EF\" align=\"center\"><br /><strong><font face=\"verdana\" size=\"2\">$m1<a href=$u1 onclick=\"jump_to_inbox();return false;\" target=\"_new\"> $m2</a>$m3</font></strong><br /><br /><font face=\"verdana\" size=\"2\"><a href=\"javascript:window.close();\" >$m4</a></font><br /><br />
	    </td>
	  </tr>
	</table>
      </td>
    </tr>
  </table>
</body>
  
  ";

  print $output;

  ?>
