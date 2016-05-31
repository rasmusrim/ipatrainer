<?PHP
function loggedIn() {
	

	if($_SESSION['username'] == $_COOKIE['username'] && $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'] && $_SESSION['sessionID'] == $_COOKIE['sessionID']) {
	
		return unserialize($_SESSION['loggedInAdminArr']);
	}

}
?>