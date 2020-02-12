<?php
require_once("../../library/pearls.php");

if ($session->is_logged_in() != true ) {
	if ($settings['public_access'] == '1') {
		$current_user = User::get_specific_id(1000);
	} else {
		redirect_to($url_mapper['login/']); 
	}
} else {
	$current_user = User::get_specific_id($session->admin_id);
}

$group = $current_user->prvlg_group;
if(!isset($settings['site_lang'])) { $settings['site_lang'] = 'English'; }
require_once(LIBRARY_PATH."/lang/lang.{$settings['site_lang']}.php");

if (isset($_GET['type']) && !empty($_GET['type']) && isset($_POST['hash']) && !empty($_POST['hash']) && isset($_POST['data']) && !empty($_POST['data']) && isset($_POST['id']) && is_numeric($_POST['id'])) {
	$id = $db->escape_value($_POST['id']);
	$type = $db->escape_value($_GET['type']);
	$hash = $db->escape_value($_POST['hash']);
	$data = $db->escape_value($_POST['data']);
	
	switch($type) {
		###############################################################
			case 'chat-heads' :
				$chat = Chat::get_chatheads();
				if($chat) {
					$m = 1;
					foreach($chat as $unread) {
						$count = Chat::count_everything(" AND sender = '{$unread->sender}' AND receiver = '{$current_user->id}' AND viewed = 0 ");
						$dev_profile = User::get_specific_id($unread->sender);
					?>
					<a href="#me" style="position:fixed; bottom:0; left:<?php echo ($m*5)+20; ?>%;" class="open-chat" data-user_id="<?php echo $unread->sender; ?>" ><img src="<?php echo $dev_profile->get_avatar(); ?>" class="chat-head img-circle pull-left" alt="User Image" style="border:3px solid white; width:50px;margin-left:-55px">
					<span class="label label-danger pull-left" style="margin-left:-60px"><?php echo $count; ?></span></a>
					<?php
					$m++;
					}					
				}
			break;
		###############################################################
			case 'chat-names' :
				$current_user->set_online();
				
				$chat = User::get_chat($current_user->ban_list);
				$count = count($chat);
					
						echo "<input type='checkbox' /><label data-expanded='{$lang['index-chat-title']} ({$count})' data-collapsed='{$lang['index-chat-title']} ({$count})'></label><div class='chat-box-content'><ul class='feed-ul'>";
						if($chat) { foreach($chat as $unread) {
							$count = Chat::count_everything(" AND sender = '{$unread->id}' AND receiver = '{$current_user->id}' AND viewed = 0 ");
							$dev_profile = User::get_specific_id($unread->id);
						echo "<li><a href='#me' class='open-chat col-xs-12' data-toggle='control-sidebar' data-user_id='{$unread->id}'><i class='fa fa-circle text-success'></i> <span>{$dev_profile->f_name} {$dev_profile->l_name}</span>";
						if($count > 0) { 
						echo "<span class='label label-danger pull-right' style='margin-top:7px'>{$count}</span>";
						}
						echo "</a></li>";
						} } else { echo "<br><li><center style='color:#5e5e5e'>{$lang['index-chat-no_friends']}</center><li>"; }
						echo '</ul></div>';
					
			break;
		
			###############################################################
			case 'open-chat' :
				if(!User::check_id_existance($data)) {
					return false;
					die();
				}
				$banned_list = str_replace('-' , '' , $current_user->ban_list);
				$banned = explode("," , $banned_list);
				
				if(in_array($data , $banned)) {
					echo "<h3 style='color:#ccc; padding:10px'><center>You can't reply to this conversation anymore!<br>This user is currently banned from chatting with you</center></h3>";
					?>
					<script> $('.box-footer').hide(); </script>
					<?php
					die();
				}
				
				$count = Chat::count_everything(" AND sender = '{$data}' AND receiver = '{$current_user->id}' AND viewed = 0 ");
				if($count <= 20) { $count = 20; }
				
				$chat = Chat::get_everything(" AND (sender = '{$current_user->id}' AND receiver = '{$data}' OR sender = '{$data}' AND receiver = '{$current_user->id}' )" , " ORDER BY sent_at DESC LIMIT {$count} ");
				
				echo "<a href='#me' id='ban-user' class='btn btn-danger col-xs-12' data-user_id='{$data}' >Ban User</a><br><br>";
				echo "<div style='padding:20px'>";
				if($chat) {
					$chat = array_reverse ($chat);
					foreach($chat as $msg) {
						$sender = User::get_specific_id($msg->sender);
						?>
						<div class="direct-chat-msg <?php if($msg->sender == $current_user->id) { echo ' right'; } ?>">
							  <div class="direct-chat-info clearfix">
								<span class="direct-chat-name pull-left"><?php echo $sender->f_name; ?></span>
								<span class="direct-chat-timestamp pull-right"><?php echo date_ago($msg->sent_at); ?></span>
							  </div>
							  <!-- /.direct-chat-info -->
							  <img class="direct-chat-img" src="<?php echo $sender->get_avatar(); ?>" alt="Message User Image"><!-- /.direct-chat-img -->
							  <div class="direct-chat-text <?php if($msg->sender == $current_user->id) { echo ' bg-blue'; } ?>">
								<?php echo $msg->msg; ?>
							  </div>
							  <?php if($msg->viewed) {  ?><span class="<?php if($msg->sender == $current_user->id) { echo ' pull-left'; } else { echo ' pull-right';  } ?> text-aqua" style='font-size:10px'><i class="fa fa-check"></i> Seen</span><?php } ?>
							  <!-- /.direct-chat-text -->
							</div>
						<?php
						if($msg->receiver == $current_user->id) {
							$msg->viewed = 1;
							$msg->update();
						}
					}
				}
				?>
			</div>
				<?php 
					$_SESSION[$elhash] = $hash;
					echo "<input type=\"hidden\" name=\"receiver\" id=\"chat-receiver\" value=\"".$data."\" readonly/>";
					echo "<input type=\"hidden\" name=\"hash\" value=\"".$hash."\" readonly/>";
				?>

  <script> 
        // wait for the DOM to be loaded 
        $(document).ready(function() {
            $('#chatForm').ajaxForm(function(responseText) {
				$("#chat-msg").val('');
				$.post("<?php echo WEB_LINK; ?>public/includes/one_ajax.php?type=open-chat", {id:1, data: <?php echo $data; ?> , hash:'<?php echo $hash; ?>'}, function(response){ $('.chat-receptor').html(response); var scrollTo_val = $('.slimscroll2').prop('scrollHeight') + 'px';
				$('.slimscroll2').slimScroll({ scrollTo : scrollTo_val });});
            });
			
			$("#ban-user").click(function() {
				var user_id = $(this).data("user_id");
				if(confirm("Are you sure you want to ban this user from chatting with you again?")) {
					$.post("<?php echo WEB_LINK; ?>public/includes/one_ajax.php?type=ban_user", {id:1, data: user_id , hash:'<?php echo $hash; ?>'}, function(){});
				}
			});
			
        }); 
    </script>
	
				<?php
			break;

		###############################################################
		case 'ban_user' :
			
			if($current_user->ban_list) {
				$ban_list = explode(","  , $current_user->ban_list);
				$ban_list[] = "-" . $data ."-";
				$current_user->ban_list = implode(",", $ban_list);
				$current_user->update();
			} else {
				$current_user->ban_list = "-".$data."-";
				$current_user->update();
			}
			
			
			//target_user:
			$target = User::get_specific_id($data);
			if($target) {				
				if($target->ban_list) {
					$ban_list = explode(","  , $target->ban_list);
					$ban_list[] = "-".$current_user->id."-";
					$target->ban_list = implode(",", $ban_list);
					$target->update();
				} else {
					$target->ban_list = "-".$current_user->id."-";
					$target->update();
				}
			}
			
			
		break;
		###############################################################
		case 'mention' :
			
			$result = User::find_username( $data , $current_user->id, " LIMIT 5");
			$return = Array();
			foreach($result as $r) {
				$e = array();
				$e['name'] = $r->username;
				$e['link'] =  $url_mapper['users/view']. $r->id .'/';
				
				array_push($return, $e);
			}
			
			if(!empty($return)) {$json = json_encode($return);
				echo $json;
			} else { return false; }
			
		break;
		###############################################################
		case 'check_notifications' :
		
			$notif = Notif::count_everything(" AND user_id = '{$current_user->id}' AND viewed = 0 ");
			$return = Array("count" => false, "menu" => false);
			if($notif) { //Send Count & Menu
				$return['count'] = $notif;
				
				$notifications = Notif::get_everything(" AND user_id = '{$current_user->id}' AND viewed = 0 ORDER BY created_at DESC LIMIT 10 ");
				$menu = array();
				
				foreach($notifications as $n ) {
					$string = str_replace('\\' , '' , $n->msg);
					
					/*if (strlen($string) > 50) {
						$stringCut = substr($string, 0, 50);
						$string = substr($stringCut, 0, strrpos($stringCut, ' '))."..."; 
					}*/
					$link = $n->link;
					if(strpos($link , '#')) {	//There's a hash!
						$linkarr = explode('#' , $link);
						$link = $linkarr[0] . "&notif={$n->id}#" . $linkarr[1];
					} else {
						$link .= "&notif={$n->id}";
					}
					
					$e = array(
						'string' => $string,
						'link' => $link
					);
					array_push($menu, $e);
				}
				
				$return['menu'] = $menu;
			}
			
			$json = json_encode($return);
			echo $json;
			
		break;
		###############################################################
		case 'follow' :
		
			$classname = ucfirst($data);
			$found = $classname::get_specific_id($id);
			
			if($found) {
				
				//Check prev like..
				$prev_follow = FollowRule::get_for_obj($data , $id, $current_user->id);
				if(!$prev_follow) {
					//Create like..
					$like = New FollowRule();
					$like->user_id = $current_user->id;
					$like->obj_id = $id;
					$like->obj_type = $data;
					$like->follow_date = strftime("%Y-%m-%d %H:%M:%S", time());
					$like->create();
					
					###############
					## FOLLOW NOTIF ##
					###############
					
					if($classname == 'User') {
						$notif_link = $url_mapper['users/view']. $current_user->id.'/';
						$str = $lang['notif-user-follow-msg']; $str = str_replace('[NAME]' , $current_user->f_name , $str); $str = str_replace('[LINK]' , $url_mapper['users/view'] . $current_user->id , $str); 
						$notif_msg = $str;
						$notif_user = $id;
						$receiver = User::get_specific_id($notif_user);
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						$award = Award::send_award($notif_user,$notif_msg . ", {$lang['notif-award']} <b>1</b> {$lang['notif-point']}" );
						$receiver->award_points(1);
						##########
						## MAILER ##
						##########
						$msg = $notif_msg . "<br>Check it out at ". $notif_link;
						$title = $lang['notif-user-follow-title'];
						if($receiver && is_object($receiver) && $receiver->can_receive_this('new-user-follow') ) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
					} elseif($classname == 'Question') {
						$receiver = User::get_specific_id($found->user_id);
						if(URLTYPE == 'slug') {
							$url_type = $found->slug;
						} else {
							$url_type = $found->id;
						}
						$str= $lang['notif-q_f_award-msg']; $str = str_replace('[LINK]' , $url_mapper['users/view'].$current_user->id , $str ); $str = str_replace('[Q_LINK]' , $url_mapper['questions/view'] . $url_type, $str ); $str = str_replace('[NAME]' , $current_user->f_name , $str );
						$award = Award::send_award($id, "{$str} , {$lang['notif-award']} <b>1</b> {$lang['notif-point']}" );
						$receiver->award_points(1);
						
						$notif_link = $url_mapper['users/view']. $current_user->id.'/';
						$notif_msg = $str;
						$notif_user = $found->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						##########
						## MAILER ##
						##########
						$msg = $notif_msg . "<br>Check it out at ". $notif_link;
						$title = $lang['notif-q_f_award-title'];
						if($receiver && is_object($receiver)  && $receiver->can_receive_this('new-question-follow') ) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
						
					}
					$found->follows +=1;
					$found->update();
				}
			}
		break;
		
		case 'unfollow' :
			$classname = ucfirst($data);
			$found = $classname::get_specific_id($id);
			if($found) {
				//Check prev like..
				$prev_likes = FollowRule::get_for_obj($data , $id, $current_user->id);
				if($prev_likes) {
					$prev_likes->delete();
					$found->follows -=1;
					$found->update();
				}
			}
		break;
		
		###############################################################
		case 'like' :
			$classname = ucfirst($data);
			$found = $classname::get_specific_id($id);
			if($found) {
				//Check prev like..
				$prev_likes = LikeRule::get_for_obj($data , "like" , $id, $current_user->id);
				if(!$prev_likes) {
					//Create like..
					$like = New LikeRule();
					$like->user_id = $current_user->id;
					$like->obj_id = $id;
					$like->obj_type = $data;
					$like->type = 'like';
					$like->like_date = strftime("%Y-%m-%d %H:%M:%S", time());
					$like->create();
					
					if($classname == 'Question') {
						if(URLTYPE == 'slug') {
							$url_type = $found->slug;
						} else {
							$url_type = $found->id;
						}
						$receiver = User::get_specific_id($found->user_id);
						$str= $lang['notif-q_l_award']; $str = str_replace('[LINK]' , $url_mapper['users/view'].$current_user->id , $str ); $str = str_replace('[Q_LINK]' , $url_mapper['questions/view'] . $url_type, $str ); $str = str_replace('[NAME]' , $current_user->f_name , $str );
						$award = Award::send_award($found->user_id,"{$str} , {$lang['notif-award']} <b>1</b> {$lang['notif-point']}" );
						$receiver->award_points(1);
						
						#######
						# NOTIF #
						#######
						if(URLTYPE == 'slug') {$url_type = $found->slug;} else {$url_type = $found->id;}
						$notif_link = $url_mapper['questions/view'].$url_type;
						$notif_msg = $str;
						$notif_user = $found->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						
					} elseif($classname == 'Answer') {
						$q = Question::get_specific_id($found->q_id);
						if(URLTYPE == 'slug') {
							$url_type = $q->slug;
						} else {
							$url_type = $q->id;
						}
						$receiver = User::get_specific_id($found->user_id);
						$str= $lang['notif-a_l_award']; $str = str_replace('[LINK]' , $url_mapper['users/view'].$current_user->id , $str ); $str = str_replace('[Q_LINK]' , $url_mapper['questions/view'] . $url_type . "#answer-{$found->id}" , $str ); $str = str_replace('[NAME]' , $current_user->f_name , $str );
						$award = Award::send_award($found->user_id,"{$str} , {$lang['notif-award']} <b>1</b> {$lang['notif-point']}" );
						$receiver->award_points(1);
						
						#######
						# NOTIF #
						#######
						//if(URLTYPE == 'slug') {$url_type = $found->slug;} else {$url_type = $found->id;}
						$notif_link = $url_mapper['questions/view'].$url_type .'#answer-'.$id;
						$notif_msg = $str;
						$notif_user = $found->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						
					}
					
					$found->likes +=1;
					$found->update();
					
				}
			}
		break;
		
		case 'unlike' :
			$classname = ucfirst($data);
			$found = $classname::get_specific_id($id);
			if($found) {
				//Check prev like..
				$prev_likes = LikeRule::get_for_obj($data , "like" , $id, $current_user->id);
				if($prev_likes) {
					//Create like..
					$prev_likes->delete();
					$found->likes -=1;
					$found->update();
				}
			}
		break;
		
		###############################################################
		case 'approve' :
			$classname = ucfirst($data);
			$found = $classname::get_specific_id($id);
			if($found) {
					
					###############
					## APPROVE NOTIF ##
					###############
					if($classname == 'Question') {
						if(URLTYPE == 'slug') {$url_type = $found->slug;} else {$url_type = $found->id;}
						$notif_link = $url_mapper['questions/view'].$url_type;
						$str = $lang['notif-q_publish-msg']; $str = str_replace('[TITLE]' , $found->title , $str);
						$notif_msg = $str;
						$notif_user = $found->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						
						##########
						## MAILER ##
						##########
						$msg = $notif_msg . "<br>Check it out at ". $notif_link;
						$title = $lang['notif-q_publish-title'];
						$receiver = User::get_specific_id($notif_user);
						if($receiver && is_object($receiver) && $receiver->can_receive_this("approve-question") ) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
					} elseif($classname == 'Answer') {
						$q = Question::get_specific_id($found->q_id);
						if(URLTYPE == 'slug') {$url_type = $q->slug;} else {$url_type = $q->id;}
						$notif_link = $url_mapper['questions/view'].$url_type.'#answer-'.$found->id;
						$str = $lang['notif-a_publish-msg']; $str = str_replace('[TITLE]' , $q->title , $str);
						$notif_msg = $str;
						$notif_user = $found->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						##########
						## MAILER ##
						##########
						$msg = $notif_msg . "<br>Check it out at ". $notif_link;
						$title = $lang['notif-a_publish-title'];
						$receiver = User::get_specific_id($notif_user);
						if($receiver && is_object($receiver) && $receiver->can_receive_this("approve-answer") ) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
					}
					
					$found->published =1;
					$found->update();
			}
		break;
		
		case 'reject' :
			$classname = ucfirst($data);
			$found = $classname::get_specific_id($id);
			if($found) {
					###############
					## APPROVE NOTIF ##
					###############
					if($classname == 'Question') {
						if(URLTYPE == 'slug') {$url_type = $found->slug;} else {$url_type = $found->id;}
						$notif_link = $url_mapper['questions/view'].$url_type;
						$str = $lang['notif-q_reject-msg']; $str = str_replace('[TITLE]' , $found->title , $str);
						$notif_msg = $str;
						$notif_user = $found->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						##########
						## MAILER ##
						##########
						$msg = $notif_msg . "<br>Check it out at ". $notif_link;
						$title = $lang['notif-q_reject-title'];
						$receiver = User::get_specific_id($notif_user);
						if($receiver && is_object($receiver) && $receiver->can_receive_this("reject-question")) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
					} elseif($classname == 'Answer') {
						$q = Question::get_specific_id($found->q_id);
						if(URLTYPE == 'slug') {$url_type = $q->slug;} else {$url_type = $q->id;}
						$notif_link = $url_mapper['questions/view'].$url_type.'#answer-'.$found->id;
						$str = $lang['notif-a_reject-msg']; $str = str_replace('[TITLE]' , $q->title , $str);
						$notif_msg = $str;
						$notif_user = $found->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						##########
						## MAILER ##
						##########
						$msg = $notif_msg . "<br>Check it out at ". $notif_link;
						$title = $lang['notif-a_reject-title'];
						$receiver = User::get_specific_id($notif_user);
						if($receiver && is_object($receiver) && $receiver->can_receive_this("reject-answer")) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
					}
					
					$found->delete();
			}
		break;
		
		###############################################################
		case 'approve-report' :
			$classname = ucfirst($data);
			$report = Report::get_specific_id($_POST['report_id']);
			$found = $classname::get_specific_id($id);
			if($found) {
					
					####################
					## APPROVE REPORT NOTIF ##
					####################
					if($classname == 'Question') {
						if(URLTYPE == 'slug') {$url_type = $found->slug;} else {$url_type = $found->id;}
						//$notif_link = $url_mapper['questions/view'].$url_type;
						$notif_link = $url_mapper['pages/view'].'terms';
						
						$str = $lang['notif-report-q_publisher-approve-msg'];
						$str = str_replace('[TITLE]' , "<a href='{$notif_link}'>".$found->title."</a>", $str);
						//$str = str_replace('[CONTENT]' , strip_tags($found->content), $str);
						$notif_msg = $str;
						$notif_user = $found->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						##########
						## MAILER ##
						##########
						$msg = $notif_msg;
						$title = $lang['notif-report-q_publisher-approve-title'];
						$receiver = User::get_specific_id($notif_user);
						if($receiver && is_object($receiver) && $receiver->can_receive_this('report-my-questions') ) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
						
						
						$str = $lang['notif-report-q_reporter-approve-msg']; $str = str_replace('[TITLE]' , "<a href='{$notif_link}'>".$found->title."</a>" , $str);
						//$str = str_replace('[CONTENT]' , strip_tags($found->content), $str);
						$notif_msg = $str;
						$notif_user = $report->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						##########
						## MAILER ##
						##########
						$msg = $notif_msg;
						$title =$lang['notif-report-q_reporter-approve-title'];
						$receiver = User::get_specific_id($notif_user);
						if($receiver && is_object($receiver)  && $receiver->can_receive_this('report-others-questions')  ) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
						
						
					} elseif($classname == 'Answer') {
						$q = Question::get_specific_id($found->q_id);
						if(URLTYPE == 'slug') {$url_type = $q->slug;} else {$url_type = $q->id;}
						//$notif_link = $url_mapper['questions/view'].$url_type.'#answer-'.$found->id;
						$notif_link = $url_mapper['pages/view'].'terms';
						
						$str = $lang['notif-report-a_publisher-approve-msg']; $str = str_replace('[TITLE]' , "<a href='{$notif_link}'>".$q->title."</a>" , $str);
						//$str = str_replace('[CONTENT]' , strip_tags($found->content), $str);
						$notif_msg = $str;
						$notif_user = $found->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						##########
						## MAILER ##
						##########
						$msg = $notif_msg;
						$title = $lang['notif-report-a_publisher-approve-title'];
						$receiver = User::get_specific_id($notif_user);
						if($receiver && is_object($receiver)  && $receiver->can_receive_this('report-my-answers')  ) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
						
						$str = $lang['notif-report-a_reporter-approve-msg']; $str = str_replace('[TITLE]' , "<a href='{$notif_link}'>".$q->title."</a>" , $str);
						//$str = str_replace('[CONTENT]' , strip_tags($found->content), $str);
						$notif_msg = $str;
						$notif_user = $report->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						##########
						## MAILER ##
						##########
						$msg = $notif_msg;
						$title = $lang['notif-report-a_publisher-approve-title'];
						$receiver = User::get_specific_id($notif_user);
						if($receiver && is_object($receiver)  && $receiver->can_receive_this('report-others-answers') ) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
						
						
					}
					
					if($classname == 'Question') { //Delete answers!
						$answers = Answer::get_answers_for($found->id);
						foreach($answers as $a) {
							$a->delete();
						}
					}
					$found->delete();
					
					$report->result = 'approved';
					$report->update();
			}
		break;
		
		case 'reject-report' :
			$classname = ucfirst($data);
			$report = Report::get_specific_id($_POST['report_id']);
			$found = $classname::get_specific_id($id);
			if($found) {
					###################
					## REJECT REPORT NOTIF ##
					###################
					if($classname == 'Question') {
						if(URLTYPE == 'slug') {$url_type = $found->slug;} else {$url_type = $found->id;}
						$notif_link = $url_mapper['questions/view'].$url_type;
						$str = $lang['notif-report-q_reporter-reject-msg']; $str = str_replace('[TITLE]' , "<a href='{$notif_link}'>".$found->title."</a>" , $str);
						$notif_msg = $str;
						$notif_user = $report->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						##########
						## MAILER ##
						##########
						$msg = $notif_msg . "<br>Check it out at ". $notif_link;
						$title = $lang['notif-report-q_reporter-reject-title'];
						$receiver = User::get_specific_id($notif_user);
						if($receiver && is_object($receiver)  && $receiver->can_receive_this('question-report-rejected')  ) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
					} elseif($classname == 'Answer') {
						$q = Question::get_specific_id($found->q_id);
						if(URLTYPE == 'slug') {$url_type = $q->slug;} else {$url_type = $q->id;}
						$notif_link = $url_mapper['questions/view'].$url_type.'#answer-'.$found->id;
						$str = $lang['notif-report-q_reporter-reject-msg']; $str = str_replace('[TITLE]' , "<a href='{$notif_link}'>".$q->title."</a>" , $str);
						$notif_msg = $str;
						$notif_user = $report->user_id;
						$notif = Notif::send_notification($notif_user,$notif_msg,$notif_link);
						##########
						## MAILER ##
						##########
						$msg = $notif_msg . "<br>Check it out at ". $notif_link;
						$title = $lang['notif-report-q_reporter-reject-title'];
						$receiver = User::get_specific_id($notif_user);
						if($receiver && is_object($receiver) && $receiver->can_receive_this('answer-report-rejected') ) {
							Mailer::send_mail_to($receiver->email , $receiver->f_name , $msg , $title);
						}
					}
					
					//$found->delete();
					$report->result = 'rejected';
					$report->update();
			}
		break;
		
		###############################################################
		case 'dislike' :
			$classname = ucfirst($data);
			$found = $classname::get_specific_id($id);
			if($found) {
				//Check prev like..
				$prev_likes = LikeRule::get_for_obj($data , "dislike" , $id, $current_user->id);
				if(!$prev_likes) {
					//Create like..
					$like = New LikeRule();
					$like->user_id = $current_user->id;
					$like->obj_id = $id;
					$like->obj_type = $data;
					$like->type = 'dislike';
					$like->like_date = strftime("%Y-%m-%d %H:%M:%S", time());
					$like->create();
					
					$found->dislikes +=1;
					$found->update();
				}
			}
		break;
		
		case 'undislike' :
			$classname = ucfirst($data);
			$found = $classname::get_specific_id($id);
			if($found) {
				//Check prev like..
				$prev_likes = LikeRule::get_for_obj($data , "dislike" , $id, $current_user->id);
				if($prev_likes) {
					//Create like..
					$prev_likes->delete();
					$found->dislikes -=1;
					$found->update();
				}
			}
		break;
		
		###############################################################
		case 'upl_img' :
			
			if ($_FILES['img']['name']) {
				if (!$_FILES['img']['error']) {
					
					$files = '';
					$img_id = 0;
					$f = 0;
					$target = $_FILES['img'];
					$upload_problems = 0;
					
						$file = "file";
						$string = $$file . "{$f}";
						$$string = new File();	
							if(!empty($_FILES['img']['name'])) {
								$$string->ajax_attach_file($_FILES['img']);
								if ($$string->save()) {
									$img_id = $$string->id;
									$img_cont = File::get_specific_id($img_id);
									echo UPL_FILES."/".$img_cont->image_path(); 
								} else {
									$upl_msg = "Upload Error! ";	
									$upl_msg .= join(" " , $$string->errors);
									echo $upl_msg;
								}
							}
				} else {
				  echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['img']['error'];
				}
			}
			
		break;
		
		###############################################################
		case 'q_suggestions' :
			
			$result = Question::find( $data , 'title' , " LIMIT 5");
			$result2 = User::find( $data , 'f_name' , " LIMIT 5");
			$return = Array();
			if(empty($result) && empty($result2) ) {
				$q = array(
						'title' => 'No Results Found!',
						'slug' => '',
						'full' => "No Results Found!"
					);
				array_push($return, $q);
			} else {
				if($result) {
					foreach($result as $r) {
						if(URLTYPE == 'slug') {
							$slug = $r->slug;
						} else {
							$slug = $r->id;
						}
						$q = array(
							'title' => $r->title,
							//'slug' => $slug,
							'slug' => $url_mapper['questions/view'] . $slug,
							'full' => "Question: {$r->title}"
						);
						array_push($return, $q);
					}	
				}	
				if($result2) {
					foreach($result2 as $r) {
						$slug = $r->id;
						
						$q = array(
							'title' => $r->f_name. ' ' . $r->l_name,
							'slug' => $url_mapper['users/view'] . $slug . '/',
							'full' => "User: {$r->f_name} {$r->l_name}"
						);
						array_push($return, $q);
					}	
				}
			}
			
			$json = json_encode($return);
			echo $json;
		
		break;
		###############################################################
		case 'tags_suggestions' :
			
			$result = Tag::find($data , "name" , "LIMIT 5");
			$return = Array();
			
			foreach($result as $r ) {
				$q = array(
					'tag' => $r->name
				);
				array_push($return, $q);
			}
			
			$json = json_encode($return);
			echo $json;
		
		break;
		###############################################################
		case 'read_msg' :
			
			if(!EMail::check_id_existance($id)) {
				echo "<h4 style=\"color:red; font-family:Century Gothic\" ><center>Error! This page can't be accessed directly! please try again using main program #item-selector</center></h4>";
			}
			
			if(!EMail::check_ownership($id, $current_user->id)) {
				echo "<h4 style=\"color:red; font-family:Century Gothic\" ><center>Error! This page can't be accessed directly! please try again using main program #item-ownership</center></h4>";
			}
			
			$mymsg = 0;
			
			$mail_msg = EMail::get_specific_id($id);
			$last_reply = Reply::get_last_reply_for($id);
			
			if($last_reply) {
				if ($last_reply->sender == $current_user->id) {
					$mymsg = 1;
				}
			}
			
			if ($data =="received" && $mymsg == 0) { $mail_msg->read_msg(); }
			
			
		break;
		###############################################################
		case 'index_posts' :


$per_page = "20";
$query = $_POST["query"];
$page= $data;

$total_count = Question::count_feed_for($current_user->id,$query," ");
$pagination = new Pagination($page, $per_page, $total_count);
$questions = Question::get_feed_for($current_user->id ,$query," LIMIT {$per_page} OFFSET {$pagination->offset()} " );

$t = 1;

if($questions) {	
foreach($questions as $q) {
$user = User::get_specific_id($q->user_id);
if($user->avatar) {
$img = File::get_specific_id($user->avatar);
$quser_avatar = WEB_LINK."public/".$img->image_path();
$quser_avatar_path = UPLOAD_PATH."/".$img->image_path();
if (!file_exists($quser_avatar_path)) {
$quser_avatar = WEB_LINK.'public/img/avatar.png';
}
} else {
$quser_avatar = WEB_LINK.'public/img/avatar.png';
}

if($q->anonymous) { $quser_avatar = WEB_LINK.'public/img/avatar.png'; }

$upvote_class = 'upvote';
$downvote_class = 'downvote';

$upvote_txt = $lang['btn-like'];
$liked = LikeRule::check_for_obj('question' , "like" , $q->id, $current_user->id);
if($liked) {
$upvote_txt = $lang['btn-liked'];
$upvote_class = 'active undo-upvote';
$downvote_class = 'downvote disabled';
}

$downvote_txt = $lang['btn-dislike'];
$disliked = LikeRule::check_for_obj('question' , "dislike" , $q->id, $current_user->id);
if($disliked) {
$downvote_txt = $lang['btn-disliked'];
$upvote_class = 'upvote disabled';
$downvote_class = 'active undo-downvote';
}
if(URLTYPE == 'slug') {
$url_type = $q->slug;
} else {
$url_type = $q->id;
}

$act_link = $url_mapper['questions/view'].$url_type;
if ($q->answers && isset($settings['q_modal']) && $settings['q_modal']== '1' ) {
	$q_link = '#q-'.$q->id.'-sneak" data-toggle="modal';
	$div_link = " data-link='q-{$q->id}-sneak' class='open_div' ";
} else {
	$q_link = $url_mapper['questions/view'].$url_type;
	$div_link = " data-link='{$q_link}' class='open_link' ";
}

?>
<div class="question-element">
<small><?php $str = $lang['index-question-intro']; $str = str_replace('[VIEWS]' , $q->views , $str); $str = str_replace('[ANSWERS]' , $q->answers , $str); echo $str; ?></small>
<h1 class="title"><a href="<?php echo $q_link; ?>"><?php echo strip_tags($q->title); ?></a></h1>
<p class="publisher">
<img src="<?php echo $quser_avatar; ?>" class="img-circle" style="float:<?php echo $lang['direction-left']; ?>;width:46px;margin-<?php echo $lang['direction-right']; ?>:10px">
<p class="name">
<?php if($q->anonymous) { echo $lang['user-anonymous']; } else { ?>
<a href="<?php echo $url_mapper['users/view'] . $q->user_id; ?>/"><?php echo $user->f_name . " " . $user->l_name; ?></a>
<?php } ?>
<br><small><?php if(!$q->anonymous) { ?>@<?php echo $user->username; ?> | <?php } if($q->updated_at != "0000-00-00 00:00:00") { echo $lang['index-question-updated'] . " " . date_ago($q->updated_at); } else { echo $lang['index-question-created'] . " " . date_ago($q->created_at); }?></small>
</p>
</p>
<br><p <?php echo $div_link; ?> style='cursor:pointer'>
<?php $string = strip_tags($q->content);
if (strlen($string) > 500) {
	// truncate string
	$stringCut = substr($string, 0, 500);
	// make sure it ends in a word so assassinate doesn't become ass...
	$string = substr($stringCut, 0, strrpos($stringCut, ' '))."... <a href='{$url_mapper['questions/view']}{$url_type}' >({$lang['index-question-read_more']})</a>"; 
}
echo profanity_filter($string);?>
</p>
<br>
<?php if($current_user->can_see_this('questions.interact', $group)) { ?><p class="footer question-like-machine">
<?php if($current_user->can_see_this("answers.create",$group)) { ?><a href="<?php echo $url_mapper['questions/view'] . $url_type; ?>#answer-question" class="btn btn-default"><i class="fa fa-pencil"></i> <?php echo $lang['index-question-answer']; if($q->answers) {  echo " | {$q->answers}"; } ?></a><?php } ?>
<?php if($q->user_id != $current_user->id) { ?><a href="#me" class="btn btn-default <?php echo $upvote_class; ?>" name="<?php echo $q->id; ?>" value="<?php echo $q->likes; ?>" data-obj="question" data-lbl="<?php echo $lang['btn-like'] ?>" data-lbl-active="<?php echo $lang['btn-liked']; ?>"  ><i class="fa fa-thumbs-o-up"></i> <?php echo $upvote_txt; if($q->likes) {  echo " | {$q->likes}"; } ?></a>
<a href="#me" class="btn btn-default <?php echo $downvote_class; ?>" name="<?php echo $q->id; ?>" value="<?php echo $q->dislikes; ?>" data-obj="question" data-lbl="<?php echo $lang['btn-dislike']; ?>" data-lbl-active="<?php echo $lang['btn-disliked']; ?>"  ><i class="fa fa-thumbs-o-down"></i> <?php echo $downvote_txt; if($q->dislikes) {  echo " | {$q->dislikes}"; } ?></a><?php } ?>
</p><?php } ?>
<?php if($q->answers) { ?>
<!-- Modal -->
<div class="modal fade in" id="q-<?php echo $q->id; ?>-sneak" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:30px">
<span aria-hidden="true">&times;</span>
</button>
<small><img src="<?php echo $quser_avatar; ?>" class="img-circle" style="float:<?php echo $lang['direction-left']; ?>;width:23px;margin-<?php echo $lang['direction-right']; ?>:10px"> Question asked by <?php if($q->anonymous) { echo $lang['user-anonymous']; } else { ?><b><a href="<?php echo $url_mapper['users/view'] . $q->user_id; ?>/" style="color:black"><?php echo $user->f_name . " " . $user->l_name; ?></a></b><?php } ?> , Posted <?php echo date_ago($q->created_at); ?></small></small>
<h1 class="title" style="margin-top:5px"><b class="col-md-12 quickfit"><?php echo strip_tags($q->title); ?></b></h1>

</div>
<div class="modal-body" style="padding:25px">

<?php
if(URLTYPE == 'slug') {$url_type = $q->slug;} else {$url_type = $q->id;}
$a = Answer::get_best_answer_for($q->id); 
if($a) {
//foreach($answers as $a) {

$user = User::get_specific_id($a->user_id);
if($user->avatar) {
$img = File::get_specific_id($user->avatar);
$quser_avatar = WEB_LINK."public/".$img->image_path();
$quser_avatar_path = UPLOAD_PATH."/".$img->image_path();
if (!file_exists($quser_avatar_path)) {
$quser_avatar = WEB_LINK.'public/img/avatar.png';
}
} else {
$quser_avatar = WEB_LINK.'public/img/avatar.png';
}


$upvote_class = 'upvote';
$downvote_class = 'downvote';

$upvote_txt = $lang['btn-like'];
$liked = LikeRule::check_for_obj('answer' , "like" , $a->id, $current_user->id);
if($liked) {
$upvote_txt = $lang['btn-liked'];
$upvote_class = 'active undo-upvote';
$downvote_class = 'downvote disabled';
}

$downvote_txt = $lang['btn-dislike'];
$disliked = LikeRule::check_for_obj('answer' , "dislike" , $a->id, $current_user->id);
if($disliked) {
$downvote_txt = $lang['btn-disliked'];
$upvote_class = 'upvote disabled';
$downvote_class = 'active undo-downvote';
}


?>

<div class="" id="answer-<?php echo $a->id; ?>">

<img src="<?php echo $quser_avatar; ?>" class="img-circle" style="float:<?php echo $lang['direction-left']; ?>;width:46px;margin-<?php echo $lang['direction-right']; ?>:10px">
<p class="name" style='padding-top:0 !important'>
<b><a href="<?php echo $url_mapper['users/view'] . $a->user_id; ?>/"><?php echo $user->f_name . " " . $user->l_name; ?></a></b><?php if($user->comment) { echo " " . $user->comment; } ?>

<?php if($a->user_id != $current_user->id && $current_user->can_see_this('users.follow' , $group) ) { ?>
<?php
$u_follow_class = 'follow';
$follow_txt = $lang['btn-follow'];
$followed = FollowRule::check_for_obj('user' , $user->id, $current_user->id);
if($followed) {
$follow_txt = $lang['btn-followed'];
$u_follow_class = 'active unfollow';
}
?>
&nbsp;&nbsp;<a href="#me" class="btn btn-sm btn-default <?php echo $u_follow_class; ?>" name="<?php echo $user->id; ?>" value="<?php echo $user->follows; ?>" data-obj="User" data-lbl="<?php echo $lang['btn-follow']; ?>" data-lbl-active="<?php echo $lang['btn-followed']; ?>" ><i class="fa fa-user-plus"></i> <?php echo $follow_txt; ?> | <?php echo $user->follows; ?></a>
<?php } ?>
<br><small>@<?php echo $user->username; ?> | <?php if($a->updated_at != "0000-00-00 00:00:00") { echo $lang['index-question-updated'] . ' ' . date_ago($a->updated_at); } else { echo $lang['index-question-created'] . ' ' . date_ago($a->created_at); }?></small>
</p>
</div><br>
<p class="question-content">
<?php $content = str_replace('\\','',$a->content);
$content = str_replace('<script','',$content);
$content = str_replace('</script>','',$content);
echo profanity_filter($content); ?>
</p>




<?php

} else {
echo "No Answers Yet!";
}
?>

</div>

<div class="modal-footer ">

<div style="float:<?php echo $lang['direction-left']; ?>">

<?php if($current_user->can_see_this('questions.interact' , $group)) { ?>
<div class="btn-group question-like-machine">
<?php if($current_user->can_see_this("answers.create",$group)) { ?><a href="<?php echo $url_mapper['questions/view'] . $url_type; ?>#answer-question" class="btn btn-default"><i class="fa fa-pencil"></i> <?php echo $lang['index-question-answer']; if($q->answers) {  echo " | {$q->answers}"; } ?></a><?php } ?>
<?php if($a->user_id != $current_user->id) { ?><a href="#me" class="btn btn-default <?php echo $upvote_class; ?>" name="<?php echo $a->id; ?>" value="<?php echo $a->likes; ?>" data-obj="answer" data-lbl="<?php echo $lang['btn-like']; ?>" data-lbl-active="<?php echo $lang['btn-liked']; ?>" ><i class="fa fa-thumbs-o-up"></i> <?php echo $upvote_txt; ?> | <?php echo $a->likes; ?></a>
<a href="#me" class="btn btn-default <?php echo $downvote_class; ?>" name="<?php echo $a->id; ?>" value="<?php echo $a->dislikes; ?>" data-obj="answer" data-lbl="<?php echo $lang['btn-dislike']; ?>" data-lbl-active="<?php echo $lang['btn-disliked']; ?>" ><i class="fa fa-thumbs-o-down"></i> <?php echo $downvote_txt; ?> | <?php echo $a->dislikes; ?></a><?php } else { ?>

<a href="#me" class="btn btn-default disabled" ><i class="fa fa-thumbs-o-up"></i> <?php echo $upvote_txt; ?> | <?php echo $a->likes; ?></a>
<a href="#me" class="btn btn-default disabled" ><i class="fa fa-thumbs-o-down"></i> <?php echo $downvote_txt; ?> | <?php echo $a->dislikes; ?></a>
<?php } ?>
<div class="btn-group">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
<?php echo $lang['btn-tools']; ?> <span class="caret"></span></button>
<ul class="dropdown-menu" role="menu" style="width:100px; background-color:white">

<?php if($current_user->can_see_this('answers.update' , $group)) { ?><li><a href="<?php echo $url_mapper['answers/edit'] . $url_type; ?>&type=edit_answer&id=<?php echo $a->id; ?>&hash=<?php echo $random_hash; ?>#answer-question" >Edit</a></li><?php } ?>
<?php if($current_user->can_see_this('answers.delete' , $group)) { ?><li><a href="<?php echo $url_mapper['answers/delete'] . $url_type; ?>&type=delete_answer&id=<?php echo $a->id; ?>&hash=<?php echo $random_hash; ?>" onclick="return confirm('Are you sure you want to delete this answer?');">Delete</a></li><?php } ?>


</ul>

</div>
</div>
<?php } ?>
</div>
<button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $lang['btn-close']; ?></button>
<a href="<?php echo $act_link; ?>" class="btn btn-md btn-success" style='color:white'><?php echo $lang['btn-go_to_q']; ?></a>
</div>

</div>
</div>
</div>

<?php } ?>
</div><?php //if(!$current_user->can_see_this('questions.interact', $group)) { echo '<hr style="margin:0">'; } ?>


<?php 
if(isset($admanager1->value) && $admanager1->value != '' && $admanager1->value != '&nbsp;' ) {
echo '<hr style="margin-bottom:5px">';
echo str_replace('\\','',$admanager1->value);
echo '<hr style="margin-top:5px">';
} else { echo '<hr style="margin:0">'; } ?>


<?php
$t++; 
}
} else {
?>
<h3 style="color:#b0b0b0"><center><i class="fa fa-edit"></i><br><?php echo $lang['index-question-no_questions']; ?><br><br><small><a href='<?php echo $url_mapper['questions/create']; ?>'><?php echo $lang['index-question-post']; ?></a></small></center></h3><br><br>
<?php
}

if(isset($pagination) && $pagination->total_pages() > 1) {
?>
<div class="pagination btn-group" style="display:none">

<?php
if ($pagination->has_previous_page()) {
	$page_param = $url_mapper['index/']. '?page=';
	
	if(isset($_GET['feed']) && $_GET['feed'] != '' ) {
		$feedreq = $db->escape_value($_GET['feed']);
		$page_param = $url_mapper['feed/'] . $feedreq. '&page=';
	}
	$page_param .= $pagination->previous_page();

echo "<a href=\"{$page_param}\" class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-chevron-{$lang['direction-left']}\"></i></a>";
} else {
?>
<a class="btn btn-default" type="button"><i class="fa fa-chevron-<?php echo $lang['direction-left']; ?>"></i></a>
<?php
}

for($p=1; $p <= $pagination->total_pages(); $p++) {
	if($p == $page) {
		echo "<a class=\"btn btn-default active\" type=\"button\">{$p}</a>";
	} else {
		$page_param = $url_mapper['index/']. '?page=';
		
		if(isset($_GET['feed']) && $_GET['feed'] != '' ) {
			$feedreq = $db->escape_value($_GET['feed']);
			$page_param = $url_mapper['feed/'] . $feedreq. '&page=';
		}
		$page_param .= $p;

		echo "<a href=\"{$page_param}\" class=\"btn btn-default\" type=\"button\">{$p}</a>";
	}
}
if($pagination->has_next_page()) {
	$page_param = $url_mapper['index/']. '?page=';
	
	if(isset($_GET['feed']) && $_GET['feed'] != '' ) {
		$feedreq = $db->escape_value($_GET['feed']);
		$page_param = $url_mapper['feed/'] . $feedreq . '&page=';
	}
	$page_param .= $pagination->next_page();

echo " <a href=\"{$page_param}\" class=\"next-page btn btn-default\" data-page=\"{$pagination->next_page()}\" type=\"button\"><i class=\"fa fa-chevron-{$lang['direction-right']}\"></i></a> ";
} else {
?>
<a class="btn btn-default" type="button"><i class="fa fa-chevron-<?php echo $lang['direction-right']; ?>"></i></a>
<?php
}
?>

</div>
<?php
}



		break;
		
		
		###############################################################
		default : 
			echo "<h4 style=\"color:red; font-family:Century Gothic\" ><center>Error! This page can't be accessed directly! please try again using main program #switch</center></h4>";
			die();
		break;
	}
	
} else {
	
	echo "<h4 style=\"color:red; font-family:Century Gothic\" ><center>Error! This page can't be accessed directly! please try again using main program #intro</center></h4>";
	die();
}
?>