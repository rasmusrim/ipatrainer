<?PHP

if(!$fromIndex) {
	lethalError('Not from index!');
}


require(CACHE_PATH . '/vowels.php');

list($tmp, $vowelID) = explode('_', $_GET['vowelID']);

// Changing location of vowel
$vowelTrapeziumConfArr['vowels'][$vowelID]['x'] = $_GET['x'];	
$vowelTrapeziumConfArr['vowels'][$vowelID]['y'] = $_GET['y'];	


// Writing configuration file
$CONFIGURATION_FILE = fopen(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php', 'w');
fwrite($CONFIGURATION_FILE, '<?PHP' . "\n" . '$vowelTrapeziumConfArr = ' . array2code($vowelTrapeziumConfArr) . ';' . "\n?>");
fclose($CONFIGURATION_FILE);

?>
<script>
window.close();
</script>