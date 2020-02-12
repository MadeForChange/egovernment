<?php

class User Extends OneClass {
	
	public static $table_name = "users";
	public static $db_fields = array( "id" , "f_name" , "l_name" , "prvlg_group", "password",  "email", "username" , "mobile" , "address", "comment" , "about" , "follows" , "avatar" ,"points","joined", "last_seen" , "intro"  ,  "disabled","deleted" , "ban_list" , "hybridauth_provider_name" , "hybridauth_provider_uid" , "mail_notif");
	
	public $id;
	public $f_name;
	public $l_name;
	public $username;
	public $comment;
	public $about;
	public $follows;
	public $password;
	public $prvlg_group;
	public $name;
	public $email;
	public $mobile;
	public $address;
	public $disabled;
	public $points;
	public $deleted;
	public $avatar;
	public $joined;
	public $last_seen;
	public $intro;
	public $ban_list;
	public $hybridauth_provider_name;
	public $hybridauth_provider_uid;
	public $mail_notif;
	
	
	
	public static function find_username($needle="" , $id=0 , $string="") {
	global $db;
	return static::preform_sql("SELECT * FROM " .  DBTP. self::$table_name  ." WHERE username LIKE '{$needle}%' AND id != '{$id}' " . $string . " " );
	}

	public static function hash_authenticate($username="") {
	global $db;
	$username = $db->escape_value($username);
	
	$sql = "SELECT * FROM  " . DBTP . self::$table_name ;
	$sql .= " WHERE email = '{$username}' ";
	$sql .= "AND deleted='0' ";
	$sql .= "LIMIT 1" ;
	$result_array =  self::preform_sql($sql);
	return (!empty($result_array)) ? array_shift($result_array) : false;
	}

	public static function authenticate($username="", $password="") {
	global $db;
	$username = $db->escape_value($username);
	$password = $db->escape_value($password);

	$sql = "SELECT * FROM  " . DBTP . self::$table_name ;
	$sql .= " WHERE username = '{$username}' ";
	$sql .= "AND password = '{$password}' ";
	$sql .= "AND deleted='0' ";
	$sql .= "LIMIT 1" ;
	$result_array =  self::preform_sql($sql);
	return (!empty($result_array)) ? array_shift($result_array) : false;
	}

	
	public static function get_for_hybridauth($provider="",$identifier="") {
	global $db;
	
	$sql = "SELECT * FROM  " . DBTP . self::$table_name ;
	$sql .= " WHERE hybridauth_provider_uid = '{$identifier}' ";
	$sql .= "AND hybridauth_provider_name = '{$provider}' ";
	$sql .= "AND deleted='0' ";
	$sql .= "LIMIT 1" ;
	$result_array =  self::preform_sql($sql);
	return (!empty($result_array)) ? array_shift($result_array) : false;
	}

	
	public static function can_see_this($sent_item=0,$sent_group=0) {
		global $db;
		$item = $db->escape_value($sent_item);
		$group = $db->escape_value($sent_group);
		$group_query = Group::get_specific_id($group);
		$group_privileges = $group_query->privileges;
		
		$pos = strpos($group_privileges,$item);

		if($pos === false) {
			return false;
		}
		else {
			return true;
		}	
	}
	
	public function can_receive_this($sent_item=0) {
		global $db;
		$item = $db->escape_value($sent_item);
		$group_privileges = $this->mail_notif;
		
		$pos = strpos($group_privileges,$item);

		if($pos === false) {
			return false;
		}
		else {
			return true;
		}	
	}
	
	public function award_points($awardedpoints = 1) {
		global $db;
		$this->points += $awardedpoints;
		if ($this->update()) { return true; } else { return false; }
	}
	
	public function set_online() {
		global $db;
		$this->last_seen = time();
		if ($this->update()) { return true; } else { return false; }
	}
	
	public static function get_users_for_group_except($id=0,$query="", $string="") {
	global $db;
	global $current_user;
	return self::preform_sql("SELECT * FROM " . DBTP . self::$table_name ." WHERE id != {$current_user->id} AND prvlg_group = '" . $id . "' AND deleted = 0 " . $query . " ORDER BY f_name DESC " . $string." ");
	}
	
	public static function get_users_for_group($id=0,$query="", $string="") {
	global $db;
	return self::preform_sql("SELECT * FROM " . DBTP . self::$table_name ." WHERE prvlg_group = '" . $id . "' AND deleted = 0 " . $query . " ORDER BY f_name DESC " . $string." ");
	}
	
	public static function get_users($query="", $string="") {
	global $db;
	return self::preform_sql("SELECT * FROM " . DBTP . self::$table_name ." WHERE deleted = 0 " . $query . " ORDER BY f_name ASC " . $string." ");
	}
	
	public static function get_chat($ban_list="") {
	global $db;
	global $current_user;
	$time = strtotime('-5 Minutes' , time());
	$id_str = str_replace('-' , '' , $ban_list);
	if($id_str) {
		$id_str .= "," . $current_user->id;
	} else {
		$id_str = $current_user->id;
	}
	
	return self::preform_sql("SELECT * FROM " . DBTP . self::$table_name ." WHERE deleted = 0 AND last_seen >= '{$time}' AND id NOT IN ({$id_str}) ORDER BY f_name ASC ");
	}
	
	
	public static function check_existance_except($column="" , $value="" , $id="" , $extra="") {
	global $db;
	$column = $db->escape_value($column);
	$value = $db->escape_value($value);
	
	$sql = "SELECT * FROM  " . DBTP . self::$table_name;
	$sql .= " WHERE {$column} = '{$value}' ";
	$sql .= " AND id != '{$id}' {$extra} ";
	$sql .= " AND deleted= 0 ";
	$sql .= "LIMIT 1" ;
	$result_array =  $db->query($sql);
	return $db->num_rows($result_array) ? true : false;
	}
	
	public function get_avatar() {
		global $db;
		if($this->avatar) {
			$img = File::get_specific_id($this->avatar);
			$dev_avatar = WEB_LINK."public/".$img->image_path();
			$dev_avatar_path = UPLOAD_PATH."/".$img->image_path();
			if (!file_exists($dev_avatar_path)) {
				$dev_avatar = WEB_LINK.'public/img/avatar.png';
			}
		} else {
			$dev_avatar = WEB_LINK.'public/img/avatar.png';
		}
		return $dev_avatar;
	}
	
}
	
?>