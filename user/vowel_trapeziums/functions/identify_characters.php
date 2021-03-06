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
$templateArr = templateLoad('vowel_trapeziums/templates/identify_characters.tmpl');

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

	$vowelIDsArr = array_keys($vowelTrapeziumConfArr['vowels']);

	$randChar = $vowelIDsArr[rand(0, (sizeof($vowelTrapeziumConfArr['vowels']) - 1))];
}

// Making trapezium
// EASY
if($_GET['level'] == 'easy') {
	foreach($vowelTrapeziumConfArr['vowels'] as $vowelID => $vowelArr) {
	
		if($_SESSION['randChar'] != $vowelID) {	

			$random = rand(0, 2);
			if($random == 0 && $vowelID != $randChar) {
				$image = '<img src="' . GFX_URL . '/vowels/' . $vowelID . '.gif" border="0" style="position:absolute; top:' . $vowelArr['y'] . 'px; left:' . $vowelArr['x'] . 'px;" id="vowel_' . $vowelID . '">';

			} else {
				$image = '<img src="' . GFX_URL . '/question_mark.gif" border="0" style="position:absolute; top:' . $vowelArr['y'] . 'px; left:' . $vowelArr['x'] . 'px;" id="vowel_' . $vowelID . '">';
			}

			$trapeziumArr[] = '<a href="index.php?c=vowel_trapezium&a=identify_characters&vowelTrapeziumID=' . $_GET['vowelTrapeziumID'] . '&adminID=' . $_GET['adminID'] . '&guess=' . $vowelID . '&rand=' . rand(0, 50000) . '&level=' . $_GET['level'] . '#trapezium"">' . $image . '</a>';
		} else {
			$trapeziumArr[] = '<img src="' . GFX_URL . '/vowels/' . $vowelID . '.gif" border="3" style="position:absolute; top:' . $vowelArr['y'] . 'px; left:' . $vowelArr['x'] . 'px;">';

			
		}	 
	}
}

// MEDIUM
if($_GET['level'] == 'medium') {
	foreach($vowelTrapeziumConfArr['vowels'] as $vowelID => $vowelArr) {
		
		$image = '<img src="' . GFX_URL . '/question_mark.gif" border="0" style="position:absolute; top:' . $vowelArr['y'] . 'px; left:' . $vowelArr['x'] . 'px;" id="vowel_' . $vowelID . '">';

		
		if($_SESSION['randChar'] != $vowelID) {	
			$trapeziumArr[] = '<a href="index.php?c=vowel_trapezium&a=identify_characters&vowelTrapeziumID=' . $_GET['vowelTrapeziumID'] . '&adminID=' . $_GET['adminID'] . '&guess=' . $vowelID . '&rand=' . rand(0, 50000) . '&level=' . $_GET['level'] . '#trapezium"">' . $image . '</a>';
		} else {
			$trapeziumArr[] = '<img src="' . GFX_URL . '/vowels/' . $vowelID . '.gif" style="position:absolute; top:' . $vowelArr['y'] . 'px; left:' . $vowelArr['x'] . 'px;">';
		}	 
	}
}


	
$_SESSION['randChar'] = $randChar;

// Allowing custom header names
foreach($languageArr['vowelArticulation']['cols'] as $colID => $string) {
		
	if($vowelTrapeziumConfArr['colNames'][$colID]) {
		$languageArr['vowelArticulation']['cols'][$colID] = $vowelTrapeziumConfArr['colNames'][$colID];
	} 	
	
}

foreach($languageArr['vowelArticulation']['rows'] as $rowID => $string) {
	$rowHeaderAnchorsArr[$rowID] = 'javascript:changeRowName(' . $rowID . ', \'' . $string . '\');';

	if($vowelTrapeziumConfArr['rowNames'][$rowID]) { 
		$languageArr['vowelArticulation']['rows'][$rowID] = $vowelTrapeziumConfArr['rowNames'][$rowID];
	} 	

}


drawTrapezium($trapeziumArr, $languageArr['vowelArticulation']['cols'], $languageArr['vowelArticulation']['rows'], $colHeaderAnchorsArr, $rowHeaderAnchorsArr);


// Displaying footer
print(templateDisplay($templateArr, array('character_image' => GFX_URL . '/vowels/' . $randChar . '.gif', 
                                          
                                          ), 'footer'));


require('templates/footer.tmpl.php');


?>