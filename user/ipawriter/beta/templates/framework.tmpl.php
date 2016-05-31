<!DOCTYPE HTML PUBLIC "-//WC3//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html><head>
<title>The IPA Writer</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<META HTTP-EQUIV="content-language" content="EN">

<META HTTP-EQUIV="Cache-Control" content="no-cache">
<META HTTP-EQUIV="Expires" content="0">

<link rel="stylesheet" href="<?PHP print(CSS_URL); ?>/style.css" type="text/css">

<!-- JavaScript !-->

<script src="<?PHP print(JAVASCRIPT_URL); ?>/navigation.js"></script>
<script src="<?PHP print(JAVASCRIPT_URL); ?>/common.js"></script>
<script src="<?PHP print(JAVASCRIPT_URL); ?>/acunote-shortcuts.js"></script>
<script src="<?PHP print(JAVASCRIPT_URL); ?>/ipa.js"></script>

</head>

<body onload="shortcutListener.init(); start();">

<center><table border="1"><tr><td>

<?PHP
$tabsArr = array(TAB_CONSONANTS => $langArr['consonants'],
				 TAB_VOWELS => $langArr['vowels'],
				 TAB_OTHER_CONSONANTS => $langArr['other_consonants'],
				 TAB_DIACRITICS_AND_SUPRASEGMENTALS => $langArr['diacritics_and_suprasegmentals'],
				 TAB_OPTIONS => $langArr['options'],
				 TAB_HELP => $langArr['help']);
?>

<input type="text" class="IPA" style="width: 100%; height: 50px;" id="IPAString">
<br><br>



<table border="0" cellspacing="0" cellpadding="0" style="width: 1000px;">
	<tr style="height: 23px;">
		<?PHP
		

		foreach($tabsArr as $tabID => $tabText) {			
			if($tabID == $_SESSION['selectedTab']) {
				$class = 'tab_selected';
				$subClass = 'tab_nomouseover';
			} else {
				$class = 'tab_notselected';
				$subClass = 'tab_nomouseover';
			}
						
			print('
		<td class="' . $class . '" onClick="changeTab(\'' . $tabID . '\');" id="tab' . $tabID . '">
			<table border="0" cellspacing="0" cellpadding="0" class="' . $subClass . '" onMouseOver="this.className = \'tab_mouseover\'" onMouseOut="this.className = \'' . $subClass . '\'">
				<tr>
					<td>
		
						<img src="' . GFX_URL . '/tab_left.gif">
					</td>
					
					<td background="' . GFX_URL . '/tab_middle.gif" style="background-repeat: repeat-x;">
						<span class="tab_text">
							' . $tabText . '
						</span>
					</td>
					
					<td>
						<img src="' . GFX_URL . '/tab_right.gif">
					</td>
				</tr>
			</table>
		</td>');
		
		}
		?>

		<td width="100%" class="border_bottom">
		</td>

	</tr>

</table>

<br>

<a name="table"></a>

<!-- Tabs !-->
<div id="contentTab1" style="display: none;">
<?PHP
require(TEMPLATES_PATH . '/consonant_table.php');
?>
</div>

<div id="contentTab2" style="display: none;">
<?PHP
require(TEMPLATES_PATH . '/vowel_trapezium.php');
?>
</div>

<div id="contentTab3" style="display: none;">
<?PHP
require(TEMPLATES_PATH . '/other_consonants.php');
?>
</div>


<div id="contentTab4" style="display: none;">
<?PHP
require(TEMPLATES_PATH . '/diacritics.php');
?>
</div>

<div id="contentTab5" style="display: none;">
<?PHP
require(TEMPLATES_PATH . '/options.php');
?>
</div>

<br>
<a href="javascript:addCharacter('0020');"><img src="<?PHP print(GFX_URL); ?>/button_spacebar.png" border="0"></a>

</center>

<div id="debug"></div>

</body>
</html>
