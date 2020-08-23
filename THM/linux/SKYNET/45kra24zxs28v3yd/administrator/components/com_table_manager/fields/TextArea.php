<?php 
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class TextArea{
		private $required;
		private $config;
		private $errorMessage;
		public $urlConfig = "../components/com_table_manager/fields/config/TextArea.php";
		
		public function GetItem($name = "input", $value = "", $config = NULL, $required = false, $errorMessage = "", $eventsString = ""){
			$this->required = $required;
			$this->config = json_decode($config);
			$this->errorMessage = $errorMessage; if(!$errorMessage) $this->errorMessage = " ";
			$field = "<textarea style='width:".$this->config->width."px; height:".$this->config->height."px' $eventsString id='".$name."' name='".$name."' ";
			$field .= " class='text_field ";
			$field .= " ' ";
			$field.= " title='$this->errorMessage' ";
			if($this->config->editor == "tinymce") $field.= " style='width: 100%; height: 300px' ";
			$field.= " >";
			$field.= $value;
			$field.= "</textarea>";
			if($this->config->editor == "tinymce") echo "<script>GetTinyEditor('$name','".$this->config->width."','".$this->config->height."')</script>";
			return $field;
		}
	}
?>
<!--<input style="margin-left:10px;" />-->
<script type="text/javascript">
	function GetTinyEditor(name, width, height){
		tinyMCE.init({
			mode : "exact",
			elements : name,
			theme : "advanced",
			width : parseInt(width) + 11,
			height : height,
			plugins : "insertdatetime,preview,layer,table, fullscreen",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview, fullscreen,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,|,insertlayer,moveforward,movebackward,absolute",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing_use_cookie : false,
			theme_advanced_resizing : true
		});
	}
</script>