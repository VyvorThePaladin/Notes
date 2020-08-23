<?php 
	$configuration = new Configuration();
?>
<div class="frame">
    <table class="menuPanel">
        <tr>
            <td>
            	<?php if($user->GetPermissionsValue($configuration->table_prefix."articles","consult")){ ?>
                    <div class="button"><a href="?option=com_table_manager&view=cu_articles"><div class="imagen articles"></div>Articles</a></div>
				<?php } ?>
                <?php if($user->GetPermissionsValue($configuration->table_prefix."categories","consult")){ ?>
	                <div class="button"><a href="?option=com_table_manager&view=cu_categories"><div class="imagen categories"></div>Categories</a></div>
                <?php } ?>
            </td>
        </tr>
    </table>
</div>