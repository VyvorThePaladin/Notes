<?php 
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class Check{
		public function GetItem($name, $value = "", $config = NULL, $required = false, $errorMessage = "", $eventsString = ""){
			if(!$value) $value = "";
			if(!$errorMessage) $errorMessage = "";
			$field = "<input type='checkbox' title='$errorMessage' value='1' id='$name' name='$name' value='$value' $eventsString ";
			if($value) $field .= " checked='checked'";
			$field .= " class='text_field ";
			if($required) $field .= " required ";
			$field .= "' /> ";
			return $field;
		}
	}
?>