<script type="text/javascript">
	function SelectType(){
		var type = 1;
		if(jQuery("#personal").attr("checked")){ type = 2; }
		ShowConfigPanel(type)
	}
		function ShowConfigPanel(type){
			jQuery("#separator_config").css('visibility', "visible");
			if(type == 1){
				jQuery("#config_table").css("display", "table");
				jQuery("#config_personal_data").css("display", "none");
				jQuery("#table").attr("checked", "checked")
			}else{
				jQuery("#config_personal_data").css("display", "table");
				jQuery("#config_table").css("display", "none");
				jQuery("#personal").attr("checked", "checked")
			}
		}
	function GetInfo(value){
		var jsonScript = "";
		if(value == "config_table"){
			var table_name = jQuery("#select_table_name").attr("value");
			var data_column = jQuery("#select_data_coumn").attr("value");
			var label_column = jQuery("#select_label_coumn").attr("value");
			if(!table_name){
				alert("Please, specify table name"); return;
			}else if(!data_column){
				alert("Please, specify data column"); return;
			}else if(!label_column){
				alert("Please, specify label column"); return;
			}
			jsonScript = '{"table_name":"'+table_name + '", "data_column":"' + data_column + '", "label_column":"' + label_column + '"}';
		}else{
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
		}
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
			ShowConfigPanel(2);
			var info = "";
			for(var i = 0; i<obj.length; i++){
				 info += "<option value='"+ obj[i][0] +"'>"+obj[i][1]+"</option>";
			}
			jQuery("#list").append(info);
		}else{
			ShowConfigPanel(1);
			jQuery("#select_table_name").attr("value", obj.table_name);
			jQuery("#select_data_coumn").attr("value", obj.data_column);
			jQuery("#select_label_coumn").attr("value", obj.label_column);
		}
	}
	ValidateDefault();
</script>
<p style="text-align:justify; margin-bottom:10px; border:1px dashed #CCC; color:#C30; background:#EEE; padding:5px 10px 5px 10px;">Nullam commodo augue fringilla dui faucibus dictum. Integer egestas lectus in orci accumsan vitae lacinia nisi dignissim. Nulla arcu urna, ultrices eu euismod eget, ullamcorper vitae erat.</p>
<div style="text-align:center;">
    <input type="radio" name="typeSelect" id="table" value="typeSelect" onchange="SelectType()" />
    <label for="table" style="margin-right:50px;">Table</label>
    <input type="radio" name="typeSelect" id="personal" value="typeSelect" onchange="SelectType()" />
    <label for="personal">Personal info</label>
</div>
<div class="separator" id="separator_config" style="margin-bottom:15px; margin-top:15px; visibility:hidden;"></div>
<!-- Config table -->
	<div id="config_table" class="config_table" style="width:100%; display:none;">
        <table style="width:100%">
            <tr>
                <td style="width:100px;">Table name:</td>
                <td><input type='text' name='select_table_name' id='select_table_name' style="width:90%"/></td>
            </tr>
            <tr>
                <td>Data column:</td>
                <td><input type='text' name='select_data_coumn' id='select_data_coumn' style="width:90%" /></td>
            </tr>
            <tr>
                <td>Label column:</td>
                <td><input type='text' name='select_label_coumn' id='select_label_coumn' style="width:90%"/></td>
            </tr>
            <tr>
                <td></td>
                <td><input class='button_form' type='button' value='Accept' onclick='GetInfo("config_table")' /></td>
            </tr>
        </table>
    </div>
<!-- Config personal data -->
	<div id="config_personal_data" class="config_personal_data" style="width:100%; display:none;">
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
				<td><input class='button_form' type='button' value='Accept' onclick='GetInfo("config_personal_data")' /></td>
            </tr>
        </table>
    </div>