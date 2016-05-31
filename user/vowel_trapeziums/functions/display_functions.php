<?PHP

require('templates/header.tmpl.php');

// Deleting information from last test
unset($_SESSION['usedChars']);
unset($_SESSION['correct']);
unset($_SESSION['incorrect']);
unset($_SESSION['vowelTrapeziumID']);
unset($_SESSION['randChar']);

// Getting information about trapezium
require(CACHE_PATH . '/vowel_trapeziums/' . $_GET['vowelTrapeziumID'] . '.php');

// Load template
$templateArr = templateLoad('vowel_trapeziums/templates/display_functions.tmpl.php');

$adminArr['URL'] = ROOT_URL . '/?' . $adminArr['username'];
$adminArr['trapeziumName'] = $vowelTrapeziumConfArr['name'];
$adminArr['vowelTrapeziumID'] = $_GET['vowelTrapeziumID']; 


// Adding constant
$adminArr['GFX_URL'] = GFX_URL;
$adminArr['IPA_WRITER_URL'] = IPA_WRITER_URL;

// Displaying template
print(templateDisplay($templateArr, $adminArr));

require('templates/footer.tmpl.php');
