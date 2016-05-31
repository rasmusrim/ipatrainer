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

		$fieldsArr['correctMessage'] = '<font color="green">Correct!</font>';
		
		// Updating statistics on how difficult it is to learn the various characters
		statistics::addCorrectGuess($_SESSION['randChar'], $_SESSION['consonantTableID'], statistics::IDENTIFY_PLACES);

		
	} else {
		$fieldsArr['result'] = '<font color="red">' . ucfirst($languageArr['incorrect']) . '</font>';

		$_SESSION['incorrect']++;

		$fieldsArr['correctMessage'] = '<font color="red">Incorrect!</font>';


		// Updating statistics on how difficult it is to learn the various characters
		statistics::addTotalGuess($_SESSION['randChar'], $_SESSION['consonantTableID'], statistics::IDENTIFY_PLACES);

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
$templateArr = templateLoad('consonant_tables/templates/identify_places.tmpl');

// Displaying header
$fieldsArr['consonantTableID'] = $_GET['consonantTableID'];
$fieldsArr['GFX_URL'] = GFX_URL;

print(templateDisplay($templateArr, array_merge($consonantTableConfArr, $fieldsArr), 'header'));

// If guess from last round, show result
if($_GET['guess']) {
	print(templateDisplay($templateArr, $fieldsArr, 'result'));
}




if(!is_array($usedCharsArr)) {
	$usedCharsArr = array();
}


// Finding random character
while(($randChar == $_SESSION['randChar'] || in_array($randChar, $usedCharsArr)) || !isset($randChar)) {

	$i++;
	if($i == 100) {
		unset($usedCharsArr);
		unset($_SESSION['usedChars']);
	}
		
	$randChar = $consonantTableConfArr['consonants'][rand(0, (sizeof($consonantTableConfArr['consonants']) - 1))];
}

// Making table
// EASY
if($_GET['level'] == 'easy') {
	foreach($consonantTableConfArr['consonants'] as $consonantID) {
		
		$consonantArr = $consonantsByIDArr[$consonantID]; 	
	
		$random = rand(0, 2);
		
		// If this question mark is not to be revealed, add character to list		
		if($random != 0 || $consonantID == $randChar) {
			$time = time();	
			$imagesArr[] = '<a href="index.php?c=consonant_table&a=identify_places&consonantTableID=' . $_GET['consonantTableID'] . '&adminID=' . $_GET['adminID'] . '&guess=' . $consonantID . '&time=' . $time . '&level=' . $_GET['level'] . '#bottomCharacter">
							<img src="' . GFX_URL . '/consonants/' . $consonantArr['col'] . '.' . $consonantArr['row'] . '.' . $consonantArr['voiced'] . '.gif" border="0"></a>';  	
		}
		
		if($randChar == $consonantID) {	
			$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/question_mark.gif" border="0">';
		} else {
			if($consonantID == $_SESSION['randChar']) {
				// Show correct character in place of guess.
				$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/consonants/' . $consonantsByIDArr[$consonantID]['col'] . '.' . $consonantsByIDArr[$consonantID]['row'] . '.' . $consonantsByIDArr[$consonantID]['voiced'] . '.gif" border="3">';
	
			} else {
				if($random == 0) {
					$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/consonants/' . $consonantArr['col'] . '.' . $consonantArr['row'] . '.' . $consonantArr['voiced'] . '.gif">';
				} else {				
				
					$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/question_mark_grey.gif">';
				}
			}
		}
	}
}



// MEDIUM
if($_GET['level'] == 'medium') {
	foreach($consonantTableConfArr['consonants'] as $consonantID) {
		
		$consonantArr = $consonantsByIDArr[$consonantID]; 	
	
		$time = time();	
		$imagesArr[] = '<a href="index.php?c=consonant_table&a=identify_places&consonantTableID=' . $_GET['consonantTableID'] . '&adminID=' . $_GET['adminID'] . '&guess=' . $consonantID . '&time=' . $time . '&level=' . $_GET['level'] . '#bottomCharacter">
							<img src="' . GFX_URL . '/consonants/' . $consonantArr['col'] . '.' . $consonantArr['row'] . '.' . $consonantArr['voiced'] . '.gif" border="0"></a>';  	
		
		if($randChar == $consonantID) {	
			$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/question_mark.gif" border="0">';
		} else {
			if($consonantID == $_SESSION['randChar']) {
				// Show correct character in place of guess.
				$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/consonants/' . $consonantsByIDArr[$consonantID]['col'] . '.' . $consonantsByIDArr[$consonantID]['row'] . '.' . $consonantsByIDArr[$consonantID]['voiced'] . '.gif">';
	
			} else {
				$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/question_mark_grey.gif">';
			}
		}
	}
}

// HARD
if($_GET['level'] == 'hard') {
	foreach($consonantTableConfArr['cols'] as $col) {
		foreach($consonantTableConfArr['rows'] as $row) {
			for($voiced = 0; $voiced < 2; $voiced++) {
		
				$time = time();	
				
				$consonantID = $consonantsByPlaceArr[$col][$row][$voiced]; 				
				
				// Adding consonant to list of characters if exists
				if($consonantID) {				
				
					$imagesArr[] = '<a href="index.php?c=consonant_table&a=identify_places&consonantTableID=' . $_GET['consonantTableID'] . '&adminID=' . $_GET['adminID'] . '&guess=' . $consonantID . '&time=' . $time . '&level=' . $_GET['level'] . '#bottomCharacter">
									<img src="' . GFX_URL . '/consonants/' . $col . '.' . $row . '.' . $voiced . '.gif" border="0"></a>';  	
				}
				
				if($randChar == $consonantID) {	
					$cellsArr[$col][$row][$voiced]['content'] = '<img src="' . GFX_URL . '/question_mark.gif" border="0">';
				} else {
					if($consonantID == $_SESSION['randChar'] && $_SESSION['randChar']) {
						// Show correct character in place of guess.
						$cellsArr[$col][$row][$voiced]['content'] = '<img src="' . GFX_URL . '/consonants/' . $consonantsByIDArr[$consonantID]['col'] . '.' . $consonantsByIDArr[$consonantID]['row'] . '.' . $consonantsByIDArr[$consonantID]['voiced'] . '.gif">';
			
					} else {
						$cellsArr[$col][$row][$voiced]['content'] = '<img src="' . GFX_URL . '/question_mark_grey.gif">';
					}
				}
			}
		}
	}
}

$_SESSION['randChar'] = $randChar;

// Adding helpful message if sound is on
if($_COOKIE['soundOff'] == 'false' || !$_COOKIE['soundOff']) {
	$soundOnMessage = '<B>Hint:</B> Click <a href="javascript:soundManager.play(\'char\');">here</a> to hear the sound spoken<br><br>';
}		

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

// Randomising list of characters
shuffle($imagesArr);
$imagesString = join('', $imagesArr);

// Displaying footer
print(templateDisplay($templateArr, array_merge($fieldsArr, array('characters' => $imagesString, 
                                          'character_sound' => SND_URL . '/consonants/' . $consonantsByIDArr[$randChar]['col'] . '.' . $consonantsByIDArr[$randChar]['row'] . '.' . $consonantsByIDArr[$randChar]['voiced'] . '.mp3',
                                          'soundOnMessage' => $soundOnMessage
                                          
                                          )), 'footer'));



require('templates/footer.tmpl.php');


?>
