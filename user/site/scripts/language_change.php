<?PHP
setcookie('language', $_GET['language'], time() + 60 * 60 * 24 * 30 * 12, '/', COOKIE_DOMAIN);
$_SESSION['language'] = $_GET['language'];

// We need to delete any language= GET directives in the returnTo value.
$_GET['returnTo'] = str_replace('language=', '', $_GET['returnTo']);

header('Location: ' . $_GET['returnTo']);


?>