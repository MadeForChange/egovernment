<div class="col-md-2 visible-sm visible-xs">
	<br><br>
	<i class="fa fa-tasks"></i>&nbsp;&nbsp;<?php echo $lang['index-sidebar-feeds']; ?>
	<hr>
	<ul class="feed-ul">
		<?php
			$current = '';
			if(!isset($_GET['feed']) || $_GET['feed'] == '' ) {
				$current = 'current';
			}
		?>
		<li><a href="<?php echo $url_mapper['index/']; ?>" class="<?php echo $current; ?> col-xs-12"><?php echo $lang['index-sidebar-top']; ?></a></li>
		<li>&nbsp;</li>
		<center><b><?php echo $lang['index-sidebar-trending']; ?></b></center>
		<?php $tags = Tag::get_trending(' LIMIT 5 ');
			if($tags) {
				foreach($tags as $tag) {
					$current = '';
					if(isset($_GET['feed']) && $_GET['feed'] != '' ) {
						if($_GET['feed'] == $tag->name ) {
							$current = 'current';
						}
					}
			?>
				<li><a href="<?php echo $url_mapper['feed/'] . $tag->name; ?>/" class="<?php echo $current; ?> col-xs-12"><?php echo $tag->name; ?></a></li>
			<?php
				}
			}
		?>
		
		</ul>
		<?php if(isset($admanager2->value) && $admanager2->value != '' && $admanager2->value != '&nbsp;' ) { echo '<br style="clear:both"><hr>'.str_replace('\\','',$admanager2->value); } ?>
	
	</div>

<div class="col-md-2 hidden-sm hidden-xs">
		
		<i class="fa fa-globe"></i>&nbsp;&nbsp;<?php echo $lang['index-sidebar-welcome']; ?> <?php echo $current_user->f_name; ?>!
		<hr>
		<ul class="feed-ul">
			<li><a href="<?php echo $url_mapper['pages/view']; ?>about_us" class="col-md-12"><?php echo $lang['pages-about-title']; ?></a></li>
			<li><a href="<?php echo $url_mapper['pages/view']; ?>contact_us" class="col-md-12"><?php echo $lang['pages-contact-title']; ?></a></li>
			<li><a href="<?php echo $url_mapper['pages/view']; ?>privacy_policy" class="col-md-12"><?php echo $lang['pages-privacy-title']; ?></a></li>
			<li><a href="<?php echo $url_mapper['pages/view']; ?>terms" class="col-md-12"><?php echo $lang['pages-terms-title']; ?></a></li>
			<li><a href="<?php echo $url_mapper['leaderboard/']; ?>" class="col-md-12"><?php echo $lang['pages-leaderboard-title']; ?></a></li>
		</ul>
		
	
	<?php
	$ads = ads('right_sidebar');
	if($ads) {
		$r= array_rand($ads);
		$ad = $ads[$r];
		if($ad) {
			echo '<p>&nbsp;</p>';
				if($ad->link) { echo "<a href='".WEB_LINK."ad/run/{$ad->id}' target='_blank'>"; }
					$content = str_replace('\\','',$ad->content);
					$content = str_replace('<script','',$content);
					$content = str_replace('</script>','',$content);
					echo $content;
				if($ad->link) { echo "</a>"; }
				$ad->view();
			echo '<hr>';
		}
	} else {
		echo "<br style='clear:both'><br style='clear:both'><br style='clear:both'>";
	}
	?>
		
		<?php if($current_user->id != '1000') { ?>
		<i class="fa fa-question-circle"></i>&nbsp;&nbsp;<?php echo $lang['index-sidebar-your_questions']; ?>
		<hr>
		<ul class="feed-ul">
			<?php
				$total_count = Question::count_questions_for($current_user->id," ");
				$questions = Question::get_questions_for($current_user->id ," LIMIT 5 " );
				if($questions) {
					foreach($questions as $q) {
						if(URLTYPE == 'slug') {
							$url_type = $q->slug;
						} else {
							$url_type = $q->id;
						}
						
						$string= strip_tags($q->title);
						if (strlen($string) > 15) {
							$stringCut = substr($string, 0, 15);
							$string = substr($stringCut, 0, strrpos($stringCut, ' '))."..."; 
						}
						
						?>
						<li><a href="<?php echo $url_mapper['questions/view']; echo $url_type; ?>" class="col-md-12"><?php echo $string; ?></a></li>
						<?php
					}
				if($total_count > 5) {
				?>
				<li><a href="<?php echo $url_mapper['users/view'].$current_user->id ?>/?section=questions" class="col-md-12">View +<?php echo ($total_count - 5); ?> more</a></li>
				<?php
				}
				}
			?>
		</ul>
		<br style='clear:both'><br style='clear:both'><br style='clear:both'>
		<i class="fa fa-comments"></i>&nbsp;&nbsp;<?php echo $lang['index-sidebar-your_answers']; ?>
		<hr>
		<ul class="feed-ul">
			<?php 
				$total_count = Answer::count_answers_for_user($current_user->id," ");
				$answers = Answer::get_answers_for_user($current_user->id ," LIMIT 5 " );
				
				if($answers) {
					foreach($answers as $a) {
						$q = Question::get_specific_id($a->q_id);
						if(URLTYPE == 'slug') {
							$url_type = $q->slug;
						} else {
							$url_type = $q->id;
						}
						
						$string=strip_tags($a->content);
						if (strlen($string) > 35) {
							$stringCut = substr($string, 0, 35);
							$string = substr($stringCut, 0, strrpos($stringCut, ' '))."..."; 
						}
						
						?>
						<li><a href="<?php echo $url_mapper['questions/view']; echo $url_type; ?>#answer-<?php echo $a->id; ?>" class="col-md-12"><?php echo $string; ?></a></li>
						<?php
					}
				if($total_count > 5) {
				?>
				<li><a href="<?php echo $url_mapper['users/view'].$current_user->id ?>/?section=answers" class="col-md-12">View +<?php echo ($total_count - 5); ?> more</a></li>
				<?php
				}
				}
			?>
		</ul>
		<?php } ?>
		
	</div>

