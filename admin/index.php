<?PHP
header('Content-Type: text/html; charset=UTF-8;');

// 

require_once('../config.php');
require_once(PHP_PATH . '/mysql.php');
require_once('classes/login.php');
require_once(PHP_PATH . '/common.php');

dbConnect();
session_start();

// Is this user already logged in?
$userArr = loggedIn();

if(!$userArr) {
	require('templates/header.tmpl.php');
	require('templates/login_form.tmpl.php');
	require('templates/footer.tmpl.php');
	exit();		
}

header('Location: main/index.php');

?>
