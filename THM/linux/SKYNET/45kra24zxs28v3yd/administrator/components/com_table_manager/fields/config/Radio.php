<script type="text/javascript">
	function GetInfo(){
		var jsonScript = "";
		var option_values =jQuery("#list").find("option")
		if(!option_values.length){ alert("Plase add valid items to the list"); return;}
		jsonScript = "[";
		for(var i = 0; i < option_values.length; i++){ 
			var value = jQuery(option_values[i]).attr("value");
			var label = jQuery(option_values[i]).text();
			if(i < option_values.length-1) jsonScript += '["'+value+'", "'+label+'"],';
			else  jsonScript += '["'+value+'", "'+label+'"]';
		}
		jsonScript += "]";
		var field_name = "#" + "<?php echo $_REQUEST["field"] ?>" + "_config";
		jQuery(field_name).attr("value", jsonScript);
		CloseDefaultAlert();
	}
	function DeleteItem(allItems){
		if(!allItems){
			var value = jQuery("#list").attr("value");
			if(value) $("#list").find("option[value='"+value+"']").remove();
			else alert("Please, select a item of the list");
		}else{
			$("#list").html('');
		}
	}
	function AddItem(){
		var data = jQuery("#new_data").attr("value");
		var label = jQuery("#new_label").attr("value");
		if(!data){
			if(!confirm("The data field is empty, click on accept to add")) return;
		}
		if(!label){
			if(!confirm("The label field is empty, click on accept to add")) return;
		}
		var newOption = "<option value='"+data+"'>"+label+"</option>"
		var value = jQuery("#list").append(newOption);
		jQuery("#new_data").attr("value", ""); jQuery("#new_label").attr("value", "");
	}
	function ValidateDefault(){
		var field_name = "#" + "<?php echo $_REQUEST["field"] ?>" + "_config";
		var obj = jQuery.parseJSON( jQuery(field_name).attr("value") );
		if(!obj) return;
		if(obj.constructor === Array){
			var info = "";
			for(var i = 0; i<obj.length; i++){
				 info += "<option value='"+ obj[i][0] +"'>"+obj[i][1]+"</option>";
			}
			jQuery("#list").append(info);
		}
	}
	ValidateDefault();
</script>
<p style="text-align:justify; margin-bottom:10px; border:1px dashed #CCC; color:#C30; background:#EEE; padding:5px 10px 5px 10px;">Nullam commodo augue fringilla dui faucibus dictum. Integer egestas lectus in orci accumsan vitae lacinia nisi dignissim. Nulla arcu urna, ultrices eu euismod eget, ullamcorper vitae erat.</p>
<div class="separator" id="separator_config" style="margin-bottom:15px; margin-top:15px; visibility:hidden;"></div>
<!-- Config personal data -->
	<div id="config_personal_data" class="config_personal_data" style="width:100%; ">
        <table style="width:100%">
            <tr>
                <td style="width:100px;">Add:</td>
                <td>
                    <table style="width:100%">
                        <tr>
                            <td>Data <input type='text' name='new_data' id='new_data' style="width:40px;" /></td>
                            <td> Label <input type='text' name='new_label' id='new_label' style="width:130px;" /></td>
                            <td><input class="button_form" type="button" value="Add" onclick="AddItem()" /></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
		<div class="separator" id="separator_config" style="margin-bottom:15px; margin-top:15px; visibility:visible;"></div>
        <table style="width:100%">
            <tr>
                <td style="width:100px; vertical-align:top;">List values:</td>
                <td>
                    <select name="list" id="list" size="4" style="width:91%"></select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                	<input class="button_form" type="button" value="Delete selected item" onclick="DeleteItem()" />
                	<input class="button_form" type="button" value="Delete all items" onclick="DeleteItem(true)" />
                </td>
            </tr>
        </table>
        <div class="separator" id="separator_config" style="margin-bottom:15px; margin-top:15px; visibility:visible;"></div>
        <table style="width:100%">
        	<tr>
                <td style="width:100px;"></td>
				<td><input class='button_form' type='button' value='Accept' onclick='GetInfo()' /></td>
            </tr>
        </table>
    </div>