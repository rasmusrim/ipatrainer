<!DOCTYPE HTML PUBLIC "-//WC3//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html><head>
<title>IPA - Admin</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >

<link rel="stylesheet" href="<?PHP print(STYLES_URL); ?>/style.css" type="text/css">

<!-- MM_MENUS -->

<div align="center">
<br><br>
<table cellspacing="0" cellpadding="0" border="0" width="800" border="0">
	<tr>
		<td align="right">
			<?PHP print('Logged in as ' . $adminArr['name']); ?>: <a href="<?PHP print(ADMIN_URL); ?>/logout.php"><?PHP print(showLabel('log off', 1) . '</a> | <a href="index.php">' . showLabel('main menu', 1) . '</a>'); ?>		
		</td>
	</tr>
</table>

<table cellspacing="0" cellpadding="0" border="0" width="800" class="border">

	<tr>
		<td>
			<img src="<?PHP print(GFX_URL); ?>/header.png">
		</td>
	</tr>

	<tr class="maintext">
		<td width="100%" class="margin" align="left">
			<!-- Maintext -->
