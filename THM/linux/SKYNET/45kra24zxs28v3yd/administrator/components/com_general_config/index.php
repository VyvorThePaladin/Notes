<?php 
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	if(@$_REQUEST["task"] == "save"){
		$contentToSave = "<?php \n	class Configuration{";
		$contentToSave .= "\n";
		$contentToSave .= '		public $host = "'.$_REQUEST["host"].'";';
		$contentToSave .= "\n";
		$contentToSave .= '		public $db = "'.$_REQUEST["db"].'";';
		$contentToSave .= "\n";
		$contentToSave .= '		public $user = "'.$_REQUEST["user"].'";';
		$contentToSave .= "\n";
		$contentToSave .= '		public $password = "'.$_REQUEST["password"].'";';
		$contentToSave .= "\n";
		$contentToSave .= '		public $table_prefix = "'.$_REQUEST["table_prefix"].'";';
		$contentToSave .= "\n";
		$contentToSave .= '		public $administrator_template = "'.$_REQUEST["administrator_template"].'";';
		$contentToSave .= "\n";
		$contentToSave .= '		public $list_limit = '.$_REQUEST["list_limit"].';';
		$contentToSave .= "\n";
		$contentToSave .= '		public $token = "'.$_REQUEST["token"].'";';
		$contentToSave .= "\n";
		$contentToSave .= '		public $allowed_extensions = "'.$_REQUEST["allowed_extensions"].'";';
		$contentToSave .= "\n";
		$contentToSave .= '		public $upload_default_path = "'.$_REQUEST["upload_default_path"].'";';
		$contentToSave .= "\n";
		$contentToSave .= '		public $maximum_file_size = "'.$_REQUEST["maximum_file_size"].'";';
		$contentToSave .= "\n";
		$contentToSave .= '		public $secure_login = '.@$_REQUEST["secure_login"].';';
		$contentToSave .= "\n";
		$contentToSave .= '		public $secure_login_value = "'.$_REQUEST["secure_login_value"].'";';
		$contentToSave .= "\n";
		$contentToSave .= '		public $secure_login_redirect = "'.$_REQUEST["secure_login_redirect"].'";';
		$contentToSave .= "\n	} \n?>";		
		$fp = fopen("Configuration.php","w");
		fwrite($fp, $contentToSave); 
		fclose($fp);
		echo '<meta http-equiv="Refresh" content="0; url=index.php">';
		return;
	}else  if(@$_REQUEST["task"] == "cancel"){
		echo '<meta http-equiv="Refresh" content="0; url=index.php">';
		return;
	}
?>
<h1><img src="templates/default/images/template/icons/config_32.png" align="top" /> General Configuration</h1>
<div class="frame">
	 <form id="form" action="" method="post" class="form">
		<fieldset style="border:1px dotted #CCCCCC;">
	        <legend>Database Settings</legend>
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form">
                    <tr>
                        <td style="width:180px; font-weight:normal"">Host</td>
                        <td style="width:160px;"><input style="width:100%" class="text_field required" title=" " id="host" name="host" value="<?php echo $configuration->host ?>" /></td>
                    	<td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight:normal">Database Name</td>
                        <td><input style="width:100%" class="text_field required" title=" " id="db" name="db" value="<?php echo $configuration->db ?>" /></td>
                    	<td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight:normal">User</td>
                        <td><input style="width:100%" class="text_field required" title=" " id="user" name="user" value="<?php echo $configuration->user ?>" /></td>
                    	<td></td>
                    </tr>
                    <tr>
                        <td style="font-weight:normal">Password</td>
                        <td><input style="width:100%" class="text_field" id="password" name="password" value="<?php echo $configuration->password ?>" /></td>
                    	<td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight:normal">Database Tables Prefix</td>
                        <td><input style="width:100%" class="text_field" id="table_prefix" name="table_prefix" value="<?php echo $configuration->table_prefix ?>" /></td>
                    	<td>&nbsp;</td>
                    </tr>
                </table>
        </fieldset>
        <div style="height:20px;"></div>
        <fieldset style="border:1px dotted #CCCCCC;">
	        <legend>File Settings</legend>
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form">
                    <tr>
                        <td style="width:180px; font-weight:normal"">Allowed Extensions</td>
                        <td style="width:160px;"><input style="width:100%" class="text_field required" title=" " id="allowed_extensions" name="allowed_extensions" value="<?php echo $configuration->allowed_extensions ?>" /></td>
                    	<td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight:normal">Upload Default Path</td>
                        <td><input style="width:100%" class="text_field required" title=" " id="upload_default_path" name="upload_default_path" value="<?php echo $configuration->upload_default_path ?>" /></td>
                    	<td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight:normal">Maximum File Size</td>
                        <td><input style="width:100%" class="text_field required" title=" " id="maximum_file_size" name="maximum_file_size" value="<?php echo $configuration->maximum_file_size ?>" /></td>
                    	<td><font style="font-weight:normal; color:#FF0000; font-style:italic">Bytes, (1 Mg = 1048576 Bytes )</font></td>
                    </tr>
                </table>
        </fieldset>
        <div style="height:20px;"></div>
        <fieldset style="border:1px dotted #CCCCCC;">
	        <legend>Other Settings</legend>
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form">
                    <tr>
                        <td style="width:180px; font-weight:normal"">Default Administrator Template</td>
                        <td style="width:160px"><input style="width:100%" class="text_field required" title=" " id="administrator_template" name="administrator_template" value="<?php echo $configuration->administrator_template ?>" /></td>
						<td>&nbsp;</td>
                    </tr>
					<tr>
						<td style="font-weight:normal">Default List Limit</td>
						<td><input style="width:100%" class="text_field required" title=" " id="list_limit" name="list_limit" value="<?php echo $configuration->list_limit ?>" /></td>
						<td>&nbsp;</td>
                    </tr>
                    <tr>
						<td style="font-weight:normal">Token</td>
						<td><input style="width:100%" class="text_field" id="token" name="token" value="<?php echo $configuration->token ?>" /></td>
						<td><font style="font-weight:normal; color:#FF0000; font-style:italic">If this is blank, the token is generated automatically</font></td>
                    </tr>
                    <tr>
						<td style="font-weight:normal">Secure Login ( Pass GET Value )</td>
						<td>
                        	<table style="width:100%; margin:0px; padding:0px;" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:65px; padding:0px;">
                                        <select style="width:55px" id="secure_login" name="secure_login">
                                            <option value="0">Off</option>
                                            <option value="1">On</option>
                                        </select>
									</td>
                                    <td style="width:35px; padding:0px;">value:</td>
                               		<td style="padding:0px;"><input style="width:100%" type="text" id="secure_login_value" name="secure_login_value" value="<?php echo $configuration->secure_login_value ?>" /></td>
                                </tr>
                            </table>
						</td>
                        <td><font style="font-weight:normal; color:#FF0000; font-style:italic">Security improve at start session. To start session you should pass a additional param by the URL, example: <b>http://www.dominio.com/administrator/?secure=value</b></font></td>
					</tr>
                    <tr>
						<td style="font-weight:normal">Secure Login Failed ( Redirect URL )</td>
						<td><input style="width:100%" type="text" id="secure_login_redirect" name="secure_login_redirect" value="<?php echo $configuration->secure_login_redirect ?>" /></td>
						<td><font style="font-weight:normal; color:#FF0000; font-style:italic">If the GET value is wrong redirect to?</font></td>
                    </tr>
                </table>
        </fieldset>
        <div style="height:20px;"></div>
        <input class="button_form" type="button" value="Update" onclick="SubminForm('save')" />
        <input class="button_form" type="button" value="Cancel" onclick="SubminForm('cancel')" />
     	<input type="hidden" name="option" id="option" value="<?php echo $_REQUEST["option"]; ?>" />
        <input type="hidden" name="task" id="task" />
     </form>
</div>
<script>
	function SubminForm(task){
		jQuery('#task').attr('value',task);
		if(task == "cancel"){ document.forms["form"].submit(); return; }
		$('#form').submit();
	}
	jQuery().ready(function(){ jQuery("#form").validate(); });

	// Auto selected items
	jQuery("#secure_login option[value=<?php echo $configuration->secure_login ?>]").attr("selected",true);
</script>