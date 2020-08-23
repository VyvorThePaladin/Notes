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
				jQuery("#btnClose_alert_iframe").css('visibility', "visible");
				jQuery("#description_iframe").css('visibility', "visible");
				jQuery("#content_alert_iframe").css('visibility', "visible");
			}
	}
</script>
<div class="alert_iframe" id="alert" style="z-index:<?php echo @$_REQUEST["zIndex"]; ?>;">
    <div class="btnClose_alert_iframe" id="btnClose_alert_iframe" onclick="javascript:CloseDefaultAlert();"></div>
	<div class="description_iframe" id="description_iframe"><?php echo @$_REQUEST["description"]; ?></div>
    <div id="content_alert_iframe" class="content_alert_iframe">
    	<iframe id="iframe" name="iframe" class="iframe" frameborder="0" style="width:100%; height:100%;" src="<?php echo $_REQUEST["url"]; ?>"></iframe>
    </div>
</div>