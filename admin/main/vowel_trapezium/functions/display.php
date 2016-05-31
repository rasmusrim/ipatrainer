<?PHP

// Display headers
$readableNameSingular = 'vowel trapezium';
$readableNamePlural = 'vowel trapeziums';
$category = 'vowel_trapezium';

require('../templates/loggedin_header.tmpl.php');
require('../templates/list_header.tmpl.php');

// Writing table headers
print('<tr class="heading1"><td>Name:</td><td>Action:</td>');

// Getting all vowel trapeziums
$result = dbQuery('SELECT * FROM vowel_trapeziums WHERE adminID = ' . $adminArr['adminID'] . ' ORDER BY name');

while($vowelTrapeziumArr = mysql_fetch_assoc($result)) {
	print('<tr class="dataElementNotMouseOver" onMouseOver="this.className=\'dataElementMouseOver\';" onMouseOut="this.className=\'dataElementNotMouseOver\';">');
	print('<td>' . $vowelTrapeziumArr['name'] . '</td>');			
	
	// Printing action elements			
	print('<td>
	<a href="index.php?c=' . $category . '&a=edit&vowelTrapeziumID=' . $vowelTrapeziumArr['vowelTrapeziumID'] . '" class="adminlink">Edit</a>&nbsp;&nbsp;&nbsp;
	<a href="javascript: if(confirm(\'Do you really want to delete ' . $vowelTrapeziumArr['name'] . '?\')) { document.location=\'index.php?c=' . $category . '&a=delete&vowelTrapeziumID=' . $vowelTrapeziumArr['vowelTrapeziumID'] . '\'; }" class="adminlink">Delete</a>
	</td>');

	print('</tr>');
}

require('../templates/footer.tmpl.php');

?>
