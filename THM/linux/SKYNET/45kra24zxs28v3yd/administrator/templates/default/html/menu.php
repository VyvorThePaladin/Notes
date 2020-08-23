<?php $configuration = new Configuration(); ?>
<div class="menu" id="menu">
    <div class="left_items">
    	<div class="dropdown">
	    	<?php echo $menu_admin ?>
		</div>
	</div>
    <div class="right_items">
    	<div class="dropdown">
        	<ul>
				<?php if($_SESSION["super_admin_login"]){ ?>
            	<li><div class="menu_divider"></div></li>
            	<li><div class="settings"></div>
                	<ul>
                    	<li><div class="sub_menu_item"><a href="?option=com_table_manager"><img src="templates/default/images/template/icons/table_16.png" />Table manager</a></div></li>
                        <li><div class="menu_divider_horizontal"></div></li>
                        <li><div class="sub_menu_item arrow"><a href="?option=menu_panel"><img src="templates/default/images/template/icons/menu_16.png" />Menu manager</a></div>
                        	<ul style="left:-100px; top:0px;">
                                <li><div class="sub_menu_item"><a href="?option=com_table_manager&view=<?php echo $configuration->table_prefix ?>menus">Menus</a></div></li>
                                <li><div class="menu_divider_horizontal"></div></li>
                                <li><div class="sub_menu_item"><a href="?option=com_menu">Menu items</a></div></li>
                                <li><div class="menu_divider_horizontal"></div></li>
                                <li><div class="sub_menu_item"><a href="?option=com_table_manager&view=<?php echo $configuration->table_prefix ?>menu_item_type">Menu items type</a></div></li>
                            </ul>
                        </li>
                        <li><div class="menu_divider_horizontal"></div></li>
                        <li><div class="sub_menu_item"><a href="?option=com_table_manager&view=<?php echo $configuration->table_prefix ?>permissions"><img src="templates/default/images/template/icons/permissions_16.png" />Permission types</a></div></li>
						<li><div class="menu_divider_horizontal"></div></li>
                        <li><div class="sub_menu_item"><a href="?option=com_general_config"><img src="templates/default/images/template/icons/general_config_16.png" />General configuration</a></div></li>
                    </ul>
                </li>
                <?php } ?>
            	<li><div class="menu_divider"></div></li>
            	<li><a href="?task=logout"><div class="logout"></div></a></li>
            </ul>
        </div>
    </div>
</div>