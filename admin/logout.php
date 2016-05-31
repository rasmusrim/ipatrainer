<?PHP
// Deleting login info
session_start();
session_destroy();

header("Location: index.php");

?>