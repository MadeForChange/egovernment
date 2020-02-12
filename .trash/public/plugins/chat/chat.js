$('a#toggle-chat').click(function(){
	var sidebar = $( ".control-sidebar" );
	if(sidebar.is(':hidden')) {
		sidebar.addClass('control-sidebar-open');
		sidebar.animate({opacity: 'toggle'});
	} else {
		sidebar.removeClass('control-sidebar-open');
		sidebar.animate({opacity: 'toggle'});
	}
});