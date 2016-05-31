<?PHP

require('templates/header.tmpl.php');
require(PHP_PATH . '/statistics.class.php');

// Getting information about table
require(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php');
require(CACHE_PATH . '/consonants.php');

// Checking if table has been changed since last time. If it has, reset stuff
if($_GET['consonantTableID'] != $_SESSION['consonantTableID']) {
	unset($_SESSION['usedChars']);
	unset($_SESSION['correct']);
	unset($_SESSION['incorrect']);
	$_SESSION['consonantTableID'] = $_GET['consonantTableID'];
} 

// Check if table is big enough
if(sizeof($consonantTableConfArr['consonants']) < 2) {
	print('<h1>Table too small</h1>This table has less than 2 IPA characters, and is therefore unavailable.<br><br><a href="index.php?adminID=' . $adminArr['adminID'] . '">Back</a>');
	require('templates/footer.tmpl.php');

	exit();
}

// Get array of characters that have already been guessed
$usedCharsArr = unserialize($_SESSION['usedChars']);

// Is there a guess from last time here?
if($_GET['guess']) {

	statistics::addConsonantLine($_SESSION['randChar'], $_SESSION['consonantTableID']);


	if($_GET['guess'] == $_SESSION['randChar']) {
		$fieldsArr['result'] = '<font color="green">' . ucfirst($languageArr['correct']) . '</font>';
		
		// Adding this character to the array of used character
		$usedCharsArr[] = $_SESSION['randChar'];
		$_SESSION['usedChars'] = serialize($usedCharsArr);

		$_SESSION['correct']++;
		
		statistics::addCorrectGuess($_SESSION['randChar'], $_SESSION['consonantTableID'], statistics::IDENTIFY_SOUNDS);
		
		
	} else {
		$fieldsArr['result'] = '<font color="red">' . ucfirst($languageArr['incorrect']) . '</font>';

		$_SESSION['incorrect']++;
		
		// Updating statistics on how difficult it is to learn the various characters
		statistics::addTotalGuess($_SESSION['randChar'], $_SESSION['consonantTableID'], statistics::IDENTIFY_SOUNDS);

	}
}



// Calculating correct ratio
if(!$_SESSION['correct']) {
	$percentage = 0;
} else {

	$complete = $_SESSION['correct'] + $_SESSION['incorrect'];
	$percentage = round($_SESSION['correct'] / $complete * 100);
}

if(!$_SESSION['correct']) {
	$_SESSION['correct'] = '0';
}

if(!$complete) {
	$complete = '0';
}

if(!$_SESSION['percentage']) {
	$_SESSION['percentage'] = '0';
}

$fieldsArr['correct'] = $_SESSION['correct'];
$fieldsArr['incorrect'] = $_SESSION['incorrect'];
$fieldsArr['percentage'] = $percentage;
$fieldsArr['total'] = $complete;

$fieldsArr['adminID'] = $_GET['adminID'];

// Load template
$templateArr = templateLoad('consonant_tables/templates/identify_sounds.tmpl');

// Displaying header
$fieldsArr['consonantTableID'] = $_GET['consonantTableID'];
$fieldsArr['GFX_URL'] = GFX_URL;

print(templateDisplay($templateArr, array_merge($consonantTableConfArr, $fieldsArr), 'header'));

// If guess from last round, show result
if($_GET['guess']) {
	print(templateDisplay($templateArr, $fieldsArr, 'result'));
}

// If all characters have been used, start over		
if(sizeof($usedCharsArr) >= (sizeof($consonantTableConfArr['consonants']) - 1)) {
	unset($usedCharsArr);
	unset($_SESSION['usedChars']);
}

if(!is_array($usedCharsArr)) {
	$usedCharsArr = array();
}


// Finding random character
while(($randChar == $_SESSION['randChar'] || in_array($randChar, $usedCharsArr)) || !$randChar) {
	$i++;
	if($i == 100) {
		unset($usedCharsArr);
		unset($_SESSION['usedChars']);
	}


	$randChar = $consonantTableConfArr['consonants'][rand(0, (sizeof($consonantTableConfArr['consonants']) - 1))];
}

// Making table
foreach($consonantTableConfArr['consonants'] as $consonantID) {
	$consonantArr = $consonantsByIDArr[$consonantID]; 	
	
	if($_SESSION['randChar'] != $consonantID) {	
		$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/question_mark.gif" border="0">';
		$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['onClick'] = 'document.location=\'index.php?c=consonant_table&a=identify_sounds&consonantTableID=' . $_GET['consonantTableID'] . '&adminID=' . $_GET['adminID'] . '&guess=' . $consonantID . '&rand=' . rand(0,500000) . '#bottomCharacter\'';


	} else {
		$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/consonants/' . $consonantsByIDArr[$consonantID]['col'] . '.' . $consonantsByIDArr[$consonantID]['row'] . '.' . $consonantsByIDArr[$consonantID]['voiced'] . '.gif">';
	}	 
}

$_SESSION['randChar'] = $randChar;

// Allowing custom header names
foreach($consonantTableConfArr['cols'] as $key => $value) {
	if($consonantTableConfArr['colNames'][$key]) {
		$colsArr[$value] = $consonantTableConfArr['colNames'][$value];
	} else {
		$colsArr[$value] = $languageArr['articulation']['places'][$value];
	}
		
}

foreach($consonantTableConfArr['rows'] as $key => $value) {
		
	if($consonantTableConfArr['rowNames'][$value]) {
		$rowsArr[$value] = $consonantTableConfArr['rowNames'][$value];
	} else {
		$rowsArr[$value] = $languageArr['articulation']['manners'][$value];
	}
}


drawTable($cellsArr, $colsArr, $rowsArr, $consonantTableConfArr['cols'], $consonantTableConfArr['rows']);

// Displaying footer
print(templateDisplay($templateArr, array_Merge($fieldsArr, array('flashURL' => FLASH_URL, 'character_sound' => SND_URL . '/consonants/' . $consonantsByIDArr[$randChar]['col'] . '.' . $consonantsByIDArr[$randChar]['row'] . '.' . $consonantsByIDArr[$randChar]['voiced'] . '.mp3')), 'footer'));


require('templates/footer.tmpl.php');


?>
