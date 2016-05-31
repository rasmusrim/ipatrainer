<?PHP
if(!$fromIndex) {
	lethalError('Not from index!');
}


// Separate the array that is to be manipulated
$tmpArr = $consonantTableConfArr[$_GET['what'] . 's'];

// Finding col/row in question
$id = array_search($_GET[$_GET['what'] . 'ID'], $tmpArr);

if($_GET['direction'] == 'up') {
	$switchID = $id - 1;
}

if($_GET['direction'] == 'down') {
	$switchID = $id + 1;
}

// Doing the switch
$switch1 = $tmpArr[$id];
$switch2 = $tmpArr[$switchID];

// If dental, alveolar, postalveolar is involved in this move, rembember the number that this chunk is supposed to follow
if($switch1 == 2 || $switch1 == 4) {
	$moveAlveolarChunkAccordingTo = $switch1;
}

if($switch2 == 2 || $switch2 == 4) {
	$moveAlveolarChunkAccordingTo = $switch2;
}

$tmpArr[$id] = $switch2;
$tmpArr[$switchID] = $switch1;

// Dental, postalveolar and alveolar problem. Looping through putting these three beside each other
if($_GET['what'] == 'col' && $moveAlveolarChunkAccordingTo) {
	foreach($tmpArr as $value) {
		if($value == $moveAlveolarChunkAccordingTo) {
			$tmpArr2[] = 2;
			$tmpArr2[] = 3;
			$tmpArr2[] = 4;
		} else {
			if($value != 2 && $value != 3 && $value != 4) {			
				$tmpArr2[] = $value;
			}
		}
	}

	$tmpArr = $tmpArr2;
}

// Putting back into configuration array
$consonantTableConfArr[$_GET['what'] . 's'] = $tmpArr;

// Saving
// Writing configuration file
$CONFIGURATION_FILE = fopen(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php', 'w');
fwrite($CONFIGURATION_FILE, '<?PHP' . "\n" . '$consonantTableConfArr = ' . array2code($consonantTableConfArr) . ';' . "\n?>");
fclose($CONFIGURATION_FILE);

header('Location: index.php?c=consonant_table&a=edit&consonantTableID=' . $_GET['consonantTableID'] . '#bottomTable'); 	


?>