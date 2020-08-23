<script>
	function CloseDefaultAlert(){
		SetAlert(false, "", "#alert");
		setTimeout(function () {SetBlockade(false)}, 200);
	}
	function ShowAlert(){
		_width = '<?php echo $_REQUEST["width"]; ?>';
		_height = '<?php echo $_REQUEST["height"]; ?>';
		jQuery('#alert').animate({width:parseInt(_width), height:parseInt(_height), 'margin-left':-(parseInt(_width)*0.5)+20, 'margin-top':-(parseInt(_height)*0.5)+20 }, 300, "easeInOutCirc", CompleteAnimation);
			function CompleteAnimation(){
				jQuery("#btnClose_alert").css('visibility', "visible");
				jQuery("#description_alert").css('visibility', "visible");
				jQuery("#content_alert").css('visibility', "visible");
			}
	}
</script>
<div class="alert_config_field" id="alert" style="z-index:<?php echo $_REQUEST["zIndex"]; ?>;">
    <div class="btnClose_alert" id="btnClose_alert" onclick="javascript:CloseDefaultAlert();"></div>
	<div class="description_alert" id="description_alert"><b>Field configuration: </b><?php echo $_REQUEST["field"]; ?></div>
    <div class="separator" style="margin-bottom:15px;"></div>
    <div id="content_alert" class="content_alert">
        <?php include($_REQUEST["urlConfig"]); ?>
    </div>
</div>