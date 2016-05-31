// Global variables
var selectedTabID;
var defaultTab = 1;

// Setting up keyboard shortcuts
var SHORTCUTS = {
'1': function() { changeTab('1'); },
'2': function() { changeTab('2'); },
'3': function() { changeTab('3'); },
'4': function() { changeTab('4'); },
'q': function() { addDiacritic(""); },
'v': function() { document.resultForm.IPAString.value = document.resultForm.IPAString.value + " "; },
}



function changeTab(tabID) {
	
	el('tab' + tabID).className = 'tab_selected';
	el('contentTab' + tabID).style.display = 'block';
	
	if(selectedTabID) {
		el('tab' + selectedTabID).className = 'tab_notselected';
		//el('contentTab' + selectedTabID).style.display = 'none';
	}
	
	selectedTabID = tabID;
}

function start() {
	// Setting default tab
	changeTab(defaultTab);
}
