<b>Advice: </b>You are not supposed to have to access this tab very frequently. Rather, click on the shortcut image (<img src="<?PHP print(GFX_URL); ?>/icon_keyboard_shortcut.gif" border="0">) to the right of a diacritc/suprasegmental to define a keyboard shortcut for that character.

<table border="1">
	<tr>
<?PHP
show('Voiceless', '0325', array("n", "d"));
show('Breathy voiced', '0324', array("b", "a"));
show('Dental', '032A', array("t", "d"));
?>	
	</tr>	

	<tr>
<?PHP
show('Voiced', '032C', array("s", "t"));
show('Creaky voiced', '0330', array("b", "a"));
show('Apical', '033A', array("t", "d"));
?>	
	</tr>	

	<tr>
<?PHP
show('Aspirated', '02B0', array("t", "d"));
show('Lingolabial', '033C', array("t", "d"));
show('Laminal', '033B', array("t", "d"));
?>	
	</tr>	


	<tr>
<?PHP
show('More rounded', '0339', array("ɔ"));
show('Labialised', '02B7', array("t", "d"));
show('Nasalised', '0303', array("e"));
?>	
	</tr>	

	<tr>
<?PHP
show('Less rounded', '031C', array("ɔ"));
show('Palatalised', '02B2', array("t", "d"));
show('Nasal release', '207F', array("d"));
?>	
	</tr>	
	
	<tr>
<?PHP
show('Advanced', '031F', array("u"));
show('Velarised', '02E0', array("t", "d"));
show('Lateral release', '02E1', array("d"));
?>	
	</tr>	
	
	<tr>
<?PHP
show('Retracted', '0320', array("e"));
show('Pharyngealised', '02E4', array("t", "d"));
show('No audible release', '031A', array("d"));
?>	
	</tr>	

	<tr>
<?PHP
show('Centralised', '0308', array("e"));	
show('Velarised or pharyngealised', '0334', array("l"));
show('', '0000', array());
?>	
	</tr>	

	<tr>
<?PHP
show('Mid-centralised', '033D', array("e"));
show('Raised', '031D', array("e"));
show('', '0000', array());
?>	
	</tr>	
	
	<tr>
<?PHP
show('Syllabic', '0329', array("n"));
show('Lowered', '031E', array("e"));
show('', '0000', array());
?>	
	</tr>	

	<tr>
<?PHP
show('Non-syllabic', '032F', array("e"));
show('Advanced tongue root', '0318', array("e"));
show('', '0000', array());
?>	
	</tr>	
	
	<tr>
<?PHP
show('Rhoticity', '02DE', array("ɐ", "ə"));
show('Retracted tongue root', '0319', array("e"));
show('', '0000', array());
?>	
	</tr>	

</table>


<div align="left"><h2>Suprasegmentals:</h2></div>

<table border="1">
	<tr>
<?PHP
show('Primary stress', '02C8', array(), 'character');
show('Secondary stress', '02CC', array(), 'character');
show('', '0000', array());
?>	
	</tr>	

	<tr>
<?PHP
show('Long', '02D0', array("e"), 'character');
show('Half long', '02D1', array("e"), 'character');
show('Extra short', '0306', array("e"));
?>	
	</tr>	

	<tr>
<?PHP
show('Minor (foot) group', '007C', array(), 'character');
show('Major (intonation) group', '2016', array(), 'character');
show('', '0000', array());
?>	
	</tr>	

	<tr>
<?PHP
show('Syllable break', '002E', array(), 'character');
show('Linking (absence of a break)', '203F', array(), 'character');
show('', '0000', array());
?>	
	</tr>	


</table>

<?PHP


function show($label, $unicode, $exampleLettersArr, $type = 'diacritic') {
	global $shortcutsArr;

	if($type == 'diacritic') {
		$function = 'addDiacritic';
	} else {
		$function = 'addCharacter';
	}
	
	print('<td onClick="' . $function . '(\'' . $unicode . '\');" onMouseOver="this.className=\'rowMouseOver\';" onMouseOut="this.className=\'rowNotMouseOver\';"><table border="0" cellspacing="0" cellpadding="0"><tr>');	
	print("\t\t" . '<td width="30">' . "\n");
	print("\t\t\t" . '<div class="IPA">&nbsp;<script>document.write("\\u' . $unicode . '");</script>&nbsp;</a></div></td><td class="noBorderLeftRight" width="100">' . $label . '</td><td width="80"><div class="IPA">' . "\n");

	if(sizeof($exampleLettersArr)) {
		foreach($exampleLettersArr as $letter) {
			print($letter . '<script>document.write("\\u' . $unicode . '");</script>');
		}
	} else {
		print('&nbsp;');
	}
	
	print('</div>');
	print("\t\t" . '</td>');
	
	// Is there a shortcut for this diacritic?
	if($shortcutsArr[$unicode]) {
		$code = '<span class="IPA">' . $shortcutsArr[$unicode]['key'] . '</span>';
	} else {
		$code = '<img src="' . GFX_URL . '/icon_keyboard_shortcut.gif" border="0">';
	} 
	
	
	if($label) {
		print('<td><a href="javascript:defineKeyboardShortcut(\'' . $unicode . '\', \'' . $type . '\');">' . $code . '</a></td>');	
	}
	
	print('</tr></table></td>' . "\n\n");
}
?>
