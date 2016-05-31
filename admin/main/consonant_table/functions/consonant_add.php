<?PHP
if(!$fromIndex) {
	lethalError('Not from index!');
}


require(CACHE_PATH . '/consonants.php');



// Manipulating arrays from configuration file
if(!in_array($consonantsByIDArr[$_GET['consonantID']]['col'], $consonantTableConfArr['cols'])) {
	
	// If dental, alveolar or postalveolar, add all three	
	if($consonantsByIDArr[$_GET['consonantID']]['col'] == 2 || 
	   $consonantsByIDArr[$_GET['consonantID']]['col'] == 3 || 
	   $consonantsByIDArr[$_GET['consonantID']]['col'] == 4) {
		
		$consonantTableConfArr['cols'][] = 2;
		$consonantTableConfArr['cols'][] = 3;
		$consonantTableConfArr['cols'][] = 4;
	} else {	
		$consonantTableConfArr['cols'][] = $consonantsByIDArr[$_GET['consonantID']]['col'];
	}
}
	
if(!in_array($consonantsByIDArr[$_GET['consonantID']]['row'], $consonantTableConfArr['rows'])) {
	$consonantTableConfArr['rows'][] = $consonantsByIDArr[$_GET['consonantID']]['row'];
}

// Adding consonant
$consonantTableConfArr['consonants'][] = $_GET['consonantID'];	

// Writing configuration file
$CONFIGURATION_FILE = fopen(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php', 'w');
fwrite($CONFIGURATION_FILE, '<?PHP' . "\n" . '$consonantTableConfArr = ' . array2code($consonantTableConfArr) . ';' . "\n?>");
fclose($CONFIGURATION_FILE);
		

header('Location: index.php?c=consonant_table&a=edit&consonantTableID=' . $_GET['consonantTableID'] . '#topTable');
?>