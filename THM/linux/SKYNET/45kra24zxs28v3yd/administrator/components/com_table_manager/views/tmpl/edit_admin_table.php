<?php
	//++ Get type fields
		$files = scandir("components/com_table_manager/fields/");
		for($i = 0; $i < count($files); $i++){
			if($files[$i] != "." && $files[$i] != ".."){
				$file = explode(".", $files[$i]);
				if(count($file) > 1) require("fields/". $file[0].".php");
			}
		}
	//--
	//++ Permissions verify
		$user = User::getInstance();
		if(!$user->GetPermissionsValue($_REQUEST["view"], "edit")){
			echo '<meta http-equiv="Refresh" content="0;url=./">';
			exit();
		}
	//--
?>
<h1><img src="templates/default/images/template/icons/box_32.png" align="top" /> Table :: <?php echo $_REQUEST["view"] ?></h1>
<div class="frame">
    <form id="form" action="" method="post" class="form">
    	<div class="title">
        	<div class="number2"><?php echo $_REQUEST["id"] ?></div>
            <div class="text"><?php if($_REQUEST["task"] == "edit"){ ?>Edit record<?php }else{ ?>New record<?php } ?></div>
        </div>
        <div class="separator"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form">
        	<?php for($i = 0; $i < count($infoColumbs); $i++){ ?>
                <tr>
                    <td style="width:150px; <?php if($field_types->$infoColumbs[$i]->type == "TextArea") echo "vertical-align:top; padding-top:5px" ?>"><?php echo $field_types->$infoColumbs[$i]->label ?></td>
                    <td>
						<?php
							$className = $field_types->$infoColumbs[$i]->type;
							$field = new $className();
							echo $field->GetItem($infoColumbs[$i]."_field", $info[$infoColumbs[$i]], json_encode(@$field_types->$infoColumbs[$i]->config), $field_types->$infoColumbs[$i]->required);
						?>
					</td>
                </tr>
             <?php } ?>
            </tbody>
        </table>
        <div style="height:20px;"></div>
        <input type="hidden" name="option" id="option" value="<?php echo $_REQUEST["option"]; ?>" />
        <input type="hidden" name="view" id="view" value="<?php echo $_REQUEST["view"] ?>" />
		<input type="hidden" name="page" id="page" value="<?php echo @$_REQUEST["page"] ?>" />
		<input type="hidden" name="id" id="id" value="<?php echo @$_REQUEST["id"]; ?>" />
        <input type="hidden" name="task" id="task" />
        <input class="button_form" type="button" value="Save" onclick="SubmitForm('save')" />
        <input class="button_form2" type="button" value="Cancel" onclick="SubmitForm('cancel')" />
    </form>
</div>
<script>
	function SubmitForm(task){
		jQuery('#task').attr('value',task);
		if(task == "cancel"){ document.forms["form"].submit(); return; }
		$('#form').submit();
	}
	jQuery().ready(function(){ jQuery("#form").validate(); });
</script>