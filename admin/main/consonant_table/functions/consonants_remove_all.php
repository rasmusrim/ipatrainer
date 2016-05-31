<?PHP
if(!$fromIndex) {
	lethalError('Not from index!');
}


require(CACHE_PATH . '/consonants.php');

// Adding all consonants, cols and rows
unset($consonantTableConfArr['consonants']);
unset($consonantTableConfArr['rows']);
unset($consonantTableConfArr['cols']);
// Writing configuration file
$CONFIGURATION_FILE = fopen(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php', 'w');
fwrite($CONFIGURATION_FILE, '<?PHP' . "\n" . '$consonantTableConfArr = ' . array2code($consonantTableConfArr) . ';' . "\n?>");
fclose($CONFIGURATION_FILE);
		

header('Location: index.php?c=consonant_table&a=edit&consonantTableID=' . $_GET['consonantTableID'] . '#topTable');
?>