<?PHP

if(!$fromIndex) {
	lethalError('Not from index!');
}

// If new vowel trapezium, assign ID
if(!$_GET['vowelTrapeziumID']) {
	// Finding lowest available ID
	$_GET['vowelTrapeziumID'] = 1;	
	
	while(file_exists(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php')) {
		$_GET['vowelTrapeziumID']++;
	}
}

if($_GET['name']) {

	$vowelTrapeziumConfArr['name'] = $_GET['name'];	
	$vowelTrapeziumConfArr['adminID'] = $adminArr['adminID'];	
	
	
	// Writing configuration file
	$CONFIGURATION_FILE = fopen(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php', 'w');
	fwrite($CONFIGURATION_FILE, '<?PHP' . "\n" . '$vowelTrapeziumConfArr = ' . array2code($vowelTrapeziumConfArr) . ';' . "\n?>");
	fclose($CONFIGURATION_FILE);
	
	// Does this table already exist?
	$result = dbQuery('SELECT * FROM vowel_trapeziums WHERE vowelTrapeziumID="' . dbClean($_GET['vowelTrapeziumID']) . '"');
	
	if(mysql_num_rows($result)) {
	
		// It exists. Updating.
		dbQuery('UPDATE vowel_trapeziums SET name="' . dbClean($_GET['name']) . '" WHERE vowelTrapeziumID="' . dbClean($_GET['vowelTrapeziumID']) . '"');
	} else {
		
		// Does not exist. Add new. 
		dbQuery('INSERT INTO vowel_trapeziums VALUES(' . $_GET['vowelTrapeziumID'] . ', "' . $adminArr['adminID'] . '", "' . dbClean($_GET['name']) . '", 0)');
	}
}

header('Location: index.php?c=vowel_trapezium&a=edit&vowelTrapeziumID=' . $_GET['vowelTrapeziumID']); 	

exit();
?>