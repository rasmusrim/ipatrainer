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


<h1>Register</h1>

<?PHP
if(sizeof($errorsArr)) {
	print('<b>The following errors occured:</b><br><ul>');

	foreach($errorsArr as $error) {
		print('<li>' . $error . '</li>');
	}

	print('</ul>');
}

print('<br>');
?>


Please fill out the form below in order to get your own username:<br><br>

<b>(Fields in bold are required)</b><br><br>


<form action="index.php" method="POST">
<input type="hidden" name="scriptID" value="admin_register">
<table border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td>
			<b>Name:</b><br>
		</td>

		<td>
			<input type="text" name="name" value="<?PHP print($_POST['name']); ?>"><br>
		</td>		
	</tr>

	<tr>
		<td>
			<b>Choose a username:</b><br>
		</td>

		<td>
			<input type="text" name="username" value="<?PHP print($_POST['username']); ?>" maxlength="20"><br>
		</td>		
	</tr>
	
	<tr>
		<td>
			<b>Password:</b><br>
		</td>

		<td>
			<input type="password" name="password"><br>
		</td>		
	</tr>

	<tr>
		<td>
			<b>Repeat password:</b><br>
		</td>

		<td>
			<input type="password" name="password2"><br>
		</td>		
	</tr>


	<tr>
		<td>
			E-mail:<br>
		</td>

		<td>
			<input type="text" name="email" value="<?PHP print($_POST['email']); ?>">&nbsp;&nbsp;&nbsp;&nbsp;<i>(Will only be used to send you information and changes about the system. Not required.)</i><br>
		</td>		
	</tr>

	<tr>
		<td colspan="2">
			<input type="submit" value="Register">
		</td>
	</tr>


</table>


</form>

