<?PHP

require('templates/header.tmpl.php');

// Deleting information from last test
unset($_SESSION['usedChars']);
unset($_SESSION['correct']);
unset($_SESSION['incorrect']);
unset($_SESSION['consonantTableID']);
unset($_SESSION['randChar']);

// Load template
$templateArr = templateLoad('admins/templates/tests_display.tmpl');

$adminArr['GFX_URL'] = GFX_URL;
$adminArr['URL'] = ROOT_URL . '/?' . $adminArr['username'];

// Displaying header
print(templateDisplay($templateArr, $adminArr, 'header'));

// Getting all consonant tables of this admin
$result = dbQuery('SELECT * FROM consonant_tables WHERE adminID = ' . dbClean($_GET['adminID'])); 

while($consonantTableArr = mysql_fetch_assoc($result)) {
		
	print(templateDisplay($templateArr, $consonantTableArr, 'consonantTable'));
		
}

print(templateDisplay($templateArr, $adminArr, 'intermezzo'));


// Getting all vowel trapeziums of this admin
$result = dbQuery('SELECT * FROM vowel_trapeziums WHERE adminID = ' . dbClean($_GET['adminID'])); 

while($vowelTrapeziumArr = mysql_fetch_assoc($result)) {
		
	print(templateDisplay($templateArr, $vowelTrapeziumArr, 'vowelTrapezium'));
		
}


// Displaying footer
$adminArr['IPA_WRITER_URL'] = IPA_WRITER_URL;
print(templateDisplay($templateArr, $adminArr, 'footer'));


require('templates/footer.tmpl.php');
