<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td valign="top">
			<table border="0">
			<!-- Consonant tables !-->	
				<tr>
					<td>
						<b>Consonant tables:</b><br>
					</td>
				</tr>
				
				<tr>
					<td>
						<a href="index.php?c=consonant_table&a=display">Consonant tables - display</a><br>
						<a href="index.php?c=consonant_table&a=edit">Consonant table - add new</a><br>
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
				</tr>				
				
				<tr>
					<td>
						<b>Vowels:</b><br>
					</td>
				</tr>
				
				<tr>
					<td>
						<a href="index.php?c=vowel_trapezium&a=display">Vowel trapeziums - display</a><br>
						<a href="index.php?c=vowel_trapezium&a=edit">Vowel trapezium - add new</a><br>
					</td>
				</tr>

				<tr>
					<td>&nbsp;</td>
				</tr>				

			<!-- Other tasks !-->	
				<tr>
					<td>
						<b>Other tasks:</b><br>
					</td>
				</tr>
				
				<tr>
					<td>
						<a href="index.php?c=preferences&a=edit">My preferences</a><br>
					</td>
				</tr>

				<tr>
					<td>
						<a href="index.php?c=preview&a=show">Look at my exercise page</a><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>

</table>			

<br><br>
...please consider <a href="<?PHP print(ROOT_URL); ?>/user/site/index.php?pageID=donate">donating</a> to IPA Trainer. Read more about why <a href="<?PHP print(ROOT_URL); ?>/user/site/index.php?pageID=donate">here</a>..<br><br>

If you know of any foundations that further the cause of phonetics and linguistics to which a site like IPA Trainer
could apply, I would be very happy if you <a href="<?PHP print(ROOT_URL); ?>/user/site/index.php?pageID=feedback">told me about it</a>.

<?PHP if($adminArr['username'] == 'demo') { ?>
<br><br>
<hr>
<div align="center" style="color: red;">
<b>WARNING:</b> You are logged into the demo account. This account is only there for people to &quot;check out&quot; the system
before registering. Making consonant tables that you intend to use in the demo account is a bad idea since anyone can
delete or alter them as they please. If you intend to use the system, you can register for your own account <a href="<?PHP print(ROOT_URL); ?>/user/site/index.php?pageID=admin_register">here</a>.

</div>
<?PHP
}
?>

