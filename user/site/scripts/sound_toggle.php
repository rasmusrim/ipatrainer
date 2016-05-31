<?PHP

if($_COOKIE['soundOff'] == 'true') {
	setcookie('soundOff', 'false', time()+60*60*24*30*6, '/', COOKIE_DOMAIN);
} else {
	setcookie('soundOff', 'true', time()+60*60*24*30*6, '/', COOKIE_DOMAIN);
}

header('Location: ' . $_GET['returnTo']);


?>