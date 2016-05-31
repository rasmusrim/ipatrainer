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
'v': function() { addCharacter("0020"); },
}



function changeTab(tabID) {
	
	
	
	el('tab' + tabID).className = 'tab_selected';
	el('contentTab' + tabID).style.display = 'block';
	
	if(selectedTabID) {
		el('tab' + selectedTabID).className = 'tab_notselected';
		el('contentTab' + selectedTabID).style.display = 'none';
	}
	
	selectedTabID = tabID;
}

function start() {
	// Setting default tab
	changeTab(defaultTab);
}

function defineKeyboardShortcut(unicode, type) {
	window.open('index.php?a=keyboard_shortcut_form&unicode=' + unicode, '', 'width=400, height=220, location=0, menubar=0, status=0');
}
