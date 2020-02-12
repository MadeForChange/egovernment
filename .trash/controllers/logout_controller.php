<?php
class LogoutController {
	public function run() {
		global $db;
		global $session;
		global $settings;
		global $url_mapper;
		if ($session->is_logged_in() != true ) {
			redirect_to($url_mapper['index/']); 
		}
		require_once('views/pages/logout.php');
	}

	public function error() {
		$page = "index.read";
		require_once('views/login/error.php');
	}
}
?>