<link href="../css/alertImage.css" rel="stylesheet" type="text/css">
<script>
	function CloseDefaultAlert(){
		SetAlert(false, "", "#alert");
		setTimeout(function () {SetBlockade(false)}, 200);
	}
	function ShowAlert(){
		var url = '<?php echo $_REQUEST["url"]; ?>';
		//++ Image complete
			function ImageLoadComplete(){
				_width = jQuery(imagePreload).attr("width");
				_height = jQuery(imagePreload).attr("height");
				jQuery("#icon_charger_image").remove(); 
				image = document.createElement("img");
				image.src = imagePreload.src;
				image.id = "image";
				image.name = "image";
				jQuery(image).addClass('image');
				jQuery('#alert').animate({width:_width + 10, height:_height + 30, 'margin-left':-(_width*0.5)+15, 'margin-top':-(_height*0.5)+5 }, 300, "easeInOutCirc", CompleteAnimation);
					function CompleteAnimation(){
						jQuery("#btnClose_alert_image").css('visibility', "visible");
						jQuery("#description_image").css('visibility', "visible");
						jQuery(image).css('opacity', 0);
						jQuery(image).css('margin-left', - (_width*0.5));
						jQuery(image).animate({opacity: 1}, 200);
						jQuery('#alert').append(image);
					}
			}
		//--
		var image;
		var imagePreload = new Image();
			imagePreload.src = url;
			if(jQuery(imagePreload).attr("complete")){ 
				ImageLoadComplete(); 
			} else{ 
				imagePreload.onload = ImageLoadComplete; 
			}
	}
</script>
<div class="alert_image" id="alert" style="z-index:<?php echo $_REQUEST["zIndex"]; ?>;">
	<div class="icon_charger_image" id="icon_charger_image"></div>
    <div class="description_image" id="description_image"><?php echo $_REQUEST["description"]; ?></div>
    <div class="btnClose_alert_image" id="btnClose_alert_image" onclick="javascript:CloseDefaultAlert();"></div>
</div>