<?php
class LoginController {
	public function run() {
		global $db;
		global $session;
		global $settings;
		global $url_mapper;
		global $captcha_info;
		global $facebook_api;
		global $google_api;
		if ($session->is_logged_in() == true ) {
			redirect_to($url_mapper['index/']); 
		}
		if(!isset($settings['site_lang'])) { $settings['site_lang'] = 'English'; }
		require_once(LIBRARY_PATH ."lang/lang.{$settings['site_lang']}.php");
		$elhash_login = "ScU8rNKXHGGyYDh4voHu";
		require_once('views/login/login.php');
	}

	public function error() {
		require_once('views/login/error.php');
	}
}
?>