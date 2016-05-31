<?PHP
if(!$fromIndex) {
	lethalError('Not from index!');
}

if($adminArr['username'] == 'demo') {
	require('../templates/loggedin_header.tmpl.php');
	require('preferences/templates/error_cannot_edit_demo.tmpl.php');
	require('../templates/footer.tmpl.php');
	exit();
}
	
// Is this a save or a display?
if($_GET['save'] != 'true') {

	// Get info about admin and display form
	$result = dbQuery('SELECT * FROM admins WHERE adminID = "' . dbClean($adminArr['adminID']) . '" LIMIT 1');
	$adminInfoArr = mysql_fetch_assoc($result);

	require('../templates/loggedin_header.tmpl.php');
	require('preferences/templates/edit.tmpl.php');
	require('../templates/footer.tmpl.php');
	
	exit();	
}

// Else, save
// Are the two passwords identical?
if($_POST['password'] != $_POST['password2']) {
	$errorsArr[] = 'The two passwords are not identical.';
}

// Are all mandatory fields filled out?
if(!$_POST['name']) {
	$errorsArr[] = 'No name was entered.';
}

if(!isUltraSafe($_POST['username']) || !isUltraSafe($_POST['password'])) {
	$errorsArr[] = 'Username and/or password contain illegal characters. (Only letters and numbers are allowed).';
}

// Any errors, display them.
if(sizeof($errorsArr)) {

	$adminInfoArr = $_POST;
	$adminInfoArr['username'] = $adminArr['username'];
	require('../templates/loggedin_header.tmpl.php');
	require('preferences/templates/edit.tmpl.php');
	require('../templates/footer.tmpl.php');

	exit();
}	

// Updating
dbQuery('UPDATE admins SET name = "' . $_POST['name'] . '", email = "' . $_POST['email'] . '" WHERE adminID = ' . $adminArr['adminID']);

// If password is changed, change that as well
if($_POST['password']) {
	dbQuery('UPDATE admins SET password = MD5("' . $_POST['password'] . '") WHERE adminID = ' . $adminArr['adminID']);
}

header('Location: index.php');
	
?>
