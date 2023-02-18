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
$todayev = "";
$todaybi = "";
$showdaywords=1;

$linkcalevent = $mklib_board->forum_link("calendar_event");

	$tool_col = "<td class=\"tdblock\" style=\"height:10px\" valign=\"middle\" align=\"center\" >";
    $col_close = "</td>";

$month_words = array( $this->lang['Jan'], $this->lang['Feb'], $this->lang['Mar'], $this->lang['Apr'], $this->lang['May'], $this->lang['Jun'], $this->lang['Jul'], $this->lang['Aug'], $this->lang['Sep'], $this->lang['Oct'], $this->lang['Nov'], $this->lang['Dec'] );
       
$day_words   = array( $this->lang['sunday'], $this->lang['monday'], $this->lang['tuesday'], $this->lang['wednesday'], $this->lang['thursday'], $this->lang['friday'], $this->lang['saturday']);

$now_date = getdate( time() + $offset);

       $chosen_month = (intval($_POST['m_m']) == "") ? $now_date['mon']  : $_POST['m_m'];
       $chosen_year  = (intval($_POST['y_y']) == "") ? $now_date['year'] : $_POST['y_y'];

       if ( ! checkdate( $chosen_month, 1 , $chosen_year ) )
       {
               $chosen_month = $now_date['mon'];
               $chosen_year  = $now_date['year'];
       }

       $our_datestamp   = mktime( 0, 0, 0, $chosen_month, 1, $chosen_year);
       $first_day_array = getdate($our_datestamp);

$temp_birthdays = $mklib_board->calendar_birth($chosen_month, $chosen_year);
$birthdays = $temp_birthdays[0];
$tool_birthdays = $temp_birthdays[1];
unset ($temp_birthdays);

$temp_events = $mklib_board->calendar_events($chosen_month, $chosen_year);
$events = $temp_events[0];
$tool_events = $temp_events[1];
unset ($temp_events);

	$return = "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']."#cal";
    for ($i = 1; $i <= 12; $i++) {
        $selected = "";
        if ($i == $chosen_month) {
            $selected = "selected=\"selected\"";
        }
        $m_options .= "
					  <option value=\"$i\" $selected >".$month_words[$i-1]."</option>\n";
    }
    for ($i = $now_date['year'] - 3; $i <= $now_date['year'] + 3; $i++) {
        $selected = "";
        if ($i == $chosen_year) {
            $selected = "selected=\"selected\"";
        }
        $y_options .= "
					  <option value=\"$i\" $selected >$i</option>\n";
    }

	  $content .= "
				<tr>
				  <td class=\"tdblock\" >

				    <form action=\"$return\" name=\"CalForm\" method=\"post\">
				    <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\">
				      <tr>
					<td class=\"tdglobal\" style=\"text-align:center;\" align=\"center\" colspan=\"7\">
					  <input type=\"hidden\" name=\"old_y\" value=\"$chosen_year\" />
					  <input type=\"hidden\" name=\"old_y\" value=\"$chosen_month\" />
					  <select name=\"m_m\" class=\"bgselect\" onchange=\"document.CalForm.submit();\">
					  $m_options
					  </select>
					  <select name=\"y_y\" class=\"bgselect\" onchange=\"document.CalForm.submit();\">
					  $y_options
					  </select>
					</td>
				      </tr>      
			      
				      <!--CALENDAR_TITLE_ROW-->				      
				      <!--CALENDAR_CONTENT-->				      
				      <!--CALENDAR_EVENTS-->				      
				      							
				    </table>
				    </form>

				  </td>
				</tr>
";
       $day_output = "";
       $cal_output = "";


       $day_output .= "
				      <tr>";

       
       if ($showdaywords) {
               foreach ($day_words as $day)
               {
                       $day_output .= "
					<th class=\"modulex\" style=\"height: 18px; padding: 0px; margin: 0px; border: 0px; font-size: 10px; width: 14%\" align=\"center\" valign=\"middle\">$day</th>
					   ";
               }
         }

       $seen_days = array();

       for ( $c = 0; $c < 42; $c++ )
       {
               $day_array = getdate($our_datestamp);

               if ( (($c) % 7 ) == 0 )
               {
                       if ($day_array['mon'] != $chosen_month)
                       {
                               break;
                       }

                       $cal_output .= "
				      </tr>
				      <tr>
				";
               }

               if ( ($c < $first_day_array['wday']) or ($day_array['mon'] != $chosen_month) )
               {
                       $cal_output .="
					<td class=\"tdblock\" style=\"height:10px; width:4px; padding: 0px; margin: 0px; border: 0px;\"><br /></td>
					";
               }
               else
               {
					$our_datestamp += 86400;
                    if ( $seen_days[ $day_array['yday'] ] == 1 )
                    {
						$c--;
						continue;
					}
                    $seen_days[ $day_array['yday'] ] = 1;
                    $this_day_events = "";
                    $cal_date        = $day_array['mday'];

			$this_events  = "";
            $tooltip = "";
			if (isset($tool_events[$day_array['mday']]) || isset($tool_birthdays[$day_array['mday']])) {
				$cal_date = "<a class=\"uno\" href=\"".$linkcalevent."&amp;code=showday&amp;y=".$chosen_year."&amp;m=".$chosen_month."&amp;d=".$day_array['mday']."&amp;month=".$chosen_month."&amp;day=".$day_array['mday']."&amp;year=".$chosen_year."\">{$day_array['mday']}</a>";
			 }

			 if ( ($day_array['mday'] == $now_date['mday']) and ($now_date['mon'] == $day_array['mon']) and ($now_date['year'] == $day_array['year']))
             {
				if ($tool_events[$day_array['mday']]) {
					$todayev .= "<a class=\"uno\" style=\"font-weight: normal;\" href=\"$linkcalevent&amp;code=showday&amp;y=$chosen_year&amp;m=$chosen_month&amp;d={$day_array['mday']}&amp;month=$chosen_month&amp;year=$chosen_year&amp;day={$day_array['mday']}\">{$tool_events[$day_array['mday']]}</a>";
				}
				$todaybi .= $tool_birthdays[$day_array['mday']];
				$cal_output .= "
				      <td class=\"tdblock\" style=\"font-size: 10px; height:10px; border:2px; border-style:outset; background-color: #ffff00;\" valign=\"middle\" align=\"center\"><b>$cal_date</b></td>
				";
             }
             else
             {
				$cal_output .= "
				      <td class=\"modulecell\" style=\"font-size: 10px; height:10px\" valign=\"middle\" align=\"center\">$cal_date</td>
				";
             }

             unset($this_day_events);
		}

      }

       $content = str_replace( "<!--CALENDAR_TITLE_ROW-->", $day_output, $content );
       $content = str_replace( "<!--CALENDAR_CONTENT-->"  , $cal_output, $content );

	   $day_output = "
				    </tr>
				    <tr>
				      <td class=\"trattini3\" style=\"font-size: 1px; background: transparent;\" colspan=\"7\">&nbsp;</td>
				    </tr>
				    ";

	   if ($todaybi) {
			$day_output .= "
				    <tr>
				      <td class=\"tdglobal\" colspan=\"7\">
				      {$this->lang['cal_tbi']}
				      </td>
				    </tr>
				    <tr>
				      <td class=\"modulecell\" style=\"font-size: 10px; font-weight: normal;\" colspan=\"7\">
					$todaybi
				      </td>
				    </tr>
			";
		}
		if ($todayev) {
			$day_output .= "
				    <tr>
				      <td class=\"tdblock\" colspan=\"7\">
				      {$this->lang['cal_tev']}
				      </td>
				    </tr>
				    <tr>
				      <td class=\"modulecell\" colspan=\"7\">
				      $todayev
				      </td>
				    </tr>
			";
		}
			$content = str_replace( "<!--CALENDAR_EVENTS-->"  , $day_output, $content );

	unset($now_date);
        unset($choose_month);
        unset($choose_year);
        unset($our_datestamp);
        unset($first_day_array);
        unset($birthdays);
        unset($tool_birthdays);
        unset($seen_days);
        unset($this_events);
        unset($caption);
        unset($tooltip);
        unset($cal_output);
        unset($cal_date);
	unset($day_output);
	unset($tooltip_js);

?>
