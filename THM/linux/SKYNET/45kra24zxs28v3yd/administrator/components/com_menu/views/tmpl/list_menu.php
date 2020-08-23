<?php 
	require("./components/com_table_manager/fields/Select.php"); 
	$configuration = new Configuration();
?>
<h1><img src="templates/default/images/template/icons/box_32.png" align="top" /> Menu items :: List</h1>
<div class="frame">
    <div class="tools">
    	<div class="filters">
            <form id="form_filter" name="form_filter" action="?option=com_menu" method="post">
            	<font style="color:#94B52C; font-weight:bold">Filter: </font> Menu
            	<?php 
						$className = "Select";
						$field = new $className();
						$params = '{"table_name":"'.$configuration->table_prefix.'menus","data_column":"id","label_column":"name"}';
						echo $field->GetItem("menu_filter", @$_REQUEST["menu_filter"], $params, false, "", "onChange='jQuery(\"#form_filter\").submit()'");
				?>
            </form>
        </div>
        <div class="delete button" title="Delete selected table" onclick="SubmitForm('delete')"></div>
        <div class="edit button" title="Edit selected table" onclick="SubmitForm('edit')"></div>
        <div class="new button" title="Add new item" onclick="SubmitForm('new')"></div>
    </div>
    <form id="form" action="" method="post">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="datagrid">
            <tbody>
                <tr>
                    <th class="header select"><input id="selectAll" type="checkbox" onclick="SelectAll(this.checked)"/></th>
                    <th class="header">Id</th>
                    <th class="header">Title</th>
                    <th class="header">Item type</th>
                    <th class="header">Parent element</th>
                    <th class="header">Menu</th>
                    <th class="header">Order</th>
                    <th class="header">Options</th>
                </tr>
                <?php for($i = 0; $i < count($info); $i++){ 
                    if(($i%2) == 0){ echo "<tr>"; }else{ echo "<tr class='grey'>"; }
                ?>
                        <td class="select"><input id="id" name="id[]" type="checkbox" value="<?php echo $info[$i]["id"] ?>" /></td>
                        <td class="id"><a href="?option=com_menu&task=edit&id=<?php echo $info[$i]["id"] ?>&menu_filter=<?php echo @$_REQUEST["menu_filter"] ?>"><?php echo $info[$i]["id"] ?></a></td>
                        <td><a href="?option=com_menu&task=edit&id=<?php echo $info[$i]["id"] ?>&menu_filter=<?php echo @$_REQUEST["menu_filter"] ?>"><?php echo $info[$i]["title"] ?></a></td>
                        <td><?php echo $info[$i]["menu_item_type_name"] ?></td>
						<?php 
							if($info[$i]["parent_title"])
								echo "<td style='background:#DFEBF2' >" . $info[$i]["parent_title"] . "</td>";
							else
								echo "<td>" . $info[$i]["parent_title"] . "</td>";
						?>
                        <td><?php echo $info[$i]["menu_name"] ?></td>
                        <td style="text-align:center; width:30px;"><?php echo $info[$i]["order"] ?></td>
                        <td>
                        	<div class="tools" style="height:auto;">
                              	<a href="?option=com_menu&task=permissions&id=<?php echo $info[$i]["id"] ?>&title=<?php echo $info[$i]["title"] ?>&menu_filter=<?php echo @$_REQUEST["menu_filter"] ?>"><div class="permissions button" title="Admin permissions for this item"></div></a>
                                <?php if($info[$i]["order"] > 1){ ?>
	                            	<a href="?option=com_menu&task=moveTop&id=<?php echo $info[$i]["id"] . "&parent_id=" . $info[$i]["parent_id"] ?>&menu_filter=<?php echo @$_REQUEST["menu_filter"] ?>"><div class="top button" title="Move this field to top"></div></a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <input type="hidden" name="option" id="option" value="<?php echo $_REQUEST["option"] ?>" />
        <input type="hidden" name="task" id="task"/>
        <!-- FILTERS -->
        	 <input type="hidden" name="menu_filter" id="menu_filter" value="<?php echo @$_REQUEST["menu_filter"] ?>" />
        <!-- END FILTERS -->
        <div class="separator"></div>
    </form>
</div>
<script>
	function SubmitForm(task){
		if(!GetSelectedItems() && (task == "edit" || (task == "delete")) ){ alert("Please, select a list item"); return; };
		if(task == "new" && jQuery("#table_name").attr("value") == "-1"){ alert("Please, select a table of the list"); return; }
		jQuery('#task').attr('value',task); document.forms["form"].submit();
	}
</script>