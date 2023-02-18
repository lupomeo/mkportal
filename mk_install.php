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


$lang = $_POST['lang'];

$mklang['title'] = "! INSTALLAZIONE DI MKPORTAL !";


if ($lang == "en") {

$mklang['title'] = "! MKPORTAL INSTALLATION !";
}

if ($lang == "fr") {

$mklang['title'] = "! INSTALLATION DE MKPORTAL !";
}
$header = "
	<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
<head>
    <meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\" />
    <meta name=\"generator\" content=\"MKPortal\">
    <meta http-equiv=\"Pragma\" content=\"no-cache\">
    <meta http-equiv=\"no-cache\">
    <meta http-equiv=\"Cache-Control\" content=\"no-cache\">
    <title>Installazione di MKportal</title>
	<link href=\"templates/default/style.css\" rel=\"stylesheet\" type=\"text/css\">
</head>
<body bgcolor=\"#EFEFEF\">
	<div align=\"center\">
	<br>
	<table align=\"center\" border=\"0\" width=\"100%\" id=\"tabmain\" cellspacing=\"0\" cellpadding=\"0\">
  	<tr>
    <td width=\"100%\" align=\"center\">
	<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
	 <tr>
        <td width=\"100%\" background=\"templates/default/images/sf_logo.jpg\" align=\"left\">
               <img src=\"templates/default/images/logo.gif\" border=\"0\">
        </td>
     </tr>
<tr><td id='contents' height=\"500\" valign=\"top\">
			<div style='text-align: center;' id='tabmain'><br />
			<img src='templates/default/images/error.gif' /><br /><span style='color: rgb(255, 0, 0); font-weight: bold;'>
			<font size='3'>! $mklang[title] !</font><br /></span><br />
			<span style='font-weight: bold;'>    </span><br style='font-weight: bold;' />
			<span style='font-weight: bold;'><table>
";
$footer = "
</table>
</span><br /><br /></div><br /> <br />
			</td></tr>
	</table>
   </td>
  </tr>
</table>
<p align=\"center\"><img src=\"templates/default/images/loghino.gif\" border=\"0\"><br><a href=\"http://www.mkportal.it/\" target=_blank>MKPortal </a> ©2004 - Tutti i diritti riservati</p>
</div>
</body>
</html>

";


switch($_GET['op']) {
				case 'step0':
    				step0();
    			break;
				case 'step1':
    				step1();
    			break;
    			case 'step2':
    				step2();
    			break;
				case 'step3':
    				step3();
    			break;
				case 'step4':
    				step4();
    			break;
				default:
    				start();
    			break;
		}

function start() {
	global $header, $footer, $BOARD;

$content = "<form name=\"main\" method=\"post\" action=\"mk_install.php?op=step0\">
	Benvenuti in MKPortal e grazie per aver scelto questo prodotto.<br><br><br><br>
	Seleziona la lingua dell'installazione (Choose installation language) (Choisissez la langue d'installation): <br>
	<br><select size=\"1\" name=\"lang\" id=\"bgselect\">
		<option value=\"it\">Italiano</option>
		<option value=\"en\">English</option>
		<option value=\"fr\">Français</option>
		</select><br><br><br>
		Seleziona la board (Choose the board you have) (Choisissez votre board): <br>
		<br><select size=\"1\" name=\"BOARD\" id=\"bgselect\">
		<option value=\"SMF\">SMF</option>
		<option value=\"IPB\">IPB 2</option>
		<option value=\"PHPBB\">PhpBB</option>
		<option value=\"VB\">VBulletin</option>
		<option value=\"OXY\">Oxygen</option>
		</select>
		<br><br><br><input type=\"submit\" value=\"Procedi >>\" name=\"B1\"></td>
	</form>";

	$output = $header.$content.$footer;
	print $output;
	exit;
}

function step0() {
	global $header, $footer, $BOARD;

	$lang = $_POST['lang'];
	$BOARD = $_POST['BOARD'];

	$welcome = "Benvenuti in MKPortal e grazie per aver scelto questo prodotto.<br>
	Per installare MKPortal è necessario prendere visione ed accettare la sua licenza.";

	$agree = "Accetto i termini della licenza";

	$licenza = "

L' EDITOR 'TinyMCE' E L'APPLICAZIONE JAVA 'PJIRC' PROPRIETA'
ESCLUSIVA DEI RISPETTIVI DETENTORI DEL COPYRIGHT E NON HANNO
NULLA A CHE  FARE  CON  QUESTA  LICENZA,  MA  SONO SOGGETTI
ALLA LICENZA PROPRIA, REPERIBILE NEI RISPETTIVI PACCHETTI E/O
DIRECTORY.

IL COPYRIGHT DELLE ICONE E' \"food's icons\" (http://www.foood.net/).
LE ICONE NON POSSONO ESSERE USATE AL DI FUORI DI MKPORTAL SENZA IL
CONSENSO ESPLICITO DELL'AUTORE.

L'USO DI QUESTO PROGRAMMA E' ASSOLUTAMENTE E COMPLETAMENTE FREE.
E' PERMESSO USARE LIBERAMENTE QUESTO PROGRAMMA PER QUALSIASI SCOPO
COMMERCIALE E NON. SENZA ALCUNA RESTRIZIONE O LIMITE O SCADENZA.

E' PROIBITO  IN QUALUNQUE MODO O FORMA ELIMINARE  LA  STRINGA  DEL
COPYRIGHT CHE APPARE NEL PIEDE DELLA PAGINA. AI TRASGRESSORI SARA'
IMMEDIATAMENTE REVOCATA LA LICENZA DI USO DEL PROGRAMMA.

E' PERMESSO ELIMINARE IL PICCOLO LOGO RECANTE LA SCRITTA'MKPORTAL'
CHE COMPARE NEL PIEDE DELLA PAGINA.

E' PERMESSO MODIFICARE IL PROGRAMMA, MA SOLO PER USI PERSONALI E A
CONDIZIONE DI NON  DISTRIBUIRE  LE MODIFICHE SE NON NEI TERMINI IN
CUI SARA' ILLUSTRATO DI SEGUITO.

E' PERMESSO  CREARE E  DISTRIBUIRE AGGIUNTE A  QUESTO PROGRAMMA MA
ESCUSIVAMENTE  SOTTO  FORMA  DI 'BLOCCHI' E 'MODULI', A CONDIZIONE
CIOE' CHE SIANO PARTI CHE SI VANNO AD AGGIUNGERE AL PACCHETTO BASE
E NON NE PRESUPPONGONO ALCUNA MODIFICA O VARIAZIONE.

E' PROIBITO REDISTRIBUIRE IL PROGRAMMA.
IL  PROGRAMMA  PUO' ESSERE DITRIBUITO ESCLUSIVAMENTE DAI DETENTORI
DEL COPYRIGHT O DA TERZI ESCPLICITAMENTE A CIO' AUTORIZZATI.

E' PROIBITO DISTRIBUIRE COPIE MODIFICATE DEL PROGRAMMA.
LE  MODIFICHE AL PROGRAMMA  POSSONO ESSERE DIFFUSE SOLO IN TERMINI
DI  'ISTRUZIONI'  E  NON  COME  PORZIONI  DI  CODICE  MODIFICATE E
CONTENUTE IN FILE  ORIGINARI  REDISTRIBUITI.
E' ALTRESI' PROIBITO  DISTRIBUIRE 'SCRIPT' O  ALTRI  PROGRAMMI CHE
VANNO A  MODIFICARE IN  QUALUNQUE  MODO O FORMA IL CODICE SORGENTE
DEL PRESENTE PROGRAMMA.

- POICHÉ IL PROGRAMMA È CONCESSO IN USO GRATUITAMENTE, NON C'È ALCUNA
GARANZIA PER  IL PROGRAMMA.
IL DETENTORE DEL COPYRIGHT E LE  ALTRE PARTI  FORNISCONO IL PROGRAMMA
\"COSÌ COM'E'\",  SENZA ALCUN TIPO  DI GARANZIA,  NÉ ESPLICITA  NÉ IMPLI
CITA;  CIÒ COMPRENDE, SENZA LIMITARSI A QUESTO, LA GARANZIA DI UTILIZ
ZABILITÀ PER UN PARTICOLARE  SCOPO.  L'INTERO  RISCHIO CONCERNENTE LA
QUALITÀ  E LE PRESTAZIONI  DEL PROGRAMMA È DELL'ACQUIRENTE.
SE  IL PROGRAMMA  DOVESSE RIVELARSI DIFETTOSO, L'ACQUIRENTE SI ASSUME
IL COSTO DI OGNI MANUTENZIONE, RIPARAZIONE O CORREZIONE NECESSARIA.
NÉ IL DETENTORE  DEL  COPYRIGHT NÉ ALTRE PARTI CHE POSSONO MODIFICARE
O  RIDISTRIBUIRE IL PROGRAMMA COME  PERMESSO  IN  QUESTA LICENZA SONO
RESPONSABILI PER DANNI NEI CONFRONTI DELL'UTENTE.
SONO INCLUSI DANNI GENERICI, SPECIALI O INCIDENTALI, COME PURE I DANNI
CHE CONSEGUONO DALL'USO O  DALL'IMPOSSIBILITÀ DI USARE  IL  PROGRAMMA.
CIÒ  COMPRENDE,  SENZA  LIMITARSI  A  QUESTO, LA PERDITA  DI DATI,  LA
CORRUZIONE DEI DATI, LE  PERDITE  SOSTENUTE  DALL' UTENTE O DA TERZI E
L'INCAPACITÀ DEL PROGRAMMA A INTERAGIRE CON ALTRI  PROGRAMMI, ANCHE SE
IL  DETENTORE O ALTRE  PARTI SONO STATE AVVISATE  DELLA POSSIBILITÀ DI
QUESTI DANNI.
\n\n";

if ($lang == "en") {

$welcome = "Welcome in MKPortal. Thank you for having choosen this product.<br>
To install MKPortal you need to read and accept its license.";

$agree = "I agree";

$licenza = "

'TinyMCE' EDITOR AND 'PJIRC' JAVA APPLET ARE EXCLUSIVE PROPERTY
OF COPYRIGHT BEHOLDERS AND THEY HAVE NOTHING TO DO WITH THIS
LICENCE, BUT THEY ARE UNDER THEIR OWN LICENCE, AVAILABLE IN THEIR
PACKAGES AND/OR DIRECTORIES.

THE ICONS PRESENTS IN MKPORTAL DEFAULT SKIN ARE OF Foood's ICON
PROPERTY (http://www.foood.net).
THEY CANNOT BE USED FOR OTHER PURPOSES DIFFERENT FROM MKPORTAL
WITHOUT THE EXPLICIT ASSENT OF THE AUTHOR.

THE USE OF THIS SCRIPT IS ABSOLUTELY AND TOTALLY FREE.
THIS SCRIPT CAN BE FREELY USED FOR COMMERCIAL AND NOT COMMERCIAL
PURPOSE. 
WITHOUT ANY RESTRICTION OR LIMIT OR EXPIRATION.


IT'S NOT ALLOWED ANYWAY DELETING COPYRIGHT AT THE BOTTOM OF THE PAGE.
LICENSE WILL BE IMMEDIATELY REVOKED TO ANYONE WHO WON'T RESPECT THIS
TERMS AND CONDITIONS.
IT'S ALLOWED DELETING SMALL 'MKPORTAL' LOGO AT THE BOTTOM OF THE PAGE.

IT'S ALLOWED MODIFYING THIS SCRIPT, BUT FOR PERSONAL USES ONLY AND UNDER 
THE CONDITION NOT TO DISTRIBUTE MODIFICATIONS BUT IN THE FOLLOWING TERMS.

IT'S ALLOWED CREATING AND DISTRIBUTING ADD-ONS FOR THIS SCRIPT BUT 
EXCLUSIVELY
AS 'BLOCKS' AND 'MODULES', THAT MEANS ADDING PARTS TO BASE SCRIPT
WHICH DON'T MODIFY ORIGINAL CODE.

IT'S FORBIDDEN SEEDING THIS SCRIPT. THE SCRIPT CAN BE DISTRIBUTED 
EXCLUSIVELY BY THE OWNER OF THE COPYRIGHT OR AUTHORIZED PEOPLE ONLY.

IT'S FORBIDDEN TO DISTRIBUTE MODIFIED COPIES OF THE SCRIPT. SCRIPT 
MODIFICATIONS CAN BE SPREAD ONLY AS 'INSTRUCTIONS' AND NOT AS PORTIONS
OF MODIFIED CODE. 
IT'S AS WELL FORBIDDEN TO DISTRIBUTE 'SCRIPTS' OR OTHER PROGRAMS THAT
MODIFY IN ANY WAY THE SOURCE CODE OF THIS SCRIPT.


- AS THE SCRIPT IS GRANTED FOR FREE, THERE'S NO GUARANTEE. THE OWNER
OF THE COPYRIGHT AND OTHERS SUPPLY THE SCRIPT \"AS IT IS\",
WITHOUT ANY KIND OF GUARANTEE, NEITHER EXPLICIT NOR IMPLICIT; THIS
IMPLIES THE GUARANTEE FOR ANY AIM.
THE WHOLE RISK CONCERNING THE QUALITY AND PERFORMANCES OF THIS SCRIPT
DEAL WITH THE CUSTOMER.
IF THE SCRIPT WILL TURN OUT BEING DEFECTIVE, THE CUSTOMER WILL BE
RESPONSIBLE OF EVERY MAINTENANCE, REPAIR OR NECESSARY CORRECTION.
NEITHER THE COPYRIGHT HOLDER NOR OTHERS PARTS, THAT CAN MODIFY OR
REDISTRIBUTE THIS SCRIPT AS ALLOWED IN THIS LICENCE, ARE RESPONSIBLE
FOR DAMAGES TOWARDS USERS.
THIS IMPLIES GENERIC, SPECIAL OR ACCIDENTAL DAMAGES, AS MUCH AS DAMAGES
DEALING WITH USE OR IMPOSSIBILITY TO USE THE SCRIPT.
THIS IMPLIES, WITHOUT LIMITS, THE LOSS OF DATAS, THE CORRUPTION OF DATAS,
ANY LOSS CONCERNING BOTH CUSTOMERS AND THIRDS
AND INCOMPATIBILITY OF THE SCRIPT WITH OTHER PROGRAMS, EVEN IF THE HOLDER
OR OTHERS HAVE BEEN INFORMED OF THE POSSIBILITY OF THESE DAMAGES.
\n\n";
}

if ($lang == "fr") {

$welcome = "Bienvenue dans MKPortal. Merci d'avoir choisi ce produit.<br>
Pour installer MKPortal vous devez lire et accepter sa licence.";

$agree = "Je suis d'accord";

$licenza = "

'TinyMCE' EDITOR ET 'PJIRC' JAVA APPLET SONT LA PROPRIÉTÉ
EXCLUSIVE DU COPYRIGHT ET ILS N'ONT RIEN À FAIRE AVEC CETTE LICENCE,
MAIS ILS SONT SOUS LEUR PROPRE LICENCE, DISPONIBLE EN LEURS PACK
ET/OU EMPLACEMENTS.

LES ICONES PRÉSENTS DANS LE SKIN PAR DÉFAUT de MKPORTAL SONT
LES ICONE DE Foood (http://www.foood.net).
ILS NE PEUVENT PAS ÊTRE EMPLOYÉS POUR D'AUTRES BUTS DIFFÉRENTS DE MKPORTAL
SANS CONSENTEMENT EXPLICITE DE L'AUTEUR.

L'UTILISATION DE CE SCRIPT EST ABSOLUMENT ET TOTALEMENT GRATUIT.
CE MANUSCRIT PEUT ÊTRE LIBREMENT EMPLOYÉ POUR LE FILM PUBLICITAIRE
 ET LE BUT NON COMMERCIAL.
SANS TOUTE RESTRICTION OU LIMITE OU D'EXPIRATION.


IL N'EST PAS PERMIS DE SUPPRIMER LE COPYRIGHT EN BAS DE LA PAGE.
LA LICENCE SERA IMMÉDIATEMENT RETIRÉ SI QUELQ'UN N'AURA PAS RESPECTER
LES MODALITÉS ET CONDITIONS.
VOUS POUVEZ SUPPRIMER LE PETIT LOGO DE MKPORTAL EN BAS DE LA PAGE.

VOUS POUVEZ MODIFIER CE SVRYPT, MAIS POUR DES USAGES PERSONNELS SEULEMENT ET DESSOUS
LA CONDITION POUR NE PAS DISTRIBUER DES MODIFICATIONS MAIS DANS LES LIMITES SUIVANTES.

VOUS POUVEZ CRÉER ET DISTRIBUER DES ADDONS POUR CE SCRYPT MAIS
 EXCLUSIVEMENT
EN TANT QUE 'BLOCS ET 'MODULES ', CES MOYENS AJOUTANT DES AJOUT AU SCRYPT DE BASE
CE QUI NE MODIFIENT PAS LE CODE ORIGINAL.

IL EST INTERDIT DE DONNER CE SCRYPT. LE SCRYPT PEUT ÊTRE DISTRIBUÉ EXCLUSIVEMENT
PAR LE PROPRIÉTAIRE DE COPYRIGHT OU DES PERSONNES AUTORISÉES SEULEMENT.

IL EST INTERDIT DE DISTRIBUER DES COPIES MODIFIÉES DU SCRYPT. DES MODIFICATIONS DE
MANUSCRIT PEUVENT ÊTRE ÉCARTÉES SEULEMENT EN TANT QUE 'INSTRUCTIONS ET PAS COMME DES
 PARTIES DE CODE MODIFIÉ.
IL EST INTERDIT AUSSI BIEN DE DISTRIBUER DES SCRYPT OU D'AUTRES PROGRAMMES QUI MODIFIENT
DE QUELQUE FAÇON LE CODE SOURCE DE CE SCRYPT.


- CAR ON ACCORDE LE MANUSCRIT POUR GRATUIT, IL N'Y A AUCUNE GARANTIE. LE PROPRIÉTAIRE DU
COPYRIGHT ET DES AUTRES FOURNISSENT LE SCRYPT \"A QUI IL EST\",
SANS TOUT GENRE DE GARANTIE, NI EXPLICITE NI IMPLICITE; CECI IMPLIQUE LA GARANTIE POUR
N'IMPORTE QUEL BUT.
LE RISQUE ENTIER POUR CE QUI CONCERNE LA QUALITÉ ET LES EXÉCUTIONS DE CETTE AFFAIRE DE
SCRYPT AVEC LE CLIENT.
SI LE MANUSCRIT S'AVÉRERA ÊTRE DÉFECTUEUX, LE CLIENT SERA RESPONSABLE DE CHAQUE ENTRETIEN,
RÉPARATION OU CORRECTION NÉCESSAIRE.
NI LE SUPPORT NI D'AUTRES DE COPYRIGHT PAS PARTIE, CELA PEUT MODIFIER OU REDISTRIBUER CE
MANUSCRIT COMME PERMIS DANS CETE LICENCE, SOYEZ RESPONSABLE DES DOMMAGES VERS DES UTILISATEURS.
CECI IMPLIQUE DES DOMMAGES GÉNÉRIQUES, SPÉCIAUX OU ACCIDENTELS, AUTANT QU'ENDOMMAGE TRAITANT
L'UTILISATION OU L'IMPOSSIBILITE D'EMPLOYER LE SCRYPT.
CECI IMPLIQUE, SANS LIMITES, LA PERTE DE DONNES, LA CORRUPTION DE DONNES, N'IMPORTE QUELLE PERTE
POUR CE QUI CONCERNE DES CLIENTS ET DES TROISIÈMEMENT ET L'INCOMPATIBILITE DU SCRYPT AVEC D'AUTRES
PROGRAMMES, MÊME SI LE SUPPORT OU D'AUTRES ONT ÉTÉ INFORMÉS DE LA POSSIBILITÉ DE CES DOMMAGES.\n\n";
}


	$content = "<form name=\"main\" method=\"post\" action=\"mk_install.php?op=step1\">
	$welcome <br>
	<br><textarea cols=\"70\" rows=\"20\" name=\"licenza\" readonly>$licenza</textarea> <br><br>
	<input type=\"hidden\" name=\"lang\" value=\"$lang\">
	<input type=\"hidden\" name=\"BOARD\" value=\"$BOARD\">
	<br><br><br><input type=\"submit\" value=\"$agree\" name=\"B1\"></td>
	</form>";

	$output = $header.$content.$footer;
	print $output;
	exit;
}

function step1() {

	global $header, $footer, $langin;

	$error = "";
	$lang = $_POST['lang'];
	$BOARD = $_POST['BOARD'];

	$error1 ="ERRORE: devi impostare i permessi del/della";
	$error2 ="in scrittura (chmod 0777).";
	$error3 ="e del";

	if ($lang == "en") {
		$error1 ="ERROR: you must set the write permissions of";
		$error2 ="(chmod 0777).";
		$error3 ="and of";
	}
	if ($lang == "fr") {
		$error1 ="ERREUR : vous devez placer les permissions d'écriture du";
		$error2 ="(chmod 0777).";
		$error3 ="et du";
	}

	$filename = "conf_mk.php";

   	if (!$handle = @fopen($filename, 'a')) {
         $error = "$error1 file conf_mk.php $error2<br>";
	}
   		if (!$bo = @fwrite($handle, "\n")) {
       		$error = "$error1 file conf_mk.php $error2<br>";
   		}
		@fclose($handle);



	$filename = "modules/downloads/file";
   	if (!is_writable($filename)) {
         $error .= "$error1 dir modules/downloads/file $error2<br>";
	}

	$filename = "modules/gallery/album";
   	if (!is_writable($filename)) {
         $error .= "$error1 dir modules/gallery/album $error2<br>";
	}

	$filename = "modules/reviews/images";
   	if (!is_writable($filename)) {
         $error .= "$error1 dir modules/reviews/images $error2<br>";
	}

	$filename = "cache/tmp_block.php";
   	if (!$handle = @fopen($filename, 'a')) {
         $error .= "$error1 dir cache $error3 file cache/tmp_block.php $error2<br>";
	}

	$filename = "blog";
   	if (!is_writable($filename)) {
         $error .= "$error1 dir blog $error2<br>";
	}

		@fclose($handle);

	if (!$error) {
		step2($lang, $BOARD);
		exit;
	}
	$content = $error;
	$output = $header.$content.$footer;
	print $output;
	exit;
}

function step2($lang, $BOARD) {

	global $header, $footer,  $_SERVER, $langin;

	$error = "";
	$urlstring = "Url del sito: <br>Url del tuo sito in cui si trova il file index.php di MKPortal,<br>da indicare senza slash finale (es. http://tuosito.it ).";
	$pathstring = "Path Forum: <br>Sottodirectory in cui si trova il forum, da indicare senza slash.<br>Ad esempio se il forum si trova appunto nella sottodirectory<br>forum scrivere nel campo solo la parola: forum";
	$gostring = "Procedi >>";

	if ($lang == "en") {
		$urlstring = "Url of site: <br>Url of your site where there is the index.php file of MKportal,<br>write it without the final slash (e.g. http://yoursite.com ).";
		$pathstring = "Path Forum: <br>Directory where your forum is put in, write it without the final slash.<br>For example, if your forum is under the directory 'forum'<br>write only the word: forum";
		$gostring = "Procedeed >>";
	}
	if ($lang == "fr") {
		$urlstring = "Url du site: <br>Url de votre site à l'emplacement où il y a le fichier index.php de MKportal, <br>écrivez-le sans le slash final (par exemple http://votre_site.com).";
		$pathstring = "Chemin du Forum: <br>Répertoire qui contient l'index.php de votre forum, écrivez-le sans le slash final.<br>Par exemple, si votre forum est dans le répertoire 'forum'<br>écrivez seulement le mot: forum";
		$gostring = "Suivant >>";
	}

	$siteurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	$siteurl = str_replace("/mkportal/mk_install.php", "", $siteurl);
	$siteurl = str_replace ("http:///", "http://", $siteurl);


	$content = "
 	<td>
	<tr>
	<form name=\"main1\" method=\"post\" action=\"mk_install.php?op=step3\">
	<tr>
	<input type=\"hidden\" name=\"lang\" value=\"$lang\">
	<input type=\"hidden\" name=\"BOARD\" value=\"$BOARD\">
	<td align=\"left\" id=\"titadmin\"><br><br><br>$urlstring<br></td>
	</tr>
	<tr>
	<td align=\"left\"><input id=\"bgselect\" type=\"text\" name=\"siteurl\" value=\"$siteurl\" size=\"60\"</td>
	</tr>
	<tr>
	<td id=\"titadmin\" align=\"left\"><br><br><br>$pathstring</td>
	</tr>
	<tr>
	<td align=\"left\"><input id=\"bgselect\" type=\"text\" name=\"forumpath\"  value=\"$forumpath\" size=\"60\"></td>
	</tr>
	<tr>
	<td align=\"left\">
	<br><br><br><input type=\"submit\" value=\"$gostring\" name=\"B1\"></td>
	</tr>
	</td>
	</tr>
	</form>
	";
	$output = $header.$content.$footer;
	print $output;
	exit;
}

function step3() {

	global $header, $footer, $langin;

	$error = "";
	$lang = $_POST['lang'];
	$BOARD = $_POST['BOARD'];

//da cambiare a seconda della board
	switch($BOARD) {
				case 'IPB':
    				$confff = "conf_global.php";
    			break;
				case 'PHPBB':
    				$confff = "config.php";
    			break;
				case 'VB':
    				$confff = "includes/config.php";
    			break;
				case 'OXY':
    				$confff = "include/config.php";
    			break;
				default:
    				$confff = "Settings.php";
    			break;
		}


	$mklang = "Italiano";
	$error1 = "ERRORE: devi compilare entrambi i campi.<br>";
	$error2 = "ERRORE: il percorso del forum è errato, non trovo il file $confff<br>";

	if ($lang == "en") {
		$mklang = "English";
		$error1 = "ERROR: you must compile both fields.<br>";
		$error2 = "ERROR: the path of your forum is wrong! It isn' possible to find the $confff file.";
	}
	if ($lang == "fr") {
		$mklang = "Francais";
		$error1 = "ERREUR : vous devez remplir les deux champs.<br>";
		$error2 = "ERREUR : le chemin de votre forum est erroné ! Impossible de trouver le fichier $confff.";
	}
	$siteurl = $_POST['siteurl'];
	$forumpath = $_POST['forumpath'];

	if (!$siteurl || !$forumpath) {
		$error = "$error1";
	}

	$filename = "../$forumpath/$confff";

   	if (!$handle = @fopen($filename, 'r')) {
         $error = "$error2";
	}

	if (!$error) {
		$content = "<?php\n\n \$FORUM_PATH = \"$forumpath\"; \n \$FORUM_VIEW = \"0\"; \n \$PORTAL_VIEW = \"0\"; \n \$FORUM_CD = \"1\"; \n \$FORUM_CS = \"1\"; \n \$SITE_NAME = \"MKPortal\";  \n \$SITE_URL = \"$siteurl\"; \n \$MK_TEMPLATE = \"default\"; \n \$MK_LANG = \"$mklang\"; \n \$MK_EDITOR = \"DEFAULT\"; \n \$MK_BOARD = \"$BOARD\"; \n ?>";
		$filename = "conf_mk.php";
   		if (!$handle = fopen($filename, 'w')) {
         	print "Non posso aprire il file $confff";
         	exit;
   		}
   		if (!fwrite($handle, $content)) {
       		print "Non posso scrivere nel file $confff Assicurati che abbia i permessi impostati in scrittura";
       		exit;
   		}
		fclose($handle);
		step4($forumpath, $lang, $BOARD);
		exit;
	}
	$content = $error;
	$output = $header.$content.$footer;
	print $output;
	exit;


}


function step4($forumpath, $lang, $BOARD) {

	global $header, $footer, $langin;

	$mtopic = "Ultimi Topic";
	$mperson = "Menu Personale";
	$monline = "Utenti online?";
	$mmain = "Menu Principale";
	$mforum = "Menu Forum";
	$mstats = "Statistiche Sito";
	$mshout = "Ultimi Urli";
	$mrandomg = "Random Gallery";
	$mchat = "Chat";
	$mcalend = "Calendario";
	$mnews = "Ultime News";
	$mpoll = "Sondaggio";
	$okend = "!! MKPORTAL INSTALLATO CON SUCCESSO !!<br><br><br>Cancellare subito dal server il file \"mk_install.php\" per la sicurezza del vostro Database.";
	$loginmk = "Entra nel tuo Portale";

	if ($lang == "en") {
		$mtopic = "Latest Topics";
		$mperson = "Personal Menu";
		$monline = "Online Users";
		$mmain = "Main Menu";
		$mforum = "Board Menu";
		$mstats = "Site Stats";
		$mshout = "Last Shouts";
		$mrandomg = "Random Image";
		$mchat = "Chat";
		$mcalend = "Calendar";
		$mnews = "Latest News";
		$mpoll = "Poll";
		$okend = "MKPORTAL SUCCESSFULLY INSTALLED!!<br><br><br>For security reason of your database, delete immediately from server the mk_install.php file.";
		$loginmk = "Enter into your Portal";
	}
	if ($lang == "fr") {
		$mtopic = "Derniers messages";
		$mperson = "Menu Personnel";
		$monline = "En Ligne";
		$mmain = "Menu Principal";
		$mforum = "Menu Forum";
		$mstats = "Statistiques";
		$mshout = "Derniers Shouts";
		$mrandomg = "Image par hazard";
		$mchat = "Chat";
		$mcalend = "Calendrier";
		$mnews = "Dernières Nouvelles";
		$mpoll = "Sondage";
		$okend = "MKPORTAL A ÉTÉ INSTALLÉ AVEC SUCCÈS!!<br><br><br>Pour des raisons de sécurité de votre base de données, supprimez immédiatement de votre serveur le fichier mk_install.php. ";
		$loginmk = "Entrez dans votre portail";
	}
//da cambiare a seconda della board

	switch($BOARD) {
				case 'IPB':
    				$confff = "conf_global.php";
    			break;
				case 'PHPBB':
    				$confff = "config.php";
				break;
				case 'VB':
    				$confff = "includes/config.php";
				break;
				case 'OXY':
    				$confff = "include/config.php";
    			break;
				default:
    				$confff = "Settings.php";
    			break;
	}
	//define('IN_PHPBB', true);
	require "../$forumpath/$confff";

	switch($BOARD) {
				case 'IPB':
    				$dbhost = $INFO['sql_host'];
					$dbname = $INFO['sql_database'];
					$dbuser = $INFO['sql_user'];
					$dbpasswd = $INFO['sql_pass'];
    			break;
				case 'PHPBB':
    				$dbhost = $dbhost;
					$dbname = $dbname;
					$dbuser = $dbuser;
					$dbpasswd = $dbpasswd;
    			break;
				case 'VB':
    				$dbhost = $servername;
					$dbname = $dbname;
					$dbuser = $dbusername;
					$dbpasswd = $dbpassword;
    			break;
				case 'OXY':
    				$dbhost = $dbhost;
					$dbname = $dbname;
					$dbuser = $dbuser;
					$dbpasswd = $dbpw;
    			break;
				default:
    				$dbhost = $db_server;
					$dbname = $db_name;
					$dbuser = $db_user;
					$dbpasswd = $db_passwd;
    			break;
	}

		$checkdb_conn = mysql_connect($dbhost, $dbuser, $dbpasswd);
		mysql_select_db($dbname);

	if (!$checkdb_conn) {
		echo "Error, Couldn't connect to database";
		exit;
	}

	// installa le table nel db
$query1="
	CREATE TABLE `mkp_blocks` (
  `id` int(11) NOT NULL auto_increment,
  `file` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `position` varchar(20) NOT NULL default 'sinistra',
  `progressive` int(3) NOT NULL default '100',
  `active` varchar(10) default NULL,
  `personal` int(2) NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
);";

mysql_query($query1);

$query2 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (3, 'last_forum_post.php', '$mtopic', 'destra', 2, 'checked', 0, '')";
$query3 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (4, 'login.php', '$mperson', 'sinistra', 2, 'checked', 0, '')";
$query4 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (5, 'online.php', '$monline', 'sinistra', 3, 'checked', 0, '')";
$query5 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (6, 'sitenav.php', '$mmain', 'sinistra', 1, 'checked', 0, '')";
$query6 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (40, 'forumnav.php', '$mforum', 'destra', 1, 'checked', 0, '')";
$query7 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (44, 'site_stat.php', '$mstats', 'destra', 5, 'checked', 0, '')";
$query8 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (45, 'last_urlo.php', '$mshout', 'destra', 3, 'checked', 0, '')";
$query9 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (46, 'random_pic.php', '$mrandomg', 'sinistra', 5, 'checked', 0, '')";
$query10 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (47, 'chat.php', '$mchat', 'sinistra', 4, 'checked', 0, '')";
$query11 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (48, 'calendar.php', '$mcalend', 'destra', 4, 'checked', 0, '')";
$query12 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (49, 'news.php', '$mnews', 'centro', 1, 'checked', 0, '')";
$query13 = "INSERT INTO `mkp_blocks` (`id`, `file`, `title`, `position`, `progressive`, `active`, `personal`, `content`) VALUES (64, 'poll.php', '$mpoll', 'sinistra', 6, 'checked', 0, '')";


//mysql_query($query2);
mysql_query($query3);
mysql_query($query4);
mysql_query($query5);
mysql_query($query6);
mysql_query($query7);
mysql_query($query8);
mysql_query($query9);
mysql_query($query10);
mysql_query($query11);
mysql_query($query12);
//mysql_query($query13);

$query14="
CREATE TABLE `mkp_chat` (
  `id` int(10) NOT NULL default '0',
  `nick` varchar(40) NOT NULL default '',
  `run_time` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query14);

$query15="
CREATE TABLE `mkp_config` (
  `id` int(11) NOT NULL auto_increment,
  `chiave` varchar(255) NOT NULL default '',
  `valore` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
);";

mysql_query($query15);
#
# Dumping data for table `mkp_config`
#

$query16 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (1, 'counter', '0')";
$query17 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (2, 'download_sec_page', '10')";
$query18 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (3, 'download_file_page', '20')";
$query19 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (4, 'gallery_sec_page', '9')";
$query20 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (5, 'gallery_file_page', '10')";
$query21 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (6, 'chat_server', 'irc.azzurra.org')";
$query22 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (7, 'chat_port', '6667')";
$query23 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (8, 'chat_channel', '#MKPortal_Chat')";
$query24 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (9, 'urlo_page', '20')";
$query25 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (10, 'urlo_max', '300')";
$query26 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (11, 'urlo_block', '10')";
$query27 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (12, 'upload_file_max', '1000')";
$query28 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (13, 'upload_image_max', '1000')";
$query29 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (15, 'news_page', '10')";
$query30 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (16, 'news_block', '10')";
$query31 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (17, 'poll_active', '0')";
$query32 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (18, 'news_words', '0')";
$query33 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (19, 'news_html', '0')";
$query34 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (20, 'mod_reviews', '0')";
$query35 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (21, 'rev_sec_page', '10')";
$query36 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (22, 'rev_file_page', '10')";
$query37 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (23, 'quote_page', '50')";
$query38 = "INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (24, 'mod_quote', '0')";

mysql_query($query16);
mysql_query($query17);
mysql_query($query18);
mysql_query($query19);
mysql_query($query20);
mysql_query($query21);
mysql_query($query22);
mysql_query($query23);
mysql_query($query24);
mysql_query($query25);
mysql_query($query26);
mysql_query($query27);
mysql_query($query28);
mysql_query($query29);
mysql_query($query30);
mysql_query($query31);
mysql_query($query32);
mysql_query($query33);
mysql_query($query34);
mysql_query($query35);
mysql_query($query36);
mysql_query($query37);
mysql_query($query38);

//added in M.09

$query16 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_quote', '0')";
$query17 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_blog', '0')";
$query18 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_gallery', '0')";
$query19 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_download', '0')";
$query20 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_news', '0')";
$query21 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_topsite', '0')";
$query22 = "INSERT INTO `mkp_config` (`chiave`, `valore`) VALUES ('approval_review', '0')";

mysql_query($query16);
mysql_query($query17);
mysql_query($query18);
mysql_query($query19);
mysql_query($query20);
mysql_query($query21);
mysql_query($query22);



$query39="
CREATE TABLE `mkp_download` (
  `id` int(10) NOT NULL auto_increment,
  `idcategoria` int(10) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `file` text NOT NULL,
  `downloads` int(10) NOT NULL default '0',
  `click` int(10) NOT NULL default '0',
  `data` int(10) NOT NULL default '0',
  `rate` varchar(10) NOT NULL default '',
  `trate` int(10) NOT NULL default '0',
  `screen1` varchar(255) NOT NULL default '',
  `screen2` varchar(255) NOT NULL default '',
  `demo` varchar(255) NOT NULL default '',
  `autore` varchar(40) NOT NULL default '',
  `peso` int(11) NOT NULL default '0',
  `validate` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
);";

mysql_query($query39);


$query40="
CREATE TABLE `mkp_download_comments` (
  `id` int(10) NOT NULL auto_increment,
  `identry` int(10) NOT NULL default '0',
  `autore` varchar(255) NOT NULL default '',
  `testo` text NOT NULL,
  `data` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query40);


$query41="
CREATE TABLE `mkp_download_sections` (
  `id` int(11) NOT NULL auto_increment,
  `evento` varchar(255) NOT NULL default '',
  `descrizione` text NOT NULL,
  `position` int(4) NOT NULL default '1',
  `father` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query41);

$query42="
CREATE TABLE `mkp_gallery` (
  `id` int(11) NOT NULL auto_increment,
  `evento` int(4) NOT NULL default '0',
  `titolo` varchar(255) NOT NULL default '',
  `descrizione` varchar(255) NOT NULL default '',
  `file` text NOT NULL,
  `click` int(10) NOT NULL default '0',
  `rate` varchar(10) NOT NULL default '',
  `trate` int(10) NOT NULL default '0',
  `autore` varchar(40) NOT NULL default '',
  `peso` int(11) NOT NULL default '0',
  `data` int(10) NOT NULL default '0',
  `validate` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
);";

mysql_query($query42);

$query43="
CREATE TABLE `mkp_gallery_comments` (
  `id` int(10) NOT NULL auto_increment,
  `identry` int(10) NOT NULL default '0',
  `autore` varchar(255) NOT NULL default '',
  `testo` text NOT NULL,
  `data` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query43);


$query44="
CREATE TABLE `mkp_gallery_events` (
  `id` int(11) NOT NULL auto_increment,
  `evento` varchar(255) NOT NULL default '',
  `position` int(4) NOT NULL default '1',
  `father` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query44);


$query45="
CREATE TABLE `mkp_news` (
  `id` int(11) NOT NULL auto_increment,
  `idcategoria` int(10) NOT NULL default '0',
  `idautore` int(10) NOT NULL default '0',
  `titolo` varchar(255) NOT NULL default '',
  `autore` varchar(34) NOT NULL default '',
  `testo` text NOT NULL,
  `data` int(10) NOT NULL default '0',
  `validate` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
);";

mysql_query($query45);


$query46 = "INSERT INTO `mkp_news` (`id`, `idcategoria`, `idautore`, `titolo`, `autore`, `testo`, `data`) VALUES (1, 1, 1, 'Benvenuti in MKPortal', 'meo', '\r\n        \r\n        \r\n        \r\n    	\r\n		<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"center\"><b><u>\r\n<font color=\"#ff0000\" size=\"4\">Benvenuti in MKPortal<br /></font></u></b></p>\r\n\r\n\r\n\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"center\">&nbsp;</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\">\r\n<img src=\"mkportal/include/mkbox.jpg\" align=\"left\" width=\"197\" height=\"311\" alt=\"\" /></p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\">&nbsp;</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\">&nbsp;</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\">&nbsp;</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\">\r\nMkportal è un prodotto che si va ad inserire in una categoria particolare.<br />L\'obiettivo di mkportal è di fornire all\'utente un portal-system di nuova concezione, semplice da gestire, ma completo ed efficiente.<br />Mkportal è votato alla massima intuitività e semplicità di uso e si pone come prodotto complementare ad una bullettin Board system (Forum). <br />Mkportal non comprende un proprio forum, ma rimane una applicazione separata, anche se per essere seguita presuppone comunque un forum a cui essere collegata.<br />Il codice e la struttura di mkportal sono del tutto separati dalle Board su cui vengono installati.<br />.<font size=\"2\" color=\"#363636\" face=\"Verdana, Helvetica\">&nbsp;</font></p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\">&nbsp;</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\"><u><b>Features presenti</b></u></p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\">&nbsp;</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\">&nbsp;</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\"><a href=\"index.php?ind=downloads\">Download system</a> (possibilità di caricare file, gestirli votarli e commentarli)</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\"><a href=\"index.php?ind=chat\">Chat</a> (chiacchierare online con gli altri utenti direttamente dal vostro portale)</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\"><a href=\"index.php?ind=urlobox\">Urlobox</a> (possibilità di lasciar dei messaggi istantanei sullo stile di un guestbook)</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\"><a href=\"index.php?ind=gallery\">Gallery</a> (inserimento e gestione di immagini potendole votare e commentare)</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\"><a href=\"index.php?ind=news\">News</a> (creare delle news e gestirle, classificarle e archiviarle comodamente)</p>\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\">&nbsp;</p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n<p style=\"margin-top: 0px; margin-bottom: 0px;\" align=\"justify\">Oltre a questo, potrete anche creare a vostro piacimento blocchi in puro <b>html</b> o utilizzando <b>php</b>, avrete le principali statistiche del forum inserite in blocchi laterali, un <b>contatore</b> delle visite integrato, un <b>calendario e tantissime altre opzioni che vi lasciamo scoprire.</b></p>\r\n\r\n		\r\n		\r\n		\r\n		\r\n		\r\n		', 1080395927)";
mysql_query($query46);


$query47="
CREATE TABLE `mkp_news_sections` (
  `id` int(10) NOT NULL auto_increment,
  `titolo` varchar(40) NOT NULL default '',
  `icona` varchar(255) NOT NULL default '',
  `position` int(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query47);


$query48 = "INSERT INTO `mkp_news_sections` (`id`, `titolo`, `icona`, `position`) VALUES (1, 'Annunci', '1', 0)";
mysql_query($query48);

$query49="
CREATE TABLE `mkp_pages` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
);";

mysql_query($query49);

$query50="
CREATE TABLE `mkp_pgroups` (
  `g_id` int(3) NOT NULL default '0',
  `g_title` varchar(23) NOT NULL default '',
  `g_send_news` tinyint(1) NOT NULL default '0',
  `g_mod_news` tinyint(1) NOT NULL default '0',
  `g_access_download` tinyint(1) NOT NULL default '0',
  `g_send_download` tinyint(1) NOT NULL default '0',
  `g_mod_download` tinyint(1) NOT NULL default '0',
  `g_access_gallery` tinyint(1) NOT NULL default '0',
  `g_send_gallery` tinyint(1) NOT NULL default '0',
  `g_mod_gallery` tinyint(1) NOT NULL default '0',
  `g_access_urlobox` tinyint(1) NOT NULL default '0',
  `g_send_urlobox` tinyint(1) NOT NULL default '0',
  `g_mod_urlobox` tinyint(1) NOT NULL default '0',
  `g_access_chat` tinyint(1) NOT NULL default '0',
  `g_access_cpa` tinyint(1) NOT NULL default '0',
  `g_access_blog` tinyint(1) NOT NULL default '1',
  `g_send_blog` tinyint(1) NOT NULL default '0',
  `g_access_topsite` tinyint(1) NOT NULL default '1',
  `g_send_topsite` tinyint(1) NOT NULL default '0',
  `g_send_ecard` tinyint(1) NOT NULL default '0',
  `g_send_quote` tinyint(1) NOT NULL default '0',
  `g_send_comments` tinyint(1) NOT NULL default '0',
  `g_access_reviews` tinyint(1) NOT NULL default '0',
  `g_send_reviews` tinyint(1) NOT NULL default '0',
  `g_mod_reviews` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`g_id`)
);";

mysql_query($query50);

//da cambiare a seconda della board
switch($BOARD) {
				case 'IPB':
    				$query51 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (3, 'Members', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query52 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (1, 'Validating', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
					$query53 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (2, 'Guests', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
					mysql_query($query51);
					mysql_query($query52);
					mysql_query($query53);
    			break;
				case 'PHPBB':
    				$query51 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (3, 'Members', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query52 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (2, 'Moderators', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query53 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (9, 'Guests', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
					mysql_query($query51);
					mysql_query($query52);
					mysql_query($query53);
    			break;
				case 'VB':
    				$query51 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (2, 'Members', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query52 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (5, 'Moderators', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query53 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (1, 'Guests', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
					$query100 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (7, 'Super Moderators', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					mysql_query($query51);
					mysql_query($query52);
					mysql_query($query53);
					mysql_query($query100);
    			break;
				case 'OXY':
    				$query51 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (3, 'Member', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query52 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (2, 'Moderator', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query53 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (1, 'Guest', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
					$query100 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (4, 'Super Moderator', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query101 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (5, 'Waiting', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
					$query102 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (6, 'Banned', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
					mysql_query($query51);
					mysql_query($query52);
					mysql_query($query53);
					mysql_query($query100);
					mysql_query($query101);
					mysql_query($query102);
    			break;
				default:
    				$query100 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (2, 'Global Moderator', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query101 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (3, 'Moderator', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query102 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (4, 'Newbie', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query103 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (5, 'Jr. Member', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query104 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (6, 'Full Member', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query105 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (7, 'Sr. Member', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query106 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (8, 'Hero Member', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0)";
					$query107 = "INSERT INTO `mkp_pgroups` (`g_id`, `g_title`, `g_send_news`, `g_mod_news`, `g_access_download`, `g_send_download`, `g_mod_download`, `g_access_gallery`, `g_send_gallery`, `g_mod_gallery`, `g_access_urlobox`, `g_send_urlobox`, `g_mod_urlobox`, `g_access_chat`, `g_access_cpa`) VALUES (99, 'Guests', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
					mysql_query($query100);
					mysql_query($query101);
					mysql_query($query102);
					mysql_query($query103);
					mysql_query($query104);
					mysql_query($query105);
					mysql_query($query106);
					mysql_query($query107);
    			break;
		}



$query54="
CREATE TABLE `mkp_urlobox` (
  `id` int(11) NOT NULL auto_increment,
  `idaut` int(10) NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `message` text NOT NULL,
  `time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query54);

$query55="
CREATE TABLE `mkp_blog` (
  `id` int(11) NOT NULL default '0',
  `autore` varchar(40) NOT NULL default '',
  `titolo` varchar(25) NOT NULL default '',
  `descrizione` text NOT NULL,
  `template` text NOT NULL,
  `template2` text NOT NULL,
  `eta` varchar(25) NOT NULL default '',
  `segno` varchar(25) NOT NULL default '',
  `citta` varchar(25) NOT NULL default '',
  `libri` text NOT NULL,
  `film` text NOT NULL,
  `canzoni` text NOT NULL,
  `link` text NOT NULL,
  `amo` text NOT NULL,
  `odio` text NOT NULL,
  `umore` varchar(30) NOT NULL default 'felice',
  `citazione` text NOT NULL,
  `click` int(11) NOT NULL default '0',
  `privacy` varchar(5) NOT NULL default 'ok',
  `mailcomm` varchar(5) NOT NULL default 'ok',
  `mailbloga` varchar(5) NOT NULL default 'ok',
  `maxmess` int(3) NOT NULL default '10',
  `aggiornato` int(11) NOT NULL default '0',
  `categoria` varchar(30) NOT NULL default '',
  `link_blog` text NOT NULL,
  `anon_comm` char(2) NOT NULL default 'no',
  `creato` int(11) NOT NULL default '0',
  `ip_address` varchar(32) NOT NULL default '',
  `rate` varchar(10) NOT NULL default '',
  `trate` int(10) NOT NULL default '0',
  `banner` varchar(255) NOT NULL default '',
  `validate` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
);";

mysql_query($query55);

$query56="
CREATE TABLE `mkp_blog_commenti` (
  `id` int(11) NOT NULL auto_increment,
  `id_blog` int(11) NOT NULL default '0',
  `id_post` int(11) NOT NULL default '0',
  `autore` varchar(25) NOT NULL default '',
  `home` varchar(80) NOT NULL default '',
  `commento` text NOT NULL,
  PRIMARY KEY  (`id`)
);";

mysql_query($query56);

$query57="
CREATE TABLE `mkp_blog_post` (
  `id` int(11) NOT NULL auto_increment,
  `id_blog` int(11) NOT NULL default '0',
  `post` text NOT NULL,
  `data` int(11) NOT NULL default '0',
  `ncom` int(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query57);

$query58="
CREATE TABLE `mkp_topsite` (
  `id` int(10) NOT NULL auto_increment,
  `id_member` int(10) NOT NULL default '0',
  `title` varchar(80) NOT NULL default '',
  `description` varchar(200) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `banner` varchar(255) NOT NULL default '',
  `banner2` varchar(255) NOT NULL default '',
  `click` int(6) NOT NULL default '0',
  `rate` varchar(40) NOT NULL default '',
  `trate` int(6) NOT NULL default '0',
  `validate` tinyint(1) NOT NULL default '0',
  `email` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
);";

mysql_query($query58);


$query59="
CREATE TABLE `mkp_votes` (
  `id` int(10) NOT NULL auto_increment,
  `id_entry` int(10) NOT NULL default '0',
  `module` varchar(40) NOT NULL default '',
  `id_member` int(10) NOT NULL default '0',
  `ip` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
);";

mysql_query($query59);

$query60="INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (25, 'topsite_page', '10')";
$query61="INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (26, 'blog_page', '10')";
$query62="INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (27, 'mod_blog', '')";
$query63="INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (28, 'mod_gallery', '')";
$query64="INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (29, 'mod_urlobox', '')";
$query65="INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (30, 'mod_downloads', '')";
$query66="INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (31, 'mod_news', '')";
$query67="INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (32, 'mod_topsite', '')";
$query68="INSERT INTO `mkp_config` (`id`, `chiave`, `valore`) VALUES (33, 'mod_chat', '')";

mysql_query($query60);
mysql_query($query61);
mysql_query($query62);
mysql_query($query63);
mysql_query($query64);
mysql_query($query65);
mysql_query($query66);
mysql_query($query67);
mysql_query($query68);

$query69="
CREATE TABLE `mkp_news_comments` (
  `id` int(10) NOT NULL auto_increment,
  `identry` int(10) NOT NULL default '0',
  `autore` varchar(255) NOT NULL,
  `testo` text NOT NULL,
  `data` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query69);

$query70="
CREATE TABLE `mkp_quotes` (
  `id` int(11) NOT NULL auto_increment,
  `author` varchar(64) NOT NULL default 'Unknown',
  `member` varchar(64) NOT NULL default 'Staff',
  `member_id` int(11) NOT NULL default '0',
  `quote` varchar(255) NOT NULL default 'No quote',
  `date_added` int(11) NOT NULL default '0',
  `validate` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query70);

$query71="
CREATE TABLE `mkp_ecards` (
  `id` int(10) NOT NULL auto_increment,
  `titolo` varchar(64) NOT NULL,
  `file` varchar(255) NOT NULL,
  `destinatario` varchar(64) NOT NULL,
  `mittente` varchar(64) NOT NULL,
  `emailmit` varchar(64) NOT NULL,
  `testo` text NOT NULL,
  `member` varchar(64) NOT NULL,
  `date` int(10) NOT NULL default '0',
  `code` int(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query71);


$query72="
CREATE TABLE `mkp_reviews` (
  `id` int(10) NOT NULL auto_increment,
  `id_cat` int(10) NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `field1` varchar(255) NOT NULL,
  `field2` varchar(255) NOT NULL,
  `field3` varchar(255) NOT NULL,
  `field4` varchar(255) NOT NULL,
  `field5` varchar(255) NOT NULL,
  `field6` varchar(255) NOT NULL,
  `field7` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `author` varchar(40) NOT NULL,
  `idauth` int(10) NOT NULL default '0',
  `click` int(10) NOT NULL default '0',
  `rate` varchar(10) NOT NULL,
  `trate` int(10) NOT NULL default '0',
  `date` int(10) NOT NULL default '0',
  `validate` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
);";

mysql_query($query72);

$query73="
CREATE TABLE `mkp_reviews_comments` (
  `id` int(10) NOT NULL auto_increment,
  `identry` int(10) NOT NULL default '0',
  `autore` varchar(40) NOT NULL,
  `testo` text NOT NULL,
  `data` int(10) NOT NULL default '0',
  `scambio` tinyint(1) NOT NULL default '0',
  `id_autore` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query73);

$query74="
CREATE TABLE `mkp_reviews_sections` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(60) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `field1` varchar(60) NOT NULL,
  `field2` varchar(60) NOT NULL,
  `field3` varchar(60) NOT NULL,
  `field4` varchar(60) NOT NULL,
  `field5` varchar(60) NOT NULL,
  `field6` varchar(60) NOT NULL,
  `field7` text NOT NULL,
  `position` int(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query74);

$query75="
CREATE TABLE `mkp_mainlinks` (
  `id` tinyint(3) NOT NULL auto_increment,
  `icon` text NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `url` text NOT NULL,
  `type` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

mysql_query($query75);

	$content = "<br><br><br>$okend<br><br>
	<br><br><span style='color: rgb(255, 0, 0); font-weight: bold;'><a href=\"../index.php\">$loginmk</a> </span>";
	$output = $header.$content.$footer;
	print $output;
	mysql_close();
	exit;
}

?>
