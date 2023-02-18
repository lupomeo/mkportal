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
|
|   > Translation French
|   > Written By Jack,
|   > http://www.mkportal-fr.com/
|   > Email: Jack_FDPC@hotmail.com
|
+--------------------------------------------------------------------------
*/

// common
$langmk['ad_titlepage'] = "Administration MKPortal";
$langmk['ad_yes'] = "Oui";
$langmk['ad_no'] = "Non";
$langmk['ad_preferences'] = "Préférences";
$langmk['ad_save'] = "Enregistrer";
$langmk['ad_saved'] = "Préférences Enregistrées avec Succès";
$langmk['ad_delete'] = "Supprimer";
$langmk['ad_edit'] = "&Eacute;diter";
$langmk['ad_insert'] = "Insérer";
$langmk['ad_activeon'] = "Activer";
$langmk['ad_address'] = "Addresse";
$langmk['ad_addresspage'] = "URL de la Page";
$langmk['ad_email'] = "Email";
$langmk['ad_banner'] = "Bannière";
$langmk['ad_author'] = "Auteur";
$langmk['ad_title'] = "Titre";
$langmk['ad_section'] = "Section";
$langmk['ad_description'] = "Description";
$langmk['ad_icon'] = "Icône";
$langmk['ad_image'] = "Image";
$langmk['ad_position'] = "Position";
$langmk['ad_show'] = "Voir";
$langmk['ad_actions'] = "Actions";
$langmk['ad_addsection'] = "Ajouter une Section";
$langmk['ad_editsection'] = "&Eacute;diter une Section";
$langmk['ad_editimage'] = "&Eacute;diter une Image";
$langmk['ad_delsection'] = "Supprimer une Section";
$langmk['ad_addiconimage'] = "Icône de l'Image";
$langmk['ad_go'] = "OK";
$langmk['ad_delsecconfirm'] = "Êtes-vous sûr de vouloir supprimer cette section?";
$langmk['ad_delgenconfirm'] = "Êtes-vous sûr de vouloir supprimer?";
$langmk['ad_editor'] = "&Eacute;diteur";

// errors
$langmk['ad_all_rows'] = "Vous devez compléter tous les champs.";
$langmk['ad_req_cat'] = "Vous devez créer une catégorie en premier.";
$langmk['ad_req_ncat'] = "Vous devez insérer un nom pour la catégorie.";
$langmk['ad_req_ndcat'] = "Vous devez insérer un nom et une description pour la catégorie.";
$langmk['ad_req_nicat'] = "Vous devez insérer un nom et une icône pour la catégorie.";
$langmk['ad_nodelcat'] = "Aucune catégorie à supprimer.";
$langmk['ad_gfnosupport'] = "Format d'Image non supporter.";
$langmk['ad_guptoobig'] = "Le fichier dépasse la taille maximum d'envoie.";
$langmk['ad_gdirnoperm'] = "Ne peut pas envoyer l'image.<br /> Assurez vous que la permission d'écriture est assurer de cet emplacement \"mkportal/modules/gallery/album\" est (CHMOD 777).";
$langmk['ad_gfnofile'] = "Ne peut pas trouver le fichier configuré dans le dossier modules/gallery/album .<br /> Vérifiez votre le nom du fichier par FTP.";
$langmk['ad_dowdelsub'] = "Vous ne pouvez pas supprimer les sections qui contiennent des sous-catégories, supprimer les sous-catégories en premiers";
$langmk['ad_dowreq3'] = "Vous devez remplir champs avec au moins un titre, une catégorie et une description.";
$langmk['ad_downofile'] = "Ne peut pas trouver le fichier configuré dans le dossier modules/downloads/file .<br /> Vérifiez votre le nom du fichier par FTP.";
$langmk['ad_blnofile'] = "Ne peut pas ouvrir le dossier.  Vérifiez la permission d'écriture du dossie mkportal/cache .";
$langmk['ad_noperms'] = "Vous n'êtes pas autorisé à entrer dans le PC Admin."; //added in M07			 

//ad_main
$langmk['ad_boardname'] = "Board Installé (&Eacute;diter conf_mk.php pour la changer)";
$langmk['sitename'] = "Nom du Site";
$langmk['ad_siteurl'] = "URL du Site (&Eacute;diter conf_mk.php pour le changer)";
$langmk['ad_skin'] = "Skin";
$langmk['ad_lang'] = "Langue";
$langmk['ad_fpath'] = "Emplacement du Forum (&Eacute;diter conf_mk.php pour le changer)";
$langmk['ad_mkview'] = "Visualisation de MKPortal";
$langmk['ad_mkviewsmall'] = "Configurer Taille";
$langmk['ad_mkviewlarge'] = "Pleine Page";
$langmk['ad_forumview'] = "Visualisation du Forum";
$langmk['ad_forumin'] = "&Agrave; l'Interieur de MKPortal";
$langmk['ad_forumout'] = "&Agrave; l'Exterieur de MKPortal";
$langmk['ad_rightcolumn'] = "Fermer la colonne de droite lorsque le Forum est affiché?";
$langmk['ad_leftcolumn'] = "Fermer la colonne de gauche lorsque le Forum est affiché?";
$langmk['ad_sytime'] = "Synchronisation de l'heure entre MKPortal et le Forum:";
$langmk['ad_curtime'] = "Date et heure actuel de MKPortal:";
$langmk['ad_diftime'] = "Diff d'heure du Forum:";
$langmk['ad_powidth'] = "Largeur totale de portail (Min. 780px, max. 1600px, seulement disponible avec Configurer Taille)";
$langmk['ad_cowidth'] = "Largeur De Colonnes Latérale (Min. 120px, max. 280px)";

//ad_blog
$langmk['ad_delblog'] = "Blog Supprimer avec Succès";
$langmk['ad_delblogconfirm'] = "Êtes-vous sûr de vouloir supprimer ce Blog?";
$langmk['ad_blogdisactive'] = "Désactiver le Module Blog";
$langmk['ad_blogpages'] = "Nombre de Blog a Afficher par page (Accueil Blogs)";
$langmk['ad_bloglist'] = "Liste de Blog par Ordre Alphabétique";
$langmk['ad_blogtitle'] = "Gérer Blog";

//ad_chat
$langmk['ad_chatdisactive'] = "Désactiver le Module Chat";
$langmk['ad_chatserver'] = "Serveur Chat";
$langmk['ad_chatport'] = "Port du Serveur";
$langmk['ad_chatchan'] = "Cannal par Défaut";
$langmk['ad_chattitle'] = "Gérer Chat";

//ad_content
$langmk['ad_delpageconfirm'] = "Êtes-vous sûr de vouloir supprimer cette page?";
$langmk['ad_contentslist'] = "Liste des Pages";
$langmk['ad_contentsedit'] = "&Eacute;diter Page";
$langmk['ad_contentsnew'] = "Créer une Nouvelle Page";

//ad_menu
$langmk['ad_mgeneral'] = "Principal";
$langmk['ad_mperm'] = "Permissions";
$langmk['ad_mblocks'] = "Blocs";
$langmk['ad_mposition'] = "Position";
$langmk['ad_mcreation'] = "Création";
$langmk['ad_mmanage'] = "Gestion";
$langmk['ad_mcont'] = "Pages Internes";
$langmk['ad_mmod'] = "Modules Internes";
$langmk['ad_mpoll'] = "Sondages";
$langmk['ad_quote'] = "Citations";
$langmk['ad_review'] = "Revues";
$langmk['ad_bnews'] = "Nouvelles Forum";

//ad_boardnews
$langmk['ad_bnewstitle'] = "Importer les Nouvelle du Forum";
$langmk['ad_bnewschose'] = "Séléctionner le Forum pour importer les nouvelles:";

//ad_news
$langmk['ad_newdisactive'] = "Désactiver le Module des Nouvelles";
$langmk['ad_newspages'] = "Nombre de nouvelles à afficher par page d'archives";
$langmk['ad_newsblockp'] = "Nombre de nouvelles à afficher sur le bloc intérieur (Accueil)";
$langmk['ad_newsaddressicon'] = "URL de l'Icône Alternative";
$langmk['ad_newswarning'] = "AVERTISSEMENT:  Supprimer une section supprimera également toutes les nouvelles contenues dans sa section.";
$langmk['ad_newstitle'] = "Gérer les Nouvelles";
$langmk['ad_newsedittitle'] = "Éditer la Section de Nouvelles";
$langmk['ad_newsmaxwords'] = " Nombre maximal de caractères contenus dans les prévisualisations de nouvelles";
$langmk['ad_newshtmldisac'] = "Désactiver les code HTML dans les prévisualisations de nouvelles";

//ad_perms
$langmk['ad_permset'] = "Configurer les Permissions de Groupe:";
$langmk['ad_permtitle'] = "Gérer les Permissions";
$langmk['ad_permcho'] = "Choisir les actions pour ce groupe";
$langmk['ad_p_sendnews'] = "Peut Insérer des Nouvelles?";
$langmk['ad_p_modnews'] = "Peut Modérer les Nouvelles?";
$langmk['ad_p_accdown'] = "Peut entrer dans la Section de Téléchargements?";
$langmk['ad_p_senddown'] = "Peut Insérer des Fichiers dans la Section de Téléchargements?";
$langmk['ad_p_moddown'] = "Peut Modérer la Section de Téléchargements?";
$langmk['ad_p_accgal'] = "Peut Voir la Galerie d'Image?";
$langmk['ad_p_sendgal'] = "Peut Insérer des Images dans la Galerie d'Image?";
$langmk['ad_p_modgal'] = "Peut Modérer la Galerie d'Image?";
$langmk['ad_p_accurlo'] = "Peut Voir la Shoutbox?";
$langmk['ad_p_sendurlo'] = "Peut &Eacute;crire des Messages dans la Shoutbox?";
$langmk['ad_p_modurlo'] = "Peut Modérer la Shoutbox?";
$langmk['ad_p_accblog'] = "Peut Voir les Blogs?";
$langmk['ad_p_sendblog'] = "Peut Avoir un Blog?";
$langmk['ad_p_acctop'] = "Peut Voir la Liste des Sites Top?";
$langmk['ad_p_sendtop'] = "Peut Soumettre un Site Web?";
$langmk['ad_p_accchat'] = "Peut Entrer dans le Salon de Chat?";
$langmk['ad_p_admin'] = "Peut Gérer MKPortal?";
$langmk['ad_perm_save'] = "Enregistrer les Permissions";
$langmk['ad_p_ecard'] = "Peut Envoyer des eCarte?";
$langmk['ad_p_quote'] = "Peut Soumettre des Citations?";
$langmk['ad_p_comments'] = "Peut &Eacute;crire des Commentaires?";
$langmk['ad_p_accreviews'] = "Peut Voir les Revues?";
$langmk['ad_p_sendreviews'] = "Peut Soumettre des Revues?";
$langmk['ad_p_modreviews'] = "Peut Modérer les Revues?";

//ad_poll
$langmk['ad_pollset'] = "Choisir le sondage du forum à afficher:";
$langmk['ad_polltitle'] = "Gérer Sondages";

//ad_topsite
$langmk['ad_toptitle'] = "Gérer la Liste de TopSite";
$langmk['ad_topactived'] = "Site soumis à la liste de TopSite.";
$langmk['ad_topdeleted'] = "Site supprimé de la base de données.";
$langmk['ad_deltopconfirm'] = "Êtes-vous sûr de vouloir supprimer ce Site?";
$langmk['ad_topdisactive'] = "Désactiver le Module de la Liste de TopSite";
$langmk['ad_toppages'] = "Nombre de Site a afficher par page";
$langmk['ad_topsubmitted'] = "Site attendant l'approbation:";
$langmk['ad_topactivated'] = "Site(s) Approuvé(s):";
$langmk['ad_topeditsite'] = "&Eacute;diter TopSite";
$langmk['ad_topeditdata'] = "&Eacute;diter les détails du Site.";
$langmk['ad_topname'] = "Nom du Site:";
$langmk['ad_topurl'] = "URL du Site:";
$langmk['ad_topemailw'] = "Adresse email du Webmaster:";
$langmk['ad_topdesc'] = "Description du Site:";
$langmk['ad_topurlban'] = "URL de la Bannière:";
$langmk['ad_topurlsban'] = "URL de la Minibanière (pour le bloc Site par hazard):";
$langmk['ad_toppb'] = "Prévisualisation de la Bannière:";
$langmk['ad_toppbs'] = "Prévisualisation de la Minibannière:";
$langmk['ad_topedittitle'] = "&Eacute;diter la liste de TopSite";

//ad_urlo
$langmk['ad_urlotitle'] = "Gérer Shoutbox";
$langmk['ad_urlodisactive'] = "Désactiver le Module Shoutbox";
$langmk['ad_urlopages'] = "Nombre de message à afficher par page";
$langmk['ad_urlomax'] = "Nombre maximum de message à garder dans la base de données";
$langmk['ad_urloblock'] = "Nombre de messages a afficher dans le bloc";

//ad_gallery
$langmk['ad_galtitle'] = "Gérer la Galerie d'Image";
$langmk['ad_galdisactive'] = "Désactiver le Module de Galerie d'Image";
$langmk['ad_galspages'] = "Nombre de sections à afficher par page";
$langmk['ad_galipages'] = "Nombre d'images à afficher par page";
$langmk['ad_galmaxup'] = "Taille maximum du fichier à envoyer <br />en Kilo Octet (0 = Aucune Limite)";
$langmk['ad_galwarning'] = "AVERTISSEMENT:  Supprimer une section supprimera également toutes les images contenues dans sa section.";
$langmk['ad_galupim'] = "Envoyer Image";
$langmk['ad_galaddim'] = "Ajoutez les images envoyer par FTP à la galerie d'image<br />(Assurez-vous que vous avez placé la permission d'écriture correcte au dossier upload, et également d'avoir placer vos images dans le répertoire mkportal/modules/gallery/album/)";
$langmk['ad_galaddname'] = "Nom des Fichiers Envoyer";
$langmk['ad_galv_e_d'] = "Afficher/&Eacute;diter/Supprimer Images";
$langmk['ad_galeditsec'] = "Éditez La Section de Galerie d'Image";
$langmk['ad_gsnoimages'] = "Aucunes Images dans cette section.";

//ad_download
$langmk['ad_dowdisactive'] = "Désactiver le Module de la Section Téléchargement";
$langmk['ad_dowtitle'] = "Gérer la Section Téléchargements";
$langmk['ad_dowpcat'] = "Catégorie Principale";
$langmk['ad_dowsfileup'] = "Fichier Envoyer avec Succès.";
$langmk['ad_dowfilepage'] = "Nombre de Fichiers par Page";
$langmk['ad_dowcat_scat'] = "Catégorie Principale/Sous-Catégorie";
$langmk['ad_dowwarn'] = "AVERTISSEMENT:  Supprimer une section supprimera également tous les fichiers contenus dans sa section.";
$langmk['ad_dowaddfile'] = "Ajouter un Fichier envoyer par FTP.";
$langmk['ad_dowsc'] = "Capture d'&Eacute;cran";
$langmk['ad_dowdurl'] = "URL de Démonstration";
$langmk['ad_dowfcat'] = "Catégorie";
$langmk['ad_doweditsec'] = "&Eacute;diter la Section de Téléchargements";

//ad_blocks
$langmk['ad_blcfg'] = "Configuration Blocs";
$langmk['ad_left'] = "Gauche";
$langmk['ad_center'] = "Centre";
$langmk['ad_right'] = "Droite";
$langmk['ad_active'] = "Actif";
$langmk['ad_delblockconfirm'] = "Êtes-vous sûr de vouloir supprimer ce bloc?";
$langmk['ad_bllist'] = "Liste Personnelle de Blocs";
$langmk['ad_blpedit'] = "&Eacute;diter Bloc Personnalisé";
$langmk['ad_blcreateh'] = "Créer un Bloc HTML";
$langmk['ad_blcreatep'] = "Créer un Bloc PHP";
$langmk['ad_blcreatel'] = "Créer un Lien de Page Interne";
$langmk['ad_blcreatetit'] = "Choisir le Bloc a créer";
$langmk['ad_blavpages'] = "Pages Disponibles:";
$langmk['ad_bladdlink'] = "Ajouter Lien";
$langmk['ad_bllremlink'] = "Liens à Supprimer:";
$langmk['ad_blremlink'] = "Supprimer Lien";
$langmk['ad_blocksave'] = "Enregistrer Bloc";
$langmk['ad_blpreview'] = "Prévisualiser Bloc";
$langmk['ad_bleditp'] = "&Eacute;diter Bloc PHP Personnalisé";
$langmk['ad_bleditl'] = "&Eacute;diter Lien de Page Interne";
$langmk['ad_blphpcode'] = "<? \n/*\nWrite code inserting output inside\nvariable \$content as in following example.\nYou have DB connection, all global vars\nand all MKPortal and Forum functions at your availability\n*/\n\n\$nome = \$mkportals->member['name'];\n\$content=\"Salut \$nome\";\n\n\n\n\n\n\n\n\n\n\n\n\n?>";

$langmk['ad_blchangetit'] = "Pour changer le titre du bloc: Double cliquez sur le titre puis Taper le nouveau titre. Enregistrer.";

//ad_quote
$langmk['ad_quottitle'] = "Gérer les Citations";
$langmk['ad_quotactived'] = "Citations Soumises";
$langmk['ad_quotdeleted'] = "Citation Supprimer de la Base de Données.";
$langmk['ad_delquotconfirm'] = "Êtes-vous sûr de vouloir supprimer cette citation?";
$langmk['ad_quotdisactive'] = "Désactiver le Module de Citations";
$langmk['ad_quotpages'] = "Nombre de citations à afficher par page";
$langmk['ad_quotsubmitted'] = "Citations attendant l'approbation:";
$langmk['ad_quotactivated'] = "Citations Approuvées:";
$langmk['ad_quottext'] = "Citation";

//ad_review
$langmk['ad_redisactive'] = "Désactiver le Module de Revues";
$langmk['ad_retitle'] = "Gérer Revues";
$langmk['ad_refilepage'] = "Nombre de revues à affciher par page";
$langmk['ad_rewarn'] = "AVERTISSEMENT:  Supprimer une section supprimera également toutes les revues contenues dans sa section.";
$langmk['ad_reop'] = "Champ Facultatif:";
$langmk['ad_reopextra'] = "Champ prolongé pour de long texte";
$langmk['ad_reeditsec'] = "Éditer la Section de Revue";

//ad_nav
$langmk['ad_navl'] = "Liens de Navigations";
$langmk['ad_navlbar'] = "Barre de Navigation";
$langmk['ad_navlmenu'] = "Menu Portail";
$langmk['ad_urll'] = "Url";
$langmk['ad_adlink'] = "Ajouter un nouveau lien";
$langmk['ad_dellinkconf'] = "&Ecirc;tes vous sûr de vouloir supprimer ce Lien?";
$langmk['ad_modlink'] = "&Eacute;diter Lien";

//ad_skin
$langmk['ad_skin'] = "Skin &amp; Templates";
$langmk['ad_skinm'] = "Gestion Skin";
$langmk['ad_skineditt'] = "&Eacute;diter Template";
$langmk['ad_skineditc'] = "&Eacute;diterCss";
$langmk['ad_skinnotok'] = "Ce n'est pas un skin valable de MKPortal.<br />Seulement les skins MKPortal > M06 sont supportés.";
$langmk['ad_skin_hea'] = "En-tête MKportal";
$langmk['ad_skin_mto'] = "Tableau Principal Ouvert";
$langmk['ad_skin_lo'] = "Logo";
$langmk['ad_skin_li'] = "Barre de Lien";
$langmk['ad_skin_sh'] = "Shoutbox";
$langmk['ad_skin_hs'] = "Espace Horizontale";
$langmk['ad_skin_pbo'] = "Corps Portail Ouvert";
$langmk['ad_skin_lc'] = "Colonne de Gauche";
$langmk['ad_skin_cs'] = "Colonne Espace";
$langmk['ad_skin_cc'] = "Colonne Centrale";
$langmk['ad_skin_rc'] = "Colonne de Droite";
$langmk['ad_skin_pbc'] = "Corps Portail Fermer ";
$langmk['ad_skin_mtc'] = "Tableau Principal Fermer";
$langmk['ad_skin_fo'] = "Titre de bas de page";
$langmk['ad_skin_bl'] = "Blocs";
$langmk['ad_skin_nofile'] = "Impossible de modifier le fichier tpl_main.php. Vous devez mettre la permission d'écriture.";
$langmk['ad_skin_nofilec'] = "Impossible de modifier le fichier style.css. Vous devez mettre la permission d'écriture.";
$langmk['ad_skin_updated'] = "Mise à Jour Complète.";

//added in M09
$langmk['ad_apprtit'] = "Admin Approval or Email notification for each submission?";
$langmk['ad_approp_0'] = "don't require approval and dont' send email notification";
$langmk['ad_approp_1'] = "dont' require approval but send email notification";
$langmk['ad_approp_2'] = "require approval and send email notification";
$langmk['ad_approp_3'] = "require approval but don't send email notification";
$langmk['ad_apprmenu'] = "Waiting approval";
$langmk['ad_newssubmitted'] = "News waiting for Approval:";
$langmk['ad_blogsubmitted'] = "Blogs waiting for Approval:";
$langmk['ad_imagesubmitted'] = "Images waiting for Approval:";
$langmk['ad_downsubmitted'] = "Downloads waiting for Approval:";
$langmk['ad_revsubmitted'] = "Reviews waiting for Approval:";
$langmk['ad_submittext'] = "Text";
$langmk['ad_waterm'] = "Apply Watermark when uploading images";
$langmk['ad_watimg'] = "Current watermark image (you can change it overwriting file: modules/gallery/wt.png):";
$langmk['ad_wattest'] = "Current watermark effect result (click on save button to refresh):";
$langmk['ad_waterpos'] = "Watermark position:";
$langmk['ad_waterlevel'] = "Transparecny level (range 0-100):";
$langmk['ad_topr'] = "Top-right";
$langmk['ad_centerpos'] = "Center";
$langmk['ad_bottomr'] = "Bottom-right";
$langmk['ad_waterwarn'] = "Warning: watermark effect required GD libraries to work and it can be applied only to jpeg and png images.";
$langmk['ad_massnowrite'] = "Cannot insert files. You have to set write permissions to uploaded files.";
?>
