<?PHP

// Display headers
$readableNameSingular = 'consonant table';
$readableNamePlural = 'consonant tables';
$category = 'consonant_table';

require('../templates/loggedin_header.tmpl.php');
require('../templates/list_header.tmpl.php');

// Writing table headers
print('<tr class="heading1"><td>Name:</td><td>Action:</td>');

// Getting all consonant tables
$result = dbQuery('SELECT * FROM consonant_tables WHERE adminID = ' . $adminArr['adminID'] . ' ORDER BY name');

while($consonantTableArr = mysql_fetch_assoc($result)) {
	print('<tr class="dataElementNotMouseOver" onMouseOver="this.className=\'dataElementMouseOver\';" onMouseOut="this.className=\'dataElementNotMouseOver\';">');
	print('<td>' . $consonantTableArr['name'] . '</td>');			
	
	// Printing action elements			
	print('<td>
	<a href="index.php?c=' . $category . '&a=edit&consonantTableID=' . $consonantTableArr['consonantTableID'] . '" class="adminlink">Edit</a>&nbsp;&nbsp;&nbsp;
	<a href="javascript: if(confirm(\'Do you really want to delete ' . $consonantTableArr['name'] . '?\')) { document.location=\'index.php?c=' . $category . '&a=delete&consonantTableID=' . $consonantTableArr['consonantTableID'] . '\'; }" class="adminlink">Delete</a>
	</td>');

	print('</tr>');
}

require('../templates/footer.tmpl.php');

?>
