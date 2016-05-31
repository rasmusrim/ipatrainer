<?PHP
session_start();

require('../../../config.php');
require_once(PHP_PATH . '/mysql.php');
require_once(PHP_PATH . '/html.php');
require_once(PHP_PATH . '/template.php');
require_once(PHP_PATH . '/common.php');
require_once(PHP_PATH . '/validation.php');
require_once(PHP_PATH . '/ipa.php');
require_once(PHP_PATH . '/user.php');


require(ROOT_PATH . '/user/templates/header.tmpl.php');
?>

<div align="right">
	<table border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td>	

				<a href="javascript:window.close();">	
				<img src="<?PHP print(GFX_URL); ?>/icon_exit.png" height="20" width="20" border="0">
				</a>
			</td>
			
			<td>				
				
				<a href="javascript:window.close();">	
				Exit
				</a>&nbsp;&nbsp;&nbsp;
			</td>

		</tr>
	</table>
</div>

<h1>Help</h1>
the IPA Writer is a tool to help you write IPA characters on your computer. Clicking on an IPA character adds it to the end of the "IPA result" textbox at the top of the page. It does, at its current stage, not contain all relevant characters, but I hope to have time to extend it soon.<br><br>

The IPA Writer is separated into four parts. Vowels, consonants, other consonants and diacritics/suprasegmentals. These can be accessed by pressing respectively 1, 2, 3 or 4 on your keyboard. The space bar has the keyboard shortcut "V".<br><br>


The idea is that you should be able to keep your left little finger on the "1"-button, your left ring finger on the "2"-button etc. While resting your hand in this position, you can comfortably reach the "V"-button) with your thumb. In this way, you can write efficiently with your right hand, while switching between the "pages" with the left one.
<br><br>


In the diacritics/suprasegmentals part of the IPA Writer, you can click on any shortcut image (<img src="<?PHP print(GFX_URL); ?>/icon_keyboard_shortcut.gif">) to define a keyboard shortcut for that diacritic. When you click on a diacritic or press the button which you have defined as shortcut for any diacritic, it will not appear right away. But you will see in the consonants and vowels tabs that all the characters are now displayed there with the diacritic. By clicking on the character now, it will be added to the IPA result textbox with the diacritic.<br><br>

You will also find dropdown menus where you can select both lecturer and which table/trapezium you wish to use so that you can transcribe with your favourite way of representing these characters. 
If you are unfamiliar with, but interested in customising consonant tables and vowel trapeziums either for yourself or for your students, I recommend that you
head over to <a href="http://www.ipatrainer.com">IPA Trainer</a> and register to customise there.<br><br>

<b>Notice: </b>You need a unicode font in order to use the IPA Writer. The ones currently supported are<br>
<ul>
<li>Code2000
<li>Arial Unicode MS
<li>Lucida Sans Unicode
<li>Doulos SIL
<li>Charis SIL
</ul> 

If you use a different font for your phonetic transcription needs, please <a href="<?PHP print(SITE_URL); ?>/index.php?pageID=feedback">contact me</a> and tell me its name so I can add it.

<?PHP
require(ROOT_PATH . '/user/templates/footer.tmpl.php');
?>
