<?PHP
setcookie('keyboardshortcut_' . $_GET['shortcut'], $_GET['type'] . '|' . $_GET['unicode'], time() + (60 * 60 * 24 * 356 * 10));
?>

<script>
		
	opener.location = '<?PHP print(IPA_WRITER_URL); ?>/index.php?tab=tab4#table';
	window.close();
</script>