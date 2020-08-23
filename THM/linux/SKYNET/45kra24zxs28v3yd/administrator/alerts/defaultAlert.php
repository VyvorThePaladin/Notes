<link href="../css/defaultAlert.css" rel="stylesheet" type="text/css">
<script>
	function CloseDefaultAlert(){
		SetAlert(false, '', '#alert');
		setTimeout(function () {SetBlockade(false)}, 200);
	}
	function ShowAlert(){
		var _width = jQuery("#alert").css("width");
		var _height = jQuery("#alert").css("height");
		jQuery('#alert').css("visibility","hidden");
		jQuery('#alert').css("margin-left",-parseInt(_width)*0.5);
		jQuery('#alert').css("margin-top",-parseInt(_height)*0.5);
		jQuery('#alert').css('opacity', 0);
		jQuery("#alert").css('visibility', "visible");
		jQuery('#alert').animate({opacity: 1}, 200, "easeInOutCirc", CompleteAnimation);
			function CompleteAnimation(){
				jQuery("#btnAccept").focus();
			}
	}
</script>
<div class="default_alert" id="alert" style="z-index:<?php echo $_REQUEST["zIndex"]; ?>;">
	<div id="content_default_alert" class="content_default_alert">
    	<div id="icon_default_alert" class="icon_default_alert"></div>
        <div id="text_default_alert" class="text_default_alert">
     	   	<?php echo $_REQUEST["message"];  ?>
      	</div>
    </div>
	<div id="buttons_default_alert" class="buttons_default_alert">
		<input type="submit" class="btnAccept" name="btnAccept" id="btnAccept" value="Aceptar" onClick="javascript:CloseDefaultAlert()">
    </div>
</div>