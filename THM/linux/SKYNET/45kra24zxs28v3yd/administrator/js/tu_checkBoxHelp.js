/* Select all items */
	var checkBoxSelected = null;
	function SelectAll(value, items) {
		checkBoxSelected = null;
		if(!items) items = "#id";
		var elements = jQuery("body").find(items);
		checkBoxSelected = elements;
		for(var i = 0; i < elements.length; i++){
			jQuery(elements[i]).attr("checked", value);
		}
	}
	function GetSelectedItems(items){
		selectedItems = Array();
		if(!items) items = "#id";
		var elements = jQuery("body").find(items);
		for(var i = 0; i < elements.length; i++){
			if(elements[i].checked){
				selectedItems.push(elements[i]);
			};
		}
		if(selectedItems.length == 0) return 0;
		return selectedItems;
	}