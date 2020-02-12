<?php

class Chat Extends OneClass {
	
	public static $table_name = "chat";
	public static $db_fields = array( "id" , "sender" , "receiver" , "msg", "sent_at", "viewed");
	
	public $id;
	public $sender;
	public $receiver;
	public $msg;
	public $sent_at;
	public $viewed;
	
	public static function get_chatheads() {
		global $current_user;
		return self::preform_sql("SELECT DISTINCT sender FROM " . DBTP. self::$table_name . " WHERE receiver = '{$current_user->id}' AND viewed = 0 ");
	}
}
	
?>