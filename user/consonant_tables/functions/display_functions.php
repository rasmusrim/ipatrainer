<?PHP

require('templates/header.tmpl.php');

// Deleting information from last test
unset($_SESSION['usedChars']);
unset($_SESSION['correct']);
unset($_SESSION['incorrect']);
unset($_SESSION['consonantTableID']);
unset($_SESSION['randChar']);

// Getting information about table
require(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php');

// Load template
$templateArr = templateLoad('consonant_tables/templates/display_functions.tmpl.php');

$adminArr['URL'] = ROOT_URL . '/?' . $adminArr['username'];
$adminArr['tableName'] = $consonantTableConfArr['name'];
$adminArr['consonantTableID'] = $_GET['consonantTableID']; 

if($_COOKIE['soundOff'] == 'true') { // Sound muted
	$adminArr['muteMessage'] = '&nbsp;&nbsp;&nbsp;Identify sounds <i>(Not really useful with muted sound (as you have). Demute to enable this option.)</i>.<br><br>';
} else {
	$adminArr['muteMessage'] = '&nbsp;&nbsp;&nbsp;<a href="index.php?c=consonant_table&a=identify_sounds&consonantTableID=' . $_GET['consonantTableID'] . '&adminID=' . $adminArr['adminID'] . '">Identify sounds</a><br><br>';

}

// Adding constant
$adminArr['GFX_URL'] = GFX_URL;
$adminArr['IPA_WRITER_URL'] = IPA_WRITER_URL;

// Displaying template
print(templateDisplay($templateArr, $adminArr));

require('templates/footer.tmpl.php');
