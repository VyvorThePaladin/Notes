<?php
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	ini_set("include_path", "components/com_table_manager/"); 
	require("views/Admin_Table.php");
	
	class Admin_Table_Controller{		
		private $view;
		private $configuration;
		public function Admin_Table_Controller(){
			$this->view = new Admin_Table_View();
			$this->configuration = new Configuration();
			//print_r($_REQUEST);
			
			if(@$_REQUEST["task"] == "new" || @$_REQUEST["task"] == "edit"){
				$db = DataBase::getInstance();
				$field_types = $db->GetList("".$this->configuration->table_prefix."tables", @$_SESSION["token"], "table_name = '".$_REQUEST["view"]."'");
				$field_types = json_decode($field_types[0]["params"]);
				$table_name = $_REQUEST["view"];
				if($_REQUEST["task"] == "edit"){ 
					if(is_array($_REQUEST["id"])) $_REQUEST["id"] = $_REQUEST["id"][0];
					if($_REQUEST["id"] == "session") $_REQUEST["id"] = $_SESSION["id"];
					$info = $db->GetRow($_REQUEST["view"], $field_types->primary_key."='".@$_REQUEST["id"]."'", @$_SESSION["token"]);
				}else{ $_REQUEST["id"] = "0";  }
				$infoColumbs = $db->GetColums($table_name, @$_SESSION["token"]);
				$this->view->AddItem(@$info, $infoColumbs, $field_types);
			}else if(@$_REQUEST["task"] == "save"){
				$db = DataBase::getInstance();
				$infoColumbs = $db->GetColums($_REQUEST["view"], @$_SESSION["token"]);
				$data_to_save = array();
				for($i = 0; $i < count($infoColumbs); $i++){ 
					$data_to_save[$infoColumbs[$i]] = "'".mysql_real_escape_string(@$_REQUEST[$infoColumbs[$i]."_field"])."'";
				}
				$db->Add($_REQUEST["view"], $data_to_save, @$_SESSION["token"]);
				$this->ShowList();
			}else if(@$_REQUEST["task"] == "delete"){
				$db = DataBase::getInstance();
				$field_types = $db->GetList("".$this->configuration->table_prefix."tables", @$_SESSION["token"], "table_name = '".$_REQUEST["view"]."'");
				$field_types = json_decode($field_types[0]["params"]);
				for($i = 0; $i < count($_REQUEST["id"]); $i++){ $db->Delete($_REQUEST["view"], $field_types->primary_key."='".$_REQUEST["id"][$i]."'", @$_SESSION["token"]); }
				$this->ShowList();
			}else{
				$this->ShowList();
			}
		}
		// Show list of recipes
			public function ShowList(){
				// Paginator 
					$currentPage = 0; if(@$_REQUEST["page"]) $currentPage = $_REQUEST["page"] - 1;
					$limit = ($currentPage*$this->configuration->list_limit) . "," . ($this->configuration->list_limit);
				// List
				$db = DataBase::getInstance();
				$info = $db->GetList($_REQUEST["view"], @$_SESSION["token"], "", $limit);
				$infoColumns = $db->GetColums($_REQUEST["view"], @$_SESSION["token"]);
				$field_types = $db->GetList("".$this->configuration->table_prefix."tables", @$_SESSION["token"], "table_name='".$_REQUEST["view"]."'");
				$field_types = json_decode($field_types[0]["params"]);
				$this->view->ListItems($info, $infoColumns, $field_types);
			}
    }
?>