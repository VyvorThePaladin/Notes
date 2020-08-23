// Set Content
	function SetContent(loadContent, urlContent, nameContent, params, data, classCSS, duration, zIndex){
		if(!data) data = "";
		if(!nameContent) nameContent = "content";
		if(!params) params = {};		// {beforeOf:"nameId", top:Number, left:Number, insideOf:"nameId", append:Boolean}
		if(!duration) duration = 0;
		if(!classCSS) classCSS = "content_default";
		if(!zIndex) zIndex = 0;
		if(loadContent){
			//++ load content
				jQuery.ajax({ type: "POST", url: urlContent, data: data, success: function(html){
					var objContent = document.createElement('div');
						objContent.id = nameContent;
						objContent.name = nameContent;
						jQuery(objContent).addClass(classCSS);
						jQuery(objContent).append(html);
						jQuery(objContent).css('opacity', 0);
						jQuery(objContent).css('z-index', zIndex);
						if(params.beforeOf){
							var content_height = jQuery(objContent).css("height");
							var beforeOf_element = jQuery(params.beforeOf);
								jQuery(objContent).insertBefore(beforeOf_element);
							var content_height = jQuery(objContent).css("height");
							jQuery(objContent).css("height", "0px");
							jQuery(objContent).animate({height:content_height}, duration);
						}else if(params.top && params.left){
							jQuery(objContent).css('position', 'absolute');
							jQuery(objContent).css('top', params.top);
							jQuery(objContent).css('left', params.left);
							if(params.insideOf){
								jQuery(params.insideOf).append(objContent);
							}else{
								jQuery("body").append(objContent);
							}
						}else if(params.insideOf){
							if(params.append)
								jQuery(params.insideOf).append(objContent);
							else
								jQuery(params.insideOf).html(objContent);
							if(params.top && params.left){
								jQuery(objContent).css('position', 'absolute');
								jQuery(objContent).css('top', params.top);
								jQuery(objContent).css('left', params.left);
							}
						}
						jQuery(objContent).animate({opacity: 1}, duration);
				} });
			//--
			return nameContent;
		}else{
			var contentToRemove = document.getElementById(nameContent);
			try{ jQuery(contentToRemove).animate({opacity: 0}, duration, function() { jQuery(contentToRemove).remove();  }); }catch(err){}
			return null;
		}
	}
// Set alert
	function SetAlert(loadAlert, urlAlert, nameAlert, data, executeFunctionName, zIndex, duration){
		if(!urlAlert) urlAlert = "alerts/defaultAlert.php";
		if(!nameAlert) nameAlert = "#alert";
		if(!data) data = "";
		if(!executeFunctionName) executeFunctionName = "";
		if(!zIndex) zIndex = 0;
		if(!duration) duration = 100;
		if(loadAlert){	
			//++ loader alert
				function LoaderAlert(){
					jQuery.ajax({ type: "POST", url: urlAlert, data: data + "&zIndex=" + zIndex, success: function(html){
						jQuery(charger).remove();
						jQuery('body').append(html);
						if(executeFunctionName) eval( executeFunctionName +"()");
					} });
				}
			//--
			//++ load Charger	
				function ShowCharger(){
					_width = 40; _height = 40;
					charger = document.createElement("div");
					charger.id = "charger_small";
					charger.name = "charger_small";
					jQuery(charger).addClass('charger_small');
					jQuery(charger).css('margin-left', -(_width*0.5));
					jQuery(charger).css('margin-top', -(_height*0.5));
					jQuery(charger).css('opacity', 0);
					jQuery(charger).css('z-index', zIndex);
					jQuery(charger).animate({opacity: 1}, 200);
					jQuery('body').append(charger);
					setTimeout(function(){LoaderAlert()}, 500);
				}
			//--
			var charger;
			ShowCharger();
		}else{
			var alertToRemove = document.getElementById(nameAlert);
			try{ jQuery(alertToRemove).animate({opacity: 0}, duration, function() { jQuery(alertToRemove).remove();  }); }catch(err){}
		}
	}
// Set blockade
	function SetBlockade(activateBlockade, nameBlockade, duration, autoDeleteContent, zIndex){
		if(!nameBlockade) nameBlockade = "blockade";
		if(!duration) duration = 100;
		if(!autoDeleteContent) autoDeleteContent = "";
		if(!zIndex) zIndex = 0;
		if(activateBlockade){
			var blockade = document.createElement('div');
				blockade.id = nameBlockade;
				blockade.name = nameBlockade;
				blockade.autoDeleteContent = autoDeleteContent;
				jQuery(blockade).addClass('blockade');
				jQuery(blockade).css('opacity', 0);
				jQuery(blockade).css('z-index', zIndex);
				jQuery(blockade).animate({opacity: 0.7}, duration);
				jQuery('body').append(blockade);
				// auto remove event
					if(autoDeleteContent){
						jQuery(blockade).click(function(){ var name_blockade = jQuery(this).attr("id"); SetAlert(false,"", jQuery(this).attr("autoDeleteContent")); setTimeout(function(){ SetBlockade(false,name_blockade ) },200);   });
					}
			return nameBlockade;
		}else{
			var blockadeToRemove = document.getElementById(nameBlockade);
			try{ jQuery(blockadeToRemove).animate({opacity: 0}, duration, function() { jQuery(blockadeToRemove).remove(); }); }catch(err){}
			return null;
		}
	}
// Show Charger
	function SetCharger(showCharger, nameCharger, duration, zIndex){
		if(!nameCharger) nameCharger = "charger_small";
		if(!duration) duration = 100;
		if(!zIndex) zIndex = 0;
		if(showCharger){
			_width = 40; _height = 40;
			charger = document.createElement("div");
			charger.id = "charger_small";
			charger.name = "charger_small";
			jQuery(charger).addClass('charger_small');
			jQuery(charger).css('margin-left', -(_width*0.5));
			jQuery(charger).css('margin-top', -(_height*0.5));
			jQuery(charger).css('opacity', 0);
			jQuery(charger).css('z-index', zIndex);
			jQuery(charger).animate({opacity: 1}, duration);
			jQuery('body').append(charger);
			return nameCharger;
		}else{
			var chargerToRemove = document.getElementById(nameCharger);
			try{ jQuery(chargerToRemove).animate({opacity: 0}, duration, function() { jQuery(chargerToRemove).remove(); }); }catch(err){}
			return null;
		}
	}
// Move Scrolls
	function MoveScrolls(target, moveScrollX, moveScrollY, positionX, positionY, duration){
		if(!moveScrollX) moveScrollX = false;
		if(!moveScrollY) moveScrollY = false;
		if(!positionX) positionX = 0;
		if(!positionY) positionY = 0;
		if(!duration) duration = 200;
		if(!target) target = "body";
		if(!document.body.scrollTop) target = "html";		
		
		if(moveScrollX && moveScrollY)	jQuery(target).animate({scrollLeft:positionX, scrollTop:positionY}, duration);
		else if(moveScrollX) jQuery(target).animate({scrollLeft:positionX}, duration);
		else if(moveScrollY) jQuery(target).animate({scrollTop:positionY}, duration);
	}