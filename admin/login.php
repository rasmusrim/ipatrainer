<?PHP
require('../config.php');

require_once(PHP_PATH . '/mysql.php');
require_once(PHP_PATH . '/common.php');
require_once(PHP_PATH . '/validation.php');

dbConnect();

// Validating input
if(!isUltraSafe($_POST['username']) || !isUltraSafe($_POST['password'])) {
	require('templates/header.tmpl.php');
	print('Illegal characters found in username and/or password. Script stopped out of security reasons. Please try logging in again.<br><br>');
	print('<a href="javascript:history.back()">&lt;&lt; Try again</a>');
	require('templates/footer.tmpl.php');
	exit();
}

// Checking if user exists in database
$query = dbQuery('SELECT * FROM ' . DB_PREFIX . 'admins WHERE username="' . dbClean($_POST['username']) . '" AND password = MD5("' . dbClean($_POST['password']) . '")');

$adminArr = mysql_fetch_assoc($query);

// If no login, go back and display error
if(!$adminArr) {
	$error .= '<li>Incorrect username or password.';
	require('index.php');
	exit();
}

// Do login
session_start();

setcookie('username', $_POST['username'], 0, '/');
$sessionId = generatePassword(200);
setcookie('sessionID', $sessionId, 0, '/');

$_SESSION['username'] = $_POST['username'];
$_SESSION['sessionID'] = $sessionId;
$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
$_SESSION['loggedInAdminArr'] = serialize($adminArr);
$_SESSION['language'] = 'en';

// Redirecting to right place
header('Location: ' . AFTER_LOGIN_REDIRECT_TO); 
?>
