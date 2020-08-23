<?php 
	$configuration = new Configuration();
	$user = User::getInstance();
?>
<div class="frame">
    <table class="menuPanel">
        <tr>
            <td>
            	<?php if($user->GetPermissionsValue("com_table_manager","consult")){ ?>
                	<div class="button"><a href="?option=com_table_manager"><div class="imagen table_manager"></div>Table Manager</a></div>
                <?php } ?>
				<?php if($user->GetPermissionsValue("user_panel","consult")){ ?>
                	<div class="button"><a href="?option=user_panel"><div class="imagen user_manager"></div>User Manager</a></div>
				<?php } ?>
                <?php if($user->GetPermissionsValue("menu_panel","consult")){ ?>
                	<div class="button"><a href="?option=menu_panel"><div class="imagen menu_manager"></div>Menu Manager</a></div>
                <?php } ?>
                <?php if($user->GetPermissionsValue("content_panel","consult")){ ?>
                	<div class="button"><a href="?option=content_panel"><div class="imagen content_manager"></div>Content Manager</a></div>
                <?php } ?>
                <?php if($user->GetPermissionsValue("com_general_config","consult")){ ?>
                	<div class="button"><a href="?option=com_general_config"><div class="imagen general_config"></div>General Configuration</a></div>
                <?php } ?>
	                <div class="button"><a onclick="SetBlockade(true); SetAlert('true', 'alerts/alertIFrame.php', '', 'width=900px&height=500px&url=http://www.tufikgroup.com/cuppa/documentation/', 'ShowAlert')"><div class="imagen help_center"></div>Help Center</a></div>
            </td>
            <?php if($user->GetPermissionsValue("control_panel","consult")){ ?>
                <td style=" width:300px;">
                    <div class="related_info_title">Related Information</div>
                    <div class="related_info_description">
                        <h4>Table Manager</h4>
                        <p>
                            Administrate tables of your data base is easy and quick. You can use <font style="color:#F40">Table Manager</font> to link up the table and auto create the form.
                        </p>
                        <br />
                        <h4>User Manager</h4>
                        <p>
                            Create additional users and groups, and add access privileges of these groups.
                        </p>
                        <br />
                        <h4>Menu Manager</h4>
                        <p>
                            Administrate differents menus, including the admin menu like you want. Also it possible add specific and custom permissions, relating it to diferents user groups.
                        </p>
                        <br />
                        <h4>General Configuration</h4>
                        <p>
                            Manage the general params for OnlyBack CMS, like Database Settings, File Settings and Other Settings.
                        </p>
                    </div>
                </td>
			<?php } ?>
        </tr>
    </table>
</div>