<?PHP

dbConnect();

// Are the two passwords identical?
if($_POST['password'] != $_POST['password2']) {
	$errorsArr[] = 'The two passwords are not identical.';
}

// Does this username already exist?
$result = dbQuery('SELECT * FROM admins WHERE username = "' . $_POST['username'] . '"');
if(mysql_num_rows($result)) {
	$errorsArr[] = 'This username is already taken.';
}

if(!isUltraSafe($_POST['username']) || !isUltraSafe($_POST['password'])) {
	$errorsArr[] = 'Username and/or password contain illegal characters. (Only letters and numbers are allowed).';
}


// Are all mandatory fields filled out?
if(!$_POST['name']) {
	$errorsArr[] = 'No name was entered.';
}

if(!$_POST['username']) {
	$errorsArr[] = 'No username was entered.';
}

if(!$_POST['password']) {
	$errorsArr[] = 'No password was entered.';
}

if(sizeof($errorsArr)) {
	require('../templates/header.tmpl.php');

	require('pages/admin_register_' . $_SESSION['language'] . '.tmpl.php');

	require('../templates/footer.tmpl.php');
	exit();
}

// Saving admin
dbQuery('INSERT INTO admins VALUES(NULL, "' . dbClean($_POST['username']) . '", "' . dbClean($_POST['password']) . '", "' . dbClean($_POST['name']) . '", "' . dbClean($_POST['email']) . '", NOW(), NOW())');

header('Location: index.php?pageID=admin_register_success');
?>