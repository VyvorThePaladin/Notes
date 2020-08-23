<?php
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class Menu{
		private static $instance;
		private $database;
		private $user_validate_permissions;
		
		private function Menu(){ 
			$this->database = DataBase::getInstance();
		}
		public static function getInstance() {
			if (self::$instance == NULL) { self::$instance = new Menu(); } 
			return self::$instance;
		}
		// Functions
			public function GetListMenu($menu_name, $token = 0, $user_validate_permissions = true){
				$this->user_validate_permissions = $user_validate_permissions;
				
				$configuration = new Configuration();
				$sql = 	"SELECT mi.*, '' as table_name, m.name AS menu_name
						FROM ".$configuration->table_prefix."menu_items AS mi 
						JOIN ".$configuration->table_prefix."menus AS m 
						WHERE mi.menus_id = m.id AND m.name = '$menu_name' ORDER BY mi.order ASC";
				$result = $this->database->PersonalSql($sql, $token);
				if($result != 0 && $result != 1){
					return  $this->CreateMenu($result);
				}
				return 0;
			}
			private function CreateMenu($data){
				if($this->user_validate_permissions)  $user = User::getInstance();
				$field = '<ul>';
				for($i = 0; $i < count($data); $i++){
					if($data[$i]["parent_id"] == "0"){
						// Permiisions validate
						if($this->user_validate_permissions){
							if($user->GetPermissionsValue($data[$i]["id"],"consult")){
								$field .= '<li><div class="menu_divider menu_divider_'.$i.'"></div></li>';
								$field .= $this->GetItemType($i, $data, true);
							}
						}else{
							$field .= '<li><div class="menu_divider menu_divider_'.$i.'"></div></li>';
							$field .= $this->GetItemType($i, $data, true);
						}
					}
				}
				$field .= '<li><div class="menu_divider menu_divider_'.$i.'"></div></li>';
				$field .= '</ul>';
				return $field;
			}
			private function GetSubMenu($id, $data){
				if($this->user_validate_permissions) $user = User::getInstance();
				$countItems = 0;
				for($j = 0; $j < count($data); $j++){
					// Permiisions validate
					if($this->user_validate_permissions){
						if($user->GetPermissionsValue($data[$j]["id"],"consult")){
							if($data[$j]["parent_id"] == $id) $countItems++;
						}
					}else{
						if($data[$j]["parent_id"] == $id) $countItems++;
					}
				}
				$field = '<ul>';
				$itemAdded = 0;
				for($j = 0; $j < count($data); $j++){
					// Permiisions validate
					if($this->user_validate_permissions){
						if($user->GetPermissionsValue($data[$j]["id"],"consult")){
							if($data[$j]["parent_id"] == $id){
								$field .= $this->GetItemType($j, $data, false);
								$itemAdded++;
								if($itemAdded < $countItems) $field .= '<li><div class="menu_divider_horizontal menu_divider_horizontal'.$data[$j]["id"].'"></div></li>';
							}
						}
					}else{
						if($data[$j]["parent_id"] == $id){
							$field .= $this->GetItemType($j, $data, false);
							$itemAdded++;
							if($itemAdded < $countItems) $field .= '<li><div class="menu_divider_horizontal menu_divider_horizontal'.$data[$j]["id"].'"></div></li>';
						}
					}
				}
				$field .= '</ul>';
				if($field != "<ul></ul>") return $field;
				else return 0;
			}
			private function GetItemType($k, $data, $principal_menu = true){
				$json_value = json_decode($data[$k]["menu_item_params"]);
				$class = "menu_button"; if(!$principal_menu) $class = "sub_menu_item";
				$field = '<li>';
					if($data[$k]["menu_item_type_id"] == "1"){
						$field .= '<div class="'.$class.' '.$class.$data[$k]["id"].'">'.$data[$k]["title"].'</div>';
					}else if($data[$k]["menu_item_type_id"] == "2"){
						$field .= '<a href="?option=com_table_manager&view='.@$json_value->table_name.@$json_value->defined_task.'"><div style="cursor:pointer" class="'.$class.' '.$class.$data[$k]["id"].'">'.$data[$k]['title'].'</div></a>';
					}else if($data[$k]["menu_item_type_id"] == "3"){
						$field .= '<a href="?option='.@$json_value->component_name.'"><div style="cursor:pointer" class="'.$class.' '.$class.$data[$k]["id"].'">'.$data[$k]['title'].'</div></a>';
					}else if($data[$k]["menu_item_type_id"] == "4"){
						if(@$json_value->target == "iframe"){
							$field .= '<a onclick="SetBlockade(\'true\', \'\', 100, \'\', \'2\'); SetAlert(\'true\', \'alerts/alertIFrame.php\', \'\', \'width=900px&height=500px&url='.@$json_value->url.'\', \'ShowAlert\', \'3\')"><div style="cursor:pointer" class="'.$class.' '.$class.$data[$k]["id"].'">'.$data[$k]['title'].'</div></a>';
						}else{
							$field .= '<a  target="'.@$json_value->target.'" href="'.@$json_value->url.'"><div style="cursor:pointer" class="'.$class.' '.$class.$data[$k]["id"].'">'.$data[$k]['title'].'</div></a>';
						}
					}
					$subMenu = $this->GetSubMenu($data[$k]["id"], $data); if($subMenu) $field .= $subMenu;
				$field .= '</li>';
				return $field;
			}
	}
?>