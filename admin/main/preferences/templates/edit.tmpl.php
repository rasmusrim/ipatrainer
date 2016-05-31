<h1><?PHP print($adminInfoArr['name']); ?></h1>

<form action="index.php?c=preferences&a=edit&save=true" method="POST">

<?PHP
if($errorsArr) {
	print('<b>The following errors occured:</b><br><ul>');	
	
	foreach($errorsArr as $error) {
		print('<li>' . $error . '</li>');
	}
	
	print('</ul><br>');
}
?>

<table border="0" cellspacing="5" cellpadding="0">
	<tr>
		<td>
			Name:
		</td>
				
		<td>
			<input type="text" name="name" value="<?PHP print($adminInfoArr['name']); ?>">
		</td>
	</tr>

	<tr>
		<td>
			Username:
		</td>
				
		<td>
			<input type="text" value="<?PHP print($adminInfoArr['username']); ?>" READONLY> <i>(Cannot be changed)</i>
		</td>
	</tr>


	<tr>
		<td valign="top">
			E-mail:
		</td>
				
		<td valign="top">
			<input type="text" name="email" value="<?PHP print($adminInfoArr['email']); ?>">
		</td>
	</tr>

	<tr>
		<td valign="top" colspan="2">
			<br><b>Password:</b><br>
			<i>(Enter something here only if you want to change your password. Otherwise, leave blank.)</i>
		</td>
	</tr>

	<tr>
		<td>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password:
		</td>
				
		<td>
			<input type="password" name="password">
		</td>
	</tr>

	<tr>
		<td>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Confirm password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
				
		<td>
			<input type="password" name="password2">
		</td>
	</tr>

	<tr>
		<td>
			<br><input type="submit" value="OK">&nbsp;&nbsp;&nbsp;
			<input type="button" value="Cancel" onClick="javascript:document.location='index.php';">
		</td>
	</tr>

</table>
</form>