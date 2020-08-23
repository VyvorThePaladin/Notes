<?php 
	if(isset($_REQUEST["view"])){
	}else{
		require("controllers/Menu.php");	
		$controller = new Menu_Controller();
	}
?>