<?PHP

if(!$fromIndex) {
	lethalError('Not from index!');
}

// If new consonant table, assign ID
if(!$_GET['consonantTableID']) {
	// Finding lowest available ID
	$_GET['consonantTableID'] = 1;	
	
	while(file_exists(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php')) {
		$_GET['consonantTableID']++;
	}
}

if($_GET['name']) {

	$consonantTableConfArr['name'] = $_GET['name'];	
	$consonantTableConfArr['adminID'] = $adminArr['adminID'];	
	
	
	// Writing configuration file
	$CONFIGURATION_FILE = fopen(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php', 'w');
	fwrite($CONFIGURATION_FILE, '<?PHP' . "\n" . '$consonantTableConfArr = ' . array2code($consonantTableConfArr) . ';' . "\n?>");
	fclose($CONFIGURATION_FILE);
	
	// Does this table already exist?
	$result = dbQuery('SELECT * FROM consonant_tables WHERE consonantTableID="' . dbClean($_GET['consonantTableID']) . '"');
	
	if(mysql_num_rows($result)) {
	
		// It exists. Updating.
		dbQuery('UPDATE consonant_tables SET name="' . dbClean($_GET['name']) . '" WHERE consonantTableID="' . dbClean($_GET['consonantTableID']) . '"');
	} else {
		
		// Does not exist. Add new. 
		dbQuery('INSERT INTO consonant_tables VALUES(' . $_GET['consonantTableID'] . ', "' . $adminArr['adminID'] . '", "' . dbClean($_GET['name']) . '", 0)');
	}
}

header('Location: index.php?c=consonant_table&a=edit&consonantTableID=' . $_GET['consonantTableID']); 	

exit();
?>