<?PHP

require(TEMPLATE_PATH . '/header.tmpl.php');
require(CACHE_PATH . '/consonants.php');



dbConnect();

$result = dbQuery('SELECT * FROM statistics_consonants');

print('<h1>Consonant statistics</h1>');

print('The data in this table is based on the consonants in the consonant table &quot;All characters&quot;. The numbers specify the percentage of correct answers for this consonant. The number in paranthesis specify the amount of times this character has been guessed in the respective exercise. The statistics does not take into account the varying levels of difficulty possible on the IPA trainer.<br><br>');

print('<table border="1">');
print('<tr><td><b>Consonant:</b></td><td><b>Identify characters:</b></td><td><b>Identify places:</b></td><td><b>Identify sounds:</b></td><td><b>Average:</b></td></tr>');

while($statisticArr = mysql_fetch_assoc($result)) {
	if($statisticArr['consonantID'] != $oldConsonantID) {
		$consonantArr = $consonantsByIDArr[$statisticArr['consonantID']]; 	
		$oldConsonantID = $statisticArr['consonantID'];
		$allPercent = 0;
		

		print('<tr><td align="center"><img src="' . GFX_URL . '/consonants/' . $consonantArr['col'] . '.' . $consonantArr['row'] . '.' . $consonantArr['voiced'] . '.gif" border="0"></td>');  	
	}
	
	if($statisticArr['total'] == 0) {
		$percent = 'N/A';
	} else {
		$percent = round((($statisticArr['correct'] / $statisticArr['total']) * 100)) . '% (' . $statisticArr['total'] . ')';
		$avg++;
	}
	
	$allPercent += $percent;

	
	print('<td align="center">' . $percent . '</td>');
	if($statisticArr['exerciseType'] == 3) {
		print('<td align="center">' . round($allPercent / $avg) . ' %</td>');
		$avg = 0;
	}
}

print('</table>');


require(TEMPLATE_PATH . '/footer.tmpl.php');

?>
