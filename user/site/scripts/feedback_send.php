<?PHP


if(mail('rasmusrim@gmail.com', stripslashes($_POST['subject']), stripslashes($_POST['mailBody']), 'From: ' .  $_POST['name'] . '<' . $_POST['email'] . '>')) {
	header('Location: index.php?pageID=feedback_sent');
} else {
	header('Location: index.php?pageID=feedback_error');
}





?>