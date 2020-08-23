<script type="text/javascript">
	function GetInfo(){
		var jsonScript = "";
		var editorSelected = jQuery('#editor').val();
		var width = jQuery('#width').val();
		var height = jQuery('#height').val();
		jsonScript += '{"editor":"'+editorSelected+'","width":"'+width+'", "height":"'+height+'"}';
		var field_name = "#" + "<?php echo $_REQUEST["field"] ?>" + "_config";
		jQuery(field_name).attr("value", jsonScript);
		CloseDefaultAlert();
	}
	function LoadDefaultInfo(){
		var field_name = "#" + "<?php echo $_REQUEST["field"] ?>" + "_config";
		var defaultInfo = jQuery.parseJSON( jQuery(field_name).attr("value") );
		if(!defaultInfo) return;
		$("#editor option[value="+defaultInfo.editor+"]").attr("selected",true);
		if(defaultInfo.width)$("#width").val(defaultInfo.width);
		if(defaultInfo.height)$("#height").val(defaultInfo.height);
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
        <table>
            <tr>
                <td><label for="editor">Editor: </label></td>
                <td>
                    <select id="editor" name="editor">
                        <option value="none">none</option>
                        <option value="tinymce">tinymce</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="editor">Default dimentions: </label></td>
                <td>
                    <input style="width:70px" type="text" id="width" name="width" value="821" /> X <input style="width:70px" type="text" id="height" name="height" value="217" />
                </td>
            </tr>
        </table>
        <div class="separator" id="separator_config" style="margin-bottom:15px; margin-top:15px;"></div>
        <input class='button_form' type='button' value='Accept' onclick="GetInfo()"/>
    </form>
</div>