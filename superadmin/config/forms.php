<?PHP
function createFormObject($category) {
	$form = new FormCreator();

	$form->set_formHeader(SUPER_ADMIN_PATH . '/templates/form_header.tmpl.php');
	$form->set_formFooter(SUPER_ADMIN_PATH . '/templates/form_footer.tmpl.php');

	$form->set_listHeader(SUPER_ADMIN_PATH . '/templates/list_header.tmpl.php');
	$form->set_listFooter(SUPER_ADMIN_PATH . '/templates/list_footer.tmpl.php');

	$form->set_adminPath(SUPER_ADMIN_PATH);

	$form->set_category($category);
	
	// ***********************************************************************************************************
	// Languages
	// ***********************************************************************************************************
	if($category == 'admin') {	
		$form->set_tableName('admins');
		$form->set_readableNameSingular('admin');
		$form->set_readableNamePlural('admins');
		
		$form->set_orderBy('username');
		
		// Setting which field is the main ID, and which one is the one which is usually referred to text-wise
		$form->set_IDField('adminID');
		$form->set_nameField('username');
		

		$inputsArr[] = array('fieldName' => 'adminID',
									'inputType' => 'hidden',
									);				
				
		$inputsArr[] = array('caption' => 'Username',
									'fieldName' => 'username',							      
							      'maxLength' => '8',
									'inputType' => 'text',
									'class' => 'input100',
									'inList' => true,									
									'mandatory' => true,
									'unique' => true
									);
									
		$inputsArr[] = array('caption' => 'Password',
									'fieldName' => 'password',							      
							      'maxLength' => '50',
									'inputType' => 'text',
									'class' => 'input100',
									'inList' => false,									
									'mandatory' => true,
									);

							
		$inputsArr[] = array('caption' => 'Name',
									'fieldName' => 'name',							      
							      'maxLength' => '50',
									'inputType' => 'text',
									'class' => 'input100',
									'inList' => true,									
									'mandatory' => true,
									'unique' => false
									);

		$inputsArr[] = array('caption' => 'E-mail',
									'fieldName' => 'email',							      
							      'maxLength' => '50',
									'inputType' => 'text',
									'class' => 'input100',
									'inList' => false,									
									'mandatory' => false,
									'unique' => false
									);
	}


$form->set_inputsArr($inputsArr);
	return $form;	
}


?>