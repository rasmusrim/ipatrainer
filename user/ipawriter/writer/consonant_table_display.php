<form name="consonantsForm">

Table: <select name="consonantTable" onChange="document.location='index.php?consonantTableID=' + document.consonantsForm.consonantTable[document.consonantsForm.consonantTable.selectedIndex].value + '&vowelTrapeziumID=' + document.vowelsForm.vowelTrapezium[document.vowelsForm.vowelTrapezium.selectedIndex].value + '&adminID=' + document.adminsForm.admin[document.adminsForm.admin.selectedIndex].value + '&tab=' + currentTab + '&IPAString=' + escape(document.resultForm.IPAString.value);">
<?PHP
if($_GET['adminID']) {
	$criterium = ' AND consonant_tables.adminID="' . dbClean($_GET['adminID']) . '"';
} 

$result = dbQuery('SELECT consonant_tables.name as tableName, admins.username as adminUsername, admins.name as adminName, admins.adminID as adminID, visits, consonantTableID FROM consonant_tables, admins WHERE consonant_tables.adminID = admins.adminID' . $criterium . ' ORDER BY tableName, adminName', 1);

if(!mysql_num_rows($result)) {
	print('<option value="0">-= This lecturer has no tables =-</option>');
} else {
	print('<option value="0">-= Please select a table =-</option>');
}	

while($consonantTableArr = mysql_fetch_assoc($result)) {
	if($consonantTableArr['consonantTableID'] == $_GET['consonantTableID']) {
		$selected = ' SELECTED';
	}
	
	print('<option value="' . $consonantTableArr['consonantTableID'] . '"' . $selected . '>' . $consonantTableArr['tableName'] . ' (' . $consonantTableArr['adminName'] . ')</option>' . "\n");
	unset($selected);
}
?>
</select>
</form>
<br>
<?PHP

if($_GET['consonantTableID']) {

	// Getting information about table
	require(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php');
	require(CACHE_PATH . '/consonants.php');
	
	
	// Making table
	foreach($consonantTableConfArr['consonants'] as $consonantID) {
		$consonantArr = $consonantsByIDArr[$consonantID]; 	
		
		$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<div class="IPA_consonant" id="consonant_' . $consonantID . '"><script>document.write("\\u' . $consonantArr['unicode'] . '");</script></div>' . "\n";
		$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['onClick'] = 'addCharacter(\'' . $consonantArr['unicode'] . '\');' . "\n";
			
	
	}
	
	// Allowing custom header names
	foreach($consonantTableConfArr['cols'] as $key => $value) {
		if($consonantTableConfArr['colNames'][$key]) {
			$colsArr[$value] = $consonantTableConfArr['colNames'][$value];
		} else {
			$colsArr[$value] = $languageArr['articulation']['places'][$value];
		}
			
	}
	
	foreach($consonantTableConfArr['rows'] as $key => $value) {
			
		if($consonantTableConfArr['rowNames'][$value]) {
			$rowsArr[$value] = $consonantTableConfArr['rowNames'][$value];
		} else {
			$rowsArr[$value] = $languageArr['articulation']['manners'][$value];
		}
	}
	
	drawTable($cellsArr, $colsArr, $rowsArr, $consonantTableConfArr['cols'], $consonantTableConfArr['rows']);
}
