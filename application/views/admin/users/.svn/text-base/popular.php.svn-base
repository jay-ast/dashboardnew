<article class="module width_full">
	<header>
		<h3 class="tabs_involved">Featured Users</h3>
	</header>
	
	<table cellspacing="0" class="tablesorter"> 
		<?php 
			$fileds = array();
 			$fileds[] = array('title'=>'', 'align'=>'left');
			$fileds[] = array('filed'=>'', 'title'=>'ID', 'align'=>'left');
			$fileds[] = array('filed'=>'', 'title'=>'Username',);
			$fileds[] = array('filed'=>'', 'title'=>'Profile',);
			$fileds[] = array('filed'=>'', 'title'=>'Location',);
			$fileds[] = array('filed'=>'', 'title'=>'Follow',);
			$fileds[] = array('filed'=>'', 'title'=>'Last Post',);
			$fileds[] = array('filed'=>'', 'title'=>'Last logined?', 'align'=>'left');
			$fileds[] = array('filed'=>'', 'title'=>'When joined?', 'align'=>'left');
			$fileds[] = array('filed'=>'', 'title'=>'Options', 'align'=>'left');
			
			$this->load->view('admin/common/table_header', array('fileds'=>$fileds));
		?>
		<tbody>
		<?php if($users->num_rows() > 0): ?>
		<!-- show user list --> 
		<?php
			$base_url = current_url();
		
			$odd = FALSE;
			$u = new User();
			$medias = new Media();
			$following = new Following();
			$featured_user = new Featured_user();
			foreach($users->result() as $user):
				$u->get_by_id($user->user_id);
				$odd = !$odd;
				$featured_user->where("user_id", $user->user_id);
				$mediacount = $medias->where("user_id", $u->id)->count();
		?>
			<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
				<td><img src="<?= my_get_file_url($u->avatar); ?>" width="50"></td>
				<td><?= $u->id?></td>
				<td><?= $u->username?></td>
				<td>
					<?= $u->fullname?><br>
					<?php if ( $u->email ):?>
					<a href="mailto:<?= $u->email?>"><?= $u->email?></a>
					<?php endif;?>
					<?php if ( $u->phone ):?>
					<a href="callto:<?= $u->phone?>"><?= $u->phone?></a>
					<?php endif;?><br/>
					<?php if ( $u->facebook_id ): ?>
						<a href="<?php echo site_url("admin/users/go_facebook/".$u->id)?>" target="_blank"><?php echo my_icon('facebook', 'Go to facebook page'); ?></a>
					<?php endif;?>
					
					<?php if ( $u->twitter_id ): ?>
						<a href="<?php echo site_url("admin/users/go_twitter/".$u->id)?>" target="_blank"><?php echo my_icon('twitter', 'Go to twitter page'); ?></a>
					<?php endif;?>
				</td>
				<td>
					Location: <?php echo $u->location?><br/>
					URL: <a href="<?php echo $u->url?>"><?php echo $u->url?></a><br/>
					Timezone: <?php echo $u->timezone?><br/>
				</td>
				<td>
					<a href="<?php echo site_url("admin/users/followings/userid/".$u->id)?>">Followings: <?php echo $following->where("following_id", $u->id)->count();?></a><br/>
					<a href="<?php echo site_url("admin/users/followers/userid/".$u->id)?>">Followers: <?php echo $following->where("follower_id", $u->id)->count();?></a>
				</td>
				<td>
				<?php
					if ( $mediacount > 0 ) { 
						$medias->where("user_id", $u->id)->order_by("id", "desc")->limit(1)->get();
				?>						
						<a href="<?php echo site_url("admin/medias/search/key/".urlencode("@".$u->username))?>">	
				<?php		
						foreach ( $medias->all as $lastmedia ) {
							echo (string) $lastmedia."<br> in ".my_get_after_time($lastmedia->created, "", "Y-m-d H:i:s")."<br/>( / ".$mediacount.")";
						}
				?>
						</a>
				<?php
					} else {
					}
				?>
				</td>
				<td>
					<?= my_get_after_time($u->logined, "", 'Y-m-d H:i:s')?><br>
					on <b><?php echo ucfirst($u->os) ?></b>
				</td>
				<td><?= my_get_after_time($u->joined, "", 'Y-m-d H:i:s')?></td>
				<td>
					<?php if ($featured_user->count() == 0):?>
						<a href="<?= site_url("admin/users/set_featured/".$u->id)?>" title="Set to Featured User"><?php echo my_icon('add_user', 'Set to Featured User'); ?></a>
					<?php else:?>
						<a href="<?= site_url("admin/users/unset_featured/".$u->id)?>" title="Unset to Featured User"><?php echo my_icon('remove_user', 'Unset to Featured User'); ?></a>
					<?php endif;?>
				</td>
			</tr>
		<?php
			endforeach;
		?>
		<?php else:?>
			<tr><td colspan="5">Emprty Users</td></tr>
		<?php endif;?>
		</tbody> 
	</table>
</article>