<?php
class PageController {
    public function about_us() {
		global $db;
		global $elhash;
		global $session;
		global $settings;
		global $url_mapper;
		global $addthis_info;
		global $analytics_info;
		if ($session->is_logged_in() != true ) {
			if ($settings['public_access'] == '1') {
				$current_user = User::get_specific_id(1000);
			} else {
				redirect_to($url_mapper['login/']); 
			}
		} else {
			$current_user = User::get_specific_id($session->admin_id);
		}
		
		$group = $current_user->prvlg_group;
		
		if(!isset($settings['site_lang'])) { $settings['site_lang'] = 'English'; }
		require_once(LIBRARY_PATH ."lang/lang.{$settings['site_lang']}.php");
		require_once(VIEW_PATH . 'pages/about_us.php');
    }
	
	public function contact_us() {
		global $db;
		global $elhash;
		global $session;
		global $settings;
		global $url_mapper;
		global $addthis_info;
		global $analytics_info;
		global $captcha_info;
		if ($session->is_logged_in() != true ) {
			if ($settings['public_access'] == '1') {
				$current_user = User::get_specific_id(1000);
			} else {
				redirect_to($url_mapper['login/']); 
			}
		} else {
			$current_user = User::get_specific_id($session->admin_id);
		}
		
		$group = $current_user->prvlg_group;
		
		if(!isset($settings['site_lang'])) { $settings['site_lang'] = 'English'; }
		require_once(LIBRARY_PATH ."lang/lang.{$settings['site_lang']}.php");
		require_once(VIEW_PATH . 'pages/contact_us.php');
    }
	
	public function privacy_policy() {
		global $db;
		global $elhash;
		global $session;
		global $settings;
		global $url_mapper;
		global $addthis_info;
		global $analytics_info;
		if ($session->is_logged_in() != true ) {
			if ($settings['public_access'] == '1') {
				$current_user = User::get_specific_id(1000);
			} else {
				redirect_to($url_mapper['login/']); 
			}
		} else {
			$current_user = User::get_specific_id($session->admin_id);
		}
		
		$group = $current_user->prvlg_group;
		
		if(!isset($settings['site_lang'])) { $settings['site_lang'] = 'English'; }
		require_once(LIBRARY_PATH ."lang/lang.{$settings['site_lang']}.php");
		require_once(VIEW_PATH . 'pages/privacy_policy.php');
    }
	
	public function terms() {
		global $db;
		global $elhash;
		global $session;
		global $settings;
		global $url_mapper;
		global $addthis_info;
		global $analytics_info;
		
		if ($session->is_logged_in() != true ) {
			if ($settings['public_access'] == '1') {
				$current_user = User::get_specific_id(1000);
			} else {
				redirect_to($url_mapper['login/']); 
			}
		} else {
			$current_user = User::get_specific_id($session->admin_id);
		}
		
		$group = $current_user->prvlg_group;
		
		if(!isset($settings['site_lang'])) { $settings['site_lang'] = 'English'; }
		require_once(LIBRARY_PATH ."lang/lang.{$settings['site_lang']}.php");
		require_once(VIEW_PATH . 'pages/terms.php');
    }
	
	public function error() {
		$title = '404 Page Not Found';
		require_once('views/pages/error.php');
    }
  }
?>