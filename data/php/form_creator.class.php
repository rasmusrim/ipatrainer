<?PHP
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

class FormCreator {
	const MANDATORY_ALL_LANGUAGES = 2;
	const MANDATORY_MAIN_LANGUAGE = 3;
		
	
	function __construct($inputsArr = NULL, $tableName = NULL) {
		
		$this->inputsArr = $inputsArr;
		$this->tableName = $tableName;
	}
	
	function set_tableName($tableName) {
		$this->tableName = $tableName;
	}
	
	function get_tableName() {
		return $this->tableName;
	}
	
	function set_inputsArr($inputsArr) {
		$this->inputsArr = $inputsArr;
	
	}
	
	function get_inputsArr() {
		return $this->inputsArr;
	}
	
	function set_readableNamePlural($readableNamePlural) {
		$this->readableNamePlural = $readableNamePlural;
	}

	function set_readableNameSingular($readableNameSingular) {
		$this->readableNameSingular = $readableNameSingular;
	}

	function set_formHeader($formHeader) {
		$this->formHeader = $formHeader;
	}

	function set_formFooter($formFooter) {
		$this->formFooter = $formFooter;
	}

	function set_listHeader($listHeader) {
		$this->listHeader = $listHeader;
	}

	function set_listFooter($listFooter) {
		$this->listFooter = $listFooter;
	}

	function set_category($category) {
		$this->category = $category;
	}

	function set_nameField($nameField) {
		$this->nameField = $nameField;
	}

	function set_IDField($IDField) {
		$this->IDField = $IDField;
	}

	function set_orderBy($orderBy) {
		$this->orderBy = $orderBy;
	}

	function set_children($childrenArr) {
		$this->children = $childrenArr;
	}

	function set_adminPath($path) {
		$this->adminPath = $path;
	}

	function set_isChild($isChild) {
		$this->isChild = $isChild;
	}

	function set_doCache($doCache) {
		$this->doCache = $doCache;
	}	
	
	function dbClean($string) {
		$string = mysql_real_escape_string($string);
	
		return $string;
	}
	
	
	// **********************************************************************************************************************
	// Show form	
	// **********************************************************************************************************************

	function displayForm() {
		if($_GET[$this->IDField]) {
			$result = dbQuery('SELECT time, username FROM change_log WHERE category = "' . $this->category . '" AND entityID = "' . $_GET[$this->IDField] . '"');		
			$logArr = mysql_fetch_assoc($result);
		}		
		
		if($this->formHeader) {
			require($this->formHeader);
		}		
		
		
		
		// Is an ID passed? If yes, get old info
		if(isset($_GET[$this->IDField])) {
			$result = dbQuery('SELECT * FROM ' . $this->tableName . ' WHERE ' . $this->IDField . '="' . $this->dbClean($_GET[$this->IDField]) . '"');
			$oldEntryArr = mysql_fetch_assoc($result);
		} 		
		
		foreach($this->inputsArr as $inputID => $inputArr) {
			
			// Preparing caption for validation
			if(ucfirst(strtolower($inputArr['caption'])) == $inputArr['caption']) {
				$errorMsgCaption = strtolower($inputArr['caption']);
			} else {
				$errorMsgCaption = $inputArr['caption'];
			}
			
			switch($inputArr['inputType']) {
				case 'text':
				case 'integer':
				case 'float':
					
					// If mandatory, make caption bold					
					if($inputArr['mandatory']) {
						// Adding javascript validation					
						$javascriptValidationString .= 'if(!document.forms[0].input_' . $inputID . '.value) { ' . "\n" . 'errorMsg("' . $errorMsgCaption . '", document.forms[0].input_' . $inputID . ");\n" . 'return false;' . "\n" . ' }' . "\n";

						$inputArr['caption'] = '<b>' . $inputArr['caption'] . '</b>';

					}					
					
									
					print("\n\t<tr>\n\t\t" . '<td>' . $inputArr['caption'] . ':</td><td><input type="text" maxlength="' . $inputArr['maxLength'] . '" class="' . $inputArr['class'] . '" name="input_' . $inputID . '" value="' . htmlspecialchars($oldEntryArr[$inputArr['fieldName']]) . '">' . $inputArr['footer'] . '</td></tr>');
					
					break;
					
				case 'image':
					if($oldEntryArr[$inputArr['fieldName']]) {
						$preview = '&nbsp;&nbsp;&nbsp;&nbsp;<img src="' . $inputArr['httpPath'] . $oldEntryArr[$inputArr['fieldName']] . '">';
					} 
						
					print("\n\t<tr>\n\t\t" . '<td>' . $inputArr['caption'] . ':</td><td><input type="file" maxlength="' . $inputArr['maxLength'] . '" class="' . $inputArr['class'] . '" name="input_' . $inputID . '">' . $preview . '</td></tr>');
					
											
					
					break;
					
				case 'checkbox':
					if($oldEntryArr[$inputArr['fieldName']]) {
						$checked = ' CHECKED';
					}
					
					print("\n\t<tr>\n\t\t" . '<td>' . $inputArr['caption'] . ':</td><td><input type="checkbox" class="' . $inputArr['class'] . '" name="input_' . $inputID . '"' . $checked . '></td></tr>');
					
					unset($checked);					
					break;
					
				case 'select':
					// If mandatory, make caption bold					
					if($inputArr['mandatory']) {
						// Adding javascript validation					
						$javascriptValidationString .= 'if(!document.forms[0].input_' . $inputID . '.selectedIndex) { ' . "\n" . 'errorMsg("' . $errorMsgCaption . '", ' . $inputID . ');' . "\n" . 'return false;' . "\n" . ' }' . "\n";

						$inputArr['caption'] = '<b>' . $inputArr['caption'] . '</b>';
					}					
					
					print("\n\t<tr>\n\t\t" . '<td>');
					print($inputArr['caption'] . ':</td>');
					print('<td><select class="' . $inputArr['class'] . '" name="input_' . $inputID . '">' . "\n");
					
					// Getting info from other table
					$newFormObj = createFormObject($inputArr['source']);
					
					// Is the "name" field a multi-language field?
					$tmpID = $this->findID($newFormObj->nameField, $newFormObj);
					
					if($newFormObj->orderBy) {
						$orderBy = ' ORDER BY ' . $newFormObj->orderBy;
					}					
					
					if($newFormObj->inputsArr[$tmpID]['inputType'] != 'multi-language') {
						$query = 'SELECT ' . $newFormObj->IDField . ' as ID, ' . $newFormObj->nameField . ' as name FROM ' . $newFormObj->tableName . $orderBy;

					} else {
						$query = 'SELECT ' . $newFormObj->tableName . '.' . $newFormObj->IDField . ' as ID, ' . $newFormObj->inputsArr[$tmpID]['namesTable'] . '.' . $newFormObj->nameField . ' as name 
			          FROM ' . $newFormObj->tableName . ', ' . $newFormObj->inputsArr[$tmpID]['namesTable'] . '
			          WHERE ' . $newFormObj->tableName . '.' . $newFormObj->IDField . ' = ' . $newFormObj->inputsArr[$tmpID]['namesTable'] . '.' . $newFormObj->inputsArr[$tmpID]['namesTableEntryIDField'] . '
			          AND ' . $newFormObj->inputsArr[$tmpID]['namesTable'] . '.' . $newFormObj->inputsArr[$tmpID]['namesTableLanguageIDField'] . ' = ' . $newFormObj->inputsArr[$tmpID]['inListLanguageID'] . $orderBy;

					} 
					
									
					print('<option = "">-= Please select a ' . $newFormObj->readableNameSingular . ' =-</option>' . "\n");
					
					$result = dbQuery($query);
					
					while($tmpArr = mysql_fetch_assoc($result)) {

						// Is this option saved in the DB?				
						if($oldEntryArr[$inputArr['fieldName']] == $tmpArr['ID']) {
							$selected = ' SELECTED';
						}
						
						print("\n" . '<option value="' . $tmpArr['ID'] . '"' . $selected . '>' . $tmpArr['name'] . '</option>');
						unset($selected);
					}					
					
					print('</select></td></tr>');
					break;
					
				case 'checkboxes':
					
					// Making array of checkboxes already checked
					$checkedArr = explode('|', $oldEntryArr[$inputArr['fieldName']]);	
									
					print("\n\t<tr>\n\t\t" . '<td valign="top">');
					print($inputArr['caption'] . ':</td>');
					print('<td>' . "\n");
					print('<table border="0" cellspacing="0" cellpadding="0"><tr><td valign="top">');
					
					// Getting info from other table
					$newFormObj = createFormObject($inputArr['source']);
					
					// Is the "name" field a multi-language field?
					$tmpID = $this->findID($newFormObj->nameField, $newFormObj);
					
					if($newFormObj->orderBy) {
						$orderBy = ' ORDER BY ' . $newFormObj->orderBy;
					}					
					
					if($newFormObj->inputsArr[$tmpID]['inputType'] != 'multi-language') {
						$query = 'SELECT ' . $newFormObj->IDField . ' as ID, ' . $newFormObj->nameField . ' as name FROM ' . $newFormObj->tableName . $orderBy;

					} else {
						$query = 'SELECT ' . $newFormObj->tableName . '.' . $newFormObj->IDField . ' as ID, ' . $newFormObj->inputsArr[$tmpID]['namesTable'] . '.' . $newFormObj->nameField . ' as name 
			          FROM ' . $newFormObj->tableName . ', ' . $newFormObj->inputsArr[$tmpID]['namesTable'] . '
			          WHERE ' . $newFormObj->tableName . '.' . $newFormObj->IDField . ' = ' . $newFormObj->inputsArr[$tmpID]['namesTable'] . '.' . $newFormObj->inputsArr[$tmpID]['namesTableEntryIDField'] . '
			          AND ' . $newFormObj->inputsArr[$tmpID]['namesTable'] . '.' . $newFormObj->inputsArr[$tmpID]['namesTableLanguageIDField'] . ' = ' . $newFormObj->inputsArr[$tmpID]['inListLanguageID'] . $orderBy;

					} 
					
									
					
					$result = dbQuery($query);
					
					while($tmpArr = mysql_fetch_assoc($result)) {

						// Is this option saved in the DB?				
						if(in_array($tmpArr['ID'], $checkedArr)) {
							$checked = ' CHECKED';
						}
						
						print("\n" . '<input type="checkbox" name="input_' . $inputID . '_' . $tmpArr['ID'] . '"' . $checked . '>' . $tmpArr['name'] . '<br>' . "\n");
						$numberOfEntities++;
						unset($checked);
						
						if($numberOfEntities % $inputArr['entitiesPrColumn'] == 0) {
							print('</td><td valign="top">');
						}
					}					
					
					unset($numberOfEntities);					
					
					print('</td></tr></table></td></tr>');
					break;

				case 'multi-language':
					print('<tr><td colspan="2" valign="bottom"><br><i>' . $inputArr['caption'] . ':</i></td></tr>');					
					
					// Getting all languages
					$result = dbQuery('SELECT ' . $inputArr['languagesTable'] . '.' . $inputArr['languagesTableIDField'] . ' as languageID, ' . $inputArr['languagesTable'] . '_names.' . $inputArr['languagesTableNameField'] . ' as languageName 
					FROM ' . $inputArr['languagesTable'] . ', ' . $inputArr['languagesTable'] . '_names 
					WHERE ' . $inputArr['languagesTable'] . '_names.systemLanguageID2 = ' . $inputArr['inListLanguageID'] . ' 
					AND ' . $inputArr['languagesTable'] . '.' . $inputArr['languagesTableIDField'] . ' = ' . $inputArr['languagesTable'] . '_names.systemLanguageID					
					ORDER BY languageName');
					
					
					// Getting information on this entity in all languages if old entry
					if(isset($_GET[$this->IDField])) {
						$result2 = dbQuery('
						SELECT ' . $inputArr['namesTable'] . '.' . $inputArr['fieldName'] . ' as formCreator_name, ' . $inputArr['namesTable'] . '.' . $inputArr['namesTableLanguageIDField'] . ' as formCreator_ID  
						FROM ' . $inputArr['namesTable'] . ', ' . $this->tableName . ' 
						WHERE ' . $inputArr['namesTable'] . '.' . $inputArr['namesTableEntryIDField'] . ' = ' . $_GET[$this->IDField]);
					
						while($nameArr = mysql_fetch_assoc($result2)) {
							$namesArr[$nameArr['formCreator_ID']] = $nameArr['formCreator_name'];
						}						
					}   						
					
					while($languageArr = mysql_fetch_assoc($result)) {
						
						// Adding validation
						if(($inputArr['mandatory'] == self::MANDATORY_ALL_LANGUAGES) || ($inputArr['mandatory'] == self::MANDATORY_MAIN_LANGUAGE && $inputArr['inListLanguageID'] == $languageArr['languageID'])) {

							// Adding javascript validation					
							$javascriptValidationString .= 'if(!document.forms[0].input_' . $inputID . '_' . $languageArr['languageID'] . '.value) { ' . "\n" . 'errorMsg("' . $errorMsgCaption . ' in ' . $languageArr['languageName'] . '", document.forms[0].input_' . $inputID . '_' . $languageArr['languageID'] . ");\n" . 'return false;' . "\n" . ' }' . "\n";

							$languageArr['languageName'] = '<b>' . $languageArr['languageName'] . '</b>';

						}
						
										
						print('<tr><td>&nbsp;&nbsp;&nbsp;' . $languageArr['languageName'] . ':</td><td><input type="text" maxlength="' . $inputArr['maxlength'] . '" name="input_' . $inputID . '_' . $languageArr['languageID'] . '" value="' . htmlspecialchars($namesArr[$languageArr['languageID']]) . '"></td></tr>');
					}
					
					print('<tr><td><br></td></tr>');
					
					
					break;
					
				case 'textarea':
					print('<tr><td valign="top">' . $inputArr['caption'] . ':</td>');
					print('<td><textarea name="input_' . $inputID . '" class="' . $inputArr['class'] . '">' . $oldEntryArr[$inputArr['fieldName']] . '</textarea></td>');					
					break;							
			}
		}
		
		// If this form is a child, pass also info about parent
		if($_GET['parentCategory']) {
			print('<input type="hidden" name="parentCategory" value="' . $_GET['parentCategory'] . '">');
			print('<input type="hidden" name="parentIDField" value="' . $_GET['parentIDField'] . '">');
			print('<input type="hidden" name="parentID" value="' . $_GET['parentID'] . '">');
		}
					
		
		// Showing some hidden inputs and submit button		
		
		print('<input type="hidden" name="formCreator_' . $this->IDField . '" value="' . $_GET[$this->IDField] . '">');		
		
		// The "cancel" button should send user to different places.		
		if(!$this->isChild) {
			$query = 'c=' . $this->category . '&a=display'; 		
		} else {
			$query = 'c=' . $_GET['parentCategory'] . '&a=edit&' . $_GET['parentIDField'] . '=' . $_GET['parentID'];
		}
							
		print('<tr><td><br><input type="submit" value="OK">&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick=\'document.location="index.php?' . $query . '";\'></td></tr>');
		
		if($this->formFooter) {
			require($this->formFooter);
		}		

		// Does this form have any children? If yes, show them if edit
		if(isset($_GET[$this->IDField])) {
			if(is_array($this->children)) {
				foreach($this->children as $child) {
					$newFormObj = createFormObject($child);
					print('<hr><h3>' . ucfirst($newFormObj->readableNamePlural) . '</h3>');
					
					$newFormObj->displayList($this->category, $this->IDField, $_GET[$this->IDField]);
				}			 
			}
		}		
	
		// Printing javascript validation		
		print('<script>function checkForm() { ' . "\n" . $javascriptValidationString . "\n" . ' } </script>');										
	
	}					

	

	// **********************************************************************************************************************
	// Saving a new entry or changes
	// **********************************************************************************************************************

	function saveForm($_POST, $_FILES) {
				
		
		// If this is an edit, get old information
		if(isset($_POST['formCreator_' . $this->IDField])) {
			$result = dbQuery('SELECT * FROM ' . $this->tableName . ' WHERE ' . $this->IDField . '="' . $this->dbClean($_POST['formCreator_' . $this->IDField]) . '"');
			$oldEntryArr = mysql_fetch_assoc($result);
		} 		
		
		/* Getting languages
		$result = dbQuery('SELECT system_languages.systemLanguageID, system_languages_names.name 
		                   FROM system_languages, system_languages_names 
		                   WHERE system_languages_names.systemLanguageID2 = ' . MAIN_SYSTEM_LANGUAGE_ID . ' 
		                   AND system_languages_names.systemLanguageID = system_languages.systemLanguageID');
		
		while($systemLanguageArr = mysql_fetch_assoc($result)) {
			$systemLanguagesArr[$systemLanguageArr['systemLanguageID']] = $systemLanguageArr['name'];
		}	
		*/
		
		// Validating
		foreach($this->inputsArr as $ID => $inputArr) {
			
			// Is this mandatory, and yet not filled in? Throw error. JavaScript should have caught this.			
			if($inputArr['mandatory'] && !$_POST['input_' . $ID] && $inputArr['inputType'] != 'multi-language') {
				lethalError('Caught in validation');
			}
			
			// TODO: Validation for multi-language fields!			
			
			// Checking if any of the unique fields already exist.			
			if($inputArr['unique'] && $inputArr['inputType'] == 'multi-language') { // Multi-language fields
		
				// Looping through languages
				foreach($systemLanguagesArr as $systemLanguageID => $systemLanguageName) {
					$whereArr[] = '(' . $inputArr['namesTableLanguageIDField'] . ' = "' . $systemLanguageID . '" 
					                AND ' . $inputArr['fieldName'] . ' = "' . dbClean($_POST['input_' . $ID . '_' . $systemLanguageID]) . '")';
				}
				
				// Searching for duplicates
				if($oldEntryArr) {
					$additionalWhere = ' AND ' . $inputArr['namesTableEntryIDField'] . ' != "' . $oldEntryArr[$this->IDField] . '"';
				}				
				
				$result = dbQuery('SELECT systemLanguageID 
				                   FROM ' . $inputArr['namesTable'] . ' 
				                   WHERE (' . join(' OR ', $whereArr) . ')' . $additionalWhere);

				unset($additionalWhere);
				
				if(mysql_num_rows($result)) {				
					$duplicateArr = mysql_fetch_assoc($result);
					
					require($this->adminPath . '/templates/loggedin_header.tmpl.php');
					print('<b>Error:</b> There is already a ' . $this->readableNameSingular . ' with this ' . $systemLanguagesArr[$duplicateArr['systemLanguageID']] . ' ' . strtolower($inputArr['caption']) . '<br><br><a href="javascript:history.back()">&lt;&lt; Go back</a>');
					require($this->adminPath . '/templates/footer.tmpl.php');
					exit();
					
				}							
												
					  		

			} else if($inputArr['unique'] && $_POST['input_' . $ID]) { // Not multi-language fields
				if($oldEntryArr) {
					$additionalWhere = ' AND ' . $this->IDField . ' != "' . $oldEntryArr[$this->IDField] . '"';
				} 				
				
				$result = dbQuery('SELECT * FROM ' . $this->tableName . ' 
				                   WHERE ' . $inputArr['fieldName'] . ' = "' . $_POST['input_' . $ID] . '"' . $additionalWhere);		
				unset($additionalWhere);				
				
				if(mysql_num_rows($result)) {
					if(mysql_num_rows($result)) {
						require($this->adminPath . '/templates/loggedin_header.tmpl.php');
						print('<b>Error:</b> There is already a ' . $this->readableNameSingular . ' with this ' . $inputArr['caption'] . '<br><br><a href="javascript:history.back()">&lt;&lt; Go back</a>');
						require($this->adminPath . '/templates/footer.tmpl.php');
						exit();
					}
				}
			}
		}
	
						
						
		// Looping through $_POST preparing query and saving
		foreach($this->inputsArr as $ID => $inputArr) {
			
			// If ID is printed as another field make sure it is not added twice.			
			if($inputArr['fieldName'] == $this->IDField && $inputArr['inputType'] != 'hidden') {
				$doNotAddID = true;
			}			
			
			// Multi-languages and images must be treated in a special way			
			if($inputArr['inputType'] == 'multi-language') {
				$multiLanguageArr[] = $ID;
			
			} else if($inputArr['inputType'] == 'image') { // All images
				
				// Only if there was actually uploaded an image				
				if($_FILES['input_' . $ID]['tmp_name']) {
					$imagesArr[] = $ID;
				} else {
					// If nothing was uploaded, keep the old file					
					$fieldsToSaveArr[] = $inputArr['fieldName'] . ' = "' . $oldEntryArr[$inputArr['fieldName']] . '"';
				}
			
			} else if($inputArr['inputType'] == 'checkboxes') {

				// Making | separated string with checked IDs
				foreach($_POST as $key => $value) {
					list($tmp, $mainID, $checkboxID) = explode('_', $key);
					
					if($mainID == $ID) {
						$checkboxesStringArr[] = $this->dbClean($checkboxID);
					}
				}
				
				$fieldsToSaveArr[] = $inputArr['fieldName'] . ' = "' . join('|', $checkboxesStringArr) . '"';
				
				unset($checkboxesStringArr);
								
			
			} else if($_POST['input_' . $ID]) {
				$fieldsToSaveArr[] = $inputArr['fieldName'] . ' = "' . $this->dbClean($_POST['input_' . $ID]) . '"'; 				
			}
		}

		// If this is a child being saved, save parent ID
		if($_POST['parentCategory']) {
			$fieldsToSaveArr[] = dbClean($_POST['parentIDField']) . ' = "' . dbClean($_POST['parentID']) . '"';
		}		
		
		
		// Adding ID
		if(!$doNotAddID) {		
			$fieldsToSaveArr[] = $this->IDField . ' = "' . $_POST['formCreator_' . $this->IDField] . '"';
		}
		
		$queryString = join(', ', $fieldsToSaveArr);
		
		$query = 'REPLACE INTO ' . $this->tableName . ' SET ' . $queryString;
	
		dbQuery($query);		

		// If this is not a replace, get new ID		
		$entryID = $_POST['formCreator_' . $this->IDField];

		if(!$entryID) {
			$entryID = mysql_insert_id();
		} 		
		
		// Saving images
		foreach($imagesArr as $ID) {
			$inputArr = $this->inputsArr[$ID];

			$fileInfoArr = pathinfo($_FILES['input_' . $ID]['name']);			
			
			// Saving uploaded image
			$filename = $inputArr['savePath'] . $inputArr['savePrefix'] . '_' . $entryID . '.' . $fileInfoArr['extension'];
			
			if(move_uploaded_file($_FILES['input_' . $ID]['tmp_name'], $filename)) {
				// Saving in DB that there is an image here				
				dbQuery('UPDATE ' . $this->tableName . ' SET ' . $inputArr['fieldName'] . ' = "' . basename($filename) . '" WHERE ' . $this->IDField . ' = ' . $entryID);
			} else {
				print('Could not upload image. Debugging info:<br>');
				pa($_FILES);
				print('$filename = ' . $filename);
			}
			
		}	
				
		// Saving multi-language fields
		foreach($multiLanguageArr as $ID) {
			
			// First, delete all the old names
			dbQuery('DELETE FROM ' . $this->inputsArr[$ID]['namesTable'] . ' WHERE ' . $this->inputsArr[$ID]['namesTableEntryIDField'] . ' = ' . $entryID);
						
			foreach($_POST as $name => $value) {
				list($tmp, $inputID, $languageID) = explode('_', $name);
								
				if($inputID == $ID) {
					if($value) {					
						dbQuery('INSERT INTO ' . $this->inputsArr[$ID]['namesTable'] . ' VALUES(' . $this->dbClean($entryID) . ', ' . $this->dbClean($languageID) . ', "' . $this->dbClean($value) . '")');
					}
				}
			}
		}
		
		// Saving by whom and when this was last changed
		dbQuery('DELETE FROM change_log WHERE category = "' . $this->category . '" AND entityID = "' . $entryID . '"');		
		dbQuery('INSERT INTO change_log VALUES("' . $this->category . '", "' . $entryID . '", "' . date('Y-m-d H:i') . '", "' . $_SESSION['username'] . '")');
		
		if($this->doCache) {
			
			print($this->writeCache());
		}
				
	
	}
	
	// **********************************************************************************************************************
	// Display list of all entities	
	// **********************************************************************************************************************

	function displayList($parentCategory = NULL, $parentIDField = NULL, $parentID = NULL) {

		
		if($this->isChild && !$parentCategory) {
			lethalError('Not supposed to arrive here!');
			
		}		
		
		// Adding some extra info to "edit tool" and "add new" if this is a child entry
		if($parentCategory) {
			$additionalEditInfo = '&parentCategory=' . $parentCategory . '&parentIDField=' . $parentIDField . '&parentID=' . $parentID;			
		}
		
		if($this->listHeader) {
			require($this->listHeader);
		}		
		
		
		
		// Finding the values that are going to be visible in heading and preparing query		
		foreach($this->inputsArr as $inputID => $inputArr) {
			
			if($inputArr['inList']) {						
				
				$inListArr[] = $inputArr['caption'];				
				
				// If multi-language, we need to get info from other table as well				
				if($inputArr['inputType'] == 'multi-language') {
					$whereArr[] = $this->tableName . '.' . $this->IDField . ' = ' . $inputArr['namesTable'] . '.' . $inputArr['namesTableEntryIDField'];
					$whereArr[] = $inputArr['namesTable'] . '.' . $inputArr['namesTableLanguageIDField'] . ' = ' . $inputArr['inListLanguageID'];					 
					
					$tablesArr[] = $inputArr['namesTable'];
					
					$fieldsArr[] = $inputArr['namesTable'] . '.' . $inputArr['fieldName'];

				// Is the field a select?				
				} else if($inputArr['inputType'] == 'select') {

					$newFormObj = createFormObject($inputArr['source']);

					// Is the 'name' of this object a multilanguage?
					$ID = $this->findID($newFormObj->nameField, $newFormObj);
					
					if($newFormObj->inputsArr[$ID]['inputType'] == 'multi-language') {
						
						$whereArr[] = $newFormObj->tableName . '.' . $newFormObj->IDField . ' = ' . $newFormObj->inputsArr[$ID]['namesTable'] . '.' . $newFormObj->inputsArr[$ID]['namesTableEntryIDField'];
						$whereArr[] = $newFormObj->inputsArr[$ID]['namesTable'] . '.' . $newFormObj->inputsArr[$ID]['namesTableLanguageIDField'] . ' = ' . $newFormObj->inputsArr[$ID]['inListLanguageID'];					 
						$whereArr[] = $newFormObj->tableName . '.' . $newFormObj->IDField . ' = ' . $this->tableName . '.' . $inputArr['fieldName'];
					
						$tablesArr[] = $newFormObj->inputsArr[$ID]['namesTable'];
						$tablesArr[] = $newFormObj->tableName;
					
						$fieldsArr[] = $newFormObj->inputsArr[$ID]['namesTable'] . '.' . $newFormObj->nameField;
					} else {
												
						$whereArr[] = $newFormObj->tableName . '.' . $newFormObj->IDField . ' = ' . $this->tableName . '.' . $inputArr['fieldName'];

						$tablesArr[] = $newFormObj->tableName;
						
						$fieldsArr[] = $newFormObj->tableName . '.' . $newFormObj->nameField;
										
					}

				} else {

					$fieldsArr[] = $this->tableName . '.' . $inputArr['fieldName'];

				}
			}
		}
		
		// Finalising fields		
		$fieldsArr[] = $this->tableName . '.' . $this->IDField . ' as formCreator_ID';
		
		
		if($this->nameField) {
			$tmpID = $this->findID($this->nameField, $this);
			if($this->inputsArr[$tmpID]['inputType'] == 'multi-language') {
				$fieldsArr[] = $this->inputsArr[$tmpID]['namesTable'] . '.' . $this->nameField . ' as formCreator_name';
			} else {
				$fieldsArr[] = $this->nameField . ' as formCreator_name';
			}
		}
				
		$fields = join(', ', $fieldsArr);

		// Finalising tables
		$tablesArr[] = $this->tableName;
		
		$tables = join(', ', $tablesArr);
		
		// Finalising where clause
		if($parentCategory) {
			$whereArr[] = $parentIDField . ' = "' . $parentID . '"';
		}		
		
			$where = join(' AND ', $whereArr);
		
		if($where) {
			$where = ' WHERE ' . $where;
		}
		
		// Finalising order by
		if($this->orderBy) {
			$orderBy = ' ORDER BY ' . $this->orderBy;
		}		

		$query = 'SELECT ' . $fields . ' FROM ' . $tables . $where . $orderBy;
		
		// Writing headers
		print('<tr class="heading1">');
		
		foreach($inListArr as $header) {
			print('<td>' . $header . ':</td>');
		}

		// Need also standard header with name "Action"		
		print('<td>Action:</td>');
		
		print('<tr>');

		$result = dbQuery($query);

		// Printing list		
		while($fieldsArr = mysql_fetch_row($result)) {
			
			if($this->nameField) {
				$name = '&quot;' . array_pop($fieldsArr) . '&quot;';
			} else {
				$name = 'this entry';
			}
			
			$ID = array_pop($fieldsArr);
			
			print('<tr class="dataElementNotMouseOver" onMouseOver="this.className=\'dataElementMouseOver\';" onMouseOut="this.className=\'dataElementNotMouseOver\';">');
			
			// Outputting data
			foreach($fieldsArr as $value) {
				if($key != 'formCreator_ID' && $key != 'formCreator_name') {
					print('<td>' . $value . '</td>');
				}
			}
			
			// Printing action elements			
			print('<td>
						<a href="index.php?c=' . $this->category . '&a=edit&' . $this->IDField . '=' . $ID . $additionalEditInfo . '" class="adminlink">Edit</a>&nbsp;&nbsp;&nbsp;
						<a href="javascript: if(confirm(\'Do you really want to delete ' . $name . '?\')) { document.location=\'index.php?c=' . $this->category . '&a=delete&' . $this->IDField . '=' . $ID . $additionalEditInfo . '\'; }" class="adminlink">Delete</a>
					</td>');
			
			
			
			print('</tr>');
		
		
		}
	
	
		if($this->listFooter) {
			require($this->listFooter);
		}		

	}					

	// **********************************************************************************************************************
	// Delete an element from the database	
	// **********************************************************************************************************************

	function deleteEntry($ID) {
		
		// Finding tables dependent on this one
		foreach($this->inputsArr as $inputArr) {
			if($inputArr['inputType'] == 'multi-language') {
				dbQuery('DELETE FROM ' . $inputArr['namesTable'] . ' WHERE ' . $inputArr['namesTableEntryIDField'] . ' = ' . $ID);
			}
		}		
		
		// Did this entry have children? If yes, delete them.
		if(isset($this->children)) {
			foreach($this->children as $child) {
				$newFormObj = createFormObject($child);
				
				// Finding all entities in child belonging to this parent
				$result = dbQuery('SELECT ' . $newFormObj->IDField . ' as ID FROM ' . $newFormObj->tableName . ' WHERE ' . $this->IDField . ' = "' . dbClean($ID) . '"');
				
				while($childArr = mysql_fetch_assoc($result)) {
					$newFormObj->deleteEntry($childArr['ID']);
				}
			}
		}		
		
		// Deleting the entry itself		
		dbQuery('DELETE FROM ' . $this->tableName . ' WHERE ' . $this->IDField . ' = "' . $this->dbClean($ID) . '";');  
	
		// Deleting change log
		dbQuery('DELETE FROM change_log WHERE category = "' . $this->category . '" AND entityID = "' . $this->dbClean($ID) . '"');		

		// Writing cache		
		if($this->doCache) {
			
			print($this->writeCache());
		}

	
	}
	
	
	function findID($fieldName, $formCreatorObj) {
		foreach($formCreatorObj->inputsArr as $ID => $inputArr) {
			if($inputArr['fieldName'] == $fieldName) {
				return $ID;
			}
		}
		
		return false;
	}					

	function writeCache() {
		$result = dbQuery('SELECT * FROM ' . $this->tableName);
	
		// Getting languages
		$result = dbQuery('SELECT systemLanguageID FROM system_languages');
		
		while($languageArr = mysql_fetch_assoc($result)) {
			$languagesArr[] = $languageArr['systemLanguageID'];
		}
		
		
		// Making query
		foreach($this->inputsArr as $inputID => $inputArr) {
			
			// If multi-language, we need to get info from other table as well				
			if($inputArr['inputType'] == 'multi-language') {
				$whereArr[] = $this->tableName . '.' . $this->IDField . ' = ' . $inputArr['namesTable'] . '.' . $inputArr['namesTableEntryIDField'];
				$whereArr[] = $inputArr['namesTable'] . '.' . $inputArr['namesTableLanguageIDField'] . ' = {replaceWithLanguageID}';					 
				
				$tablesArr[] = $inputArr['namesTable'];
				
				$fieldsArr[] = $inputArr['namesTable'] . '.' . $inputArr['fieldName'];
			} else {
				$fieldsArr[] = $this->tableName . '.' . $inputArr['fieldName'];
			}

		}
				
		// Finalising		
		$fields = join(', ', $fieldsArr);
		
		$tablesArr[] = $this->tableName;
		$tables = join(', ', $tablesArr);

		$where = join(' AND ', $whereArr);
		
		if($where) {
			$where = ' WHERE ' . $where;
		}
		
		$query = 'SELECT ' . $fields . ' FROM ' . $tables . $where . $orderBy;
		
		// Looping through all languages
		foreach($languagesArr as $languageID) {
			
					
			$result = dbQuery(str_replace('{replaceWithLanguageID}', $languageID, $query));
			
			// Getting data		
			while($elementArr = mysql_fetch_assoc($result)) {
					
				$ID = $elementArr[$this->IDField];
				unset($elementArr[$this->IDField]);
		
				$cacheArr[$ID] = $elementArr;
			}
			
			$cacheStr = $this->array2code($cacheArr);
			unset($cacheArr);			
			
			$variableName = '$' . $this->tableName . 'Arr';			
			
			$cacheStr = '<?PHP' . "\n" . $variableName . ' = ' . $cacheStr . ";\n";
		
			$cacheStr .= '?>';
		
			
			$CACHE_FILE = fopen(CACHE_PATH . '/' . $this->tableName . '.' . $languageID . '.php', 'w');
			fwrite($CACHE_FILE, $cacheStr);
			fclose($CACHE_FILE);
			

		}


	}

	function array2code($arr) {
					
		
		foreach($arr as $key => $value) {
			if(is_array($value)) {
				$value = $this->array2code($value);				
			} else {
				$value = '"' . $value . '"';
			}
			
			$arrayElementsArr[] = '"' . $key . '" => ' . $value;
		}
		
		return 'array(' . join(', ', $arrayElementsArr) . ')';
	}
}
 
	
?>