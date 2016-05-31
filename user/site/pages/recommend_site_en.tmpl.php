<div align="right">
	<table border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td>	

				<a href="index.php">	
				<img src="<?PHP print(GFX_URL); ?>/icon_exit.png" height="20" width="20" border="0">
				</a>
			</td>
			
			<td>				
				
				<a href="index.php">	
				Back to main site
				</a>&nbsp;&nbsp;&nbsp;
			</td>

		</tr>
	</table>
	
</div>

<?PHP
if($_GET['errors'] == 'true') {
	$errorsArr = $_SESSION['errors'];
	$_POST = $_SESSION['POST'];
}

?>

<h1>Tell someone about this site:</h1>

<?PHP
if($errorsArr) {
	print('<hr><b><font color="red">The following errors occured when trying to process form:</b></font><br><ul><li>');
	print(join('<li>', $errorsArr));
	print('</ul><hr>');
}
?>

<form action="index.php?scriptID=recommend_site_send" method="POST">

<table border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td width="150">
			<b>Email of recipient(s):</b> 
		</td>
		
		<td width="150">
			<input type="text" name="to" value="<?PHP print($_POST['to']); ?>">
		</td>
		
		<td>
			&nbsp;&nbsp;<i>(multiple addresses can be separated by commas, max. 10)</i>
		</td>
	</tr>
	
	<tr>
		<td>
			&nbsp;
		</td>
	</tr>	
	
	<tr>
		<td>
			<b>Your name:</b>
		</td>
		
		<td>
			<input type="text" name="name" value="<?PHP print($_POST['name']); ?>">
		</td>
	</tr>
	
	<tr>
		<td>
			<b>Your e-mail address:&nbsp;&nbsp;</b>
		</td>
		
		<td>
			<input type="text" name="email" value="<?PHP print($_POST['email']); ?>">	
		</td>
		
		<td>
			&nbsp;&nbsp;<i>(Will be used <b>only</b> to send this email)</i>
		</td>
	</tr>

	<tr>
		<td>
			&nbsp;
		</td>
	</tr>

	<tr>
		<td>
			<b>Subject:&nbsp;&nbsp;</b>
		</td>		
		
		<td>
			IPA Trainer
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<b>Message:</b>
		</td>

		<td colspan="3">
			Dear receiver,<br>
			I would like to tell you about a tool called IPA Trainer. It is a web application aimed at helping students to learn the characters of the IPA. Anyone can register and then customise an IPA consonant table/vowel trapezium containing only the IPA characters that are relevant to his/her students and in the order he/she teaches them. A link can then be distributed to the students, and they can go practice these characters.<br><br>
			
			The system also includes an IPA Writer which makes writing IPA characters on a computer a lot easier. Also in this tool the customised tables/trapeziums can be used.<br><br> 
			
			If one does not want to customise an individual table, there is an opportunity to practice tables which others have made.<br><br>
			
			The system can be found at http://www.ipatrainer.com<br><br>
			
			Yours sincerely,<br>
			&nbsp;&nbsp;&nbsp;&lt;Your name will be automatically added here&gt;

		
		</td>

	</tr>
	


	<tr>
		
		<td>
			<input type="submit" value="Send">
			<input type="reset" value="Reset">
		</td>
	</tr>

</table>

</form>