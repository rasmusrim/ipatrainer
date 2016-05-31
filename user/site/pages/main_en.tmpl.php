
<h1>IPA Trainer - Helping you practice and transcribe phonetics</h1>



<table border="1" align="right" style="margin: 10px;" cellpadding="5">

	<tr>
		<td valign="bottom">
			
<!-- google_ad_section_start -->

			<b>Most popular consonant tables:</b><br>
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
						print('&nbsp;&nbsp;&nbsp;<a href="../index.php?c=consonant_table&a=display_functions&adminID=' . $consonantTableArr['adminID'] . '&consonantTableID=' . $consonantTableArr['consonantTableID'] . '">Practice or transcribe ' . $consonantTableArr['tableName'] . '</a> (<a href="' . ROOT_URL . '/?' . $consonantTableArr['adminUsername'] . '">' . $consonantTableArr['adminName'] . '</a>) - ' . $consonantTableArr['visits'] . ' visits<br>');
						$numberOfTables++;
					}
				}
			}

			print('<hr><b>Most popular vowel trapeziums:</b><br>');
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
						print('&nbsp;&nbsp;&nbsp;<a href="../index.php?c=vowel_trapezium&a=display_functions&adminID=' . $vowelTrapeziumArr['adminID'] . '&vowelTrapeziumID=' . $vowelTrapeziumArr['vowelTrapeziumID'] . '">Practice or transcribe ' . $vowelTrapeziumArr['trapeziumName'] . '</a> (<a href="' . ROOT_URL . '/?' . $vowelTrapeziumArr['adminUsername'] . '">' . $vowelTrapeziumArr['adminName'] . '</a>) - ' . $vowelTrapeziumArr['visits'] . ' visits<br>');
						$numberOfTrapeziums++;
					}
				}
			}

			?>
						
			

<!-- google_ad_section_end -->

		</td>
	</tr>
	
	
	
</table>

<h2>Phonetics is the study of the sounds of human speech. This site aims at helping people interested in phonetics to practice and transcribe the characters of the IPA. The site also includes the <a href="index.php?pageID=ipawriter">IPA Writer</a>, which is an immensely valuable tool which can be used to transcribe and
For discussing phonetics or other linguistics, we provide the <a href="<?PHP print(FORUM_URL); ?>">IPA Forum</a>.</h2>


<a href="<?PHP print(ROOT_URL); ?>/user/site/index.php?pageID=admin_register">Register to customise IPA tables</a><br>
<a href="<?PHP print(ADMIN_URL); ?>">Login to customise IPA tables</a><br><br>

<a href="<?PHP print(FORUM_URL); ?>">&nbsp;&nbsp;&nbsp;<b>IPA Forum: </b>Discuss anything linguistics related.</a> <font color="red">(Now: Facebook login)</font><br><br>

Since all the symbols in the IPA are not relevant to all languages, IPA Trainer offers the opportunity for anyone to register and customise their own IPA table(s) and then practice them themselves, or direct their students to those/that table(s).<br><br>

<b>If you want an introduction to customising your own IPA table, <a href="index.php?pageID=for_lecturers">click here</a></b><br><br>

<b>If you want to practice IPA characters, you have the following opportunities:</b><br>
<ul>
	<li><b>If a teacher gave you a username...</b><br>
	The URL to directly access it is <?PHP print(ROOT_URL); ?>/?username where "username" has to be replaced with your lecturer's username. To go directly there, enter his/her username in the text box below, and click OK:<br><br>

	<form action="<?PHP print(ROOT_URL); ?>/" method="GET">
		Enter the username here to access his/her page: <input type="text" name="admin">
		<input type="submit" value="OK">
	</form><br>
	
	<li><b>If you forgot your teacher's username...</b><br>
	Please enter parts of or the entire name of him/her below, and click "Search".<br><br>

	<form action="index.php" method="GET">
	Name: <input type="text" name="name">
	<input type="hidden" name="scriptID" value="lecturer_search"> 
	<input type="submit" value="Search">
	</form><br>


	
	<li><b>If no one you know of has created an IPA table for you to practice...</b><br>
	You can search for consonant tables. To search for table, enter something you are searching for in the text box below:<br><br>

	<form action="index.php" method="GET">
	Consonant table: <input type="text" name="searchString">
	<input type="hidden" name="type" value="consonantTable"> 
	<input type="hidden" name="scriptID" value="table_trapezium_search"> 
	<input type="submit" value="Search">
	</form>

	<form action="index.php" method="GET">
	Vowel trapezium: <input type="text" name="searchString">
	<input type="hidden" name="scriptID" value="table_trapezium_search"> 
	<input type="hidden" name="type" value="vowelTrapezium"> 
	<input type="submit" value="Search">
	</form>
	
	Or you can register and customise your own IPA table. To register, click <a href="index.php?pageID=admin_register">here</a><br><br> 


