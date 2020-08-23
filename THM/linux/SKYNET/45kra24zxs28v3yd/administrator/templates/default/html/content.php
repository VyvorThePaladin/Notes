<div class="content" id="content">
	<div class="content_info">
	<?php
		if(isset($_REQUEST["option"])){
			$option = explode("_",$_REQUEST["option"]);
			if($option[0] == "com"){
				require("components/".$_REQUEST["option"]."/index.php");
			}else if($_REQUEST["option"] == "user_panel"){
				require("panels/user_panel.php");
			}else if($_REQUEST["option"] == "menu_panel"){
				require("panels/menu_panel.php");
			}else if($_REQUEST["option"] == "content_panel"){
				require("panels/content_panel.php");
			}
		}else{
			require("panels/contro_panel.php");
		}
    ?>
    </div>
</div>