<?PHP
// Connects to server and chooses DB
function dbConnect() {
	$db = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
	if(mysql_error()) {
		print('Could not connect to db<br>' . mysql_error());
		exit();
	}			
	
	mysql_select_db(DB_DATABASE);
	
	if(mysql_error()) {
		print('Could not select database ' . DB_DATABASE . '<br>' . mysql_error());
		exit();
	}
		
	return $db;
}

function dbQuery($query, $showQuery = 0, $db = '') {
	
	// If debug is on, show query
	if($_SESSION['debugOn']) {
		$showQuery = 1;
	}
	
	// Show the line being queried
	if($showQuery) {
		print('<font color=\'black\'><hr><b>Requested to show query:</b><br>' . $query . '<hr></font>');
	}
	
	if($db) {
		$result = mysql_query($query, $db);
	} else {
		$result = mysql_query($query);
	}
				
	if(mysql_error()) {
		lethalError('<font color=\'black\'><hr><b>Could not run query:</b><br>' . $query . '<br></font><font color=red>' . mysql_error() . '</font><hr>');
		
	}
	
	return $result;
}

function dbGet($query, $sortBy = 'ID', $limit = 0, $showQuery = 0) {
	if($limit) {
		$query .= ' LIMIT ' . $limit;
	}
	
	$result = dbQuery($query, $showQuery);
	
	while($row = mysql_fetch_assoc($result)) {
		if($limit = 1) {
			return $row;
		} else {
			$retArr[$row[$sortBy]] = $row;
		}
	}
	
	return $retArr;
}

function getElement($ID, $table, $idName, $showQuery = 0) {
	$result = dbQuery('SELECT * FROM ' . dbClean($table) . ' WHERE ' . $idName . ' = "' . dbClean($ID) . '" LIMIT 1;', $showQuery);
	$elementArr = mysql_fetch_assoc($result);
	
	return $elementArr;
}

function dbClean($string) {
	$string = mysql_real_escape_string($string);
	
	return $string;
}

?>