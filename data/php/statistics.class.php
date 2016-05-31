<?PHP

class statistics {
	const IDENTIFY_CHARACTERS = 1;
	const IDENTIFY_PLACES = 2;
	const IDENTIFY_SOUNDS = 3;
	
	function addConsonantLine($consonantID, $consonantTableID) {
		if($consonantID == 0) {
			return;
		}

		// Is there an entry for this consonant and table in the statistics table? If not, add one.
		$result = dbQuery('SELECT * FROM statistics_consonants WHERE consonantID = "' . $consonantID . '" AND consonantTableID = "' . $consonantTableID . '"');
		if(!mysql_num_rows($result)) {
			dbQuery('INSERT INTO statistics_consonants VALUES("' . $consonantID . '", "' . $consonantTableID . '", 0, 0, 0, 0, 0, 0)');
		}
	}
	
	function addCorrectGuess($consonantID, $consonantTableID, $exercise) {
		if($consonantID == 0) {
			return;
		}

		dbQuery('UPDATE statistics_consonants SET correct' . $exercise . ' = correct' . $exercise . ' + 1 WHERE consonantID = "' . $consonantID . '" AND consonantTableID = "' . $consonantTableID . '"');
		statistics::addTotalGuess($consonantID, $consonantTableID, $exercise);
	}

	function addTotalGuess($consonantID, $consonantTableID, $exercise) {
		if($consonantID == 0) {
			return;
		}

		dbQuery('UPDATE statistics_consonants SET total' . $exercise . ' = total' . $exercise . ' + 1 WHERE consonantID = "' . $consonantID . '" AND consonantTableID = "' . $consonantTableID . '"');
	}
}	
?>
