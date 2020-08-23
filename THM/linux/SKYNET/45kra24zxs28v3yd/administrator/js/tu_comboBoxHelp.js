/* Select a Item with a validate Date */
	function getComboBoxIndexData(combo, value) {
		for (i = 0; i < combo.length; i++) {
			if (combo[i].value == value) { combo[i].selected = true; break; }
		}
	}