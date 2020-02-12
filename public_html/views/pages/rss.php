<?php require_once(LIBRARY_PATH.'pearls.php'); header('Content-Type: text/xml');
$builder= '<?xml version="1.0" encoding="utf-8" ?><rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	xmlns:georss="http://www.georss.org/georss" xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#" xmlns:media="http://search.yahoo.com/mrss/"
	>
<channel>
<title>'.APPNAME.' | '.$title.'</title>
	<atom:link href="'.WEB_LINK.'rss" type="application/rss+xml" rel="self"/>
	<link>'.WEB_LINK.'</link>
	<description>'.APPSLOGAN.'</description>
	<lastBuildDate>';
	$builder .= gmdate(DATE_RSS , time());
	$builder .='</lastBuildDate>
	<language>En</language>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<generator>'.WEB_LINK.'</generator>
<cloud domain="'.WEB_LINK.'" port="80" path="/?rsscloud=notify" registerProcedure="" protocol="http-post" />';

global $settings;
if(isset($settings['site_logo']) && $settings['site_logo'] != 0 ) {
	$file = File::get_specific_id($settings['site_logo']);
	$img_url = WEB_LINK."public/".$file->image_path();
	$builder .= '<image>
	<url>'.$img_url.'</url>
	<title>'.APPNAME.' | '.$title.'</title>
	<link>'.WEB_LINK.'</link>
	</image>';
}

foreach($questions as $q) {
	$user = User::get_specific_id($q->user_id);
	
	if(URLTYPE == 'slug') {
		$url_type = $q->slug;
	} else {
		$url_type = $q->id;
	}
	
	$q_link = $url_mapper['questions/view'].rawurlencode($url_type);
	
	$builder .="<item>
			<title>Question: {$q->title}</title>
			  <link>{$q_link}</link>
			  <guid isPermaLink='true'>{$q_link}</guid>
			  <description>"; 
			  $builder.=strip_tags($q->content); 
			  $builder .="</description>
			  <pubDate>"; 
			  $builder .= gmdate(DATE_RSS , strtotime($q->created_at)); 
			  $builder .="</pubDate>
			  <category>{$q->feed}</category>
			  <author>{$user->email} ({$user->f_name} {$user->l_name})</author>
			  <comments>{$q_link}</comments>
			</item>";
}

if(!empty($answers)) {
	foreach($answers as $a) {
		$user = User::get_specific_id($a->user_id);
		$q = Question::get_specific_id($a->q_id);
	
	if(URLTYPE == 'slug') {
		$url_type = $q->slug;
	} else {
		$url_type = $q->id;
	}
	
	$q_link = $url_mapper['questions/view'].rawurlencode($url_type).'#answer-'.$a->id;
	
	$builder .="<item>
			  <title>Answer for: {$q->title}</title>
			  <link>{$q_link}</link>
			  <guid isPermaLink='true'>{$q_link}</guid>
			  <description>"; 
			  $builder.=strip_tags($a->content); 
			  $builder .="</description>
			  <pubDate>"; 
			  $builder .= gmdate(DATE_RSS , strtotime($a->created_at)); 
			  $builder .="</pubDate>
			  <category>{$q->feed}</category>
			  <author>{$user->email} ({$user->f_name} {$user->l_name})</author>
			  <comments>{$q_link}</comments>
			</item>";
	}
}

$builder .='</channel>
</rss>';
$builder = str_replace("nbsp" , "" , $builder);
echo preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $builder);
?>