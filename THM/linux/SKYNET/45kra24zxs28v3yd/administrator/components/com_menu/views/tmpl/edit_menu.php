<?php 
	require("./components/com_table_manager/fields/Select.php"); 
	$configuration = new Configuration();
	$menu_item_params = json_decode($info["menu_item_params"]);
?>
<h1><img src="templates/default/images/template/icons/box_32.png" align="top" /> Menu item :: <?php if($_REQUEST["task"] == "edit"){ ?>Edit<?php }else{ ?>New<?php } ?></h1>
<div class="frame">
    <form id="form" action="" method="post" class="form">
    	<div class="title">
        	<div class="number2"><?php echo $_REQUEST["id"] ?></div>
            <div class="text"><?php if($_REQUEST["task"] == "edit"){ ?>Record of the menu<?php }else{ ?>Settings of new menu item<?php } ?></div>
        </div>
        <div class="separator"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form">
            <tr>
                <td style="width:150px;">Title</td>
                <td><input class="required" title=" " id="title_field" name="title_field" value="<?php echo $info["title"] ?>" /></td>
            </tr>
            <tr>
            	<td style="width:150px;">Parent element</td>
                <td>
					<?php 
						$db = DataBase::getInstance();
						$sql = "SELECT id, title FROM ".$configuration->table_prefix."menu_items WHERE id <> '".$_REQUEST["id"]."'";
						$query = $db->PersonalSql($sql, @$_SESSION["token"]);
						$data = array();
							for( $i = 0; $i < count($query); $i++ ){ $data[$i][0] = $query[$i]["id"]; $data[$i][1] = $query[$i]["title"]; }
						$json_data = json_encode($data);
						$className = "Select";
						$field = new $className();
						echo $field->GetItem("parent_field", $info["parent_id"], $json_data,  false, "", "", true);
					?>
                </td>
            </tr>
            <tr>
            	<td style="width:150px;">Menu</td>
                <td>
					<?php 
						$className = "Select";
						$field = new $className();
						$params = '{"table_name":"'.$configuration->table_prefix.'menus","data_column":"id","label_column":"name"}';
						echo $field->GetItem("menu_field", $info["menus_id"], $params);
					?>
                </td>
            </tr>
            <tr>
            	<td style="width:150px;">Enabled</td>
                <td>
					<?php 
						$className = "Select";
						$field = new $className();
						$params = '[["1","true"],["0","false"]]';
						echo $field->GetItem("enabled_field", $info["enabled"], $params);
					?>
                </td>
            </tr>
        </table>
        <div class="separator"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form">
            <tr>
            	<td style="width:150px;">Menu item type</td>
                <td>
					<?php 
						$className = "Select";
						$field = new $className();
						$params = '{"table_name":"'.$configuration->table_prefix.'menu_item_type","data_column":"id","label_column":"name"}';
						echo $field->GetItem("type_field", $info["menu_item_type_id"], $params, false, "", "onChange='ShowMoreInfo()'");
					?>
                </td>
            </tr>
            <tr id="table_name_tr" style="display:none">
            	<td style="width:150px;">Table name</td>
                <td>
					<?php 
						$className = "Select";
						$field = new $className();
						$params = '{"table_name":"'.$configuration->table_prefix.'tables","data_column":"table_name","label_column":"table_name"}';
						echo $field->GetItem("table_name_field", @$menu_item_params->table_name, $params, false, "", "onChange='Assign_Menu_Item_Params()'");
					?>
					Defined_task
                    <input id="defined_task" name="defined_task" value="<?php echo @$menu_item_params->defined_task ?>" onChange="Assign_Menu_Item_Params()" />
                </td>
            </tr>
            <tr id="component_name_tr" style="display:none">
            	<td style="width:150px;">Component name</td>
                 <td><input id="component_name_field" name="component_name_field" value="<?php echo @$menu_item_params->component_name ?>" onChange="Assign_Menu_Item_Params()" /></td>
            </tr>
            <tr id="url_tr" style="display:none">
            	<td style="width:150px;">Url</td>
                <td>
                	<input id="url_field" name="url_field" value="<?php echo @$menu_item_params->url ?>" onChange="Assign_Menu_Item_Params()" />
                    Target
                    <?php 
	                    $className = "Select";
						$field = new $className();
						$params = '[["_blank", "blank"],["_self", "self"],["_top", "top"],["_new", "new"],["iframe", "iframe"]]';
						echo $field->GetItem("url_target_field", @$menu_item_params->target, $params, false, "", "onChange='Assign_Menu_Item_Params()'");
					?>
                </td>
            </tr>
        </table>
        <div style="height:20px;"></div>
        <input type="hidden" name="option" id="option" value="<?php echo $_REQUEST["option"] ?>" />
		<input type="hidden" name="id" id="id" value="<?php echo @$_REQUEST["id"] ?>" />
        <input type="hidden" name="order" id="order" value="<?php echo @$info["order"] ?>" />
        <input type="hidden" name="task" id="task" />
        <input type="hidden" name="menu_item_params" id="menu_item_params" value="<?php echo @$info["menu_item_params"] ?>" />
        <input class="button_form" type="button" value="Save" onclick="SubmitForm('save')" />
        <input class="button_form2" type="button" value="Cancel" onclick="SubmitForm('cancel')" />
         <!-- FILTERS -->
        	 <input type="hidden" name="menu_filter" id="menu_filter" value="<?php echo @$_REQUEST["menu_filter"] ?>" />
        <!-- END FILTERS -->
    </form>
</div>
<script>
	function SubmitForm(task){
		jQuery('#task').attr('value',task);
		if(task == "cancel"){ document.forms["form"].submit(); return; }
		$('#form').submit();
	}
	jQuery().ready(function(){ jQuery("#form").validate(); });
	
	//++ Assign Menu_Item_Params
		function Assign_Menu_Item_Params(){
			jQuery("#menu_item_params").val("");
			var value = "";
			if(jQuery("#type_field").val() == "2"){
				value = '{"table_name":"' + jQuery('#table_name_field option:selected').text() + '", "defined_task":"'+jQuery("#defined_task").val()+'"}';
			}else if(jQuery("#type_field").val() == "3"){
				value = '{"component_name":"' + jQuery("#component_name_field").val() + '"}';
			}else if(jQuery("#type_field").val() == "4"){
				value = '{"url":"' + jQuery("#url_field").val() + '","target":"' + jQuery("#url_target_field").val() + '"}';
			}
			jQuery("#menu_item_params").val(value);
		}
	//--
	
	function ShowMoreInfo(){
		var valueSelected = jQuery("#type_field").val();
		HiddeAll();
		if(valueSelected == "2")
			jQuery("#table_name_tr").css("display", "table-row");
		else if(valueSelected == "3")
			jQuery("#component_name_tr").css("display", "table-row");
		else if(valueSelected == "4")
			jQuery("#url_tr").css("display", "table-row");
			
		Assign_Menu_Item_Params();
	}
	function HiddeAll(){
		jQuery("#table_name_tr").css("display", "none");
		jQuery("#component_name_tr").css("display", "none");
		jQuery("#url_tr").css("display", "none");
	}
	ShowMoreInfo();
</script>