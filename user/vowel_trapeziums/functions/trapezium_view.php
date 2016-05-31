<?PHP

require('templates/header.tmpl.php');

// Getting information about trapezium
require(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php');
require(CACHE_PATH . '/vowels.php');



// Load template
$templateArr = templateLoad('vowel_trapeziums/templates/trapezium_view.tmpl');

// Adding vowels
foreach($vowelTrapeziumConfArr['vowels'] as $vowelID => $vowelArr) {
	$trapeziumArr[$vowelID] = '<img src="' . GFX_URL . '/vowels/' . $vowelID . '.gif" border="0" style="position:absolute; top:' . $vowelArr['y'] . 'px; left:' . $vowelArr['x'] . 'px;" id="vowel_' . $vowelID . '">';
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

$vowelTrapeziumConfArr['GFX_URL'] = GFX_URL;

print(templateDisplay($templateArr, $vowelTrapeziumConfArr, 'header'));

// Drawing trapezium
drawTrapezium($trapeziumArr, $languageArr['vowelArticulation']['cols'], $languageArr['vowelArticulation']['rows'], $colHeaderAnchorsArr, $rowHeaderAnchorsArr);

// Displaying footer
$fieldsArr['adminID'] = $_GET['adminID'];
$fieldsArr['vowelTrapeziumID'] = $_GET['vowelTrapeziumID'];


print(templateDisplay($templateArr, $fieldsArr, 'footer'));

require('templates/footer.tmpl.php');


?>