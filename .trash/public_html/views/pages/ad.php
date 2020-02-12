<?php defined('LIBRARY_PATH') ? null : die('Direct access to this file is not allowed!');
	$link = urldecode($ad->link);
	redirect_to($link);
	echo "Redirecting ...";
?>