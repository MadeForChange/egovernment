<?php
defined('LIBRARY_PATH') ? null : die('Direct access to this file is not allowed!');
if( isset( $_GET["provider"] ) ){
	// the selected provider
	$provider_name = $db->escape_value($_GET["provider"]);

	try {
		// inlcude HybridAuth library
		// change the following paths if necessary
		$config   = UPLOAD_PATH . '/includes/hybridauth/config.php';
		require_once( UPLOAD_PATH . "/includes/hybridauth/Hybrid/Auth.php" );
		require_once( UPLOAD_PATH . "/includes/hybridauth/Hybrid/thirdparty/Facebook/autoload.php" );
		
		// initialize Hybrid_Auth class with the config file
		$hybridauth = new Hybrid_Auth( $config );
		
		// try to authenticate with the selected provider
		$adapter = $hybridauth->authenticate( $provider_name );
 
		// then grab the user profile
		$user_profile = $adapter->getUserProfile();
	}
 
	// something went wrong?
	catch( Exception $e ) {
		
		switch( $e->getCode() ){
		  case 0 : $msg= "Unspecified error."; break;
		  case 1 : $msg= "Hybriauth configuration error."; break;
		  case 2 : $msg= "Provider not properly configured."; break;
		  case 3 : $msg= "Unknown or disabled provider."; break;
		  case 4 : $msg= "Missing provider application credentials."; break;
		  case 5 : $msg= "Authentification failed. "
					  . "The user has canceled the authentication or the provider refused the connection.";
				   break;
		  case 6 : $msg= "User profile request failed. Most likely the user is not connected "
					  . "to the provider and he should authenticate again.";
				   $adapter->logout();
				   break;
		  case 7 : $msg= "User not connected to the provider.";
				   $adapter->logout();
				   break;
		  case 8 : $msg= "Provider does not support this feature."; break;
		}
		redirect_to("{$url_mapper['login/']}?edit=fail&msg={$msg}");
		exit();
	}

	// check if the current user already have authenticated using this provider before
	$user_exist = User::get_for_hybridauth( $provider_name, $user_profile->identifier );
	
	// if the used didn't authenticate using the selected provider before
	// we create a new entry on database.users for him
	if( ! $user_exist ) {
		$email_exists = User::check_existance("email", $user_profile->email , " AND deleted = 0 ");
		
		if($email_exists) {
			$msg = $lang['alert-email_exists'];
			redirect_to($url_mapper['login/']."?edit=fail&msg={$msg}");
		}
		
		$password = get_random(10);
		$phpass = new PasswordHash(8, true);
		$hashedpassword = $phpass->HashPassword($password);
		
		//get avatar ..
		$ch = curl_init($user_profile->photoURL);
		$filename = uniqid().'.jpg';
		file_put_contents(UPLOAD_PATH.'/upl_files/'.$filename, file_get_contents($user_profile->photoURL));
		
		$avatar = new File();
		$avatar->filename = $filename;
		$avatar->type = 'image/jpg';
		$avatar->create();
		
		$username = $user_profile->firstName . '.' . $user_profile->lastName;
		
		$user_exist= New User();
		$user_exist->email = $user_profile->email;
		$user_exist->password = $hashedpassword;
		$user_exist->prvlg_group = $settings['reg_group'];
		$user_exist->f_name = $user_profile->firstName;
		$user_exist->l_name = $user_profile->lastName;
		$user_exist->username = $username;
		$user_exist->hybridauth_provider_name = $provider_name;
		$user_exist->hybridauth_provider_uid = $user_profile->identifier;
		$user_exist->joined = strftime("%Y-%m-%d %H:%M:%S");
		$user_exist->avatar = $avatar->id;
		$user_exist->create();
	}
 
	// set the user as connected and redirect him
	$session->login($user_exist);
	Log::log_action($user_exist->id , "Login" , "Login to system using HybridAuth ({$provider_name}) module");
	
	$params = session_get_cookie_params();
	setcookie(session_name(), $_COOKIE[session_name()], time() + 60*60*24*30, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	
	redirect_to($url_mapper['index/']);
}

if(isset($_POST['forgotpassword'])) {
	if($_POST['loginhash'] == $_SESSION[$elhash_login]){
		$email = trim($_POST["forgot-email"]);
		$found_user =User::hash_authenticate($email);
		if ($found_user) {
			$password = get_random(10);
			$phpass = new PasswordHash(8, true);
			$hashedpassword = $phpass->HashPassword($password);
			
			$found_user->password = $hashedpassword;
			
			if($found_user->update()) {
				
				##########
				## MAILER ##
				##########
				$msg = "You've requested to reset your password on " . APPNAME ." (".WEB_LINK . ")<br>";
				$msg .= "Here's a temporary password generated for your account, please login and reset your password to ensure safety of your information<br>";
				$msg .= "Your new password is:<br><pre>{$password}</pre>";
				$title = 'Password Reset';
				Mailer::send_mail_to($found_user->email , $found_user->f_name , $msg , $title);
				
				$msg = $lang['alert-password_reset'];
				redirect_to($url_mapper['login/'].'?edit=success&msg=' .$msg);
			}
			
		} else {
			$msg = $lang['alert-user_not_found'];
			redirect_to($url_mapper['login/'].'?edit=fail&msg=' .$msg);
		}
		
	} else {
		$msg = $lang['alert-auth_error'];
		redirect_to($url_mapper['login/'].'?edit=fail&msg=' .$msg);
	}
}

if(isset($_POST['register-account'])) {
	
	if($_POST['loginhash'] == $_SESSION[$elhash_login]){
		
		if(isset($_POST['g-recaptcha-response'])) {
          $captcha=$_POST['g-recaptcha-response'];

        if(!$captcha){
			$msg = $lang['alert-captcha_error'];
			redirect_to($url_mapper['login/'].'?edit=fail&msg=' .$msg);
        }
        $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$captcha_info['secret']}&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
		
		if($response['success'] == false){
			$msg = $lang['alert-captcha_error'];
			redirect_to($url_mapper['login/'].'?edit=fail&msg=' .$msg);
        } else {
				$f_name = $db->escape_value($_POST['first_name']);
				$l_name = $db->escape_value($_POST['last_name']);
				$email = $db->escape_value($_POST['reg-email']);
				$username = $db->escape_value(trim(str_replace(' ','',$_POST['reg-username'])));
				$password = $db->escape_value($_POST['reg-password']);
				
				$terms = $db->escape_value($_POST['terms']);
				
			
				
				$acc = New User();
				
				$acc->f_name = $f_name;
				$acc->l_name = $l_name;
				
				$email_exists = User::check_existance("email", $email , " AND deleted = 0 ");
				
				if($email_exists) {
					$msg = $lang['alert-email_exists'];
					redirect_to($url_mapper['login/']."?edit=fail&msg={$msg}");
				}
				
				$acc->email = $email;
				
				if (preg_match('/^[a-zA-Z0-9]+_?[a-zA-Z0-9]+$/D', $username))
                {	
                    
                }
                else {    $msg = $lang['invalid username'];
					redirect_to($url_mapper['login/']."?edit=fail&msg={$msg}");
                    
                }
				
				$username_exists = User::check_existance("username", $username);
				
				if($username_exists) {
					$msg = $lang['alert-username_exists'];
					redirect_to($url_mapper['login/']."?edit=fail&msg={$msg}");
				}
				
				$acc->username = $username;
				
				$phpass = new PasswordHash(8, true);
				$hashedpassword = $phpass->HashPassword($password);
				
				$acc->prvlg_group = $settings['reg_group'];
				$acc->password = $hashedpassword;
				$acc->joined = strftime("%Y-%m-%d %H:%M:%S");
				
				if($acc->create()) {
					$msg = $lang['alert-account_created'] . " {$settings['site_name']} Thank You :)";
				$found_user =User::hash_authenticate($email);	
				$session->login($found_user);
	redirect_to($url_mapper['index/']."?edit=success&msg={$msg}");

				} else {
					$msg = $lang['alert-account_failed'];
					redirect_to($url_mapper['login/']."?edit=fail&msg={$msg}");
				}
        }

		} else {
			$msg = $lang['alert-captcha_error'];
			redirect_to($url_mapper['login/'].'?edit=fail&msg=' .$msg);
		}
	} else {
		$msg = $lang['alert-auth_error'];
		redirect_to($url_mapper['login/'].'?edit=fail&msg=' .$msg);
	}

}


if (isset($_POST['enterlogin'])) {
	if($_POST['loginhash'] == $_SESSION[$elhash_login]){
		$email = trim($_POST["email"]);
		$password = trim($_POST["password"]);
		
		if (strlen($password) > 72) {
			redirect_to($url_mapper['login/']);
			die();
		}
			
		$found_user =User::hash_authenticate($email);
		if ($found_user) {
			
			//check if disabled ...
			if ($found_user->disabled == "1") {
				redirect_to($url_mapper['login/']."?type=account_disabled");
			}
			
			//check password ...
			$saltedhash = $found_user->password;
			
			if ( substr($password , 0, 1 ) == '#' ) {	//direct hash mode!
				
				$password = str_replace('#', "", $password);
				
				if ($saltedhash == $password) {
					$session->login($found_user);
					
					if(isset($_POST['remember-me']) && $_POST['remember-me'] == '1') {
						$params = session_get_cookie_params();
						setcookie(session_name(), $_COOKIE[session_name()], time() + 60*60*24*30, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
					}
					
					redirect_to($url_mapper['index/']);
				} else {
					$error_message = $lang['alert-invalid_pass'];
				}
			
			} else {
			
				$phpass = new PasswordHash(8, true);
				if ($phpass->CheckPassword($password, $saltedhash)) {
					$session->login($found_user);
					
					Log::log_action($found_user->id , "Login" , "Login to system");
					
					if(isset($_POST['remember-me']) && $_POST['remember-me'] == '1') {
						$params = session_get_cookie_params();
						setcookie(session_name(), $_COOKIE[session_name()], time() + 60*60*24*30, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
					}
					
					redirect_to($url_mapper['index/']);
				} else {
					$error_message = $lang['alert-invalid_pass'];
				}
				
			}
			
		} else {
			$error_message = $lang['alert-invalid_user'];
		}
	} else {
		//security fail
		$error_message = $lang['alert-auth_error'];
	}

} 

if(isset($_SESSION[$elhash_login]) && $_SESSION[$elhash_login] != "") { 
	$random_hash = $_SESSION[$elhash_login];
} else {
	$random_hash = uniqid();
	$_SESSION[$elhash_login] = $random_hash;
}

?><!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo APPSLOGAN; ?>">
    <meta name="author" content="Please Zoom In">
    <link rel="icon" href="favicon.ico">

    <title><?php echo APPNAME; ?> | <?php echo APPSLOGAN; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo WEB_LINK; ?>public/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo WEB_LINK; ?>public/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo WEB_LINK; ?>public/css/cover.css?v=1.01" rel="stylesheet">
	<?php if($lang['direction']=='rtl') { ?>
		<link href="<?php echo WEB_LINK; ?>public/css/bootstrap-rtl.css" rel="stylesheet">	
	<?php } ?>
	<script src="https://use.fontawesome.com/48d68862e7.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
	
	<div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              
            </div>
          </div>

			<div class="inner cover searchsection">

				<div class="loginbox">
					<div class="row">
							<?php
			if (isset($_GET['edit']) && isset($_GET['msg']) && $_GET['edit'] == "success") :
			$status_msg = $db->escape_value($_GET['msg']); $status_msg = htmlspecialchars($status_msg, ENT_QUOTES, 'UTF-8');				
		?>
			<div class="alert alert-success">
				<i class="fa fa-check"></i> <strong><?php echo $lang['alert-type-success']; ?>!</strong>&nbsp;&nbsp;<?php echo $status_msg; ?>
			</div>
		<?php
			endif; 	
			if (isset($_GET['edit']) && isset($_GET['msg']) && $_GET['edit'] == "fail") :
			$status_msg = $db->escape_value($_GET['msg']); $status_msg = htmlspecialchars($status_msg, ENT_QUOTES, 'UTF-8');		
		?>
			<div class="alert alert-danger">
				<i class="fa fa-times"></i> <strong><?php echo $lang['alert-type-error']; ?>!</strong>&nbsp;&nbsp;<?php echo $status_msg; ?>
			</div>
			
		<?php 
			endif;
		?>
		

					<?php if(isset($_GET['logout']) && $_GET['logout'] == 'true' ) { ?>
						<div class="alert alert-success">
							<i class="fa fa-lock"></i>&nbsp;<?php echo $lang['login-logged_out']; ?>
						</div>
						<?php } ?>
						<?php if(isset($error_message) && $error_message !='') { ?>
						<div class="alert alert-danger">
							<i class="fa fa-lock"></i>&nbsp;<?php echo $error_message; ?>
						</div>
						<?php } ?>
						<div class="col-md-6 horizontal-separator">
							<div id="register-block">
							    <h2>Signup</h2><br><br>
								<form method="POST" action="<?php echo $url_mapper['login/']; ?>" >
									<div class="row">
									<div class="col-md-6">
									<div class="form-group">
										<label for="first_name" class="control-label"><?php echo $lang['login-register-f_name']; ?></label>
										<input type="text" class="form-control " id="first_name" name="first_name" placeholder="" value="" onkeypress="return onlyAlphabets(event,this);" required>
									</div>
									</div>
									<div class="col-md-6">
									<div class="form-group">
										<label for="last_name" class="control-label"><?php echo $lang['login-register-l_name']; ?></label>
										<input type="text" class="form-control " id="last_name" name="last_name" placeholder="" value="" onkeypress="return onlyAlphabets(event,this);" required >
									</div>
									</div>
									<div class="col-md-12">
									<div class="form-group">
										<label for="reg-email" class="control-label"><?php echo $lang['login-register-email']; ?></label>
										<input type="email" class="form-control no-space" id="reg-email" name="reg-email" placeholder="Email will be verified in next step" value="" required>
									</div>
									</div>
									
									<div class="col-md-12">
										<div class="form-group">
											<label for="username" class="control-label"><?php echo $lang['admin-users-username']; ?></label>				  
											<div class="input-group">
											  <span class="input-group-addon" id="basic-addon1">@</span>
											  <input type="text" class="form-control no-space" id="reg-username" name="reg-username" placeholder="No Spaces and Special characters allowed" value=""  required >
											</div>
										</div>
									</div>
									
									<div class="col-md-12">
									<div class="form-group">
										<label for="reg-password" class="control-label"><?php echo $lang['login-register-pass']; ?></label>
										<input type="password" class="form-control " id="reg-password" name="reg-password" placeholder="6 character minimum" value="" required>
									</div>
									</div>
									<div class="col-md-12" >
									<div class="g-recaptcha" data-sitekey="<?php echo $captcha_info['sitekey']; ?>" ></div>
						    		
									</div>
									</div>
									<br>
									<input class="btn btn-primary" type="submit" name="register-account" value="<?php echo $lang['btn-register']; ?>" style='z-index=10001'>
							
							
							
							
								 <br> <br><?php echo $lang['login-register-terms']; ?>
									<?php
										echo "<input type=\"hidden\" name=\"loginhash\" value=\"".$random_hash."\" readonly/>";
									?>
								</form>
							</div>
						</div>
						<div class="col-md-6 ">
						    <h2>Signin</h2><br><br>
							<div id="login-block">
							
							<form method="POST" action="<?php echo $url_mapper['login/']; ?>" >
									<div class="form-group">
										<label for="email" class="control-label"><?php echo $lang['login-register-email']; ?></label>
										<input type="email" class="form-control no-space" id="email" name="email" placeholder="" value="" required>
										<input type="checkbox" name="remember-me" checked=true> <?php echo $lang['login-remember']; ?>
									</div>
									<div class="form-group">
										<label for="password" class="control-label"><?php echo $lang['login-register-pass']; ?></label>
										<input type="password" class="form-control " id="password" name="password" placeholder="" value="" required>
										<a href="#me" id="forgot-password" style="color:grey"><?php echo $lang['login-forgot_pass']; ?></a>
									</div>
									<input class="btn btn-primary" type="submit" name="enterlogin" value="<?php echo $lang['btn-login']; ?>">
									<?php
										echo "<input type=\"hidden\" name=\"loginhash\" value=\"".$random_hash."\" readonly/>";
									?>
								</form>
							</div>
							<div id="forgot-password-block" style="display:none">
								
								<form method="POST" action="<?php echo $url_mapper['login/']; ?>" >
									<div class="form-group">
										<label for="forgot-email" class="control-label"><?php echo $lang['login-register-email']; ?></label>
										<input type="email" class="form-control " id="forgot-email" name="forgot-email" placeholder="" value="" required>
									</div>
									
									<a href="#me" id="back-to-login" class="btn btn-primary"><?php echo $lang['btn-back']; ?></a>&nbsp;
									<input class="btn btn-primary" type="submit" name="forgotpassword" value="<?php echo $lang['btn-reset_pass']; ?>">
									<?php
										echo "<input type=\"hidden\" name=\"loginhash\" value=\"".$random_hash."\" readonly/>";
									?>
								</form>
							</div>
							<br><br>
							<div id="social-login">
								<?php //if (isset($google_api) && isset($google_api['id']) && $google_api['id'] != ''  ) { ?><a href="<?php echo $url_mapper['login/']; ?>&provider=facebook" class="btn btn-primary btn-lg btn-block"><?php echo $lang['login-using_facebook']; ?></a><?php //} ?>
								<?php //if (isset($facebook_api) && isset($facebook_api['id']) && $facebook_api['id'] != ''  ) { ?><a href="<?php echo $url_mapper['login/']; ?>&provider=google" class="btn btn-danger btn-lg btn-block"><?php echo $lang['login-using_google']; ?></a><?php //} ?>
								<br>
								
								<?php # echo $lang['login-register']; #if($settings['public_access'] == '1' ) { echo '<br>' . $lang['login-as_guest']; }
								?>



							</div>
							
						</div>
					</div>
				</div>
				
			</div>
			
          <div class="mastfoot ">
            <div class="inner">
              <p>&copy; <a href="https://pleasezoom.in" style="color:white">Please Zoom In</a>.</p>
            </div>
          </div>

        </div>

      </div>

	  
<!-- Modal -->
<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $lang['pages-terms-title']; ?></h4>
      </div>
      <div class="modal-body">
        <?php 
			$terms = MiscFunction::get_function("terms");	
			$output = str_replace('\\' , '' , $terms->value);
			$output = str_replace('<script' , '' , $output);
			$output = str_replace('/script>' , '' , $output);
			echo $output;
		?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['btn-close']; ?></button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="privacy_policy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $lang['pages-privacy-title']; ?></h4>
      </div>
      <div class="modal-body">
        <?php 
			$terms = MiscFunction::get_function("privacy-policy");	
			$output = str_replace('\\' , '' , $terms->value);
			$output = str_replace('<script' , '' , $output);
			$output = str_replace('/script>' , '' , $output); 
			echo $output;
		?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
	  
    </div>

	
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo WEB_LINK; ?>public/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="<?php echo WEB_LINK; ?>public/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo WEB_LINK; ?>public/js/ie10-viewport-bug-workaround.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script type="text/javascript">
		$('#register').click(function(){
			$('#social-login').hide();
			$('#register-block').fadeIn();
		});
		$('#cancel-register').click(function(){
			$('#social-login').fadeIn();
			$('#register-block').hide();
		});
		
		$('#forgot-password').click(function(){
			$('#login-block').hide();
			$('#forgot-password-block').fadeIn();
		});
		$('#back-to-login').click(function(){
			$('#login-block').fadeIn();
			$('#forgot-password-block').hide();
		});
		
$(function() {
    $('.no-space').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});

	</script>

  <script language="Javascript" type="text/javascript">

        function onlyAlphabets(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }

    </script>
  </body>
</html>