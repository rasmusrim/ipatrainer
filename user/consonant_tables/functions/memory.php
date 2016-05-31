
<style>
.cell {
	border-style: solid;
	border-color: black;
	
}
</style>



<?PHP
require('templates/header.tmpl.php');

// Getting information about table
require(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php');
require(CACHE_PATH . '/consonants.php');

// Checking if table has been changed since last time. If it has, reset stuff
if($_GET['consonantTableID'] != $_SESSION['consonantTableID']) {
	unset($_SESSION['usedChars']);
	unset($_SESSION['correct']);
	unset($_SESSION['incorrect']);
	$_SESSION['consonantTableID'] = $_GET['consonantTableID'];
} 

// Check if table is big enough
if(sizeof($consonantTableConfArr['consonants']) < 2) {
	print('<h1>Table too small</h1>This table has less than 2 IPA characters, and is therefore unavailable.<br><br><a href="index.php?adminID=' . $adminArr['adminID'] . '">Back</a>');
	require('templates/footer.tmpl.php');

	exit();
}

// Making list of images
foreach($consonantTableConfArr['consonants'] as $consonantID) {
	$imagesArr[] = GFX_URL . '/consonants/'  . $consonantsByIDArr[$consonantID]['col'] . '.' . $consonantsByIDArr[$consonantID]['row'] . '.' . $consonantsByIDArr[$consonantID]['voiced'] . '.gif';
} 

// If more than 15 images, select some random ones
if(sizeof($imagesArr) > 15) {
	shuffle($imagesArr);
	$imagesArr = array_chunk($imagesArr, 15);
	$imagesArr = $imagesArr[0];
	
			
	
}
if($_COOKIE['soundOff'] != 'true') { // Sound is on

	foreach($imagesArr as $image) {
		$tmpArr = explode('.', basename($image));
		array_pop($tmpArr);	
		
		$soundmanagerString .= 'soundManager.createSound("player' . join('_', $tmpArr) . '", "' . SND_URL . '/consonants/' . join('.', $tmpArr) . '.mp3");' . "\n";
		
	}
	
		
} else { // Sound if off
	$muteMessage = 'This game has sound, but since you have muted all sounds you cannot hear it. If you demute (by clicking <br>"Turn sound on" in the upper right corner of your browser), your learning experience from this game will be even greater.<br><br>';
}	


$numberOfCards = (sizeof($imagesArr) * 2);

$x = 6;
$y = ceil($numberOfCards / $x);


?><center>
<form action="index.php" method="GET">
	<input type="hidden" name="adminID" value="<?PHP print($adminArr['adminID']); ?>">
	<input type="hidden" name="consonantTableID" value="<?PHP print($_GET['consonantTableID']); ?>">
	<input type="hidden" name="c" value="consonant_table">
	<input type="hidden" name="a" value="display_functions">
	<input type="submit" value="Cancel game">
</form>

<a href="http://pic-a-card.com" target="_BLANK">Make a memory game with your own photos!</a>
</center>

<script type="text/javascript">

function loadSounds() {
  // Loading SM2 sounds
	<?PHP print($soundmanagerString); ?>
  
}

var imagesArr = new Array();

<?PHP
$i = '0';
foreach($imagesArr as $image) {
	print('imagesArr[' . $i . '] = new Image();' . "\n");
	print('imagesArr[' . $i++ . '].src = \'' . $image . '\';' . "\n");
}

?>

imagesArr = imagesArr.concat(imagesArr);

openImage = new Array();
openImageID = new Array();
var z = 0, click = 0, numberOfTries = 0; numberOfSuccesses = 0, seconds = 0;
var timerStarted = false;

secondsToWaitBeforeClosing = 1.5;
sizeOfBoardX = <?PHP print($x); ?>;
sizeOfBoardY = <?PHP print($y); ?>;
numberOfTiles = sizeOfBoardX * sizeOfBoardY;
numberOfImagesNeeded = numberOfTiles / 2;



shuffle(imagesArr);

// Making tiles
document.write('<a name="topOfGame"></a><center><table border="0">');
for(y = 0; y < sizeOfBoardY; y++) {
	document.write('<tr>');
	for(x = 0; x < sizeOfBoardX; x++) {
		
		if(imagesArr[z]) {		
			document.write('<td width="100" height="100" class="cell" align="center"><img src="<?PHP print(GFX_URL); ?>/memory_background.png" height="100" width="100" name="image' + z + '" onClick="javascript:clickImage(' + z + ');"></td>');
		} else {
			document.write('<td width="100" height="100" class="cell" align="center"></td>');
		}
		
		z++;
	}
	document.write('</tr>');

}

document.write('</table>');

document.write('<form name="form1">Pairs found: <input type="text" name="success" value="0">&nbsp;&nbsp;&nbsp;');
document.write('Tries: <input type="text" name="attempts" value="0">&nbsp;&nbsp;&nbsp;Seconds spent: <input type="text" name="time" value="0"></form>');
document.write('<?PHP print($muteMessage); ?>');
document.form1.success.value = 0;
document.form1.attempts.value = 0;

function clickImage(z) {
	// Since there are two images in the header (banner and mute symbol), we need an extra variable	
	var imageNumber = z + 2;	
		
	var player = 'player' + str_replace('.', '_', basename(imagesArr[z].src, '.gif'));
	
	soundManager.play(player);			
		
	if(click == 2 || document.images[imageNumber].src != "<?PHP print(GFX_URL); ?>/memory_background.png") {
				
		return;
	}
		
	document.images[imageNumber].src = imagesArr[z].src;
	document.images[imageNumber].height = '30';
	document.images[imageNumber].width = '14';
	click++;
	
	openImage[click] = imagesArr[z];
	openImageID[click] = imageNumber;

	if(timerStarted == false) {
		setTimeout("addTimer()", 1000);
		timerStarted = true;
	}
	
	
	if(click == 2) {
		numberOfTries++;
		
		if(openImage[1] == openImage[2]) {
			// You've won!
			click = 0;
			numberOfSuccesses++;
			
			
			if(numberOfSuccesses == <?PHP print($numberOfCards / 2); ?>) {
				if(confirm('You did it! Play again?')) {
					document.location.reload(true);
				} else {
					document.location = 'index.php?adminID=<?PHP print($adminArr['adminID']); ?>&c=consonant_table&a=display_functions&consonantTableID=<?PHP print($_GET['consonantTableID']); ?>';
				}
						
			}
			
			document.form1.success.value = numberOfSuccesses;
			document.form1.attempts.value = numberOfTries;

		} else {
			setTimeout("resetImages()", secondsToWaitBeforeClosing * 1000);
		}
	}
}

function resetImages() {
	document.images[openImageID[1]].src = "<?PHP print(GFX_URL); ?>/memory_background.png";
	document.images[openImageID[2]].src = "<?PHP print(GFX_URL); ?>/memory_background.png";
	
	document.images[openImageID[1]].height = '100';
	document.images[openImageID[1]].width = '100';

	document.images[openImageID[2]].height = '100';
	document.images[openImageID[2]].width = '100';

	click = 0;

	document.form1.attempts.value = numberOfTries;

}

	
function addTimer() {
	if(numberOfSuccesses != numberOfImagesNeeded) {
		setTimeout("addTimer()", 1000);
		seconds++;
		document.form1.time.value = seconds;
	}
}
		

function shuffle ( myArray ) {
  var i = myArray.length;
  if ( i == 0 ) return false;
  while ( --i ) {
     var j = Math.floor( Math.random() * ( i + 1 ) );
     var tempi = myArray[i];
     var tempj = myArray[j];
     myArray[i] = tempj;
     myArray[j] = tempi;
   }
}

function basename(path, suffix) {
 
    var b = path.replace(/^.*[\/\\]/g, '');
    
    if (typeof(suffix) == 'string' && b.substr(b.length-suffix.length) == suffix) {
        b = b.substr(0, b.length-suffix.length);
    }
    
    return b;
} 
 
function str_replace(search, replace, subject) {
 
    var f = search, r = replace, s = subject;
    var ra = r instanceof Array, sa = s instanceof Array, f = [].concat(f), r = [].concat(r), i = (s = [].concat(s)).length;
 
    while (j = 0, i--) {
        if (s[i]) {
            while (s[i] = s[i].split(f[j]).join(ra ? r[j] || "" : r[0]), ++j in f){};
        }
    };
 
    return sa ? s : s[0];
} 

</script>

