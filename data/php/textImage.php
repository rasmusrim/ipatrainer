<?PHP
error_reporting(0);

require('../../config.php');
require_once('TextToImage.class.php');

$_im = new TextToImage();
$_im->makeImageF($_GET['string'], DATA_PATH . "/fonts/CENTURY.TTF", ($_GET['fontSize'] * strlen($_GET['string'])) / 1.2, $_GET['fontSize'] * 1.5, 0, 0, $_GET['fontSize']);
$_im->setTransparentColor(255, 255, 255);

$_im->showAsGif();
?>

