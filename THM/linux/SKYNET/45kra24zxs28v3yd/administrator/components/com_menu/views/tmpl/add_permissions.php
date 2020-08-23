<?php
	$configuration = new Configuration;
	$db = DataBase::getInstance();
	$permission_types = $db->GetList("".$configuration->table_prefix."permissions", @$_SESSION["token"]);
	$user_groups = $db->GetList("".$configuration->table_prefix."user_groups", @$_SESSION["token"]);
	$info = json_decode($info["permissions_params"]);
	
	//++ Get [string_name]
		$sql = "SELECT mi.* FROM ".$configuration->table_prefix."menu_items AS mi  WHERE mi.id = '".$_REQUEST["id"]."'";
		$result = $db->PersonalSql($sql, $_SESSION["token"]);
		$string_name = "";
		if($result){
			$json_decode = json_decode($result[0]["menu_item_params"]);
			if($result[0]["menu_item_type_id"] == "2"){		// Auto administrate
				$string_name = $json_decode->table_name;
			}else if($result[0]["menu_item_type_id"] == "3"){	//	Personalized component
				$string_name =  $json_decode->component_name;
			}
		}
	//--
?>
<h1><img src="templates/default/images/template/icons/box_32.png" align="top" /> Menu item :: Edit Permissions</h1>
<div class="frame">
    <form id="" action="" method="post" class="form">
    	<div class="title ">
        	<div class="number2"><?php echo $_REQUEST["id"] ?></div>
            <div class="text"><?php echo $_REQUEST["title"] ?></div>
        </div>
	</form>
	<form id="form" action="" method="post">
        <div class="separator"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="datagrid">
        	<tbody>
        	<tr>
	        	<th class='header'>User groups</th>
                <?php 
					for($i = 0; $i < count($permission_types); $i++){ 
	                	echo "<th class='header'>".$permission_types[$i]['title']."</th>";
                	} 
				?>
            </tr>
			<?php 
                for($i = 0; $i < count($user_groups); $i++){
                    echo "<tr>";
                        echo "<td style='width:150px; border-left:0px; background:#EEE'>".$user_groups[$i]["name"]."</td>";
						for($j = 0; $j < count($permission_types); $j++){
							$name = strtolower($user_groups[$i]["name"]."_".$permission_types[$j]["title"]);
							$name = str_replace(" ", "_", $name);
							if($info){
								if(@$info->$user_groups[$i]["name"]->$permission_types[$j]["title"] == "1")
									echo "<td><input value='1' checked='checked' type='checkbox' id='".$name."' name='".$name."' value='' /></td>";
								else
									echo "<td><input value='1' type='checkbox' id='".$name."' name='".$name."' value='' /></td>";
							}else{
								echo "<td><input value='1' checked='checked' type='checkbox' id='".$name."' name='".$name."' value='' /></td>";
							}
						} 
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
        <div class="separator"></div>
        <div style="height:20px;"></div>
        <input type="hidden" name="option" id="option" value="<?php echo $_REQUEST["option"] ?>" />
		<input type="hidden" name="id" id="id" value="<?php echo @$_REQUEST["id"] ?>" />
	    <input type="hidden" name="string_name" id="string_name" value="<?php echo @$string_name ?>" />
        <input type="hidden" name="task" id="task" />
        <input class="button_form" type="button" value="Save" onclick="SubmitForm('update_permissions')" />
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
	
	function ShowMoreInfo(){
		var valueSelected = jQuery("#type_field").val();
		HiddeAll();
		if(valueSelected == "2")
			jQuery("#table_name_tr").css("display", "table-row");
		else if(valueSelected == "3")
			jQuery("#component_name_tr").css("display", "table-row");
		else if(valueSelected == "4")
			jQuery("#external_url_tr").css("display", "table-row");
	}
	function HiddeAll(){
		jQuery("#table_name_tr").css("display", "none");
		jQuery("#component_name_tr").css("display", "none");
		jQuery("#external_url_tr").css("display", "none");
	}
	ShowMoreInfo();
</script>