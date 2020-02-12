<?php

class AdManager Extends OneClass {
	
	public static $table_name = "ads";
	public static $db_fields = array( "id" , "name" , "content" , "link" , "created_at" , "expiry" , "views" , "clicks", "location" );
	
	public $id;
	public $name;
	public $content;
	public $link;
	public $created_at;
	public $expiry;
	public $views;
	public $clicks;
	public $location;
	
	public function view() {
		$this->views += 1;
		if ($this->update()) { return true; } else { return false; }
	}
	public function click() {
		$this->clicks += 1;
		if ($this->update()) { return true; } else { return false; }
	}
	
}
	
?>