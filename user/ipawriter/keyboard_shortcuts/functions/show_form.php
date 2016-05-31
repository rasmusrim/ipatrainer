<?PHP
require(ROOT_PATH . '/user/templates/header_no_content.tmpl.php');
?>

<center>
Please select the keyboard shortcut you would like to assign to the character on the right in the dropdown on your left.<br><br>

<?PHP
$keysArr = array('5',
				     '6',
				     '7',
				     '8',
				     '9',
				     '0',
				     'A',
				     'B',
				     'C',
				     'D',
				     'E',
				     'F',
				     'G',
				     'H',
				     'I',
				     'J',
				     'K',
				     'L',
				     'M',
				     'N',
				     'O',
				     'P',
				     'Q',
				     'R',
				     'S',
				     'T',
				     'U',
				     'W',
				     'X',
				     'Y',
				     'Z');
?>


<form action="index.php" method="GET">

<input type="hidden" name="c" value="keyboardShortcut">
<input type="hidden" name="a" value="define">
<input type="hidden" name="unicode" value="<?PHP print($_GET['unicode']); ?>">
<input type="hidden" name="type" value="<?PHP print($_GET['type']); ?>">

<select class="IPA" name="shortcut">
	<?PHP
	foreach($keysArr as $key) {
		if($_COOKIE['keyboardshortcut_' . $key]) {
			list($tmp, $unicode) = explode('|', $_COOKIE['keyboardshortcut_' . $key]);	
			$taken = ' (Already taken by &quot;&nbsp;&#' . hexdec($unicode) . ';&quot;)';
		}		
		
		print('<option value="' . $key . '">' . $key . $taken . '</option>' . "\n");
		unset($taken);
	}
	?>
</select>

=&nbsp;&nbsp;&nbsp;

<span class="IPA"><script>document.write('\u<?PHP print($_GET['unicode']); ?>');</script></span>

<br><br><input type="submit" value="Define"> <input type="button" value="Cancel" onClick="window.close();">
</form>

<b>Notice: </b>If you select a key which is already assigned to another character, the old shortcut will be overwritten.