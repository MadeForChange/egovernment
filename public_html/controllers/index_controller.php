<?php require_once('library/pearls.php');
class IndexController {
    public function run(){
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
				redirect_to($url_mapper['egovernment']);
			} else {
				redirect_to($url_mapper['login/']); 
			}
		} else {    
			$current_user = User::get_specific_id($session->admin_id);
		}
		$group = $current_user->prvlg_group;
		if(!isset($settings['site_lang'])) { $settings['site_lang'] = 'English'; }
		require_once(LIBRARY_PATH ."lang/lang.{$settings['site_lang']}.php");
		
		$title = 'Please Zoom In | No Problem is Big';
	    require_once(VIEW_PATH . 'pages/index.php');

		
	}
    
	public function logout() {
		global $url_mapper;
		require_once(VIEW_PATH . '/pages/logout.php');
    }
	
	public function error() {
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
		
		$title = '404 Page Not Found';
		require_once('views/pages/error.php');
    }
  }
?>