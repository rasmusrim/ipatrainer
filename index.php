<?PHP

require('config.php');
require(PHP_PATH . '/mysql.php');

session_start();

dbConnect();

if($_GET['admin']) {
	$admin = $_GET['admin'];
}

if($_SERVER['QUERY_STRING'] && !$admin) {
	// We need to remove the language directive if it is there	
	$elementsArr = explode('&', $_SERVER['QUERY_STRING']);
	foreach($elementsArr as $key => $element) {
		list($key, $value) = explode('=', $element);
				
		if(!$value) {	
			$admin = $key;
		}
	}
}



if($admin) {

	// Finding ID of this admin
	$result = dbQuery('SELECT * FROM admins WHERE username = "' . dbClean($admin) . '" LIMIT 1');
	$adminArr = mysql_fetch_assoc($result);

	if(!$adminArr) {
		print('Invalid admin specified');
		die();
	}
	
	$_SESSION['adminArr'] = serialize($adminArr);
	header('HTTP/1.1 301 Moved Permanently'); 
	header('Location: user/index.php?adminID=' . $adminArr['adminID'] . '&language=' . $_GET['language']);
} else {
	header('HTTP/1.1 301 Moved Permanently'); 
	header('Location: user/site/?language=' . $_GET['language']);
}

?>
