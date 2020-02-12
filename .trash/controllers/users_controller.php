<?php
  class UsersController {
    public function view($id) {
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
		
		if(!$current_user->can_see_this('users.read',$group)) {
			$msg = $lang['alert-restricted'];
			redirect_to($url_mapper['index/']."?edit=fail&msg={$msg}");
			exit();
		}
		
		if($id) {
			$page = "users.read";
			$title = 'Users';
			require_once(VIEW_PATH . 'users/users.php');
		} else {
			redirect_to($url_mapper['error/404/']);
		}
		
    }
  }
?>