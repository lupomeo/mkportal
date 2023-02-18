<?php

class tpl_mkchat {


function view_chat($chat_server, $chat_port, $chat_channel) {
global $mkportals, $mklib;
return <<<EOF

<tr>
  <td>
    <iframe src="$mklib->siteurl/index.php?ind=chat&amp;op=refresh_list" frameborder="0"  width="0" align="middle" height="0" scrolling="no"></iframe>
    
      <table cellspacing="0" width="100%" border="0">
	<tr>
	  <td class="tdblock">{$mklib->lang['ch_welc']}</td>
	</tr>	
	<tr>
	  <td valign="top" align="center" class="taburlo">
 	    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      	      <tr>
      		<td valign="top">

		  <applet name="pjirc" code="IRCApplet.class" archive="irc.jar,pixx.jar," width="100%" height="400" codebase="mkportal/modules/chat/" >
                  <param name="CABINETS" value="irc.cab,securedirc.cab,pixx.cab" />
                  <param name="nick" value="{$mkportals->member['name']}" />
                  <param name="alternatenick" value="{$mkportals->member['name']}???" />
                  <param name="name" value="{$mklib->lang['ch_chatter']}" />
                  <param name="host" value="{$chat_server}" />
		  <param name="port" value="{$chat_port}" />
                  <param name="gui" value="pixx" />
		  <param name="command1" value="join {$chat_channel}" />
                  <param name="pixx:language" value="{$mklib->lang['ch_piixlang']}" />
                  <param name="quitmessage" value="{$mklib->lang['ch_quitmes']}" />
		  <param name="asl" value="true" />
		  <param name="useinfo" value="true" />
		  <param name="soundbeep" value="snd/bell2.au" />
		  <param name="soundquery" value="snd/ding.au" />
                  <param name="style:bitmapsmileys" value="true" />
                  <param name="style:smiley1" value=":) img/smile.gif" />
                  <param name="style:smiley2" value=":-) img/smile.gif" />
                  <param name="style:smiley3" value=":-D img/haha.gif" />
                  <param name="style:smiley4" value=":-D img/haha.gif" />
                  <param name="style:smiley5" value=":-O img/OH-2.gif" />
                  <param name="style:smiley6" value=":o img/OH-1.gif" />
                  <param name="style:smiley7" value=":-P img/prrr.gif" />
                  <param name="style:smiley8" value=":P img/prrr.gif" />
                  <param name="style:smiley9" value=";-) img/occ.gif" />
                  <param name="style:smiley10" value=";) img/occ.gif" />
                  <param name="style:smiley11" value=":-( img/triste.gif" />
                  <param name="style:smiley12" value=":( img/triste.gif" />
                  <param name="style:smiley13" value=":-| img/triste.gif" />
                  <param name="style:smiley14" value=":| img/triste.gif" />
                  <param name="style:smiley15" value=":'( img/frigna.gif" />
                  <param name="style:smiley16" value=":ghgh: img/ghgh.gif" />
                  <param name="style:smiley17" value=":gh: img/ghgh.gif" />
                  <param name="style:smiley18" value="(H) img/dito.gif" />
                  <param name="style:smiley19" value="(h) img/dito.gif" />
                  <param name="style:smiley20" value=":-@ img/inca.gif" />
                  <param name="style:smiley21" value=":@ img/inca.gif" />
                  <param name="style:smiley22" value=":dito: img/dito.gif" />
                  <param name="style:smiley23" value=":clap: img/clap.gif" />
                  <param name="style:smiley24" value=":ciao: img/ciao.gif" />
                  <param name="style:smiley25" value=":argh: img/inca.gif" />
                  <param name="style:smiley26" value=":porc: img/porc.gif" />
                  <param name="style:smiley27" value=":maiale: img/porc.gif" />
                  <param name="style:smiley28" value=":lol: img/haha.gif" />
                  <param name="style:smiley29" value=":haha: img/haha.gif" />
                  <param name="style:smiley30" value=":lov: img/love.gif" />
                  <param name="style:smiley31" value=":amore: img/love.gif" />
                  <param name="style:smiley32" value=":love: img/love.gif" />
                  <param name="style:smiley33" value=":nono: img/nono.gif" />
                  <param name="style:smiley34" value=":no: img/nono.gif" />
                  <param name="style:smiley35" value=":ko: img/ko.gif" />
                  <param name="style:smiley36" value=":tvb: img/abbra.gif" />
                  <param name="style:smiley37" value=":ubria: img/ubria.gif" />
                  <param name="style:smiley38" value=":beer: img/ubria.gif" />
                  <param name="style:smiley39" value=":kiss: img/bacio.gif" />
                  <param name="style:smiley40" value=":bacio: img/bacio.gif" />
                  <param name="style:smiley41" value=":perdono: img/perdono.gif" />
                  <param name="style:smiley42" value=":ing: img/perdono.gif" />
                  <param name="style:smiley43" value=":abbra: img/abbra.gif" />
                  <param name="style:smiley44" value=":prrr: img/prrr.gif" />
                  <param name="style:smiley45" value=":fuma: img/fuma.gif" />
                  <param name="style:smiley46" value=":smoke: img/fuma.gif" />
                  <param name="style:smiley47" value=":frigna: img/frigna.gif" />
                  <param name="style:smiley48" value=":inca: img/inca.gif" />
                  <param name="style:smiley49" value=":piange: img/frigna.gif" />
                  
		  <param name="style:backgroundimage" value="true" />
                  <param name="style:backgroundimage1" value="all all 0 " />
                  <param name="style:sourcefontrule1" value="all all Verdana 12" />
                  <param name="style:floatingasl" value="true" />
                  <param name="pixx:timestamp" value="true" />
                  <param name="pixx:highlight" value="true" />
                  <param name="pixx:highlightnick" value="true" />
                  <param name="pixx:highlightcolor" value="DFE6EF" />

                  <param name="pixx:highlightwords" value="ciao buongiorno buonanotte cazzo meo kim ..." />
                  <param name="pixx:nickfield" value="false" />
                  <param name="pixx:showconnect" value="true" />
                  <param name="pixx:showchanlist" value="true" />
                  <param name="pixx:showabout" value="false" />
		  <param name="pixx:showhelp" value="false" />
                  <param name="pixx:nicklistwidth" value="130" />
                  <param name="pixx:setfontonstyle" value="true" />
                  <param name="pixx:styleselector" value="true" />

                  <param name="pixx:showstatus" value="true" />
                  <param name="style:righttoleft" value="false" />
                  <param name="style:sourcecolorrule1" value="none+Channel all 0=FFFFFF" />
                  <param name="style:sourcecolorrule2" value="none+Query none+some_nick 0=000000 1=ffffff" />
                  <param name="channelfont" value="15 bold verdana" />
                  <param name="pixx:color0" value="345487" />
                  <param name="pixx:color1" value="345487" />
                  <param name="pixx:color2" value="000000" />
                  <param name="pixx:color3" value="000000" />

                  <param name="pixx:color4" value="345487" />
                  <param name="pixx:color5" value="F5F9FD" />
                  <param name="pixx:color6" value="F5F9FD" />
                  <param name="pixx:color7" value="EEF2F7" />
                  <param name="pixx:color8" value="A1C3EF" />
                  <param name="pixx:color9" value="F5F9FD" />
                  <param name="pixx:color10" value="00CC66" />
                  <param name="pixx:color11" value="D2E9FF" />
                  <param name="pixx:color12" value="D2E9FF" />

                  <param name="pixx:color15" value="DFE6EF" />
                  <param name='pixx:configurepopup' value='true' />
                  <param name='pixx:popupmenustring1' value="{$mklib->lang['ch_infouser']}" />
                  <param name='pixx:popupmenustring2' value="{$mklib->lang['ch_pmsg']}" />
                  <param name='pixx:popupmenustring3' value='Ban' />
                  <param name='pixx:popupmenustring4' value='kick + Ban' />
                  <param name='pixx:popupmenustring5' value='--' />
                  <param name='pixx:popupmenustring6' value='+ Op' />
                  <param name='pixx:popupmenustring7' value='- Op' />

                  <param name='pixx:popupmenustring8' value='+ v' />
                  <param name='pixx:popupmenustring9' value='- v' />
                  <param name='pixx:popupmenustring10' value='--' />
                  <param name='pixx:popupmenustring11' value='Ping' />
                  <param name='pixx:popupmenustring12' value='Finger' />

		  <param name='pixx:popupmenustring13' value='--' />
                  <param name='pixx:popupmenustring14' value="{$mklib->lang['ch_squeeze']}" />
		  <param name='pixx:popupmenustring15' value="{$mklib->lang['ch_five']}" />
		  <param name='pixx:popupmenustring16' value="{$mklib->lang['ch_kiss']}" />
		  <param name='pixx:popupmenustring17' value="{$mklib->lang['ch_rose']}" />
		  <param name='pixx:popupmenustring18' value="{$mklib->lang['ch_pat']}" />
                  <param name='pixx:popupmenucommand1_1' value='/Whois %1' />
                  <param name='pixx:popupmenucommand2_1' value='/Query %1' />
                  <param name='pixx:popupmenucommand3_1' value='/mode %2 -o %1' />

                  <param name='pixx:popupmenucommand3_2' value='/mode %2 +b %1' />
                  <param name='pixx:popupmenucommand4_1' value='/mode %2 -o %1' />
                  <param name='pixx:popupmenucommand4_2' value='/mode %2 +b %1' />
                  <param name='pixx:popupmenucommand4_3' value='/kick %2 %1' />
                  <param name='pixx:popupmenucommand6_1' value='/mode %2 +o %1' />
                  <param name='pixx:popupmenucommand7_1' value='/mode %2 -o %1' />
                  <param name='pixx:popupmenucommand8_1' value='/mode %2 +v %1' />
                  <param name='pixx:popupmenucommand9_1' value='/mode %2 -v %1' />
                  <param name='pixx:popupmenucommand11_1' value='/CTCP PING %1' />


                  <param name='pixx:popupmenucommand12_1' value='/CTCP FINGER %1' />
		  <param name='pixx:popupmenucommand14_1' value="{$mklib->lang['ch_squeeze1']}" />
		  <param name='pixx:popupmenucommand15_1' value="{$mklib->lang['ch_five1']}" />
		  <param name='pixx:popupmenucommand16_1' value="{$mklib->lang['ch_kiss1']}" />
		  <param name='pixx:popupmenucommand17_1' value="{$mklib->lang['ch_rose1']}" />
                  <param name='pixx:popupmenucommand18_1' value="{$mklib->lang['ch_pat1']}" />

		  </applet>

		</td>
	      </tr>
	    </table>				  		   
	  </td>
	</tr>
	
	<tr>
	  <td valign="top" class="taburlo">
	    <table width="100%" border="0">
	      <tr>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/ciao.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':ciao:');document.pjirc.requestSourceFocus()" alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/inca.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':inca:');document.pjirc.requestSourceFocus()" alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/occ.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+';)');document.pjirc.requestSourceFocus()" alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/dito.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':dito:');document.pjirc.requestSourceFocus()" alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/clap.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':clap:');document.pjirc.requestSourceFocus()" alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/porc.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':porc:');document.pjirc.requestSourceFocus()" alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/nono.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':nono:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/haha.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':haha:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
           <td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/love.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':love:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/ko.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':ko:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
	      </tr>
	      
	      <tr>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/smile.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':)');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/triste.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':(');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/abbra.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':abbra:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/ghgh.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':ghgh:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
		 <td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/ubria.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':ubria:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/bacio.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':bacio:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/perdono.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':perdono:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/prrr.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':prrr:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/fuma.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':fuma:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
		<td class="tdblock"><div align="center"><a href="#mkchat"><img src="mkportal/modules/chat/img/frigna.gif" border="0" onclick="document.pjirc.setFieldText(document.pjirc.getFieldText()+':frigna:');document.pjirc.requestSourceFocus()"  alt="" /></a></div></td>
	    </tr>
	  </table>     
           
         </td>
	</tr>
      </table>
      
    <div align="right">
      <table width="550"  border="0" cellpadding="0" cellspacing="0" class="but">
        <tr>
          <td valign="top" align="center">
	    [<a  href="javascript:document.pjirc.setFieldText('/\msg nickserv identify ');document.pjirc.requestSourceFocus()">{$mklib->lang['ch_identify']}</a>]&nbsp;&nbsp;&nbsp;
	    [<a  href="javascript:document.pjirc.setFieldText('/\msg nickserv register password email');document.pjirc.requestSourceFocus()">{$mklib->lang['ch_regnick']}</a>]&nbsp;&nbsp;&nbsp;
	    [<a href="javascript:document.pjirc.sendString('/me {$mklib->lang[ch_afk2]}')">{$mklib->lang['ch_afk']}</a>]&nbsp;&nbsp;&nbsp;
	    [<a href="javascript:document.pjirc.sendString('/beep')">{$mklib->lang['ch_beep']}</a>]&nbsp;&nbsp;&nbsp;
	    [<a  href="javascript:document.pjirc.sendString('/me {$mklib->lang[ch_byeall2]}')">{$mklib->lang['ch_byeall']}</a>]&nbsp;&nbsp;&nbsp;
	    [<a class="but" href="javascript:document.pjirc.sendString('/quit')">{$mklib->lang['ch_exit']}</a>]
	  </td>
        </tr>
      </table>
    </div>
    
    <br /><br />
    <div align="center">©2004 <a href="http://www.mkportal.it" target="_blank">MKPortal</a> Chat - Powered by  <a href="http://www.pjirc.com/" target="_blank">pjIRC</a></div>

  </td>
</tr>
EOF;
}

}
?>
