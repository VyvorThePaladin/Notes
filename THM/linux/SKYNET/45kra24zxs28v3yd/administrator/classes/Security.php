<?php
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class Security{
		private static $instance;
		private $sessionKey = "4EXvzeEwhVnvcrj5";
		public $token = "";
		
		public function Security(){ }
		public static function getInstance() {
			if (self::$instance == NULL) { self::$instance = new Security(); } 
			return self::$instance;
		}
		public function CreateSecurityData(){
			@session_start();
			$_SESSION['sessionKey'] = $this->sessionKey;
			if(!$this->token) $this->token = md5(rand(0,99999)); // md5(random)
			$_SESSION['token'] = $this->token;
			return $_SESSION['token'];
		}
		public function SecurityValidator($token = ""){
			@session_start();
			if (!isset ( $_SESSION['token']) || !isset ( $_SESSION['sessionKey'])) return false;
			if(trim($_SESSION['token']) != trim($token)) return false;
			return $_SESSION['token'];
		}
	}
?>
