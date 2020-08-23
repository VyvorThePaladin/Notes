<?php 
	ini_set("include_path", "classes/");
	require("Paginator.php");
	$configuration = new Configuration();
	//++ Permissions verify
		$user = User::getInstance();
		if(!$user->GetPermissionsValue($_REQUEST["view"], "consult")){
			echo '<meta http-equiv="Refresh" content="0;url=./">';
			exit();
		}
	//--
?>
<h1><img src="templates/default/images/template/icons/box_32.png" align="top" /> Table :: <?php echo $_REQUEST["view"]; ?></h1>
<div class="frame">
    <div class="tools">
    	<?php if($user->GetPermissionsValue($_REQUEST["view"], "delete")){ ?>
	        <div class="delete button" title="Delete selected table" onclick="SubmitForm('delete')"></div>
        <?php } if($user->GetPermissionsValue($_REQUEST["view"], "edit")) {?>
	        <div class="edit button" title="Edit selected table" onclick="SubmitForm('edit')"></div>
		<?php } if($user->GetPermissionsValue($_REQUEST["view"], "insert")) {?>
	        <div class="new button" title="Add new item" onclick="SubmitForm('new')"></div>
		<?php } ?>
    </div>
    <form id="form" action="" method="post">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="datagrid">
            <tbody>
                <tr>
                	<th class="header select"><input id="selectAll" type="checkbox" onclick="SelectAll(this.checked)"/></th>
                	<?php for($i = 0; $i < count($infoColumns); $i++){ ?>
                    	<?php if(strtolower($infoColumns[$i]) == "id"){ ?>
                        	<?php if(@$field_types->$infoColumns[$i]->showList){ ?>
	                    		<th class="header id"><a href="#"><?php echo $field_types->$infoColumns[$i]->label ?><img src="templates/default/images/template/datagrid/arrow.gif" /></a></th>
                        	<?php } ?>
						<?php }else{ ?>
                        	<?php if(@$field_types->$infoColumns[$i]->showList){ ?>
                        		<th class="header"><a href="#"><?php echo $field_types->$infoColumns[$i]->label ?><img src="templates/default/images/template/datagrid/arrow.gif" /></a></th>
                        	<?php } ?>
						<?php }?>
                    <?php } ?>
                </tr>
                <?php 
					if($info){
						for($i = 0; $i < count($info); $i++){ 
                    		if(($i%2) == 0){ echo "<tr>"; }else{ echo "<tr class='grey'>"; }
                ?>
                            <td class="select"><input id="id" name="id[]" type="checkbox" value="<?php echo $info[$i][$field_types->primary_key] ?>" /></td>
                            <?php for($j = 0; $j < count($infoColumns); $j++){ ?>
                                <?php if(strtolower($infoColumns[$j]) == $field_types->primary_key){ ?>
                                	<?php if(@$field_types->$infoColumns[$j]->showList){ ?>
                                    	<?php if($user->GetPermissionsValue($_REQUEST["view"], "edit")) {?>
											<td><a href="?option=com_table_manager&task=edit&view=<?php echo $_REQUEST["view"] ?>&id=<?php echo $info[$i][$j] ?>"><?php echo $info[$i][$j] ?></a></td>
                                		<?php }else{ ?>
											<td><?php echo $info[$i][$j]?></td>
										<?php } ?>
									<?php } ?>
								<?php }else{ ?>
                                	<?php if(@$field_types->$infoColumns[$j]->showList){ ?>
                                    	<td><?php echo $info[$i][$j] ?></td>
									<?php } ?>
                                <?php }?>
                            <?php } ?>
                            </tr>
                <?php 
						}
					}
				?>
            </tbody>
        </table>
        <?php if(!$info){ ?>
            <table class="datagrid" style="width:100%; margin-top:10px;">
                <tr>
                    <td style="text-align:center; font-weight:bold; background:#FFF4CC; color:#E79300; padding:10px 0 10px 0; border:0px;">Table without info</td>
                </tr>
            </table>
		<?php } ?>
        <input type="hidden" name="option" id="option" value="<?php echo $_REQUEST["option"] ?>" />
		<input type="hidden" name="view" id="view" value="<?php echo $_REQUEST["view"] ?>" />
        <input type="hidden" name="task" id="task" />
    </form>
   	<?php 
		$paginator = new Paginator(); echo $paginator->GetAutoPaginator($_REQUEST["view"], $_SESSION["token"],@$_REQUEST["page"],$configuration->list_limit);
	?>
	<div class="separator"></div>
</div>
<script>
	function SubmitForm(task){
		if(!GetSelectedItems() && (task == "edit" || (task == "delete")) ){ alert("Please, select a list item"); return; };
		jQuery('#task').attr('value',task); document.forms["form"].submit();
	}
</script>