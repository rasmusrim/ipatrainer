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


<h1>Feedback:</h1>

I welcome any kind of feedback be it questions, suggestions, bugs or kind words.<br><br>

If you are reporting a bug, please click &quot;Include system information&quot; to automatically
insert information about your system into the message before sending.<br><br>

<form action="index.php?scriptID=feedback_send" method="POST">

<table border="0">
	<tr>
		<td>
			Name:
		</td>
		
		<td>
			<input type="text" name="name">
		</td>
	</tr>
	
	<tr>
		<td>
			Email:
		</td>
		
		<td>
			<input type="text" name="email">
		</td>
	</tr>
	
	<tr>
		<td>
			Subject:
		</td>
		
		<td>
			<input type="text" name="subject">
		</td>
	</tr>

	<tr>
		<td valign="top">
			Body:<br>
		</td>
		
		<td>
			<textarea rows="10" cols="70" name="mailBody"></textarea>

		</td>
	</tr>

	<input type="hidden" name="systemInfo" value="

<?PHP
	print('Time: ' . date('d-m-Y H:i:s') . "\n");
	print('Browser: ' . $_SERVER['HTTP_USER_AGENT'] . "\n");
	
	
	?>">

	<tr>
		<td>
			&nbsp;
		</td>
				
		<td colspan="2">
			<input type="submit" value="Send">&nbsp;&nbsp;&nbsp;<input type="button" value="Include system information" onClick="mailBody.value = mailBody.value + systemInfo.value">
		</td>
	</tr> 


</table>
</form>