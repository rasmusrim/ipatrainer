<?PHP
if(!$title) {
	$title = 'IPATrainer ' . APP_VERSION;
} 

?>
<!DOCTYPE HTML PUBLIC "-//WC3//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html><head>
<title><?PHP print($title); ?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<META HTTP-EQUIV="content-language" content="EN">


<META NAME="title" content="IPA Trainer">

<?PHP
if(!$_GET['description']) {
	$_GET['description'] = 'A web application for learning and writing the characters of the internation phonetic alphabet.';
}
?>

<META NAME="description" content="<?PHP print($_GET['description']); ?>">
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
			document.location = '<?PHP print(SITE_URL); ?>/index.php?scriptID=sound_toggle&returnTo=' + escape(document.location);
		}
	}
	</script>
	<?PHP

}
?>

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
?>

<body onload="shortcutListener.init();">


