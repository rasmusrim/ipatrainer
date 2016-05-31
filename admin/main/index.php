<?PHP
error_reporting(E_ALL);

session_start();

set_magic_quotes_runtime(0);

require_once('../../config.php');


if(!$_SESSION['language']) {
	$_SESSION['language'] = 'en';
}

require_once(LANGUAGES_PATH . '/' . $_SESSION['language'] . '.php');
require_once('../classes/login.php');
require_once(PHP_PATH . '/mysql.php');
require_once(PHP_PATH . '/html.php');
require_once(PHP_PATH . '/template.php');
require_once(PHP_PATH . '/common.php');
require_once(PHP_PATH . '/validation.php');
require_once(PHP_PATH . '/ipa.php');
require_once(PHP_PATH . '/form_creator.class.php');



// Is user logged in?
dbConnect();

// Is this user logged in?
if(!$loggedInAdminArr = loggedIn()) {

	header('Location: ' . ADMIN_URL);
	exit();
}

$adminArr = unserialize($_SESSION['loggedInAdminArr']);

$fromIndex = true;

// If no action is selected, show main menu
if(!$_GET['c'] || !$_GET['a']) {
	
	require(ADMIN_PATH . '/templates/loggedin_header.tmpl.php');
	require('mainmenu.tmpl.php');
	require(ADMIN_PATH . '/templates/footer.tmpl.php');
	exit();
}

// Consonant table
if($_GET['c'] == 'consonant_table') {
	
	// Checking if this is the admin of this table before allowing user to proceed	
	if($_GET['consonantTableID']) {
		if(!isInt($_GET['consonantTableID'])) {
			lethalError('Invalid consonant table ID');
		}
		
		if(!file_exists(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php')) {
			lethalError('Configuration file missing');
		}		
			
		require(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php');		
		
		if($adminArr['adminID'] != $consonantTableConfArr['adminID']) {
			lethalError('This admin is not allowed to edit this table');
		}
	}
	
	if($_GET['a'] == 'display') {
		require('consonant_table/functions/display.php');

	}
	
	if($_GET['a'] == 'saveName') {
		require('consonant_table/functions/name_save.php');
	}
	
	if($_GET['a'] == 'edit') {
		require('../templates/loggedin_header.tmpl.php');

		require('consonant_table/functions/edit.php');		
		require('../templates/footer.tmpl.php');
	}
	
	if($_GET['a'] == 'consonant_add') {
		require('consonant_table/functions/consonant_add.php');
	}	

	if($_GET['a'] == 'consonant_remove') {
		require('consonant_table/functions/consonant_remove.php');
	}	

	if($_GET['a'] == 'consonants_add_all') {
		require('consonant_table/functions/consonants_add_all.php');
	}	

	if($_GET['a'] == 'consonants_remove_all') {
		require('consonant_table/functions/consonants_remove_all.php');
	}	

	if($_GET['a'] == 'move') {
		require('consonant_table/functions/colrow_move.php');
	}
		
	if($_GET['a'] == 'delete') {
		require('consonant_table/functions/delete.php');
	}

	if($_GET['a'] == 'changeHeaderName') {
		require('consonant_table/functions/change_header_name.php');
	}
				

}

// Vowel trapezium
if($_GET['c'] == 'vowel_trapezium') {
	
	// Checking if this is the admin of this table before allowing user to proceed	
	if($_GET['vowelTrapeziumID']) {
		if(!isInt($_GET['vowelTrapeziumID'])) {
			lethalError('Invalid vowel trapezium ID');
		}
		
		if(!file_exists(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php')) {
			lethalError('Configuration file missing');
		}		
			
		require(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php');		
		
		if($adminArr['adminID'] != $vowelTrapeziumConfArr['adminID']) {
			lethalError('This admin is not allowed to edit this table');
		}
	}
	
	if($_GET['a'] == 'display') {
		require('vowel_trapezium/functions/display.php');

	}
	
	if($_GET['a'] == 'saveName') {
		require('vowel_trapezium/functions/name_save.php');
	}
	
	if($_GET['a'] == 'edit') {
		require('../templates/loggedin_header.tmpl.php');

		require('vowel_trapezium/functions/edit.php');		
		require('../templates/footer.tmpl.php');
	}
	
	if($_GET['a'] == 'vowel_add') {
		require('vowel_trapezium/functions/vowel_add.php');
	}	

	if($_GET['a'] == 'vowel_remove') {
		require('vowel_trapezium/functions/vowel_remove.php');
	}	

	if($_GET['a'] == 'vowels_add_all') {
		require('vowel_trapezium/functions/vowels_add_all.php');
	}	

	if($_GET['a'] == 'vowels_remove_all') {
		require('vowel_trapezium/functions/vowels_remove_all.php');
	}	

	if($_GET['a'] == 'vowel_move') {
		require('vowel_trapezium/functions/vowel_move.php');
	}
		
	if($_GET['a'] == 'delete') {
		require('vowel_trapezium/functions/delete.php');
	}

	if($_GET['a'] == 'changeHeaderName') {
		require('vowel_trapezium/functions/change_header_name.php');
	}
				

}


// Preferences
if($_GET['c'] == 'preferences') {
	if($_GET['a'] == 'edit') {
		require('preferences/functions/edit.php');
	}
}

// Exercises
if($_GET['c'] == 'preview') {
	if($_GET['a'] == 'show') {
		require('preview/functions/show.php');
	}
	
	if($_GET['a'] == 'top_frame') {
		require('preview/templates/top_frame.tmpl.php');
	}		
}

?>