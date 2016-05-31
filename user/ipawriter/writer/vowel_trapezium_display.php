

<form name="vowelsForm">

Trapezium: <select name="vowelTrapezium" onChange="document.location='index.php?consonantTableID=' + document.consonantsForm.consonantTable[document.consonantsForm.consonantTable.selectedIndex].value + '&vowelTrapeziumID=' + document.vowelsForm.vowelTrapezium[document.vowelsForm.vowelTrapezium.selectedIndex].value + '&adminID=' + document.adminsForm.admin[document.adminsForm.admin.selectedIndex].value + '&tab=' + currentTab + '&IPAString=' + escape(document.resultForm.IPAString.value);">
<?PHP

if($_GET['adminID']) {
	$criterium = ' AND vowel_trapeziums.adminID="' . dbClean($_GET['adminID']) . '"';
} 

$result = dbQuery('SELECT vowel_trapeziums.name as trapeziumName, admins.username as adminUsername, admins.name as adminName, admins.adminID as adminID, visits, vowelTrapeziumID FROM vowel_trapeziums, admins WHERE vowel_trapeziums.adminID = admins.adminID' . $criterium . ' ORDER BY trapeziumName, adminName');

if(!mysql_num_rows($result)) {
	print('<option value="0">-= This lecturer has no trapeziums =-</option>');
} else {
	print('<option value="0">-= Please select a trapezium =-</option>');
}	



while($vowelTrapeziumArr = mysql_fetch_assoc($result)) {

	if($vowelTrapeziumArr['vowelTrapeziumID'] == $_GET['vowelTrapeziumID']) {
		$selected = ' SELECTED';
	}
	
	print('<option value="' . $vowelTrapeziumArr['vowelTrapeziumID'] . '"' . $selected . '>' . $vowelTrapeziumArr['trapeziumName'] . ' (' . $vowelTrapeziumArr['adminName'] . ')</option>' . "\n");
	unset($selected);
}
?>
</select>
</form>
<br><br>

<?PHP

if($_GET['vowelTrapeziumID']) {

	// Getting information about trapezium
	require(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php');
	require(CACHE_PATH . '/vowels.php');
	
	// Adding vowels
	foreach($vowelTrapeziumConfArr['vowels'] as $vowelID => $vowelArr) {
				
		$trapeziumArr[$vowelID] = '
						
			<table border="0" cellspacing="0" cellpadding="0" style="top:' . ($vowelArr['y'] - 12) . 'px; left:' . $vowelArr['x'] . 'px; position: absolute;" class="rowNotMouseOver">
				<tr onMouseOver="this.className=\'rowMouseOver\';" onMouseOut="this.className=\'rowNotMouseOver\';">
					<td onClick="addCharacter(\'' . $vowelsArr[$vowelID]['unicode'] . '\');"> 
			    
			   		<div id="vowel_' . $vowelID . '" class="IPA_vowel">			
			
			 	  			&#' . hexdec($vowelsArr[$vowelID]['unicode']) . ';
			 			</div>
					</td>
				</tr>
			</table>
		 ';
	}
	
	// Getting custom headers
	foreach($languageArr['vowelArticulation']['cols'] as $colID => $string) {
			
		if($vowelTrapeziumConfArr['colNames'][$colID]) {
			$languageArr['vowelArticulation']['cols'][$colID] = $vowelTrapeziumConfArr['colNames'][$colID];
		} 	
		
	}
	
	foreach($languageArr['vowelArticulation']['rows'] as $rowID => $string) {
	
		if($vowelTrapeziumConfArr['rowNames'][$rowID]) { 
			$languageArr['vowelArticulation']['rows'][$rowID] = $vowelTrapeziumConfArr['rowNames'][$rowID];
		} 	
	
	}
	
	// Drawing trapezium
	drawTrapezium($trapeziumArr, $languageArr['vowelArticulation']['cols'], $languageArr['vowelArticulation']['rows'], $colHeaderAnchorsArr, $rowHeaderAnchorsArr);

}
?>
