<?php 
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class Text{
		private $required;
		private $config;
		private $errorMessage;
		public $urlConfig = "../components/com_table_manager/fields/config/Text.php";
		
		public function GetItem($name = "input", $value = "", $config = NULL, $required = false, $errorMessage = "", $eventsString = ""){
			$this->required = $required;
			$this->config = json_decode($config);
			$this->errorMessage = $errorMessage; if(!$errorMessage) $this->errorMessage = " ";
			$field = "<input $eventsString id='".$name."' name='".$name."' value='$value' ";
				if($this->config->type != "password") $field.= " type='text' ";
				else $field.= " type='password' ";
			$field .= " class='text_field "; 
				if($this->config->type == "email")	if($required) $field .= " email ";
				if($this->config->type == "number")	if($required) $field .= " number ";
				if($required) $field .= " required ";
			$field .= " ' ";
			$field.= " title='$this->errorMessage' ";
				if(@$this->config->encode == "md5") $field.= " onchange='Encode(this, \"md5\")' ";
				if(@$this->config->encode == "sha1") $field.= " onchange='Encode(this, \"sha1\")' ";
			$field.= " /> ";
			return $field;
		}
	}
?>
<script>
	function Encode(item, type){
		var value = jQuery(item).val();
		if(type == "md5") var encode = jQuery.md5(value);
		else if(type == "sha1") var encode = jQuery.sha1(value);
		jQuery(item).val(encode);
	}
</script>