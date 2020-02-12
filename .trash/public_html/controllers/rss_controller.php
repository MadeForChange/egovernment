<?php
  class RssController {
    public function run() {
		global $url_mapper;
		$query = "";
		$title = "RSS Feed";
		$questions = Question::get_everything($query, ' ORDER BY id DESC ');
		require_once(VIEW_PATH . 'pages/rss.php');
    }
	public function user($id) {
		global $db;
		global $url_mapper;
		$title = "RSS Feed";
		$query = "";
		if($id && User::check_id_existance($id)) {
			$query = " AND user_id= '" . $db->escape_value($id) . "' ";
			$user = User::get_specific_id($id);
			$title .= " for user ({$user->f_name} {$user->l_name})";
		}
		$questions = Question::get_everything($query, ' ORDER BY id DESC ');
		require_once(VIEW_PATH . 'pages/rss.php');
    }
	public function feed($id) {
		global $db;
		global $url_mapper;
		$query = "";
		
		$feedreq = $db->escape_value($id);
		$query = " AND feed LIKE '%{$feedreq}%' ";
		$title = "RSS Feed for subject ({$feedreq}) ";
		
		$questions = Question::get_everything($query, ' ORDER BY id DESC ');
		require_once(VIEW_PATH . 'pages/rss.php');
    }
	
	public function question($id) {
		global $db;
		global $url_mapper;
		$query = "";
		
		if($id && Question::check_id_existance($id)) {
			$question = Question::get_specific_id($id);
			$title = "RSS Feed for question ({$question->title}) ";
			$query = " AND id = {$id} ";
			$questions = Question::get_everything($query, ' ORDER BY id DESC ');
			$answers = Answer::get_answers_for($id);
		} else {
			$title = "RSS Feed";
			$questions = Question::get_everything($query, ' ORDER BY id DESC ');
		}
		
		require_once(VIEW_PATH . 'pages/rss.php');
    }
  }
?>