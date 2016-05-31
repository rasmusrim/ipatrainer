<?PHP
require_once('../config.php');
require_once(PHP_PATH . '/mysql.php');
require_once(PHP_PATH . '/html.php');
require_once(PHP_PATH . '/template.php');
require_once(PHP_PATH . '/common.php');
require_once(PHP_PATH . '/validation.php');
require_once(PHP_PATH . '/ipa.php');
require_once(PHP_PATH . '/user.php');

dbConnect();

// Validating input
if(!isUltraSafe($_POST['username']) || !isUltraSafe($_POST['password'])) {
	require('templates/header.tmpl.php');
	print('Ulovlige tegn i brukernavn eller passord. Av sikkerhetsgrunn er scriptet blitt stoppet.<br><br>');
	print('<a href="javascript:history.back()">&lt;&lt; Tilbake</a>');
	require('templates/footer.tmpl.php');
	exit();
}

// Checking if user exists in database
$query = dbQuery('SELECT * FROM ' . DB_PREFIX . 'superadmins WHERE username="' . dbClean($_POST['username']) . '" AND password = MD5("' . dbClean($_POST['password']) . '")');

$adminArr = mysql_fetch_assoc($query);

// If no login, go back and display error
if(!$adminArr) {
	$error .= '<li>Feil brukernavn eller passord';
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

// Redirecting to right place
header('Location: main/');
?>
