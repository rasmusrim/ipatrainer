<table width="100%" border="0">
	<tr>
		<td width="100%">
			<div class="title">
				<?PHP print(ucfirst($this->readableNameSingular)); ?>
			</div>
			
			<?PHP if($logArr) { ?>			
			<i>Last changed on <?PHP print(dateAm2Eur($logArr['time'])); ?> by <?PHP print($logArr['username']); ?></i><br>
			<?PHP } ?>

			<br>Change values as you please. When you are done, click &quot;Save&quot;. If you want to cancel the changes you have done, click &quot;Cancel&quot;<br><br>

			<form enctype="multipart/form-data" onSubmit="return checkForm()" action="index.php?c=<?PHP print($this->category); ?>&a=edit&save=yes" method="POST">

			<table border="0" width="100%">
