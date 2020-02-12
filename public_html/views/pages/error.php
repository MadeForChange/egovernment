<?php
defined('LIBRARY_PATH') ? null : die('Direct access to this file is not allowed!');

$title="404 Page Not Found";
require_once(VIEW_PATH.'pages/header.php'); ?>
<?php require_once(VIEW_PATH.'pages/navbar.php'); ?>

<div class="container">		

<div class="row">
	<?php require_once(VIEW_PATH.'pages/lt_sidebar.php'); ?>
	<div class="col-md-8">
		
		<br><br><br>
		<center><img src="<?php echo WEB_LINK; ?>public/img/404.png" ><br>
		<h2>Page Not Found!</h2><hr>
		May be you'll find what you're looking for here:<br>
		
		
		<form action="<?php echo $url_mapper['questions/create'] ?>" method="post" role="form" enctype="multipart/form-data">
			<div class="input-group searchbox hidden-sm hidden-xs" style="">
			  <input type="text" name="title" class="searchbox-field form-control typeahead" placeholder="What's in your mind ?">
			  <span class="input-group-btn">
				<button class="btn btn-default" type="submit">Ask!</button>
			  </span>
			</div><!-- /input-group -->
			<?php 
				$_SESSION[$elhash] = $random_hash;
				echo "<input type=\"hidden\" name=\"hash\" value=\"".$random_hash."\" readonly/>";
			?>
		</form>
		</center>
		
	</div>
	
	<?php require_once(VIEW_PATH.'pages/rt_sidebar.php') ?>
	
</div>
<?php require_once(VIEW_PATH.'pages/footer.php'); ?>
</div> <!-- /container -->
<?php require_once(VIEW_PATH.'pages/preloader.php'); ?>
<?php require_once(VIEW_PATH.'pages/bottom.php'); ?>