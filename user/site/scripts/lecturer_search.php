<?PHP

dbConnect();

require('../templates/header.tmpl.php');

$result = dbQuery('SELECT username, adminID, name FROM admins WHERE name LIKE "%' . dbClean($_GET['name']) . '%" ORDER BY name');

if(!mysql_num_rows($result)) {
	print('<h1>Zero result</h1>No lecturers found.<br><br><a href="index.php?pageID=main">Back</a>');
	exit();
}

print('<h1>Result</h1>');

while($adminArr = mysql_fetch_assoc($result)) {
	print('<a href="' . ROOT_URL . '/?' . $adminArr['username'] . '">' . $adminArr['name'] . ' (' . $adminArr['username'] . ')</a><br>');	
}

print('<br><a href="index.php?pageID=main">Back</a>');

require('../templates/footer.tmpl.php');

?>