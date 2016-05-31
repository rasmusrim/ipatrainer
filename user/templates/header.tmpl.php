<!DOCTYPE HTML PUBLIC "-//WC3//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html><head>
<title><?PHP print($languageArr['lang_title']); ?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<META HTTP-EQUIV="content-language" content="EN">





<META NAME="title" content="IPA Trainer">

<?PHP
if(!$_GET['description']) {
	$_GET['description'] = $title;
}

?>

<META NAME="description" content="<?PHP print($languageArr['lang_title']); ?>">
<META HTTP-EQUIV="Cache-Control" content="no-cache">
<META HTTP-EQUIV="Expires" content="0">

<link rel="image_src" href="<?PHP print(GFX_URL); ?>/rel_image.png" />

<link rel="stylesheet" href="<?PHP print(ROOT_URL); ?>/user/styles/style.css" type="text/css">



<?PHP
// Do we need to include Sound Manager 2?
if($_COOKIE['soundOff'] == 'false' || !$_COOKIE['soundOff']) {
	?>

	<!-- Initialising Sound Manager 2 !-->
	<script type="text/javascript" src="<?PHP print(FLASH_URL); ?>/soundmanager/soundmanager2.js"></script>
		
	<script type="text/javascript">
		
		

	soundManager.url = '<?PHP print(FLASH_URL); ?>/soundmanager/'; // directory where SM2 .SWFs live
	
	// disable debug mode after development/testing..
	soundManager.debugMode = false;

	soundManager.onload = function() {
		loadSounds();
	}		

	soundManager.onerror = function() {

		var isSupported = soundManager.supported();
		
		if(!isSupported) {
			
			alert('There was an error in loading Sound Manager 2. This is probably because you lack the Adobe Flash player which is required to hear sounds. All sound will be muted.');	
			//document.location = '<?PHP print(SITE_URL); ?>/index.php?scriptID=sound_toggle&returnTo=' + escape(document.location);
		}
	}
	</script>
	<?PHP

}
?>


<!-- MM_MENUS -->
		<script language="JavaScript" type="text/javascript" src="<?PHP print(DATA_URL); ?>/javascript/mm_menu.js"></script>
		<script language="JavaScript">

			function mmLoadMenus() {
				// Go to
				window.mm_menu_goto = new Menu("root",200,20,"Arial", 12,"#444444","#FFFFFF","#DDDDFF","#364482","left","middle",3,0,200,-5,7,1,1,1,0,1, 1);

				mm_menu_goto.hideOnMouseOut=true;
				mm_menu_goto.bgColor="#FFFFFF";
				mm_menu_goto.menuBorder=1;
				mm_menu_goto.menuLiteBgColor="#FFFFFF";
				mm_menu_goto.menuBorderBgColor='';
				mm_menu_goto.addMenuItem("<?PHP print($languageArr['lang_home']); ?>","location='<?PHP print(ROOT_URL); ?>'");
				mm_menu_goto.addMenuItem("<?PHP print($languageArr['lang_login_to_customise']); ?>","location='<?PHP print(ADMIN_URL); ?>'");
				mm_menu_goto.addMenuItem("IPA Writer","location='/user/ipawriter/'");
				mm_menu_goto.addMenuItem("<?PHP print($languageArr['lang_phonetics_store']); ?>","location='<?PHP print(ROOT_URL); ?>/user/store/'");

				// Help
				window.mm_menu_help = new Menu("root",150,20,"Arial", 12,"#444444","#FFFFFF","#DDDDFF","#364482","left","middle",3,0,200,-5,7,1,1,1,0,1, 1);

				mm_menu_help.hideOnMouseOut=true;
				mm_menu_help.bgColor="#FFFFFF";
				mm_menu_help.menuBorder=1;
				mm_menu_help.menuLiteBgColor="#FFFFFF";
				mm_menu_help.menuBorderBgColor='';
				mm_menu_help.addMenuItem("Feedback","location='<?PHP print(SITE_URL); ?>/index.php?pageID=feedback'");
				mm_menu_help.addMenuItem("Credits","location='<?PHP print(SITE_URL); ?>/index.php?pageID=credits'");


				writeMenus();
			}

			
</script>


</head>
<?PHP 
if(ROOT_URL != 'http://localhost/ipa') {
?>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7448049-1");
pageTracker._trackPageview();
} catch(err) {}</script>

<?PHP
}


// Start shortcutlistener only in IPA Writer
if(stristr($_SERVER['REQUEST_URI'], 'ipawriter')) {
	print('<body onload="shortcutListener.init();">');
} else {
	print('<body>');
}

?>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="<?PHP print(DATA_URL); ?>/javascript/notify.min.js"></script>js

<style>
.pointer {
	cursor: pointer;
}
</style>
<script>



$.notify.defaults({ className: "info pointer" });
$.notify('The IPA Trainer has been open sourced and I am looking for people willing to help.\n Click here to get to the project\'s GitHub site.', { position: "right bottom", autoHide: true, autoHideDelay: 5000, clickToHide: false});


$('.notifyjs-wrapper').on('click', function() {
	window.open('https://github.com/rasmusrim/ipatrainer');
});
</script>

<div align="center">
<br><br>


<table cellspacing="0" cellpadding="0" border="0" width="1000" border="0">

	<tr>
		<td align="right">
			<?PHP
			if($_GET['adminID']) {
						
				print('<a href="index.php?adminID=' . $adminArr['adminID'] . '">' . $languageArr['lang_to'] . ' ' . $adminArr['name'] . '\'s ' . $languageArr['lang_page']. '</a>' . ' | ');
			}
			?>			
			
			<a href="<?PHP print(ROOT_URL); ?>"><?PHP print($languageArr['lang_main_page']); ?></a> | 
			
			<?PHP
			// Toggle sound			
			if($_COOKIE['soundOff'] == 'true') {
				$turnSound = $languageArr['lang_on'];
				$affix = '_mute';
			} else {
				$turnSound = $languageArr['lang_off'];
			}
			$returnURL = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; 			
			print('<a href="' . ROOT_URL . '/user/site/index.php?scriptID=sound_toggle&returnTo=' . urlencode($returnURL) . '">' . $languageArr['lang_turn_sound'] . ' ' . $turnSound . '&nbsp;&nbsp;');
			print('<img height="8" src="' . SITE_URL . '/images/loudspeaker' . $affix . '.png" border="0"></a>');
			?>

			<br>			
			
			<?PHP 
			$selected[$_SESSION['language']] = ' SELECTED';
						
			print($languageArr['change_language']); ?>			
			<select name="language" onChange="document.location='<?PHP print(ROOT_URL); ?>/user/site/index.php?scriptID=language_change&returnTo=<?PHP print(urlencode($returnURL)); ?>&language=' + this.options[this.selectedIndex].value;">
				<option value="en"<?PHP print($selected['en']); ?>>English</option>
				<option value="de"<?PHP print($selected['de']); ?>>Deutsch (noch nicht fertig übersetzt)</option>
						
			</select>			
		</td>
	</tr>
</table>


<table cellspacing="0" cellpadding="0" border="0" width="1000" class="border">

	<tr>
		<td>
			<img src="<?PHP print(GFX_URL); ?>/header.png" border="0" usemap="#map">

			<map name="map">
				<area shape="rect" coords="0,1,100,23" href="http://www.ipatrainer.com" />
				<area shape="rect" coords="101,0,201,22" href="http://www.ipatrainer.com/user/ipawriter/" />
				<area shape="rect" coords="201,0,301,22" href="http://www.ipatrainer.com/user/forum"/>
			</map>

		</td>
	</tr>

	<tr>
		<td>
			<table border="0" cellspacing="0" cellpadding="0" class="dropdown">
				<tr>
					<td width="1">
						&nbsp;
					</td>


					<td width="40">
						<div id='goto' onMouseOver="MM_showMenu(window.mm_menu_goto,0,14,null,'goto')" onMouseOut="MM_startTimeout();">
							<?PHP print($languageArr['lang_go_to']); ?>
						</div>
					</td>


					<td width="40">
						<div id='help' onMouseOver="MM_showMenu(window.mm_menu_help,0,14,null,'help')" onMouseOut="MM_startTimeout();">
							<?PHP print($languageArr['lang_help']); ?>
						</div>
					</td>

					<td width="80%" align="right">
						 <iframe src="https://www.facebook.com/plugins/like.php?href=<?PHP print(urlencode('http://www.ipatrainer.com')); ?>"
						scrolling="no" frameborder="0"
						style="border:none; width:450px; height:22px"></iframe>
						
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr class="maintext">
	

		<td width="100%" class="margin" align="left">
		<!-- Maintext -->

