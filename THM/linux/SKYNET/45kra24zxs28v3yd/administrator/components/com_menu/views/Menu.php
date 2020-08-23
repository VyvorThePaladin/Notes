<?php
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class Menu_View{
		public function ListItems($info){
			require("tmpl/list_menu.php");
		}
		public function AddItem($info = NULL){
			require("tmpl/edit_menu.php");
		}
		public function AddPermissions($info = NULL){
			require("tmpl/add_permissions.php");
		}
	}
?>