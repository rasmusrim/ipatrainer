<?PHP


if(!$fromIndex) {
	lethalError('Not from index');
	exit();
}


set_time_limit(0);


// Getting all e-mail addresses
$result = dbQuery('SELECT DISTINCT email FROM admins WHERE email != ""');

while($emailArr = mysql_fetch_assoc($result)) {
	$emailsArr[] = $emailArr['email'];
}


$totalMails = sizeof($emailsArr);

require(SUPER_ADMIN_PATH . '/templates/loggedin_header.tmpl.php');
print(templateDisplay(SUPER_ADMIN_PATH . '/main/mail/templates/send.tmpl.php', array('maxMails' => $totalMails)));
require(SUPER_ADMIN_PATH . '/templates/footer.tmpl.php');

$name = "IPA Trainer"; //senders name
$email = "rasmus@ipatrainer.com"; //senders e-mail adress
$header = "From: ". $name . " <" . $email . ">\r\n"; //optional headerfields

$_POST['body'] = stripslashes($_POST['body']);

foreach($emailsArr as $email) {

	if(!mail($email, $_POST['subject'], $_POST['body'], $header)) {
		print('<script>document.report.log.value = document.report.log.value + "' . $email . ' - Feil\n"; document.report.errors.value++;</script>' . "\n");
	} else {
		print('<script>document.report.log.value = document.report.log.value + "' . $email . ' - Sendt\n"; document.report.successes.value++;</script>' . "\n");
	}		

	print('<script>document.report.sent.value++;</script>' . "\n");
	
	$numberOfMails++;
	
	$percentage = ceil(($numberOfMails / $totalMails) * 100);
	print('<script>document.report.percentage.value = "' . $percentage . ' %";</script>' . "\n");

	flush();
	
	unset($mail);

}


?>