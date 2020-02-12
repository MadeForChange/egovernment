<?php
function call($controller, $action , $id="") {
	require_once(CONTROLLER_PATH . $controller . '_controller.php');
	
	switch($controller) {
		case 'login':
			$controller = new LoginController();
		break;
		case 'index':
			$controller = new IndexController();
		break;
		case 'page':
			$controller = new PageController();
		break;
		case 'post':
			$controller = new PostController();
		break;
		case 'admin':
			$controller = new AdminController();
		break;
		case 'users':
			$controller = new UsersController();
		break;
		case 'rss':
			$controller = new RssController();
		break;
		case 'logout':
			$controller = new LogoutController();
		break;
		case 'test':
			$controller = new TestController();
		break;
		case 'egovernment':
			$controller = new EgovernmentController();
		break;
		case 'donate':
			$controller = new DonateController();
		break;
		case 'collaborate':
			$controller = new CollaborateController();
		break;
		case 'thankyou':
			$controller = new ThankyouController();
		break;
		case 'welcome':
			$controller = new WelcomeController();
		break;
		
	}

	$controller->{ $action }($id);
}

// we're adding an entry for the new controller and its actions
$controllers = array(
							'login' => ['run', 'error'],
							'page' => ['about_us' , 'contact_us' , 'privacy_policy' , 'terms'],
							'index' => ['run' , 'notifications', 'error'],
							'post' => ['create', 'read' , 'update' , 'delete'],
							'admin' => ['run', 'error'],
							'users' => ['view' , 'error'],
							'rss' => ['run','user','feed','question'],
							'logout' => ['run'],
							'test' => ['run'],
							'egovernment' => ['run'],
							'donate' => ['run'],
							'collaborate' => ['run'],
							'thankyou' => ['run'],
							'welcome' => ['run', 'error']
				   );

if (array_key_exists($controller, $controllers)) {
	if (in_array($action, $controllers[$controller])) {
		if(!isset($id)) { $id = ""; }
		call($controller, $action , $id);
	} else {
		call('index', 'error');
	}
} else {
	call('index', 'error');
}
