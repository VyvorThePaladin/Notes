 <?php 
 	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class Select {
		private $name;
		private $value;
		private $eventsString;
		private $config;
		private $required;
		private $errorMessage;
		private $include_clear_item;
		public $urlConfig = "../components/com_table_manager/fields/config/Select.php";
		
		public function GetItem($name = "select", $value = "", $config = NULL, $required = false, $errorMessage = "", $eventsString = "", $include_clear_item = false){
			$this->name = $name;
			$this->value = $value;
			$this->config = json_decode($config);
			$this->required = $required;
			$this->errorMessage = $errorMessage; if(!$errorMessage) $this->errorMessage = " ";
			$this->eventsString = $eventsString;
			$this->include_clear_item = $include_clear_item;
			if(is_array($this->config)){
				return $this->ArrayType($this->config);
			}else{
				return $this->TableType($this->config->table_name, $this->config->data_column, $this->config->label_column);
			}
		}
		private function ArrayType($config){
			$field =  "<select name='$this->name' id='$this->name' $this->eventsString";
			if($this->required) $field.= " class='required' title='$this->errorMessage' ";
			$field.= ">";
			if($this->include_clear_item) $field .= "<option value=''></option>";
			for($i = 0; $i < count($config); $i++){
				if($this->value == $config[$i][0]) $field .= "<option value='".$config[$i][0]."' selected='selected'>".$config[$i][1]."</option>";
				else $field .= "<option value='".$config[$i][0]."'>".$config[$i][1]."</option>";
			}
			$field .= "</select>";
			return $field;
		}
		private function TableType($table_name, $data_column, $label_column){
			$db = DataBase::getInstance();
			$config = $db->GetList($table_name, $_SESSION["token"]);
			$field =  "<select name='$this->name' id='$this->name' $this->eventsString>";
			if($this->include_clear_item) $field .= "<option value=''></option>";
			if($config){
				for($i = 0; $i < count($config); $i++){
					if($this->value == $config[$i][$data_column]) $field .= "<option value='".$config[$i][$data_column]."' selected='selected'>".$config[$i][$label_column]."</option>";
					else $field .= "<option value='".$config[$i][$data_column]."'>".$config[$i][$label_column]."</option>";
				}
			}
			$field .= "</select>";
			return $field;
		}
	}
?>