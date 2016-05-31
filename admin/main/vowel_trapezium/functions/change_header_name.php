<?PHP


if(!$fromIndex) {
	lethalError('Not from index!');
}

$vowelTrapeziumConfArr[$_GET['header'] . 'Names'][$_GET[$_GET['header'] . 'ID']] = $_GET['newName'];

// Writing configuration file
$CONFIGURATION_FILE = fopen(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php', 'w');
fwrite($CONFIGURATION_FILE, '<?PHP' . "\n" . '$vowelTrapeziumConfArr = ' . array2code($vowelTrapeziumConfArr) . ';' . "\n?>");
fclose($CONFIGURATION_FILE);


header('Location: index.php?c=vowel_trapezium&a=edit&vowelTrapeziumID=' . $_GET['vowelTrapeziumID'] . '#bottomTable');
?>

