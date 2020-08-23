<?php 
	$configuration = new Configuration();
?>
<div class="frame">
    <table class="menuPanel">
        <tr>
            <td>
            	<?php if($user->GetPermissionsValue("com_menu","consult")){ ?>
                	<div class="button"><a href="?option=com_menu"><div class="imagen menu_item"></div>Menu items</a></div>
				<?php } ?>
                <?php if($user->GetPermissionsValue($configuration->table_prefix."menus","consult")){ ?>
	                <div class="button"><a href="?option=com_table_manager&view=<?php echo $configuration->table_prefix ?>menus"><div class="imagen menus"></div>Menus</a></div>
                <?php } ?>
            </td>
            <?php if($user->GetPermissionsValue("menu_panel","consult")){ ?>
                <td style=" width:300px;">
                    <div class="related_info_title">Related Information</div>
                    <div class="related_info_description">
                        <h4>Menu items</h4>
                        <p>
                            Manage the diferents levels of your menus, also you can change the order of this and administrate the permissions by group.
                            <br /><br />For add new permissions types go to <font style="font-weight:bold" >Settings > Prmissions types</font>
                        </p>
                        <br />
                        <h4>Menus</h4>
                        <p>
                            Create and administrate differents menus.
                        </p>
                    </div>
                </td>
			<?php } ?>
        </tr>
    </table>
</div>