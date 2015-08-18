function css_selector(selector) {
	hojas = document.styleSheets;
	for (var i = hojas.length - 1; i >= 0; i--) {
		selectores = hojas[i].rules;
		for (var c = selectores.length - 1; c >= 0; c--) {
			if( selectores[c].selectorText == selector ) {
				selector = selectores[c].style;
				break;
			}
		}
	}
	return selector;
}