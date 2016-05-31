<script type="text/javascript" src="<?PHP print(DATA_URL); ?>/javascript/wz_dragdrop.js"></script> 
<script type="text/javascript" src="<?PHP print(DATA_URL); ?>/javascript/goog/base.js"></script> 
<script type="text/javascript" src="<?PHP print(DATA_URL); ?>/javascript/goog/style/style.js"></script> 

<?PHP


if(!$fromIndex) {
	lethalError('Not from index!');
}


require(CACHE_PATH . '/vowels.php');

// Stop here, if no name is specified
if(!$vowelTrapeziumConfArr) {
	$error = true;
}

// If new, require name to be specified before showing table
print('<form action="index.php" method="GET">' . showLabel('name', true) . ':&nbsp;&nbsp;&nbsp;<input type="text" name="name" value="' .  $vowelTrapeziumConfArr['name'] . '"> <input type="submit" value="Set/change name"><input type="hidden" name="c" value="vowel_trapezium"><input type="hidden" name="a" value="saveName"><input type="hidden" name="vowelTrapeziumID" value="' . $_GET['vowelTrapeziumID'] . '"></form><br><br>');


/* If no error, show table editing tools */
if(!$error) {

	$remainingVowelsArr = $vowelsArr;	
	
	// Making bottom trapezium
	foreach($vowelTrapeziumConfArr['vowels'] as $vowelID => $vowelArr) {
	
		
		$bottomTrapeziumArr[$vowelID] = '<img src="' . GFX_URL . '/vowels/' . $vowelID . '.gif" border="0" style="position:absolute; top:' . $vowelArr['y'] . 'px; left:' . $vowelArr['x'] . 'px;" id="vowel_' . $vowelID . '">';
		   
		$vowelIDsArr[] = $vowelID;		
		
		// Deleting this vowel from remaining vowels table
		unset($remainingVowelsArr[$vowelID]);
	}

	$scriptSetDHTML = '"vowel_' . join('", "vowel_', $vowelIDsArr) . '"';

	// Making top trapezium
	foreach($remainingVowelsArr as $vowelID => $value) {
		
		
		$topTrapeziumArr[] = '		
			<a href="index.php?
			c=vowel_trapezium&
			a=vowel_add&
			vowelTrapeziumID=' . $_GET['vowelTrapeziumID'] . '&
			vowelID=' . $vowelID . '">
			<img src="' . GFX_URL . '/vowels/' . $vowelID . '.gif" border="0" style="position:absolute; top:' . $value['y'] . 'px; left:' . $value['x'] . 'px;" id="vowel_' . $vowelID . '">
			</a>';
	}

	

	print('<form action="index.php">
			 <input type="submit" value="' . showLabel('OK') . '">
			 </form>');
	
	// Making A anchor
	print('<a name="topTable"></a><br><h2><b>All vowels:</h2></b><i>To add vowel to your trapezium, click on it below.&nbsp;&nbsp;&nbsp;<input type="button" value="Add all" onClick="document.location=\'index.php?c=vowel_trapezium&a=vowels_add_all&adminID=' . $adminArr['adminID'] . '&vowelTrapeziumID=' . $_GET['vowelTrapeziumID'] . '\'"></i><br><br>');
	$topTrapeziumID = drawTrapezium($topTrapeziumArr, $languageArr['vowelArticulation']['cols'], $languageArr['vowelArticulation']['rows']);
	print('<br><br>');
	


	print('<a name="bottomTable"></a>');
	print('<div><h2>Your vowel trapezium</h2><i>');
	print('<ul>');	
	print('<li>If you want to change the names of the labels, click on the name you wish to change.<br>');
	print('<li>To move a vowel, click on it and move your mouse while holding the mouse button down. (May not work correctly in all browsers)</li>');
	print('<li>To remove a vowel, click on it.&nbsp;&nbsp;&nbsp;<input type="button" value="Remove all" onClick="document.location=\'index.php?c=vowel_trapezium&a=vowels_remove_all&adminID=' . $adminArr['adminID'] . '&vowelTrapeziumID=' . $_GET['vowelTrapeziumID'] . '\'"></i>');
	print('</ul></div>');

	// Making anchors for changing labels, and replacing default names by custom ones 	
	foreach($languageArr['vowelArticulation']['cols'] as $colID => $string) {
		$colHeaderAnchorsArr[$colID] = 'javascript:changeColName(' . $colID . ', \'' . $string . '\');';
		
		if($vowelTrapeziumConfArr['colNames'][$colID]) {
			$languageArr['vowelArticulation']['cols'][$colID] = $vowelTrapeziumConfArr['colNames'][$colID];
		} 	
	
	}

	foreach($languageArr['vowelArticulation']['rows'] as $rowID => $string) {
		$rowHeaderAnchorsArr[$rowID] = 'javascript:changeRowName(' . $rowID . ', \'' . $string . '\');';

		if($vowelTrapeziumConfArr['rowNames'][$rowID]) { 
			$languageArr['vowelArticulation']['rows'][$rowID] = $vowelTrapeziumConfArr['rowNames'][$rowID];
		} 	

	}

	$bottomTrapeziumID = drawTrapezium($bottomTrapeziumArr, $languageArr['vowelArticulation']['cols'], $languageArr['vowelArticulation']['rows'], $colHeaderAnchorsArr, $rowHeaderAnchorsArr);
	
	print('<br><br>
			 <form action="index.php">
			 <input type="submit" value="' . showLabel('OK') . '">
			 </form>');
}

?>

<script type="text/javascript">


SET_DHTML(<?PHP print($scriptSetDHTML); ?>);

<?PHP
foreach($vowelIDsArr as $vowelID) {
	print('dd.elements.vowel_' . $vowelID . '.setDropFunc(drop);' . "\n");
	print('dd.elements.vowel_' . $vowelID . '.setPickFunc(pick);' . "\n");

	print('dd.elements.vowel_' . $vowelID . '.maxoffl = ' . $vowelTrapeziumConfArr['vowels'][$vowelID]['x'] . ' - 55;' . "\n");
	print('dd.elements.vowel_' . $vowelID . '.maxoffr = 425 - ' . $vowelTrapeziumConfArr['vowels'][$vowelID]['x'] . ' - 35;' . "\n");
	print('dd.elements.vowel_' . $vowelID . '.maxofft = ' . $vowelTrapeziumConfArr['vowels'][$vowelID]['y'] . ' - 30;' . "\n");
	print('dd.elements.vowel_' . $vowelID . '.maxoffb = 300 - ' . $vowelTrapeziumConfArr['vowels'][$vowelID]['y'] . ' - 20;' . "\n");
	print('dd.elements.vowel_' . $vowelID . '.setZ(0);' . "\n");

}

?>

dd.elements.vowel_1.maxoffr = 5;

var oldX;
var oldY;

function pick() {
	oldX = dd.obj.x;
	oldY = dd.obj.y;
}

function drop() {
	
	
	var x = dd.obj.x;	
	var y = dd.obj.y;	

	if(x == oldX && y == oldY) {
		document.location = 'index.php?c=vowel_trapezium&a=vowel_remove&vowelTrapeziumID=<?PHP print($_GET['vowelTrapeziumID']); ?>&vowelID=' + dd.obj.name;
			return; 
	}	
	
	bottomTrapezium = document.getElementById('trapezium_<?PHP print($bottomTrapeziumID); ?>');
	coordinates = goog.style.getPageOffset(bottomTrapezium);

	y = y - coordinates.y;
	x = x - coordinates.x;

	
	myRef = window.open('index.php?c=vowel_trapezium&a=vowel_move&x=' + x + '&y=' + y + '&vowelID=' + dd.obj.name + '&vowelTrapeziumID=<?PHP print($_GET['vowelTrapeziumID']); ?>', 'background_upload', 'width=1, height=1');
}

function changeRowName(rowID, oldName) {
	newName = prompt('Enter the new name of this row:', oldName);
	document.location = 'index.php?c=vowel_trapezium&a=changeHeaderName&header=row&newName=' + newName + '&vowelTrapeziumID=<?PHP print($_GET['vowelTrapeziumID']); ?>&rowID=' + rowID;

}

function changeColName(colID, oldName) {
	newName = prompt('Enter the new name of this column:', oldName);
	document.location = 'index.php?c=vowel_trapezium&a=changeHeaderName&header=col&newName=' + newName + '&vowelTrapeziumID=<?PHP print($_GET['vowelTrapeziumID']); ?>&colID=' + colID;

}


</script>