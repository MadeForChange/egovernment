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
			} else {
				redirect_to($url_mapper['login/']); 
			}
		} else {
			$current_user = User::get_specific_id($session->admin_id);
		}
		$group = $current_user->prvlg_group;
		if(!isset($settings['site_lang'])) { $settings['site_lang'] = 'English'; }
		require_once(LIBRARY_PATH ."lang/lang.{$settings['site_lang']}.php");
		
		$page = "index.read";
		$title = 'Index';
		require_once(VIEW_PATH . 'pages/index.php');
	}
    
	public function ad($id) {
		global $url_mapper;
		if(!AdManager::check_id_existance($id)) {
			redirect_to($url_mapper['error/404/']);
		}
		$ad = AdManager::get_specific_id($id);
		$ad->click();
		require_once(VIEW_PATH . '/pages/ad.php');
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
		$page = "index.read";
		$title = '404 Page Not Found';
		require_once('views/pages/error.php');
    }
  }
?>