<h1><img src="templates/default/images/template/icons/box_32.png" align="top" /> Tables :: <?php if($_REQUEST["task"] == "edit"){ ?>Edit<?php }else{ ?>New<?php } ?></h1>
<div class="frame">
	<!-- Create array with URL for config -->
		<?php
            $fields_array = json_decode($field_types);
            $urlConfig = array();
            for($i = 0; $i < count($fields_array); $i++){
                $className = $fields_array[$i][0];
                require("fields/".$className.".php");
                $item = new $className();
                echo "<input type='hidden' name='".$className."_urlConfig"."' id='".$className."_urlConfig"."' value='".@$item->urlConfig."' />";
                $urlConfig[$className] = @$item->urlConfig;
            }
        ?>
	<!-- Create array with URL for config -->
    <form id="form" action="" method="post" class="form">
    	<div class="title">
        	<div class="number2"><?php echo $_REQUEST["id"] ?></div>
            <div class="text"><?php if($_REQUEST["task"] == "edit"){ ?>Settings of the table<?php }else{ ?>Settings of new table<?php } ?></div>
        	<div class="name"><?php echo $table_name; ?></div>
        </div>
        <div class="separator"></div>
        <table width="100%" cellspacing="2" cellpadding="0" border="0" class="form" >
        	<tr>
            	<th style="width:150px;">Column</th>
                <th style="width:150px;">Label</th>
                <th style="width:80px; text-align:center;">Show in list</th>
                <th style="width:60px; text-align:center;">Required</th>
                <th style="width:60px; text-align:center;">Primary Key</th>
                <th>Config</th>
            </tr>
             <tr>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        	<?php for($i = 0; $i < count($infoColumbs); $i++){ ?>
                <tr>
                    <td><?php echo $infoColumbs[$i] ?></td>
                    <td style="width:150px;">
                    	<?php  if(isset($default_info->$infoColumbs[$i]->label)){ ?>
                        	<input class="text_field required" title=" " id="<?php echo $infoColumbs[$i] ?>_label" name="<?php echo $infoColumbs[$i] ?>_label" value="<?php echo @$default_info->$infoColumbs[$i]->label ?>" />
                        <?php } else{ ?>
                        	<input class="text_field required" title=" " id="<?php echo $infoColumbs[$i] ?>_label" name="<?php echo $infoColumbs[$i] ?>_label" value="<?php echo ucfirst( str_replace("_"," ",$infoColumbs[$i])) ?>" />
                        <?php } ?>
					</td>
					<td style="text-align:center;" >
                    	 <?php  if(isset($default_info->$infoColumbs[$i]->showList)){ ?>
                         	<?php if($default_info->$infoColumbs[$i]->showList == 1){?>
	                         	<input value="1" type="checkbox" name="<?php echo $infoColumbs[$i] ?>_showList" id="<?php echo $infoColumbs[$i] ?>_showList" checked="checked" />
                            <?php }else {?>
                            	<input value="1" type="checkbox" name="<?php echo $infoColumbs[$i] ?>_showList" id="<?php echo $infoColumbs[$i] ?>_showList" />
							<?php } ?>
						<?php } else{ ?>
	                    	<input type="checkbox" name="<?php echo $infoColumbs[$i] ?>_showList" id="<?php echo $infoColumbs[$i] ?>_showList" checked="checked" />
                         <?php } ?>
                    </td>
                    <td style="text-align:center;" >
                    	<?php  if(isset($default_info->$infoColumbs[$i]->required)){ ?>
                        	<?php if($default_info->$infoColumbs[$i]->required == 1){?>
	                         	<input type="checkbox" name="<?php echo $infoColumbs[$i] ?>_required" id="<?php echo $infoColumbs[$i] ?>_required" checked="checked" />
                            <?php }else {?>
                            	<input type="checkbox" name="<?php echo $infoColumbs[$i] ?>_required" id="<?php echo $infoColumbs[$i] ?>_required" />
							<?php } ?>
                        <?php } else{ ?>
                        	<input type="checkbox" name="<?php echo $infoColumbs[$i] ?>_required" id="<?php echo $infoColumbs[$i] ?>_required" checked="checked" />
                        <?php } ?>
                    </td>
                    <td style="text-align:center;" >
                    	<?php  if(isset($default_info->primary_key)){ ?>
                        	<?php if($default_info->primary_key ==  $infoColumbs[$i]){?>
	                         	<input class="required" title=" " type="radio" name="primary_key" id="primary_key" value="<?php echo $infoColumbs[$i] ?>" checked="checked" />
                            <?php }else {?>
                            	<input class="required" title=" " type="radio" name="primary_key" id="primary_key" value="<?php echo $infoColumbs[$i] ?>" />
							<?php } ?>
                        <?php } else{ ?>
                        	<?php if($i == 0){?>
	                        	<input class="required" title=" " type="radio" name="primary_key" id="primary_key" value="<?php echo $infoColumbs[$i] ?>" checked="checked" />
							<?php }else{ ?>
                            	<input class="required" title=" " type="radio" name="primary_key" id="primary_key" value="<?php echo $infoColumbs[$i] ?>" />
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <td class="<?php echo $infoColumbs[$i]."_field" ?>">
						<?php
							echo "<div style='float:left'>";
								$className = "Select";
								$value = "Id"; if(isset($default_info)) $value = @$default_info->$infoColumbs[$i]->type;
								$item = new $className();
								echo $item->GetItem($infoColumbs[$i]."_field", $value, $field_types, true, "", "onchange='LoadConfig(this)'");
							echo "</div>";
							//++ Assing default config
								$defaultConfig = json_encode(@$default_info->$infoColumbs[$i]->config);
								if($defaultConfig != "null"){
									$itemName = $infoColumbs[$i]."_field";
									$urlConfig_link = $urlConfig[$default_info->$infoColumbs[$i]->type];
										$newField = "<div style='float:left' name='".$itemName."_div"."' id='".$itemName."_div"."'>";
										$newField .= "<input class='button_form3' type='button' value='Settings' onclick='LoadIFrame(\"".$itemName."\", \"".$urlConfig_link."\")'/>";
										$newField .= "<input style='width:70px' value='".json_encode($default_info->$infoColumbs[$i]->config)."' class='readonly required' title=' ' type='text' readonly='readonly' name='" . $itemName . "_config" . "' id='".$itemName."_config"."' />";
										$newField .= "</div>";
									echo $newField;
								}
							//--
						?>
					</td>
                </tr>
             <?php } ?>
            </tbody>
        </table>
        <div style="height:20px;"></div>
        <input type="hidden" name="option" id="option" value="<?php echo $_REQUEST["option"]; ?>" />
        <input type="hidden" name="table_name" id="table_name" value="<?php echo $table_name; ?>" />
        <input type="hidden" name="id" id="id" value="<?php echo @$_REQUEST["id"]; ?>" />
        <input type="hidden" name="task" id="task" />
        <input class="button_form" type="button" value="Save" onclick="SubmitForm('save')" />
        <input class="button_form2" type="button" value="Cancel" onclick="SubmitForm('cancel')"/>
    </form>
</div>
<script>
	function SubmitForm(task){
		jQuery('#task').attr('value',task);
		if(task == "cancel"){ document.forms["form"].submit(); return; }
		$('#form').submit();
	}
	jQuery().ready(function(){ jQuery("#form").validate(); });
	
	function LoadConfig(item){
		var itemName = jQuery(item).attr("name");
		var itemValue = jQuery(item).attr("value");
		var urlConfig = jQuery("#"+itemValue+"_urlConfig").attr("value");
		
		var contentToDelete = itemName + "_div";
		SetContent(false, "", contentToDelete);
		if(urlConfig){
			var newField = "<div style='float:left' name='" + itemName + "_div" + "' id='" + itemName +"_div"+"'>";
				newField += "	<input class='button_form3' type='button' value='Settings' onclick='LoadIFrame(\""+itemName+"\", \"" + urlConfig + "\")'/>";
				newField += "	<input style='width:70px' class='readonly required' title=' ' type='text' readonly='readonly' name='" + itemName + "_config" +"' id='" + itemName + "_config" +"' />"
				newField +=  "</div>";
			jQuery("." + itemName).append(newField);
		}
	}
	
	function LoadIFrame(field, urlConfig){
		SetBlockade(true);
		SetAlert(true, "alerts/alertConfigField.php", "","field="+field+"&urlConfig="+urlConfig+"&width=500px&height=450px", "ShowAlert");
	}
</script>