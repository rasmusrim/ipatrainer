<?PHP
if(!$fromIndex) {
	lethalError('Not from index!');
}

require(CACHE_PATH . '/consonants.php');

// Deleting consonant	
$consonantTableConfArr['consonants'] = array_flip($consonantTableConfArr['consonants']);
unset($consonantTableConfArr['consonants'][$_GET['consonantID']]);
$consonantTableConfArr['consonants'] = array_flip($consonantTableConfArr['consonants']);


// Going through cols and rows and checking if any of them are empty
foreach($consonantTableConfArr['consonants'] as $consonantID) {
	$colsArr[$consonantsByIDArr[$consonantID]['col']]++;
	$rowsArr[$consonantsByIDArr[$consonantID]['row']]++;
}

foreach($consonantTableConfArr['cols'] as $id => $col) {
	if(!$colsArr[$col] && $col != 2 && $col != 3 && $col != 4) {
		unset($consonantTableConfArr['cols'][$id]);
	}
}
			
// Checking dental, alveolar, postalveolar chunk
if(!$colsArr[2] && !$colsArr[3] && !$colsArr[4]) {
	$consonantTableConfArr['cols'] = array_flip($consonantTableConfArr['cols']);
	unset($consonantTableConfArr['cols'][2]);
	unset($consonantTableConfArr['cols'][3]);
	unset($consonantTableConfArr['cols'][4]);
	$consonantTableConfArr['cols'] = array_flip($consonantTableConfArr['cols']);
}
	 
		
foreach($consonantTableConfArr['rows'] as $id => $row) {
	if(!$rowsArr[$row]) {
		unset($consonantTableConfArr['rows'][$id]);
	}
}

// If an entire col or row is deleted, the keys in $colsArr and $rowsArr are defect. We need to reorder them
$colsArr = $consonantTableConfArr['cols'];
$rowsArr = $consonantTableConfArr['rows'];

unset($consonantTableConfArr['cols']);
unset($consonantTableConfArr['rows']);

foreach($colsArr as $col) {
	$consonantTableConfArr['cols'][] = $col;
}

foreach($rowsArr as $row) {
	$consonantTableConfArr['rows'][] = $row;
}

// Writing configuration file
$CONFIGURATION_FILE = fopen(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php', 'w');
fwrite($CONFIGURATION_FILE, '<?PHP' . "\n" . '$consonantTableConfArr = ' . array2code($consonantTableConfArr) . ';' . "\n?>");
fclose($CONFIGURATION_FILE);

header('Location: index.php?c=consonant_table&a=edit&consonantTableID=' . $_GET['consonantTableID'] . '#bottomTable');
?>