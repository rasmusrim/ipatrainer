			</table>
		</td>
	</tr>
	
	<tr>
		<td>
			<input type="button" onClick="document.location='index.php?c=<?PHP print($this->category); ?>&a=edit<?PHP print($additionalEditInfo); ?>';" value="Add new <?PHP print($this->readableNameSingular); ?>">&nbsp;&nbsp;&nbsp;
			<input type="button" value="To main menu" onClick="document.location='index.php';">		</td>
	</tr>
</table>