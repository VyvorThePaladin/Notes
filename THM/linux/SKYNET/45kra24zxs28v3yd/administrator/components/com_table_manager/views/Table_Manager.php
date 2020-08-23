<?php
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class Table_Manager_View{
		public function ListItems($info, $infoTables){
			require("tmpl/list_table_manager.php");
		}
		public function AddItem($info = NULL, $infoColumbs = NULL, $table_name = NULL, $field_types = NULL){
			if(@$info["params"]){ 			
				$default_info = json_decode($info["params"]);
			}
			require("tmpl/edit_table_manager.php");
		}
	}
?>