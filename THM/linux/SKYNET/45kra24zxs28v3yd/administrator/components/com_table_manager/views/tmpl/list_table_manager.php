<h1><img src="templates/default/images/template/icons/box_32.png" align="top" /> Tables :: List</h1>
<div class="frame">
    <div class="tools">
        <div class="delete button" title="Delete selected table" onclick="SubmitForm('delete')"></div>
        <div class="edit button" title="Edit selected table" onclick="SubmitForm('edit')"></div>
    </div>
    <form id="form" action="" method="post">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="datagrid">
            <tbody>
                <tr>
                    <th class="header select"><input id="selectAll" type="checkbox" onclick="SelectAll(this.checked)"/></th>
                    <th class="header"><a href="#">Id<img src="templates/default/images/template/datagrid/arrow.gif" /></a></th>
                    <th class="header"><a href="#">Table<img src="templates/default/images/template/datagrid/arrow.gif" /></a></th>
                    <th class="header"><a href="">Params<img src="templates/default/images/template/datagrid/arrow.gif" /></a></th>
                </tr>
                <?php for($i = 0; $i < count($info); $i++){ 
                    if(($i%2) == 0){ echo "<tr>"; }else{ echo "<tr class='grey'>"; }
                ?>
                        <td class="select"><input id="id" name="id[]" type="checkbox" value="<?php echo $info[$i]["id"] ?>" /></td>
                        <td class="id"><a href="?option=com_table_manager&task=edit&id=<?php echo $info[$i]["id"] ?>"><?php echo $info[$i]["id"] ?></a></td>
                        <td><a href="?option=com_table_manager&task=edit&id=<?php echo $info[$i]["id"] ?>"><?php echo $info[$i]["table_name"] ?></a></td>
                        <td>JSON params</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <input type="hidden" name="option" id="option" value="<?php echo $_REQUEST["option"];  ?>" />
        <input type="hidden" name="task" id="task" />
        <div class="separator"></div>
        <div style="padding-left:0px; color:#393939; font-weight:bold;">
            Add new table: 
            <select name="table_name" id="table_name">
                <option value="-1">Select table</option>
                <?php 
                    for($i = 0; $i < count($infoTables); $i++){
                        echo "<option value='".$infoTables[$i]."'>".$infoTables[$i]."</option>";
                    }
                ?>
            </select>
            <input class="button_form" type="button" value="Configure" onclick="SubmitForm('new')" />
        </div>
    </form>
</div>
<script>
	function SubmitForm(task){
		if(!GetSelectedItems() && (task == "edit" || (task == "delete")) ){ alert("Please, select a list item"); return; };
		if(task == "new" && jQuery("#table_name").attr("value") == "-1"){ alert("Please, select a table of the list"); return; }
		jQuery('#task').attr('value',task); document.forms["form"].submit();
	}
</script>