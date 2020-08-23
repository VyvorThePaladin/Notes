<?php 
	$configuration = new Configuration();
	$user = User::getInstance();
?>
<div class="frame">
    <table class="menuPanel">
        <tr>
            <td>
            	<?php if($user->GetPermissionsValue($configuration->table_prefix."users","consult")){ ?>
	                <div class="button"><a href="?option=com_table_manager&view=<?php echo $configuration->table_prefix ?>users"><div class="imagen user_accounts"></div>User Accounts</a></div>
                <?php } ?>
                <?php if($user->GetPermissionsValue($configuration->table_prefix."user_groups","consult")){ ?>
	                <div class="button"><a href="?option=com_table_manager&view=<?php echo $configuration->table_prefix ?>user_groups"><div class="imagen user_manager"></div>User Groups</a></div>
            	<?php } ?>
            </td>
            <?php if($user->GetPermissionsValue("user_panel","consult")){ ?>
                <td style=" width:300px;">
                    <div class="related_info_title">Related Information</div>
                    <div class="related_info_description">
                        <h4>User Accounts</h4>
                        <p>
                            Manage the users information.
                            <br /><br /><font style="font-weight:bold" >For add more info to the user form:</font>
                            <br /><font style="color:#F40">1. </font> Edit the fisic table in the Data Base how you want afand.
                            <br /><font style="color:#F40">2. </font> Go to: Settings > Table Manager, Edit <font style="color:#F40">"<?php echo $configuration->table_prefix ?>users"</font> table.
                        </p>
                        <br />
                        <h4>User Groups</h4>
                        <p>
                            Create and edit the diferents groups, and the access privileges of these groups.
                        </p>
                    </div>
                </td>
            <?php } ?>
        </tr>
    </table>
</div>