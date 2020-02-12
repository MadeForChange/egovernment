<?php
defined('LIBRARY_PATH') ? null : die('Direct access to this file is not allowed!');

if(isset($_GET['notif']) && is_numeric($_GET['notif'])) {
	$notification = Notif::get_specific_id($db->escape_value($_GET['notif']));
	if($notification && $notification->user_id == $current_user->id) {
		$notification->read();
	}
}
$curpage = MiscFunction::get_function("terms");
$title = $lang['pages-terms-title'];

require_once(VIEW_PATH.'pages/header.php');
require_once(VIEW_PATH.'pages/navbar.php');

?>
<div class="container">		

<div class="row">
	<?php require_once(VIEW_PATH.'pages/lt_sidebar.php'); ?>
	
	<div class="col-md-8">
	
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
				
				echo "<h2 class='page-header'>{$title}</h2>";
				
				$content = str_replace('\\','', $curpage->value);
				$content = str_replace('<script','', $content);
				$content = str_replace('</script>','', $content);
				echo $content;
			?>
		
	</div>
	<?php require_once(VIEW_PATH.'pages/rt_sidebar.php'); ?>
</div>
	<?php require_once(VIEW_PATH.'pages/footer.php'); ?>
    </div> <!-- /container -->
    <?php require_once(VIEW_PATH.'pages/preloader.php'); ?>
	<script src="<?php echo WEB_LINK; ?>public/plugins/summernote/summernote.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script>
    $(document).ready(function() {
        
	if(window.location.hash) {
	  scrollToId(window.location.hash);
	}
	
	$(document).ready(function(){
		$("img").addClass("img-responsive");
	});
	</script>
	
<?php require_once(VIEW_PATH.'pages/bottom.php'); ?>