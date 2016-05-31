<?PHP

if(!$fromIndex) {
	lethalError('Not from index!');
}

unlink(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php');

dbQuery('DELETE FROM consonant_tables WHERE consonantTableID = ' . $_GET['consonantTableID']);

header('Location: index.php?c=consonant_table&a=display');

?>