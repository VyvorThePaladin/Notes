<?php
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	ini_set("include_path", "components/com_menu/"); 
	require("views/Menu.php");
	
	class Menu_Controller{
		private $view;
		private $configuration;
		public function Menu_Controller(){
			//print_r($_REQUEST);
			$this->view = new Menu_View();
			$this->configuration = new Configuration();
			if(@$_REQUEST["task"] == "new" || @$_REQUEST["task"] == "edit"){
				$db = DataBase::getInstance();
				$info = NULL;
				if($_REQUEST["task"] == "edit"){
					if(is_array($_REQUEST["id"])) $_REQUEST["id"] = $_REQUEST["id"][0];
					$info = $db->GetRow("".$this->configuration->table_prefix."menu_items", "id=".$_REQUEST["id"], @$_SESSION["token"]);
				}else{
					$_REQUEST["id"] = "0";
				}
				$this->view->AddItem($info);
			}else if(@$_REQUEST["task"] == "save"){
				$db = DataBase::getInstance();
				$array = array();
				$data["id"] = "'".mysql_real_escape_string($_REQUEST["id"])."'";
				$data["title"] = "'".mysql_real_escape_string($_REQUEST["title_field"])."'";
				$data["menu_item_type_id"] = "'".mysql_real_escape_string($_REQUEST["type_field"])."'";
				$data["menu_item_params"] = "'".mysql_real_escape_string($_REQUEST["menu_item_params"])."'";
				$data["parent_id"] = "'".mysql_real_escape_string($_REQUEST["parent_field"])."'";
				$data["menus_id"] = "'".mysql_real_escape_string($_REQUEST["menu_field"])."'";
				$data["enabled"] = "'".mysql_real_escape_string($_REQUEST["enabled_field"])."'";
					// validate order
					$itemsGroup = $db->GetList("".$this->configuration->table_prefix."menu_items", @$_SESSION["token"], "parent_id = ".$data["parent_id"], "","`order` ASC");
					$order = $itemsGroup[count($itemsGroup)-1]["order"] + 1;
						$newItem = true;
						if($data["id"] != "'0'"){
							$currentItem = $db->GetRow("".$this->configuration->table_prefix."menu_items", "id=".$data["id"], @$_SESSION["token"]);
							if($currentItem["parent_id"] == "0") $currentItem["parent_id"] = "";
							if("'".$currentItem["parent_id"]."'" == $data["parent_id"]) $newItem = false;

						}
				if($newItem) $data["`order`"] = "'".$order."'";
				$result = $db->Add("".$this->configuration->table_prefix."menu_items", $data, @$_SESSION["token"]);
				echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=".$_SERVER['PHP_SELF']."?option=com_menu&menu_filter=".@$_REQUEST["menu_filter"]."'>";
				$this->ShowList();
			}else if(@$_REQUEST["task"] == "delete"){
				$db = DataBase::getInstance();
				for($i = 0; $i < count($_REQUEST["id"]); $i++){ $db->Delete("".$this->configuration->table_prefix."menu_items", "id='".$_REQUEST["id"][$i]."'", @$_SESSION["token"]); }
				echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=".$_SERVER['PHP_SELF']."?option=com_menu&menu_filter=".@$_REQUEST["menu_filter"]."'>";
				$this->ShowList();
			}else if(@$_REQUEST["task"] == "moveTop" || @$_REQUEST["task"] == "moveDown"){
				$db = DataBase::getInstance();
				$data = $db->GetList("".$this->configuration->table_prefix."menu_items", @$_SESSION["token"], "parent_id = '".$_REQUEST["parent_id"] ."'", "","`order` ASC");			
				for($i = 0; $i < count($data); $i++){ if($data[$i]["id"] == $_REQUEST["id"]){ break; } }
				if(@$_REQUEST["task"] == "moveTop"){
					$updateData = array();
					$updateData["`order`"] = $data[$i-1]["order"];
					if(!$updateData["`order`"]) $updateData["`order`"] = "1";
					$db->Update("".$this->configuration->table_prefix."menu_items", $updateData, "id='".$data[$i]["id"]."'", @$_SESSION["token"]);
					$updateData = array();
					$updateData["`order`"] = $data[$i]["order"];
					if(!$updateData["`order`"]) $updateData["`order`"] = "1";
					$db->Update("".$this->configuration->table_prefix."menu_items", $updateData, "id='".$data[$i-1]["id"]."'", @$_SESSION["token"]);
				}
				echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=".$_SERVER['PHP_SELF']."?option=com_menu&menu_filter=".@$_REQUEST["menu_filter"]."'>";
				$this->ShowList();
			}else if(@$_REQUEST["task"] == "permissions"){
				$db = DataBase::getInstance();
				$info = $db->GetRow("".$this->configuration->table_prefix."menu_items_extra_data", "menu_items_id = '".$_REQUEST["id"]."'", @$_SESSION["token"]);
				$this->view->AddPermissions($info);
			}else if(@$_REQUEST["task"] == "update_permissions"){
				$db = DataBase::getInstance();
				$user_groups = $db->GetList("".$this->configuration->table_prefix."user_groups", @$_SESSION["token"]);
				$permission_types = $db->GetList("".$this->configuration->table_prefix."permissions", @$_SESSION["token"]);
				echo "<br /><br />";
				$data = array();
				for($i = 0; $i < count($user_groups); $i++){
					$info = array();
					for($j = 0; $j < count($permission_types); $j++){
						$name_field_request = strtolower($user_groups[$i]["name"]."_".$permission_types[$j]["title"]);
						$name_field_request = str_replace(" ", "_", $name_field_request);
						if(isset($_REQUEST[$name_field_request])) $info[$permission_types[$j]["title"]] = $_REQUEST[$name_field_request];
						else $info[$permission_types[$j]["title"]] = "0";
					}
					$data[$user_groups[$i]["name"]] = $info;
                }
				$data = json_encode($data);
				$data_to_save = array();
				$data_to_save["menu_items_id"] = "'".$_REQUEST["id"]."'";
				$data_to_save["string_name"] = "'".$_REQUEST["string_name"]."'";
				$data_to_save["permissions_params"] = "'".$data."'";
				$result = $db->Add("".$this->configuration->table_prefix."menu_items_extra_data", $data_to_save, @$_SESSION["token"]);
				$this->ShowList();
			}else{
				$this->ShowList();
			}
		}
		// Show list of recipes
			public function ShowList(){
				//++ Filters
					$filters = "";
					if(@$_REQUEST["menu_filter"]) $menu_filter = @$_REQUEST["menu_filter"]; else $menu_filter = @$_REQUEST["menu_filter"] = "1";
					
					$filters = " AND mi.menus_id = '$menu_filter' ";
					
				//--
				$db = DataBase::getInstance();
				$sql = "SELECT mi.id, mi.title, mi.parent_id, '' as parent_title, mit.name as menu_item_type_name, m.name as menu_name, mi.order
						FROM ".$this->configuration->table_prefix."menu_items as mi
						JOIN ".$this->configuration->table_prefix."menu_item_type as mit
						JOIN ".$this->configuration->table_prefix."menus as m
						WHERE mit.id = mi.menu_item_type_id AND m.id = mi.menus_id AND mi.parent_id = '' $filters
						UNION
						SELECT mi.id, mi.title, mi.parent_id, mi2.title as parent_title, mit.name as menu_item_type_name, m.name as menu_name, mi.order
						FROM ".$this->configuration->table_prefix."menu_items as mi
						JOIN ".$this->configuration->table_prefix."menu_item_type as mit
						JOIN ".$this->configuration->table_prefix."menus as m
						JOIN ".$this->configuration->table_prefix."menu_items as mi2
						WHERE mit.id = mi.menu_item_type_id AND m.id = mi.menus_id AND mi.parent_id = mi2.id $filters
						ORDER BY parent_id ASC, `order` ASC";
				$info = $db->PersonalSql($sql, @$_SESSION["token"]);
				$this->view->ListItems($info);
			}
    }
?>