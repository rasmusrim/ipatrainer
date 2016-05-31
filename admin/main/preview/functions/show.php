<?PHP


$previewURL = ROOT_URL . '/?' . $adminArr['username'];
$returnURL = ADMIN_URL . '/main/index.php?c=preview&a=top_frame';

require('preview/templates/show.tmpl.php');

?>