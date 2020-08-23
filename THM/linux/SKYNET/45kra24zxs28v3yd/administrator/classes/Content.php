<?php
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class Content{
		private static $instance;
		private $database;
		private $configuration;
		
		private function Content(){ 
			$this->database = DataBase::getInstance();
		}
		public static function getInstance() {
			if (self::$instance == NULL) { self::$instance = new Content(); } 
			return self::$instance;
		}
		// Functions
			public function GetArticlesByCategory($value){
				if(is_numeric($value)){
					return $this->database->GetList("cu_articles", $_SESSION["token"], "categories_id = '$value'","", "id DESC");
				}else if(is_string($value)){
					$sql = "SELECT a.*, c.name as 'categories_name' FROM cu_articles as a JOIN cu_categories as c WHERE a.categories_id = c.id AND c.name = '$value' ORDER BY id DESC";
					return $this->database->PersonalSql($sql, $_SESSION["token"]);
				}
			}
			public function GetArticle($value){
				if(is_numeric($value)){
					return $this->database->GetRow("cu_articles","id = '$value'", $_SESSION["token"]);
				}else if(is_string($value)){
					return $this->database->GetRow("cu_articles","title = '$value'", $_SESSION["token"]);
				}
			}
	}
?>