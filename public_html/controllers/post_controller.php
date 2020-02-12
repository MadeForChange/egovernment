<?php
  class PostController {
    public function create() {
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
		
		if(!$current_user->can_see_this('post.read',$group)) {
			$msg = $lang['alert-restricted'];
			redirect_to($url_mapper['index/']."?edit=fail&msg={$msg}");
			exit();
		}
		
		$title = 'Submit New Question';
		require_once(VIEW_PATH . 'post/create.php');
    }

    public function read($q_slug) {
		
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
		
		if(!$current_user->can_see_this('questions.read',$group)) {
			$msg = $lang['alert-restricted'];
			redirect_to($url_mapper['index/']."?edit=fail&msg={$msg}");
			exit();
		
		}
		if($q_slug) {
			$title = 'Read Question';
			require_once(VIEW_PATH . 'post/read.php');
		} else {
			redirect_to($url_mapper['error/404/']); 
		}
		
    }
	
	public function update($q_slug) {
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
		
		if(!$current_user->can_see_this('questions.update',$group)) {
			$msg = $lang['alert-restricted'];
			redirect_to($url_mapper['index/']."?edit=fail&msg={$msg}");
			exit();
		}
			
			if($_GET['hash'] != $_SESSION[$elhash] ) {
				redirect_to($url_mapper['index/']);
			}
			
			$edit_mode = true;
			
		if($q_slug) {
			$title= "Update Question";
			require_once(VIEW_PATH . 'post/update.php');
		} else {
			redirect_to($url_mapper['error/404/']); 
		}
		
    }

    public function delete($q_slug) {
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
		
		
			if($_GET['hash'] != $_SESSION[$elhash] ) {
				redirect_to($url_mapper['index/']);
			}
			
		if($q_slug) {
			
			if(URLTYPE == 'id') {
				$q = Question::get_specific_id($q_slug);
			} else {
				$q = Question::get_slug($q_slug);
			}
			
			if(!$current_user->can_see_this("questions.delete",$group)) {
				$msg = $lang['alert-restricted'];
				if(URLTYPE == 'slug') {$url_type = $q->slug;} else {$url_type = $q->id;}
				redirect_to($url_mapper['questions/view'].$url_type."&edit=fail&msg={$msg}");
			}
			
			if($q) {
				
				if($current_user->prvlg_group != '1' && $q->user_id != $current_user->id ) {
					$msg = $lang['alert-restricted'];
					if(URLTYPE == 'slug') {$url_type = $q->slug;} else {$url_type = $q->id;}
					redirect_to($url_mapper['questions/view'].$url_type."&edit=fail&msg={$msg}");
				}
				
				if($q->delete()) {
					
					//get assoc reports..
					$rep = Report::get_everything(" AND obj_type = 'question' AND obj_id = '{$q->id}' ");
					if($rep) {
						foreach($rep as $r) {
							$r->delete();
						}
					}
					$answers = Answer::get_answers_for($q->id,"");
					if($answers) {
						foreach($answers as $a) {
							$a->delete();							
							//get assoc reports..
							$rep = Report::get_everything(" AND obj_type = 'answer' AND obj_id = '{$a->id}' ");
							if($rep) {
								foreach($rep as $r) {
									$r->delete();
								}
							}
						}
					}
					
					
					$msg = $lang['alert-delete_success'];
					redirect_to($url_mapper['questions/create']."&edit=success&msg={$msg}");
				} else {
					$msg = $lang['alert-delete_failed'];
					redirect_to($url_mapper['questions/create']."&edit=fail&msg={$msg}");
				}
			}
			
		} else {
			redirect_to($url_mapper['error/404/']); 
		}
		
    }

    
  }
?>