<?php
ob_start();
session_start();

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

defined('DS') ? null : define('DS' , DIRECTORY_SEPARATOR);

$current = dirname(__FILE__);
$parent = dirname(dirname(__FILE__));

defined('LIBRARY_PATH') ? null : define('LIBRARY_PATH' ,  $current . DS );

defined('MODEL_PATH') ? null : define('MODEL_PATH' , $parent .'/models/' );
defined('VIEW_PATH') ? null : define('VIEW_PATH' , $parent  .'/views/' );
defined('CONTROLLER_PATH') ? null : define('CONTROLLER_PATH' ,$parent.'/controllers/');

defined('UPLOAD_PATH') ? null : define('UPLOAD_PATH' ,$parent.DS.'public');

if(filesize(LIBRARY_PATH .'config.php') == '0') { 
	header("Location: install/index.php");
    exit; 
}

//assign globals!
require_once(LIBRARY_PATH."config.php");
require_once(LIBRARY_PATH."DBManager.php");
require_once(LIBRARY_PATH."Functions.php");
require_once(LIBRARY_PATH."SessManager.php");
require_once(LIBRARY_PATH."Mailer.php");
require_once(LIBRARY_PATH."OneClass.php");
require_once(LIBRARY_PATH."Pagination.php");
require_once(LIBRARY_PATH."PasswordHash.php");

require_once(MODEL_PATH."Award.php");
require_once(MODEL_PATH."Answer.php");
require_once(MODEL_PATH."Chat.php");
require_once(MODEL_PATH."FollowRule.php");
require_once(MODEL_PATH."File.php");
require_once(MODEL_PATH."Group.php");
require_once(MODEL_PATH."LikeRule.php");
require_once(MODEL_PATH."Log.php");
require_once(MODEL_PATH."Misc.php");
require_once(MODEL_PATH."Notif.php");
require_once(MODEL_PATH."Question.php");
require_once(MODEL_PATH."Report.php");
require_once(MODEL_PATH."Tag.php");
require_once(MODEL_PATH."User.php");
require_once(MODEL_PATH."AdManager.php");

$elhash = '0aWWeI8cndsrOMyBUmKZ';

?>