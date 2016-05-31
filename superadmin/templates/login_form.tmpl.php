			<form action="login.php" method="POST" name="loginForm">
			<table border="0">
				<tr>
					<td colspan="2">
						<?PHP
						// If error from login.php, display it
						print($error);
						?>
					</td>
				</tr>

				<tr>
					<td>
						<table border="0">
							<tr>
								<td>
									Username:&nbsp;&nbsp;
								</td>
								
								<td>
									<input type="text" name="username" value="<?PHP print($_POST['username']);?>" class="input150">
								</td>
							</tr>
			
							<tr>
								<td>
									Password:&nbsp;&nbsp;
								</td>
								
								<td>
									<input type="password" name="password" class="input150">
								</td>
							</tr>
			
							<tr>
								<td>
									&nbsp;
								</td>
								
								<td align="right">
									<input type="submit" value="Login">
								</td>
							</tr>
						</table>
					</td>
				</tr>			
				<tr>
					<td valign="bottom" align="center">
						<br>You need JavaScript and cookies to access this system.
					</td>
				</tr>	
			</table>
			</form>