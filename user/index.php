<?PHP
session_start();

require('../config.php');


require_once(LANGUAGES_PATH . '/' . $_SESSION['language'] . '.php');
require_once(PHP_PATH . '/mysql.php');
require_once(PHP_PATH . '/html.php');
require_once(PHP_PATH . '/template.php');
require_once(PHP_PATH . '/common.php');
require_once(PHP_PATH . '/validation.php');
require_once(PHP_PATH . '/ipa.php');
require_once(PHP_PATH . '/user.php');
require_once(PHP_PATH . '/script_specific.php');

setLanguage();

dbConnect();

if(!$_GET['adminID']) {
	header('location: ' . ROOT_URL);
	exit();
}

// Getting info about this admin
$adminArr = getAdminInfo($_GET['adminID']);

// If there is a consonant table here, add to statistics
if($_GET['consonantTableID']) {
	dbQuery('UPDATE consonant_tables SET visits = visits + 1 WHERE consonantTableID = ' . dbClean($_GET['consonantTableID']));
}

// If there is a vowel trapezium here, add to statistics
if($_GET['vowelTrapeziumID']) {
	dbQuery('UPDATE vowel_trapeziums SET visits = visits + 1 WHERE vowelTrapeziumID = ' . dbClean($_GET['vowelTrapeziumID']));
}


// If nothing is entered, show main menu
if(!$_GET['a'] && !$_GET['c']) {
	require('admins/functions/tests_display.php');
}


if($_GET['c'] == 'consonant_table') {


	if($_GET['a'] == 'display_functions') {
		require('consonant_tables/functions/display_functions.php');
	}
	
	
	if($_GET['a'] == 'identify_characters') {
		require('consonant_tables/functions/identify_characters.php');
	}
	
	if($_GET['a'] == 'identify_places') {
		require('consonant_tables/functions/identify_places.php');
	}
	
	if($_GET['a'] == 'identify_sounds') {
		require('consonant_tables/functions/identify_sounds.php');
	}
	
	if($_GET['a'] == 'memory') {
		require('consonant_tables/functions/memory.php');
	}
	
	if($_GET['a'] == 'table_view') {
		require('consonant_tables/functions/table_view.php');
	}

	if($_GET['a'] == 'statistics_display') {
		require('consonant_tables/functions/statistics_display.php');
	}


}

if($_GET['c'] == 'vowel_trapezium') {
	if($_GET['a'] == 'display_functions') {
		require('vowel_trapeziums/functions/display_functions.php');
	}
	
	
	if($_GET['a'] == 'identify_characters') {
		require('vowel_trapeziums/functions/identify_characters.php');
	}
	
	if($_GET['a'] == 'identify_places') {
		require('vowel_trapeziums/functions/identify_places.php');
	}
	
	if($_GET['a'] == 'memory') {
		require('vowel_trapeziums/functions/memory.php');
	}
	
	if($_GET['a'] == 'trapezium_view') {
		require('vowel_trapeziums/functions/trapezium_view.php');
	}

}

if($_GET['c'] == 'ipastring') {
	if($_GET['a'] == 'convert') {
		require('ipastring/functions/convert.php');
	}
}


?>	
		
