
<h1>IPA Trainer - Hilft Ihnen beim Phonetik üben und transkribieren</h1>



<table border="1" align="right" style="margin: 10px;" cellpadding="5">
	<tr>
		<td valign="bottom">
			
<!-- google_ad_section_start -->

			<b>Die popularsten Konsonantentabellen:</b><br>
			<?PHP
			dbConnect();			
			$usedTableNamesArr = array();

			$result = dbQuery('SELECT consonant_tables.name as tableName, admins.username as adminUsername, admins.name as adminName, admins.adminID as adminID, visits, consonantTableID FROM consonant_tables, admins WHERE consonant_tables.adminID = admins.adminID ORDER BY visits DESC, consonant_tables.name');
				
			while($numberOfTables < 10) {
				
				$consonantTableArr = mysql_fetch_assoc($result);
				
				if(!$consonantTableArr) {
					break;
				}
				
				// Do not include unusable tables.			
				require(CACHE_PATH . '/consonant_tables/' . $consonantTableArr['consonantTableID'] . '.php');
				if(sizeof($consonantTableConfArr['consonants']) > 2) {				
				
					if(!in_array(strtolower($consonantTableArr['tableName']), $usedTableNamesArr)) {
						
						if(strlen($consonantTableArr['tableName']) > 17) {
							$consonantTableArr['tableName'] = substr($consonantTableArr['tableName'], 0, 20) . '...';
						 }
						 
						$usedTableNamesArr[] = strtolower($consonantTableArr['tableName']);
						print('&nbsp;&nbsp;&nbsp;<a href="../index.php?c=consonant_table&a=display_functions&adminID=' . $consonantTableArr['adminID'] . '&consonantTableID=' . $consonantTableArr['consonantTableID'] . '">' . $consonantTableArr['tableName'] . ' üben oder transkribieren</a> (<a href="' . ROOT_URL . '/?' . $consonantTableArr['adminUsername'] . '">' . $consonantTableArr['adminName'] . '</a>) - ' . $consonantTableArr['visits'] . ' Besuche<br>');
						$numberOfTables++;
					}
				}
			}

			print('<hr><b>Die popularsten Vokaltrapeze:</b><br>');
			$usedTrapeziumNamesArr = array();

			$result = dbQuery('SELECT vowel_trapeziums.name as trapeziumName, admins.username as adminUsername, admins.name as adminName, admins.adminID as adminID, visits, vowelTrapeziumID FROM vowel_trapeziums, admins WHERE vowel_trapeziums.adminID = admins.adminID ORDER BY visits DESC, vowel_trapeziums.name');
				
			while($numberOfTrapeziums < 10) {
				
				$vowelTrapeziumArr = mysql_fetch_assoc($result);
				
				if(!$vowelTrapeziumArr) {
					break;
				}
				
				// Do not include unusable trapeziums.			
				require(CACHE_PATH . '/vowel_trapeziums/' . $vowelTrapeziumArr['vowelTrapeziumID'] . '.php');
				if(sizeof($vowelTrapeziumConfArr['vowels']) > 2) {				
				
					if(!in_array(strtolower($vowelTrapeziumArr['trapeziumName']), $usedTrapeziumNamesArr)) {
						
						if(strlen($vowelTrapeziumArr['trapeziumName']) > 17) {
							$vowelTrapeziumArr['trapeziumName'] = substr($vowelTrapeziumArr['trapeziumName'], 0, 20) . '...';
						 }
						 
						$usedTrapeziumNamesArr[] = strtolower($vowelTrapeziumArr['trapeziumName']);
						print('&nbsp;&nbsp;&nbsp;<a href="../index.php?c=vowel_trapezium&a=display_functions&adminID=' . $vowelTrapeziumArr['adminID'] . '&vowelTrapeziumID=' . $vowelTrapeziumArr['vowelTrapeziumID'] . '">' . $vowelTrapeziumArr['trapeziumName'] . ' üben oder transkribieren</a> (<a href="' . ROOT_URL . '/?' . $vowelTrapeziumArr['adminUsername'] . '">' . $vowelTrapeziumArr['adminName'] . '</a>) - ' . $vowelTrapeziumArr['visits'] . ' Besuche<br>');
						$numberOfTrapeziums++;
					}
				}
			}

			?>
						
			

<!-- google_ad_section_end -->

		</td>
	</tr>
	
	
</table>

<h2>Phonetik ist das Studium der Geräusche der menschlichen Sprache. Diese Website hat das Ziel Leuten die interessiert daran sind Phonetik zu üben und transkribieren zu helfen. Die Website benutzt die Zeichen der IPA. Die Website hat auch den <a href="index.php?pageID=ipawriter">IPA Writer</a> der ein sehr wertvolles Werkzeug ist mit dem man online transkribieren kann. Um Phonetik zu diskutieren, haben wir das <a href="<?PHP print(FORUM_URL); ?>">IPA Forum</a>.</h2>

<a href="<?PHP print(ROOT_URL); ?>/user/site/index.php?pageID=admin_register">Registrieren um Konsonanttabellen und Vokaltrapeze anzupassen</a><br>
<a href="<?PHP print(ADMIN_URL); ?>">Einloggen um Konsonanttabellen und Vokaltrapeze anzupassen</a><br><br>

<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<img src="<?PHP print(ROOT_URL); ?>/user/site/images/new.jpg" height="30" width="30">
		</td>
		
		<td>
			<a href="<?PHP print(FORUM_URL); ?>">&nbsp;&nbsp;&nbsp;<b>IPA Forum: </b>Diskutieren sie alles das mit Linguistik zu tun hat.</a> <font color="red">(Neu! Facebook login!)</font>
		</td>
	</tr>
</table>
<br>

Weil alle Zeichen der IPA nicht für alle Sprachen relevant sind, gibt es beim IPA Trainer die Möglichkeit sich zu registrieren und dann eigene IPA Tabellen und Trapeze anzupassen. Diese kann man dann entweder selber Üben, oder einen Link and Studenten geben.<br><br>

<b>Wenn Sie eine Introduktion zur Anpassung eigener Trapeze und Tabellen möchten, <a href="index.php?pageID=for_lecturers">klicken sie hier</a></b><br><br>

<b>Wenn Sie IPA Zeichen üben oder transkribieren möchten, haben Sie die folgenden Möglichkeiten:</b><br>

<ul>
	<li><b>Wenn ein Lehrer Ihnen einen Benutzernamen gegeben hat...</b><br>
	Der URL um direkt zur Seite des Lehrers zu kommen ist <?PHP print(ROOT_URL); ?>/?benutzername wo "benutzername" vom Benutzernamen des Lehrers/Professors ersätzt werden muss. Um jetzt zu dieser Seite zu kommen, geben Sie den Benutzernamen in der Textbox unten ein, und klicken Sie OK:<br><br>
	
	<form action="<?PHP print(ROOT_URL); ?>/" method="GET">
		Geben Sie hier den Benutzernamen ein: <input type="text" name="admin">
		<input type="submit" value="OK">
	</form><br>
	
	<li><b>Wenn Sie den Benutzernamen des Lehrers/Professors vergessen haben...</b><br>
	Bitte geben Sie den ganzen oder Teile vom Namen des Lehrers/Professors unten ein, und klicken sie "Suche".<br><br>

	<form action="index.php" method="GET">
	Name: <input type="text" name="name">
	<input type="hidden" name="scriptID" value="lecturer_search"> 
	<input type="submit" value="Suche">
	</form><br>


	
	<li><b>Wenn niemand den Sie kennen eine Tabelle/Trapez für Sie gemacht hat...</b><br>
	Können sie alle Trapeze/Tabellen durchsuchen. Bitte geben Sie unten das wonach sie suchen ein, und klicken sie "Suche":<br><br>

	<form action="index.php" method="GET">
	Konsonantentabelle: <input type="text" name="searchString">
	<input type="hidden" name="type" value="consonantTable"> 
	<input type="hidden" name="scriptID" value="table_trapezium_search"> 
	<input type="submit" value="Suche">
	</form>

	<form action="index.php" method="GET">
	Vokaltrapez: <input type="text" name="searchString">
	<input type="hidden" name="scriptID" value="table_trapezium_search"> 
	<input type="hidden" name="type" value="vowelTrapezium"> 
	<input type="submit" value="Suche">
	</form>
	
	Oder Sie können sich registrieren um eigene Tabellen/Trapeze zu machen. Falls Sie das möchten, <a href="index.php?pageID=admin_register">klicken Sie hier.</a><br><br> 


