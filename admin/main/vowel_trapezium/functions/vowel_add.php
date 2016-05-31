<?PHP
error_reporting(E_ALL);
if(!$fromIndex) {
	lethalError('Not from index!');
}


require(CACHE_PATH . '/vowels.php');

// Adding vowel
$vowelTrapeziumConfArr['vowels'][$_GET['vowelID']]['x'] = $vowelsArr[$_GET['vowelID']]['x'];	
$vowelTrapeziumConfArr['vowels'][$_GET['vowelID']]['y'] = $vowelsArr[$_GET['vowelID']]['y'];	

// Writing configuration file
$CONFIGURATION_FILE = fopen(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php', 'w');
fwrite($CONFIGURATION_FILE, '<?PHP' . "\n" . '$vowelTrapeziumConfArr = ' . array2code($vowelTrapeziumConfArr) . ';' . "\n?>");
fclose($CONFIGURATION_FILE);

header('Location: index.php?c=vowel_trapezium&a=edit&vowelTrapeziumID=' . $_GET['vowelTrapeziumID'] . '#topTable');
?>