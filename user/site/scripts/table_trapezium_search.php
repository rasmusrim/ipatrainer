<?PHP

dbConnect();

require('../templates/header.tmpl.php');

?>

<div align="right">
	<table border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td>	

				<a href="index.php">	
				<img src="<?PHP print(GFX_URL); ?>/icon_exit.png" height="20" width="20" border="0">
				</a>
			</td>
			
			<td>				
				
				<a href="index.php">	
				Back to main site
				</a>&nbsp;&nbsp;&nbsp;
			</td>

		</tr>
	</table>
	
</div>


<?PHP

if($_GET['type'] == 'consonantTable') {
	$result = dbQuery('SELECT consonantTableID as ID, admins.name as adminName, admins.username as username, admins.adminID as adminID, consonant_tables.name as name, visits FROM consonant_tables, admins WHERE consonant_tables.adminID = admins.adminID AND consonant_tables.name LIKE "%' . dbClean($_GET['searchString']) . '%" ORDER BY visits DESC, consonant_tables.name');
} elseif($_GET['type'] == 'vowelTrapezium') {
	$result = dbQuery('SELECT vowelTrapeziumID as ID, admins.name as adminName, admins.username as username, admins.adminID as adminID, vowel_trapeziums.name as name, visits FROM vowel_trapeziums, admins WHERE vowel_trapeziums.adminID = admins.adminID AND vowel_trapeziums.name LIKE "%' . dbClean($_GET['searchString']) . '%" ORDER BY visits DESC, vowel_trapeziums.name');
} else {
	lethalError('Invalid type');
	exit();
}



if(!mysql_num_rows($result)) {
	print('<h1>Zero result</h1>No entities found.<br><br><a href="index.php?pageID=main">Back</a>');
	exit();
}

print('<h1>Result</h1><br><br>');



while($resultArr = mysql_fetch_assoc($result)) {

	$i++;

	if($_GET['type'] == 'consonantTable') {	
		print('<a href="../index.php?c=consonant_table&a=display_functions&adminID=' . $resultArr['adminID'] . '&consonantTableID=' . $resultArr['ID'] . '">' . $resultArr['name'] . '</a> (<a href="' . ROOT_URL . '/?' . $resultArr['username'] . '">' . $resultArr['adminName'] . ')</a> - ' . $resultArr['visits'] . ' visits<br>');
	} else {
		print('<a href="../index.php?c=vowel_trapezium&a=display_functions&adminID=' . $resultArr['adminID'] . '&vowelTrapeziumID=' . $resultArr['ID'] . '">' . $resultArr['name'] . '</a> (<a href="' . ROOT_URL . '/?' . $resultArr['username'] . '">' . $resultArr['adminName'] . ')</a> - ' . $resultArr['visits'] . ' visits<br>');
	}		
}

print('<br><a href="index.php?pageID=main">Back</a>');

require('../templates/footer.tmpl.php');

?>