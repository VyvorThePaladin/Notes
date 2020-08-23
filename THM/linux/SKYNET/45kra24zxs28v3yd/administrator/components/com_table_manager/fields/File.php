<?php 
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class File{
		private $config;
		private $errorMessage;
		public $urlConfig = "../components/com_table_manager/fields/config/File.php";
		
		public function GetItem($name, $value = "", $config = NULL, $required = false, $errorMessage = "", $eventsString = ""){
			$configuration = new Configuration();
			if(!$value) $value = "";
			$this->errorMessage = $errorMessage; if(!$errorMessage) $this->errorMessage = " ";
			$this->config = json_decode($config);
			$field = "<div style='position:relative;'>";
			$field .= "<input style='position:relative; vertical-align:top; top:-1px;' type='text' $eventsString id='".$name."' name='".$name."' value='$value' onchange='UploadFile()' ";
			$field .= " readonly='readonly' class='text_field readonly"; 
				if($required) $field .= " required ";
			$field .= " ' ";
			$field .= " title='$this->errorMessage' ";
			$field .= " /> ";
			$field .= " <script>ConfigUploadFile('$name', '".@$this->config->folder."','".@$configuration->allowed_extensions."','".@$configuration->maximum_file_size."')</script>";
			$field .= "<input type='file' id='".$name."_upload' name='".$name."_upload' />";
			$field .= "</div>";
			return $field;
		}
	}
?>
<script>
	function ConfigUploadFile(name, folder, allowed_extensions, maximum_file_size){
		jQuery(document).ready(function() {
			jQuery('#' + name + "_upload").uploadify({
				'uploader'  : 'js/uploadify/uploadify.swf',
				'script'    : 'js/uploadify/uploadify.php',
				'cancelImg' : 'js/uploadify/cancel.png',
				'folder'    :  folder,
				'auto'      : true,
				'fileExt'   : allowed_extensions,
				'fileDesc'  : allowed_extensions,
				'sizeLimit' : maximum_file_size,
				'height'	: 25,
				'width'		: 93,
				'onComplete': function(event, ID, fileObj, response, data) {
					jQuery("#" + name).attr("value", folder +"/"+ fileObj.name);
			    }
			});
		});
	}
</script>