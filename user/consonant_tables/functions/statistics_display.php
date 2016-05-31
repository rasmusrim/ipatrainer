<?PHP

require(TEMPLATE_PATH . '/header.tmpl.php');
require(CACHE_PATH . '/consonants.php');
require(PHP_PATH . '/statistics.class.php');

// Getting information about table
require(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php');
?>

<div align="right">
	<table border="0" cellspacing="0" cellpadding="2">
		<tr>

			<td>	

				<a href="index.php?adminID=<?PHP print($_GET['adminID']); ?>&consonantTableID=<?PHP print($_GET['consonantTableID']); ?>&c=consonant_table&a=display_functions">	
				<img src="<?PHP print(GFX_URL); ?>/icon_exit.png" height="20" width="20" border="0">
				</a>
			</td>
			
			<td>				
				
				<a href="index.php?adminID=<?PHP print($_GET['adminID']); ?>&consonantTableID=<?PHP print($_GET['consonantTableID']); ?>&c=consonant_table&a=display_functions">	
				Exit
				</a>&nbsp;&nbsp;&nbsp;
			</td>

		</tr>
	</table>
	
</div>
<?PHP


dbConnect();

if(!$_GET['orderBy']) {
	$_GET['orderBy'] = statistics::IDENTIFY_CHARACTERS;
}

$result = dbQuery('SELECT * FROM statistics_consonants WHERE consonantTableID = "' . $_GET['consonantTableID'] . '" ORDER BY (correct' . $_GET['orderBy'] . ' / total' . $_GET['orderBy'] . ')');

print('<h1>Statistics for table &quot;' . $consonantTableConfArr['name'] . '&quot;</h1>');

print('The data in this table is based on the correct and incorrect answers people have given when they have practiced this specific consonant table. The numbers specify the percentage of correct answers for this consonant. The number in paranthesis specify the amount of times this character has been guessed in the respective exercise. The statistics does not take into account the varying levels of difficulty possible on the IPA trainer. If certain characters are missing, this is probably because they have not yet appeared to anyone who has practiced the table.<br><br>');

print('<table border="1">');
print('<tr><td><b>Consonant:</b></td>
<td><b><a href="index.php?c=consonant_table&a=statistics_display&consonantTableID=' . $_GET['consonantTableID'] . '&adminID=' . $_GET['adminID'] . '&orderBy=' . statistics::IDENTIFY_CHARACTERS . '">Identify characters:</b></a></td>
<td><b><a href="index.php?c=consonant_table&a=statistics_display&consonantTableID=' . $_GET['consonantTableID'] . '&adminID=' . $_GET['adminID'] . '&orderBy=' . statistics::IDENTIFY_PLACES . '">Identify places:</b></a></td>
<td><b><a href="index.php?c=consonant_table&a=statistics_display&consonantTableID=' . $_GET['consonantTableID'] . '&adminID=' . $_GET['adminID'] . '&orderBy=' . statistics::IDENTIFY_SOUNDS . '">Identify sounds:</b></a></td>
<td><b>Average:</b></td></tr>');

while($statisticArr = mysql_fetch_assoc($result)) {
	
	
	$consonantArr = $consonantsByIDArr[$statisticArr['consonantID']]; 	
		

	print('<tr><td align="center"><img src="' . GFX_URL . '/consonants/' . $consonantArr['col'] . '.' . $consonantArr['row'] . '.' . $consonantArr['voiced'] . '.gif" border="0"></td>');  	
	
	$avg = 0;
	$totalPercent = 0;
	
	for($i = 1; $i < 4; $i++) {

		if($statisticArr['total' . $i] == 0) {
			$percent = 'N/A';
		} else {
			$percent = round((($statisticArr['correct' . $i] / $statisticArr['total' . $i]) * 100)) . '% (' . $statisticArr['total' . $i] . ')';
			$totalPercent += $percent;
			$avg++;
		}
		
		
		
		print('<td align="center">' . $percent . '</td>');
	}
	
	print('<td align="center">' . round($totalPercent / $avg) . ' %</td>');
}

print('</table>');


require(TEMPLATE_PATH . '/footer.tmpl.php');

?>
