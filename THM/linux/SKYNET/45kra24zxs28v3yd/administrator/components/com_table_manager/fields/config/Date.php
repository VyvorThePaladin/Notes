<script type="text/javascript">
	function GetInfo(){
		var jsonScript = "";
		var radioSelected = jQuery('input[name=typeSelect]:checked', '#text_form').val();
		if(radioSelected == "normal"){
			jsonScript += '{"type":"normal"}';
		}else if(radioSelected == "datePicker"){
			var config = jQuery('#config').val();
			jsonScript += '{"type":"datePicker", "config":"'+config+'"}';
		}
		var field_name = "#" + "<?php echo $_REQUEST["field"] ?>" + "_config";
		jQuery(field_name).attr("value", jsonScript);
		CloseDefaultAlert();
	}
	function LoadDefaultInfo(){
		jQuery("#datePicker").attr("checked", "checked");
		var field_name = "#" + "<?php echo $_REQUEST["field"] ?>" + "_config";
		var defaultInfo = jQuery.parseJSON( jQuery(field_name).attr("value") );
		if(!defaultInfo) return;
		if(defaultInfo.type == "datePicker"){
			jQuery("#datePicker").attr("checked", "checked");
			$("#config option[value="+defaultInfo.config+"]").attr("selected",true);
		}
	}
	LoadDefaultInfo();
</script>
<style>
	.text td{
		padding:3px;
		vertical-align:central;
		text-align:left;
	}
</style>
<p style="text-align:justify; margin-bottom:10px; border:1px dashed #CCC; color:#C30; background:#EEE; padding:5px 10px 5px 10px;">Nullam commodo augue fringilla dui faucibus dictum. Integer egestas lectus in orci accumsan vitae lacinia nisi dignissim. Nulla arcu urna, ultrices eu euismod eget, ullamcorper vitae erat.</p>
<div class="text">
    <form id="text_form" name="text_form">
        <table style="width:100%">
            <tr>
                <td><input type="radio" name="typeSelect" id="datePicker" value="datePicker" /></td>
                <td><label for="datePicker">Date picker :: Type: </label></td>
                <td>
                    <select id="config" name="config">
                        <option value="simple">simple</option>
                        <option value="auto_today_selected">auto today selected</option>
                    </select>
                </td>
            </tr>
        </table>
        <div class="separator" id="separator_config" style="margin-bottom:15px; margin-top:15px;"></div>
        <input class='button_form' type='button' value='Accept' onclick="GetInfo()"/>
    </form>
</div>