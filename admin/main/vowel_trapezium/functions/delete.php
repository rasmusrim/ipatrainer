<?PHP

if(!$fromIndex) {
	lethalError('Not from index!');
}

unlink(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php');

dbQuery('DELETE FROM vowel_trapeziums WHERE vowelTrapeziumID = ' . $_GET['vowelTrapeziumID']);

header('Location: index.php?c=vowel_trapezium&a=display');

?>