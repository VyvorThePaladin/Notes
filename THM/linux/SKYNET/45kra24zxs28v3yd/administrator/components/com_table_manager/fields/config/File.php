<?php 
	include("../Configuration.php");
	$configuration = new Configuration();
?>
<script type="text/javascript">
	function GetInfo(){
		var jsonScript = "";
		var folder = jQuery('#folder').val();
		if(!folder){ alert("Please, write a folder path");  return;	}
		jsonScript += '{"folder":"' + folder + '"}';
		var field_name = "#" + "<?php echo $_REQUEST["field"] ?>" + "_config";
		jQuery(field_name).attr("value", jsonScript);
		CloseDefaultAlert();
	}
	function LoadDefaultInfo(){
		var defaultFolder = '<?php echo $configuration->upload_default_path ?>';
		var field_name = "#" + "<?php echo $_REQUEST["field"] ?>" + "_config";
		var defaultInfo = jQuery.parseJSON( jQuery(field_name).attr("value") );
		if(!defaultInfo){ jQuery("#folder").attr("value", defaultFolder); return};
		jQuery("#folder").attr("value", defaultInfo.folder);
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
                <td><label for="folder">Folder Path: </label></td>
                <td><input id="folder" name="folder" class="required" /></td>
            </tr>
        </table>
        <div class="separator" id="separator_config" style="margin-bottom:15px; margin-top:15px;"></div>
        <input class='button_form' type='button' value='Accept' onclick="GetInfo()"/>
    </form>
</div>