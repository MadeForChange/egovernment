<?php
if($settings['site_status']== "0" && $current_user->prvlg_group != "1" ) {
	require_once(VIEW_PATH."pages/closed.php");
	exit();
}

if(isset($_SESSION[$elhash]) && $_SESSION[$elhash] != "") { 
	$random_hash = $_SESSION[$elhash];
} else {
	$random_hash = uniqid();
	$_SESSION[$elhash] = $random_hash;
}

$admanager1 = MiscFunction::get_function("admanager1");
$admanager2 = MiscFunction::get_function("admanager2");
$chat = MiscFunction::get_function("chat");

?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php echo $title . " | " . APPSLOGAN; ?>">
    <meta name="keywords" content="<?php echo APPKEYWORDS; ?>">
	<meta name="author" content="PleaseZoomIn">
    <link rel="icon" href="<?php echo UPL_FILES; ?>/img/favicon.ico">

    <title><?php echo $title . " | " . APPNAME; ?></title>
	
	<link rel="alternate" href="<?php echo WEB_LINK; ?>rss/" title="<?php echo APPNAME . " | RSS Feed"; ?>" type="application/rss+xml" />
	
	<meta property="og:title" content="<?php echo $title . " | " . APPNAME; ?>">
	<meta property="og:description" content="<?php echo $title . " | " . APPSLOGAN; ?>">
	<meta property="og:type" content="article">
	<meta property="og:url" content="<?php echo  "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>">
	
    <!-- Bootstrap core CSS -->
    <link href="<?php echo WEB_LINK; ?>public/css/bootstrap.css" rel="stylesheet">
    
	<!-- Custom CSS -->
    <link href="<?php echo WEB_LINK; ?>public/css/custom.css?v=1.01" rel="stylesheet">

	<?php if($lang['direction']=='rtl') { ?>
		<link href="<?php echo WEB_LINK; ?>public/css/bootstrap-rtl.css" rel="stylesheet">	
	<?php } ?>
	
	
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo WEB_LINK; ?>public/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="<?php echo WEB_LINK; ?>public/plugins/summernote/summernote.css" rel="stylesheet">
	<link href="<?php echo WEB_LINK; ?>public/plugins/tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
	<link href="<?php echo WEB_LINK; ?>public/plugins/typeahead/typeaheadjs.css" rel="stylesheet">
	<link href="<?php echo WEB_LINK; ?>public/plugins/cropper/cropper.min.css" rel="stylesheet">
	<?php if($chat->value=='on' && $current_user->id != '1000' ) { ?><link href="<?php echo WEB_LINK; ?>public/plugins/chat/chat.css" rel="stylesheet"><?php } ?>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" rel="stylesheet" >
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script async="async" src="https://www.google.com/adsense/search/ads.js"></script>

<!-- other head elements from your page -->

<script type="text/javascript" charset="utf-8">
(function(g,o){g[o]=g[o]||function(){(g[o]['q']=g[o]['q']||[]).push(
  arguments)},g[o]['t']=1*new Date})(window,'_googCsa');
</script>


<script src="https://use.fontawesome.com/48d68862e7.js"></script>
	
</head>
