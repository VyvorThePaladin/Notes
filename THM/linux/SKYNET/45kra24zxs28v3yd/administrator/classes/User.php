<?php
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class User{
		private static $instance;
		public function User(){ }
		public static function getInstance() {
			if (self::$instance == NULL) { self::$instance = new User(); } 
			return self::$instance;
		}
		public function CreateUserSession($user, $password, $access_type = "admin_login"){
			$configuration = new Configuration();
			$security = Security::getInstance();
			$db = DataBase::getInstance();
			$sql = "SELECT id, name, email, username, user_group_id FROM ".$configuration->table_prefix."users AS u WHERE enabled = '1' AND username = '".mysql_real_escape_string($_REQUEST["user"])."' AND password = MD5('".mysql_real_escape_string($_REQUEST["password"])."')";
			$result = $db->PersonalSql($sql, $security->token);
			if($result == 1 || !$result) return;
			$access = $this->GetAccessTypes(@$result[0]["user_group_id"]);
			if(@$access[$access_type]){
				@session_start();
				$_SESSION["id"] = $result[0]["id"];
				$_SESSION["name"] = $result[0]["name"];
				$_SESSION["email"] = $result[0]["email"];
				$_SESSION["username"] = $result[0]["username"];
				$_SESSION["user_group_id"] = $result[0]["user_group_id"];
				$_SESSION["user_group_name"] = $access["name"];
				$_SESSION["admin_login"] = $access["admin_login"];
				$_SESSION["super_admin_login"] = $access["super_admin_login"];
			}
		}
		public function DestroyUserSession(){
			@session_start();
			@session_destroy();
			header ("Location: index.php");
		}
		public function GetAccessTypes($user_group_id){
			if(!$user_group_id) return;
			$configuration = new Configuration();
			$db = DataBase::getInstance();
			$result = $db->GetRow($configuration->table_prefix."user_groups","id = $user_group_id AND enabled = 1",$_SESSION["token"]);
			$array = array();
			$array["name"] = $result["name"];
			$array["super_admin_login"] = $result["super_admin_login"];
			$array["admin_login"] = $result["admin_login"];
			$array["site_login"] = $result["site_login"];
			return $array;
		}
		// reference can be id or string
		public function GetPermissionsValue($reference, $permissions_type){		
			$configuration = new Configuration();
			if(@$_SESSION["super_admin_login"] == "1"){
				return 1;
			}else if(is_numeric($reference)){
				if(!isset($_SESSION["user_group_name"])) return;
				$db = DataBase::getInstance();
				$result = $db->GetRow($configuration->table_prefix."menu_items_extra_data","menu_items_id = '$reference'",$_SESSION["token"]);
				$result = json_decode($result["permissions_params"]);
				@$result = $result->$_SESSION["user_group_name"]->$permissions_type;
				return $result;
			}else{
				if(!isset($_SESSION["user_group_name"])) return;
				$db = DataBase::getInstance();
				$result = $db->GetRow($configuration->table_prefix."menu_items_extra_data","string_name = '$reference'",$_SESSION["token"]);
				$result = json_decode($result["permissions_params"]);
				@$result = $result->$_SESSION["user_group_name"]->$permissions_type;
				return $result;
			}
		}
	}
?>