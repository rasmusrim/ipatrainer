<?PHP
session_start();


require('../../config.php');

require_once(PHP_PATH . '/mysql.php');
require_once(PHP_PATH . '/html.php');
require_once(PHP_PATH . '/template.php');
require_once(PHP_PATH . '/common.php');
require_once(PHP_PATH . '/validation.php');
require_once(PHP_PATH . '/ipa.php');
require_once(PHP_PATH . '/user.php');
require_once(PHP_PATH . '/script_specific.php');

setLanguage();

require_once(LANGUAGES_PATH . '/' . $_SESSION['language'] . '.php');

if(!$_REQUEST['pageID'] && !$_REQUEST['scriptID']) {
	$_REQUEST['pageID'] = 'main';
}

if($_REQUEST['pageID']) {
	require('../templates/header.tmpl.php');

	if(file_exists('pages/' . $_REQUEST['pageID'] . '_' . $_SESSION['language'] . '.tmpl.php')) {
		require('pages/' . $_REQUEST['pageID'] . '_' . $_SESSION['language'] . '.tmpl.php');
	} else {
		// See if the page exists in English. If it does, show it instead of local language.		
		if(file_exists('pages/' . $_REQUEST['pageID'] . '_en.tmpl.php')) {
			require('pages/' . $_REQUEST['pageID'] . '_en.tmpl.php');
		} else {
			print('<h1>Page not found</h1> The page you were looking for could not be found.<br><br><a href="index.php?pageID=main">Back to main page</a>');
		}
	}

	require('../templates/footer.tmpl.php');

} else {
	if(file_exists('scripts/' . $_REQUEST['scriptID'] . '.php')) {
		require('scripts/' . $_REQUEST['scriptID'] . '.php');
	} else {
		require('../templates/header.tmpl.php');
		
		print('<h1>Page not found</h1> The page you were looking for could not be found.<br><br><a href="index.php?pageID=main">Back to main page</a>');
		require('../templates/footer.tmpl.php');
	
	}
}	


?>
