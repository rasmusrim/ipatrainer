<?PHP
function setLanguage() {
	if($_COOKIE['language']) {
		$_SESSION['language'] = $_COOKIE['language'];
	}

	if($_GET['language']) {
		$_SESSION['language'] = $_GET['language'];
	}

	

	if(!$_SESSION['language']) {
		$_SESSION['language'] = 'en';
	}
}
	
