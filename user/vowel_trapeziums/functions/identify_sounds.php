<?PHP

require('templates/header.tmpl.php');

// Getting information about trapezium
require(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php');
require(CACHE_PATH . '/vowels.php');

// Checking if trapezium has been changed since last time. If it has, reset stuff
if($_GET['vowelTrapeziumID'] != $_SESSION['vowelTrapeziumID']) {
	unset($_SESSION['usedChars']);
	unset($_SESSION['correct']);
	unset($_SESSION['incorrect']);
	$_SESSION['vowelTrapeziumID'] = $_GET['vowelTrapeziumID'];
} 

// Check if trapezium is big enough
if(sizeof($vowelTrapeziumConfArr['vowels']) < 2) {
	print('<h1>Trapezium too small</h1>This trapezium has less than 2 IPA characters, and is therefore unavailable.<br><br><a href="index.php?adminID=' . $adminArr['adminID'] . '">Back</a>');
	require('templates/footer.tmpl.php');

	exit();
}

// Get array of characters that have already been guessed
$usedCharsArr = unserialize($_SESSION['usedChars']);

// Is there a guess from last time here?
if($_GET['guess']) {
	if($_GET['guess'] == $_SESSION['randChar']) {
		$fieldsArr['result'] = '<font color="green">' . ucfirst($languageArr['correct']) . '</font>';
		
		// Adding this character to the array of used character
		$usedCharsArr[] = $_SESSION['randChar'];
		$_SESSION['usedChars'] = serialize($usedCharsArr);

		$_SESSION['correct']++;
		
		
		
	} else {
		$fieldsArr['result'] = '<font color="red">' . ucfirst($languageArr['incorrect']) . '</font>';

		$_SESSION['incorrect']++;
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
$templateArr = templateLoad('vowel_trapeziums/templates/identify_sounds.tmpl');

// Displaying header
$fieldsArr['vowelTrapeziumID'] = $_GET['vowelTrapeziumID'];
$fieldsArr['GFX_URL'] = GFX_URL;

print(templateDisplay($templateArr, array_merge($vowelTrapeziumConfArr, $fieldsArr), 'header'));

// If guess from last round, show result
if($_GET['guess']) {
	print(templateDisplay($templateArr, $fieldsArr, 'result'));
}

// If all characters have been used, start over		
if(sizeof($usedCharsArr) >= (sizeof($vowelTrapeziumConfArr['vowels']) - 1)) {
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


	$randChar = $vowelTrapeziumConfArr['vowels'][rand(0, (sizeof($vowelTrapeziumConfArr['vowels']) - 1))];
}

// Making trapezium
foreach($vowelTrapeziumConfArr['vowels'] as $vowelID) {
	$vowelArr = $vowelsByIDArr[$vowelID]; 	
	
	if($_SESSION['randChar'] != $vowelID) {	
		$cellsArr[$vowelArr['col']][$vowelArr['row']][$vowelArr['voiced']] = '<a href="index.php?c=vowel_trapezium&a=identify_sounds&vowelTrapeziumID=' . $_GET['vowelTrapeziumID'] . '&adminID=' . $_GET['adminID'] . '&guess=' . $vowelID . '&rand=' . rand(0,500000) . '#bottomCharacter""><img src="' . GFX_URL . '/question_mark.gif" border="0"></a>';
	} else {
		$cellsArr[$vowelArr['col']][$vowelArr['row']][$vowelArr['voiced']] = '<img src="' . GFX_URL . '/vowels/' . $vowelsByIDArr[$vowelID]['col'] . '.' . $vowelsByIDArr[$vowelID]['row'] . '.' . $vowelsByIDArr[$vowelID]['voiced'] . '.gif">';
	}	 
}

$_SESSION['randChar'] = $randChar;

// Allowing custom header names
foreach($vowelTrapeziumConfArr['cols'] as $key => $value) {
	if($vowelTrapeziumConfArr['colNames'][$key]) {
		$colsArr[$value] = $vowelTrapeziumConfArr['colNames'][$value];
	} else {
		$colsArr[$value] = $languageArr['articulation']['places'][$value];
	}
		
}

foreach($vowelTrapeziumConfArr['rows'] as $key => $value) {
		
	if($vowelTrapeziumConfArr['rowNames'][$value]) {
		$rowsArr[$value] = $vowelTrapeziumConfArr['rowNames'][$value];
	} else {
		$rowsArr[$value] = $languageArr['articulation']['manners'][$value];
	}
}


drawTrapezium($cellsArr, $colsArr, $rowsArr, $vowelTrapeziumConfArr['cols'], $vowelTrapeziumConfArr['rows']);

// Displaying footer
print(templateDisplay($templateArr, array('flashURL' => FLASH_URL, 'character_sound' => SND_URL . '/vowels/' . $vowelsByIDArr[$randChar]['col'] . '.' . $vowelsByIDArr[$randChar]['row'] . '.' . $vowelsByIDArr[$randChar]['voiced'] . '.mp3'), 'footer'));


require('templates/footer.tmpl.php');


?>