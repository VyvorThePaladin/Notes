<?php 
	if(isset($_REQUEST["view"])){
		require("controllers/Admin_Table.php");
		$class = "Admin_Table_Controller";
		$controller = new $class();
	}else{
		require("controllers/Table_Manager.php");	
		$controller = new Table_Manager_Controller();
	}
?>