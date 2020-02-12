<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo WEB_LINK; ?>public/js/vendor/jquery.min.js"><\/script>')</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo WEB_LINK; ?>public/plugins/typeahead/typeahead.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo WEB_LINK; ?>public/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">var PATH = '<?php echo WEB_LINK; ?>';</script>
<script src="<?php echo WEB_LINK; ?>public/plugins/Emoji/jquery.emotions.js"></script>
<script src="<?php echo WEB_LINK; ?>public/plugins/quickfit/jquery.quickfit.js"></script>
<script src="<?php echo WEB_LINK; ?>public/plugins/cropper/cropper.min.js"></script>
<script src="<?php echo WEB_LINK; ?>public/js/jquery.slugit.js"></script>
<script type="text/javascript">var HASH = '<?php echo $random_hash; ?>';</script>
<?php if($chat->value=='on'  && $current_user->id != '1000' ) { ?>
<script src="<?php echo WEB_LINK; ?>public/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo WEB_LINK; ?>public/plugins/chat/chat.js"></script>
<script src="<?php echo WEB_LINK; ?>public/js/jquery.form.min.js"></script>
<?php } ?>
<script type="text/javascript">
		
		/*$(".searchbox-field").focusin(function() {
			$(".overlay").fadeIn(100);
		});*/

		$(".searchbox-field").focusout(function() {
			$(".overlay").fadeOut(100);
		});

var fittedwidth = $('.title').width();
$('.quickfit').quickfit({ max: 22, min: 15, width: fittedwidth, truncate: false});
$('.typeahead').typeahead({
  hint: true,
  highlight: true,
  minLength: 2
},{
    name: 'title',
	displayKey: 'full',
	source: function (query, process) {
		$.ajax({
			url: '<?php echo WEB_LINK; ?>public/includes/one_ajax.php?type=q_suggestions',
			type: 'POST',
			dataType: 'JSON',
			data: 'id=<?php echo $current_user->id; ?>&data=' + query + '&hash="<?php echo $random_hash; ?>"',
			success: function(data) {
				process(data);
				$(".overlay").fadeIn(100);
			},
			error: function(data) {
				console.log(data);
			}
		});
	}
}).on('typeahead:selected', function (obj, datum) {
	if(datum.length !== 0 && datum.slug !== '' ) {
		window.location.href = datum.slug;
	}
});

$('.typeahead').focus();

function scrollToAnchor(aid){
    var aTag = $("a[name='"+ aid +"']");
    $('html,body').animate({scrollTop: aTag.offset().top},'slow');
}
function scrollToId(aid){
	var aid = aid.split('#')[1];
    var aTag = $("[id='"+ aid +"']");
    $('html,body').animate({scrollTop: eval(aTag.offset().top - 50)},'slow');
}

$('.grid').emotions();
$('.col-md-9').emotions();
$('.modal-body').emotions();

$('.open_div').click(function() {
	var link = $(this).data('link');
	$('#'+link).modal('show')
});
$('.open_link').click(function() {
	var link = $(this).data('link');
	window.location.href = link;
});

<?php if($chat->value=='on'  && $current_user->id != '1000') { ?>
$(".slimscroll2").slimscroll({
	height: ($(window).height()-105),
	width: 250,
	start: 'bottom',
	alwaysVisible: false,
	railVisible: true,
	size: '7px',
	scrollTo: "bottom"
}).css("width", "100%");	
<?php } ?>

<?php if ($session->is_logged_in() == true ) { ?>
<?php if($chat->value=='on') { ?>

		$.post("<?php echo WEB_LINK; ?>public/includes/one_ajax.php?type=chat-names", {id:1, data: 1 , hash:'<?php echo $random_hash; ?>'}, function(response){
				$('.chat-box').html(response);
		});
		
		$.post("<?php echo WEB_LINK; ?>public/includes/one_ajax.php?type=chat-heads", {id:1, data: 1 , hash:'<?php echo $random_hash; ?>'}, function(response){
				$('.chat-heads').html(response);
		});
		
		$(document).on('click', '.open-chat' , function () {
			var chat_user_id = $(this).data('user_id');
			$.post("<?php echo WEB_LINK; ?>public/includes/one_ajax.php?type=open-chat", {id:1, data: chat_user_id , hash:'<?php echo $random_hash; ?>'}, function(response){ $('.chat-receptor').html(response); var scrollTo_val = $('.slimscroll2').prop('scrollHeight') + 'px';
				$('.slimscroll2').slimScroll({ scrollTo : scrollTo_val }); });
				$(".box-footer").show();
				var sidebar = $( ".control-sidebar" );
				if(sidebar.is(':hidden')) {
					sidebar.addClass('control-sidebar-open');
					sidebar.animate({opacity: 'toggle'});
				}
		});
<?php } ?>


setInterval(function() {
		
		<?php if($chat->value=='on' && $current_user->id != '1000' ) { ?>
		var sidebar = $( ".control-sidebar" );
		
		//if(!sidebar.hasClass('control-sidebar-open')) {
			$.post("<?php echo WEB_LINK; ?>public/includes/one_ajax.php?type=chat-names", {id:1, data: 1 , hash:'<?php echo $random_hash; ?>'}, function(response){
					$('.chat-box').html(response);
			});
			$.post("<?php echo WEB_LINK; ?>public/includes/one_ajax.php?type=chat-heads", {id:1, data: 1 , hash:'<?php echo $random_hash; ?>'}, function(response){
				$('.chat-heads').html(response);
			});
		//}
		if(sidebar.hasClass('control-sidebar-open')) {
			if(sidebar.find('#chat-receiver').val()) {
				var chat_user_id = sidebar.find('#chat-receiver').val();
				$.post("<?php echo WEB_LINK; ?>public/includes/one_ajax.php?type=open-chat", {id:1, data: chat_user_id , hash:'<?php echo $random_hash; ?>'}, function(response){ $('.chat-receptor').html(response); var scrollTo_val = $('.slimscroll2').prop('scrollHeight') + 'px';
				$('.slimscroll2').slimScroll({ scrollTo : scrollTo_val }); });
				$(".box-footer").show();
			}
		}
		<?php } ?>
		
			$.post("<?php echo WEB_LINK; ?>public/includes/one_ajax.php?type=check_notifications", {id: 1 , data: 1,  hash:'<?php echo $random_hash; ?>'}, function(data){
			
			var test = $.parseJSON(data);
			if(test.count) {
				$(".count-ajax-receptor").html("<span class='label label-danger'>"+ test.count +"</span>");
			}
			if(test.menu) {
				$(".menu-ajax-receptor").html('');
				$.each( test.menu , function( i, l ){
					$(".menu-ajax-receptor").append("<li style='padding:10px;color:black;border-bottom:1px solid #ededed;cursor:pointer' onclick=\"location.href='"+ test.menu[i].link +"';\"><i class='fa fa-globe'></i>&nbsp;&nbsp;"+ test.menu[i].string +"</li>");
				});
			}
		});
}, 7500);
<?php } ?>
</script>