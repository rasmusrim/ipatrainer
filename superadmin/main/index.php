<?PHP
set_magic_quotes_runtime(0);

require_once('../../config.php');
require_once(PHP_PATH . '/mysql.php');
require_once(PHP_PATH . '/html.php');
require_once(PHP_PATH . '/template.php');
require_once(PHP_PATH . '/common.php');
require_once(PHP_PATH . '/validation.php');
require_once(PHP_PATH . '/ipa.php');
require_once(PHP_PATH . '/user.php');
require('../classes/login.php');

// Is user logged in?
session_start();
dbConnect();

// Is this user logged in?
if(!$loggedInAdminArr = loggedIn()) {
	header('Location: ' . SUPER_ADMIN_URL);
	exit();
}

$fromIndex = true;


// If no action is selected, show main menu
if(!$_REQUEST['c'] || !$_REQUEST['a']) {
	require(SUPER_ADMIN_PATH . '/templates/loggedin_header.tmpl.php');
	require('mainmenu.tmpl.php');
	require(SUPER_ADMIN_PATH . '/templates/footer.tmpl.php');
	exit();
}

if($_REQUEST['c'] == 'mail') {

	if($_REQUEST['a'] == 'write') {
		require(SUPER_ADMIN_PATH . '/templates/loggedin_header.tmpl.php');
		require('mail/functions/write.php');
		require(SUPER_ADMIN_PATH . '/templates/footer.tmpl.php');
	}

	if($_REQUEST['a'] == 'send') {
		
		require(SUPER_ADMIN_PATH . '/templates/loggedin_header.tmpl.php');
		require('mail/functions/send.php');
		require(SUPER_ADMIN_PATH . '/templates/footer.tmpl.php');
	}
}
