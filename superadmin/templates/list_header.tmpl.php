<TABLE width="100%" cellspacing="0" cellpadding="4" border=0>
	<TR>
		<TD>Below you see all the <?PHP print($this->readableNamePlural); ?> that you have added. Use the tools on the right hand of each language to change and delete them. If you wish to add a new, click the button &quot;Add <?PHP print($this->readableNameSingular); ?>&quot;
		<br><br><input type="button" onClick="document.location='index.php?c=<?PHP print($this->category); ?>&a=edit<?PHP print($additionalEditInfo); ?>';" value="Add new <?PHP print($this->readableNameSingular); ?>">&nbsp;&nbsp;&nbsp;
		<input type="button" value="To main menu" onClick="document.location='index.php';">
		
		
		<br><br>
			<table width=100% border=0 cellspacing=2 cellpadding=2>
