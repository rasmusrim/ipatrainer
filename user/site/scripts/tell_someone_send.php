<?PHP

// Validation
if(!$_POST['to']) {
	$errorsArr[] = 'You have not entered any e-mail addresses to send to.';
}

if(!$_POST['name']) {
	$errorsArr[] = 'You have not entered your own name.';
}

if(!$_POST['email']) {
	$errorsArr[] = 'You have not entered your own email address.';
}

// Any errors? If so, save entered values and redirect back to form.
if($errorsArr) {
	$_SESSION['errors'] = $errorsArr;
	$_SESSION['POST'] = $_POST;
	header('Location: index.php?pageID=tell_someone_about_site&errors=true');
	exit();
} else {
	unset($_SESSION['errors']);
	unset($_SESSION['POST']);
}

$subject = 'IPA Trainer';
$body = '
Dear receiver,
I would like to tell you about a tool called IPA Trainer. It is a web application aimed at helping students to learn the characters of the IPA. Anyone can register and then customise an IPA consonant table containing only the IPA characters that are relevant to his/her students and in the order he/she teaches them. A link can then be distributed to the students, and they can go practice these characters. 
			
If one does not want to customise an individual table, there is an opportunity to practice tables which others have made.
			
The system can be found at http://www.ipatrainer.com
			
Yours sincerely,
   ' . $_POST['name'];
   
// Everything OK. Sending...
$toArr = explode(',', $_POST['to']);

foreach($toArr as $to) {
	if(!mail(ltrim(rtrim($to)), $subject, $body, 'From: ' .  $_POST['name'] . '<' . $_POST['email'] . '>')) {
		$notSentArr[] = $to;
	}
}

header('Location: index.php?pageID=tell_someone_about_site_sent');

?>