<?PHP


if(!$fromIndex) {
	lethalError('Not from index!');
}


require(CACHE_PATH . '/consonants.php');

// Stop here, if no name is specified
if(!$consonantTableConfArr) {
	$error = true;
}

// If new, require name to be specified before showing table
print('<form action="index.php" method="GET">' . showLabel('name', true) . ':&nbsp;&nbsp;&nbsp;<input type="text" name="name" value="' .  $consonantTableConfArr['name'] . '"> <input type="submit" value="Set/change name"><input type="hidden" name="c" value="consonant_table"><input type="hidden" name="a" value="saveName"><input type="hidden" name="consonantTableID" value="' . $_GET['consonantTableID'] . '"></form><br><br>');


/* If no error, show table editing tools */
if(!$error) {

	$remainingConsonantsArr = $consonantsByIDArr;	
	
	// Making array with consonants added
	foreach($consonantTableConfArr['consonants'] as $consonantID) {

		$consonantArr = $consonantsByIDArr[$consonantID];		
		
		$inTableArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/consonants/' . $consonantArr['col'] . '.' . $consonantArr['row'] . '.' . $consonantArr['voiced'] . '.gif" border="0">';
		$inTableArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['onClick'] = 'document.location=\'index.php?c=consonant_table&a=consonant_remove&consonantTableID=' . $_GET['consonantTableID'] . '&consonantID=' . $consonantID . '\'';
		
		// Deleting this consonant from remaining consonants table
		unset($remainingConsonantsArr[$consonantID]);
	}

	// Making array with remaining characters
	foreach($remainingConsonantsArr as $consonantID => $value) {
		
		$remainingConsonantsArr2[$value['col']][$value['row']][$value['voiced']]['content'] = '<img src="' . GFX_URL . '/consonants/' . $value['col'] . '.' . $value['row'] . '.' . $value['voiced'] . '.gif" border="0">';
		$remainingConsonantsArr2[$value['col']][$value['row']][$value['voiced']]['onClick'] = 'document.location=\'index.php?c=consonant_table&a=consonant_add&consonantTableID=' . $_GET['consonantTableID'] . '&consonantID=' . $consonantID . '\'';
	}
	
	$remainingConsonantsArr = $remainingConsonantsArr2;
	unset($remainingConsonantsArr2);

	// Getting order from configuration file
	$colsArr = $consonantTableConfArr['cols'];
	$rowsArr = $consonantTableConfArr['rows'];

	// Getting headers
	$rowHeadersArr = $languageArr['articulation']['manners'];
	$colHeadersArr = $languageArr['articulation']['places'];	
	
	$rowHeadersArr = array_ucfirst($rowHeadersArr);
	$colHeadersArr = array_ucfirst($colHeadersArr);
	
	print('<form action="index.php">
			 <input type="submit" value="' . showLabel('OK') . '">
			 </form>');
	
	
	// Making A anchor
	print('<a name="topTable"></a><br><h2><b>All IPA characters:</h2></b><i>To add IPA characters to your consonant table, click on them in the table below.&nbsp;&nbsp;&nbsp;<input type="button" value="Add all" onClick="document.location=\'index.php?c=consonant_table&a=consonants_add_all&adminID=' . $adminArr['adminID'] . '&consonantTableID=' . $_GET['consonantTableID'] . '\'"></i><br><br>');
	drawTable($remainingConsonantsArr, $colHeadersArr, $rowHeadersArr);
	print('<br><br>');
	
	// Manipulating headers to allow custom names, moving and renaming
	foreach($rowHeadersArr as $key => $value) {
	
		if($consonantTableConfArr['rowNames'][$key]) {
			$value = $consonantTableConfArr['rowNames'][$key];
		} 
		
		$value = '<a href="javascript:changeRowName(' . $key . ', \'' . $value . '\');">' . $value . '</a>';		
				
		unset($images);		
		if($key != $rowsArr[0]) {
			$images .= '<a href="index.php?c=consonant_table&a=move&what=row&direction=up&rowID=' . $key . '&consonantTableID=' . $_GET['consonantTableID'] . '"><img src="' . GFX_URL . '/arrow_up.gif" border="0"></a>';
		}
		
		if($key != $rowsArr[(sizeof($rowsArr) - 1)]) { 
			$images .= '<a href="index.php?c=consonant_table&a=move&what=row&direction=down&rowID=' . $key . '&consonantTableID=' . $_GET['consonantTableID'] . '"><img src="' . GFX_URL . '/arrow_down.gif" border="0"></a>';
		}
		
		$value = $images . '&nbsp;' . $value;
		$rowHeadersArr[$key] = $value;		
	}
	
		
	foreach($colHeadersArr as $key => $value) {
		unset($leftImage);
		unset($rightImage);		

		if($consonantTableConfArr['colNames'][$key]) {
			$value = $consonantTableConfArr['colNames'][$key];
		} 

		$value = '<a href="javascript:changeColName(' . $key . ', \'' . $value . '\');">' . $value . '</a>';		

		if($key != $colsArr[0]) {
			$leftImage .= '<a href="index.php?c=consonant_table&a=move&what=col&direction=up&colID=' . $key . '&consonantTableID=' . $_GET['consonantTableID'] . '"><img src="' . GFX_URL . '/arrow_left.gif" border="0"></a>';
		}
		
		if($key != $colsArr[(sizeof($colsArr) - 1)]) { 
			$rightImage .= '<a href="index.php?c=consonant_table&a=move&what=col&direction=down&colID=' . $key . '&consonantTableID=' . $_GET['consonantTableID'] . '"><img src="' . GFX_URL . '/arrow_right.gif" border="0"></a>';
		}

		// Fixing dental, alveolar, postalveolar so there is only one set of arrow for entire chunk		
		if($key == 3 || $key == 4) {
			unset($leftImage);
		}		
		
		if($key == 2 || $key == 3) {
			unset($rightImage);
		}		

		$value = $leftImage . '&nbsp;' . $value . '&nbsp;' . $rightImage;
		$colHeadersArr[$key] = $value;
	}


	print('<a name="bottomTable"></a>');
	print('<h2>Your IPA table</h2><i>');
	print('<ul>');	
	print('<li>If you want to change the names of the manners of places of articulation, click on the name you wish to change.<br>');
	print('<li>To remove characters, click on them. If you want to move a row or a column, click on the arrows to the left or right of its header.&nbsp;&nbsp;&nbsp;<input type="button" value="Remove all" onClick="document.location=\'index.php?c=consonant_table&a=consonants_remove_all&adminID=' . $adminArr['adminID'] . '&consonantTableID=' . $_GET['consonantTableID'] . '\'"></i><br><br>');
	print('</ul>');
				
	drawTable($inTableArr, $colHeadersArr, $rowHeadersArr, $colsArr, $rowsArr);
	
	print('<br><br>
			 <form action="index.php">
			 <input type="submit" value="' . showLabel('OK') . '">
			 </form>');
}

?>

<script>
function changeRowName(rowID, oldName) {
	newName = prompt('Enter the new name of this row:', oldName);
	document.location = 'index.php?c=consonant_table&a=changeHeaderName&header=row&newName=' + newName + '&consonantTableID=<?PHP print($_GET['consonantTableID']); ?>&rowID=' + rowID;

}

function changeColName(colID, oldName) {
	newName = prompt('Enter the new name of this column:', oldName);
	document.location = 'index.php?c=consonant_table&a=changeHeaderName&header=col&newName=' + newName + '&consonantTableID=<?PHP print($_GET['consonantTableID']); ?>&colID=' + colID;

}


</script>
