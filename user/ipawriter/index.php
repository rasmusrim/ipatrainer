<?PHP
session_start();

if(!$_SESSION['language']) {
	$_SESSION['language'] = 'en';
}


require('../../config.php');
require_once(LANGUAGES_PATH . '/' . $_SESSION['language'] . '.php');
require_once(PHP_PATH . '/mysql.php');
require_once(PHP_PATH . '/html.php');
require_once(PHP_PATH . '/template.php');
require_once(PHP_PATH . '/common.php');
require_once(PHP_PATH . '/validation.php');
require_once(PHP_PATH . '/ipa.php');
require_once(PHP_PATH . '/user.php');

dbConnect();

if($_GET['c'] == 'keyboardShortcut') {
	if($_GET['a'] == 'showForm') {
		require('keyboard_shortcuts/functions/show_form.php');
		exit();
	}
	
	if($_GET['a'] == 'define') {	
		require('keyboard_shortcuts/functions/define.php');
		exit();
	}
}

require('writer/display.php');

?>
