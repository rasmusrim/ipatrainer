var withDiacritic;

function addCharacter(unicode) {

	
	eval('unicode = "\\u' + unicode + '";');	
	
	if(withDiacritic) {	
	
		//insertAtCursor(resultForm.IPAString, unicode);
		el('IPAString').value = el('IPAString').value + unicode + withDiacritic;
	} else {
		el('IPAString').value = el('IPAString').value + unicode;
	}		
	
	// Remove diacritic	
	addDiacritic("");
}

function addDiacritic(unicode) {
	
	
	if(unicode) {
		eval('unicode = "\\u' + unicode + '";');
	}	 	

	

	
	var divs = document.getElementsByTagName('div') 
	
	for (var i = 0;i < divs.length;i++) { 
		
		
		if(divs[i].id.substr(0, 10) == 'consonant_' || divs[i].id.substr(0, 6) == 'vowel_') {
			
			if(withDiacritic) {
	
				// Delete old diacritic
				divs[i].innerHTML = divs[i].innerHTML.substr(0, (divs[i].innerHTML.length - 1));
			}
			
			divs[i].innerHTML = divs[i].innerHTML + unicode;
		}
		
	}
	
	withDiacritic = unicode;
	
	
}

