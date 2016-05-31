<?PHP
require('config.php');

require(LANGUAGES_PATH . '/en.php');

require_once(PHP_PATH . '/mysql.php');
require_once(PHP_PATH . '/html.php');
require_once(PHP_PATH . '/template.php');
require_once(PHP_PATH . '/common.php');
require_once(PHP_PATH . '/validation.php');
require_once(PHP_PATH . '/ipa.php');
require_once(PHP_PATH . '/user.php');

dbConnect();

if($_GET['a'] == 'keyboard_shortcut_form') {
	require(TEMPLATES_PATH . '/keyboard_shortcut_form.php');
	exit();
}

// Building HTML output.
require(TEMPLATES_PATH . '/framework.tmpl.php');


?>

