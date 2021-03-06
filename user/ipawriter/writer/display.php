<?PHP
// Going through values to save as cookies
$valsArr = array('adminID', 'consonantTableID', 'vowelTrapeziumID');

if(!$_GET['consonantTableID'] && !$_COOKIE['ipawriter_consonantTableID']) {
	$_GET['consonantTableID'] = 1;
}

if(!$_GET['vowelTrapeziumID'] && !$_COOKIE['ipawriter_vowelTrapeziumID']) {
	$_GET['vowelTrapeziumID'] = 1;
}

foreach($valsArr as $val) {
	if(isset($_GET[$val])) {
		setcookie('ipawriter_' . $val, $_GET[$val], time()+60*60*24*30*6, '/');
	} else {
		$_GET[$val] = 0;		
		if($_COOKIE['ipawriter_' . $val]) {
			$_GET[$val] = $_COOKIE['ipawriter_' . $val];
		} else {
			$_GET[$val] = 0;
				
		}
	}
}





require(ROOT_PATH . '/user/templates/header.tmpl.php');

if(!$_GET['tab']) {
	$_GET['tab'] = 'tab1';
}

// Go through cookies and specify shortcuts
foreach($_COOKIE as $key => $value) {
	list($tmp, $key) = explode('_', $key);
	list($type, $unicode) = explode('|', $value);
	if($tmp == 'keyboardshortcut') {
		$shortcutsArr[$unicode]['key'] = $key;
		$shortcutsArr[$unicode]['type'] = $type;
	}
}

if(!is_array($shortcutsArr)) {
	$shortcutsArr = array();
}

?>

<div align="right">
	<table border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td>	
				<a href="<?PHP print(IPA_WRITER_URL); ?>/writer/help_ipawriter.php" target="help">	
				<img src="<?PHP print(GFX_URL); ?>/icon_help.png" height="20" width="20" border="0">
				</a>
			</td>
			
			<td>				
				<a href="<?PHP print(IPA_WRITER_URL); ?>/writer/help_ipawriter.php" target="help">	
				Help
				</a>&nbsp;&nbsp;&nbsp;
			</td>
			<td>	

				<a href="index.php">	
				<img src="<?PHP print(GFX_URL); ?>/icon_exit.png" height="20" width="20" border="0">
				</a>
			</td>
			
			<td>				
				
				<a href="<?PHP print(SITE_URL); ?>" target="_TOP">	
				To IPA Trainer
				</a>&nbsp;&nbsp;&nbsp;
			</td>

		</tr>
	</table>
<br>	
</div>

<script src="<?PHP print(DATA_URL); ?>/javascript/acunote-shortcuts.js"></script>



<center>

<div style="padding: 10px; background-color: pink; width: 400px;">
<b>The next generation of IPA Writer is coming!<br>
<a href="http://ipatrainer.com/forum/viewforum.php?f=4" target="_BLANK">Post your feature requests here</a></b>
</div>

<h1>IPA Writer - Online tool for phonetic transcription</h1>

New to IPA Writer? Read this <a href="<?PHP print(SITE_URL); ?>/index.php?pageID=ipawriter">introduction</a>.<br>

Do you have any feedback about the IPA Writer? <a href="<?PHP print(SITE_URL); ?>/index.php?pageID=feedback">Click here to give feedback</a><br><br>


<form name="adminsForm">
Lecturer: <select name="admin" onChange="document.location='index.php?consonantTableID=' + document.consonantsForm.consonantTable[document.consonantsForm.consonantTable.selectedIndex].value + '&vowelTrapeziumID=' + document.vowelsForm.vowelTrapezium[document.vowelsForm.vowelTrapezium.selectedIndex].value + '&adminID=' + document.adminsForm.admin[document.adminsForm.admin.selectedIndex].value + '&tab=' + currentTab + '&IPAString=' + escape(document.resultForm.IPAString.value);">
<option value="">-= Show all tables/trapeziums =-</option>
<?PHP
// Getting admins
$result = dbQuery('SELECT * FROM admins ORDER BY name');
while($adminArr = mysql_fetch_assoc($result)) {
	if($adminArr['adminID'] == $_GET['adminID']) {
		$selected = ' SELECTED';
	} 	
	
	print('<option value="' . $adminArr['adminID'] . '"' . $selected . '>' . $adminArr['name'] . '</option>' . "\n");
	
	unset($selected);
}
?>
</select>
</form>


<form name="resultForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			IPA result: <input type="text" class="IPA" style="width: 500px; height: 50px;" name="IPAString">
			
		</td>
		
	</tr>
</table>

</form>
<hr>

<?PHP
print('| ');

$tabsArr = array(1 => 'Consonants', 2 => 'Vowels', 3 => 'Other consonants', 4 => 'Diacritics and suprasegmentals');

foreach($tabsArr as $key => $value) {
	print('<span id="tab' . $key . 'Button"><a href="javascript:showTab(\'tab' . $key . '\');">' . $value . '</a></span> | ');
}
?>



<a name="table"></a>

<!-- Tabs !-->
<div id="tab1" style="display: none;">
<?PHP
require('consonant_table_display.php');
?>
</div>

<div id="tab2" style="display: none;">
<?PHP
require('vowel_trapezium_display.php');
?>
</div>

<div id="tab3" style="display: none;">
<?PHP
require('other_consonants_display.php');
?>
</div>


<div id="tab4" style="display: none;">
<?PHP
require('diacritics_display.php');
?>
</div>


<br>
<a href="javascript:addCharacter('0020');"><img src="<?PHP print(GFX_URL); ?>/button_spacebar.png" border="0"></a>

</center>

<script>
var currentTab = 'tab1';
document.getElementById(currentTab + 'Button').style.backgroundColor = 'lightgreen';

tab = document.getElementById(currentTab);
tab.style.display = "block"; // Show

var withDiacritic;

var SHORTCUTS = {
     '1': function() { showTab('tab1'); },
     '2': function() { showTab('tab2'); },
     '3': function() { showTab('tab3'); },
     '4': function() { showTab('tab4'); },
     'q': function() { addDiacritic(""); },
     'v': function() { document.resultForm.IPAString.value = document.resultForm.IPAString.value + " "; },
     
		<?PHP
		foreach($shortcutsArr as $unicode => $infoArr) {
			
			if($infoArr['type'] == 'diacritic') {
				$function = 'addDiacritic';
			} else {
				$function = 'addCharacter';
			}
			
			print('\'' . strtolower($infoArr['key']) . '\': function() { ' . $function . '("' . $unicode . '"); },');
		}
		
		
		?>
			     
     
}

function addCharacter(unicode) {
	eval('unicode = "\\u' + unicode + '";');	
	
	if(withDiacritic) {	
	
		//insertAtCursor(resultForm.IPAString, unicode);
		document.resultForm.IPAString.value = document.resultForm.IPAString.value + unicode + withDiacritic;
	} else {
		document.resultForm.IPAString.value = document.resultForm.IPAString.value + unicode;
	}		
	
	// Remove diacritic	
	addDiacritic("");
}

function showTab(tab) {
	hiddenTab = document.getElementById(currentTab);
	hiddenTab.style.display = "none"; // Hide
	
	// Deselecting old tab
	document.getElementById(currentTab + 'Button').style.backgroundColor = '';

	currentTab = tab;	
	
	visibleTab = document.getElementById(tab);
	visibleTab.style.display = "block"; // Show
	
	// Selecting new tab
	document.getElementById(tab + 'Button').style.backgroundColor = 'lightgreen';
	
	
}

// Javascript function to change the inner HTML
function addDiacritic(unicode) {
	if(unicode) {
		eval('unicode = "\\u' + unicode + '";');
	}	 	


	withDiacritic = unicode;
	
	<?PHP
	if(!$consonantTableConfArr['consonants']) {
		$consonantTableConfArr['consonants'] = array();
	}
	
	if(!$vowelTrapeziumConfArr['vowels']) {
		$vowelTrapeziumConfArr['vowels'] = array();
	}

	foreach($consonantTableConfArr['consonants'] as $consonantID) {
		print('document.getElementById("consonant_' . $consonantID . '").innerHTML = "\\u' . $consonantsByIDArr[$consonantID]['unicode'] . '" + unicode;' . "\n");
	}

	foreach($vowelTrapeziumConfArr['vowels'] as $vowelID => $vowelArr) {
		print('document.getElementById("vowel_' . $vowelID . '").innerHTML = "\\u' . $vowelsArr[$vowelID]['unicode'] . '" + unicode;' . "\n");
	}

	?>
}
		
function defineKeyboardShortcut(unicode, type) {
	myRef = window.open('index.php?c=keyboardShortcut&a=showForm&unicode=' + unicode + '&type=' + type, 'background_upload', 'width=450, height=300');
}



</script>



<?PHP
require(ROOT_PATH . '/user/templates/footer.tmpl.php');
?>
