<script type="text/javascript">
	function GetInfo(){
		var jsonScript = "";
		var radioSelected = jQuery('input[name=typeSelect]:checked', '#text_form').val();
		if(radioSelected == "text"){
			jsonScript += '{"type":"text"}';
		}else if(radioSelected == "password"){
			var encode = jQuery('#encode').val();
			jsonScript += '{"type":"password", "encode":"'+encode+'"}';
		}else if(radioSelected == "email"){
			jsonScript += '{"type":"email"}';
		}else if(radioSelected == "number"){
			jsonScript += '{"type":"number"}';
		}
		var field_name = "#" + "<?php echo $_REQUEST["field"] ?>" + "_config";
		jQuery(field_name).attr("value", jsonScript);
		CloseDefaultAlert();
	}
	function LoadDefaultInfo(){
		var field_name = "#" + "<?php echo $_REQUEST["field"] ?>" + "_config";
		var defaultInfo = jQuery.parseJSON( jQuery(field_name).attr("value") );
		if(!defaultInfo) return;
		if(defaultInfo.type == "text"){
			jQuery("#text").attr("checked", "checked");
		}else if(defaultInfo.type == "password"){
			jQuery("#password").attr("checked", "checked");
			$("#encode option[value="+defaultInfo.encode+"]").attr("selected",true);
		}else if(defaultInfo.type == "email"){
			jQuery("#email").attr("checked", "checked");
		}else if(defaultInfo.type == "number"){
			jQuery("#number").attr("checked", "checked");
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
        <table>
            <tr>
                <td><input type="radio" name="typeSelect" id="text" value="text" checked="checked" /></td>
                <td><label for="text">Text</label></td>
                <td></td>
            </tr>
            <tr>
                <td><input type="radio" name="typeSelect" id="password" value="password" /></td>
                <td><label for="password">Password :: encode: </label></td>
                <td>
                    <select id="encode" name="encode">
                        <option value="none">none</option>
                        <option value="md5">md5</option>
                        <option value="sha1">sha1</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><input type="radio" name="typeSelect" id="email" value="email" /></td>
                <td><label for="email">Email</label></td>
                <td></td>
            </tr>
            <tr>
                <td><input type="radio" name="typeSelect" id="number" value="number"/></td>
                <td><label for="number">Number</label></td>
                <td></td>
            </tr>
        </table>
        <div class="separator" id="separator_config" style="margin-bottom:15px; margin-top:15px;"></div>
        <input class='button_form' type='button' value='Accept' onclick="GetInfo()"/>
    </form>
</div>