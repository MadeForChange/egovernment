<div class="chat-box">
</div>
<div class="chat-heads">
</div>

<div class="control-sidebar" style="right:0px">
	
	<a href="#me" id="toggle-chat" class="btn btn-primary col-xs-12">Close</a>
	
	<form action="<?php echo WEB_LINK; ?>index.php" method="post" id="chatForm">
	<div class="chat-receptor slimscroll2">
		<br><br><h3 class="" style="color:#dedede; padding:30px"><center><i class="fa fa-comments-o"></i> <?php echo $lang['index-chat-no_chat']; ?></center></h3>
	</div>
	
	<div class="box-footer" style="position:fixed; width:250px; bottom:1px; margin:0;padding:0;display:none" id="message-sender">
		<div class="input-group">
		  <input type="text" name="message" id="chat-msg" placeholder="Type Message ..." class="form-control" required autocomplete="off" >
			  <span class="input-group-btn">
				<button type="submit" name="send-chat" class="btn btn-primary btn-flat"><?php echo $lang['index-chat-send']; ?></button>
			  </span>
		</div>
	</div>
	</form>

</div>