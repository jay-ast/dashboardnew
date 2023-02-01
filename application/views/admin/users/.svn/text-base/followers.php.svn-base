<?php 
$medias = new Media();
$following = new Following();
$mediacount = $medias->where("user_id", $user->id)->count();	
?>
<article class="module width_quarter">
	<header><h3><?php echo $user->username?></h3></header>
	<div class="module_content">
		<table><tr>
			<td width="60"><img src="<?= my_get_file_url($user->avatar); ?>" width="50"></td>
			<td>
				<span style="font-size: 2em; font-weight: bold;"><?php echo $user->username?></span><br>
				(<?php echo $user->status?> | <?php echo ($user->actived=='Y'?'Actived':'Blocked')?>)
			</td>
		</tr></table>
		<p>ID: <?= $user->id?></p>
		<p>
			Fullname: <?= $user->fullname?><br>
			<?php if ( $user->email ):?>
			Email: <a href="mailto:<?= $user->email?>"><?= $user->email?></a><br/>
			<?php endif;?>
			<?php if ( $user->phone ):?>
			Phone: <a href="callto:<?= $user->phone?>"><?= $user->phone?></a><br/>
			<?php endif;?>
			Social: 
			<?php if ( $user->facebook_id ): ?>
				<a href="<?php echo site_url("admin/users/go_facebook/".$user->id)?>" target="_blank"><?php echo my_icon('facebook', 'Go to facebook page'); ?></a>
			<?php endif;?>
			
			<?php if ( $user->twitter_id ): ?>
				<a href="<?php echo site_url("admin/users/go_twitter/".$user->id)?>" target="_blank"><?php echo my_icon('twitter', 'Go to twitter page'); ?></a>
			<?php endif;?>
		</p>
		<p>
			Location: <?php echo $user->location?><br/>
			URL: <a href="<?php echo $user->url?>"><?php echo $user->url?></a><br/>
			Timezone: <?php echo $user->timezone?><br/>
		</p>
		<p>
			<a href="<?php echo site_url("admin/users/followings/userid/".$user->id)?>">Followings: <?php echo $following->where("following_id", $user->id)->count();?></a><br/>
			<a href="<?php echo site_url("admin/users/followers/userid/".$user->id)?>">Followers: <?php echo $following->where("follower_id", $user->id)->count();?></a>
		</p>
		<?php
			if ( $mediacount > 0 ) { 
				$medias->where("user_id", $user->id)->order_by("id", "desc")->limit(1)->get();
		?>	
		<p>
			Last posted media:<br/>					
			<a href="<?php echo site_url("admin/medias/search/key/".urlencode("@".$user->username))?>">
		<?php		
				foreach ( $medias->all as $lastmedia ) {
					echo (string) $lastmedia."<br> in ".my_get_after_time($lastmedia->created, "", "Y-m-d H:i:s")."<br/>( / ".$mediacount.")";
				}
		?>
			</a>
		</p>
		<?php
			} else {
			}
		?>
		<p>
			Last logined in <?= my_get_after_time($user->logined, "", 'Y-m-d H:i:s')?> on <b><?php echo ucfirst($user->os) ?></b>
		</p>
		<p>
			Joined in <?= my_get_after_time($user->joined, "", 'Y-m-d H:i:s')?>
		</p>
	</div>
</article>

<article class="module width_3_quarter">
	<header>
		<h3 class="tabs_involved">Followers</h3>
		
		<div class="submit_link">
			<input type="button" value="Back" onclick="location.href='<?php echo site_url("admin/users")?>'"/>&nbsp;
		</div>
	</header>
	
	<table cellspacing="0" class="tablelist"> 
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
			
			$this->load->view('admin/common/table_header', array('fileds'=>$fileds));
		?>
		<tbody>
		<?php if($followers->result_count() > 0): ?>
		<!-- show user list --> 
		<?php
			$base_url = current_url();
		
			$odd = FALSE;
			$u = new User();
			foreach($followers as $follower):
				$u->get_by_id($follower->following_id); 
				$odd = !$odd;
			
				$mediacount = $medias->where("user_id", $u->id)->count();
		?>
			<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
				<?php                              
                                    $axure= "http://doggybnb.blob.core.windows.net";
                                    if (strpos($u->avatar,$axure) !== false) { ?>
                                    <td><img src="<?= $u->avatar; ?>" width="50"></td>
                                    <? }
                                    else{ ?>
                                    <td><img src="<?= my_get_file_url($u->avatar); ?>" width="50"></td>               
                                    <? }                            
                                ?>
				<td><?= $u->id?></td>
				<td><?= $u->username?></td>
				<td>
					<?= $u->fullname?><br>
					<?php if ( $u->email ):?>
					<a href="mailto:<?= $u->email?>"><?= $u->email?></a><br/>
					<?php endif;?>
					<?php if ( $u->phone ):?>
					<a href="callto:<?= $u->phone?>"><?= $u->phone?></a><br/>
					<?php endif;?>
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
			</tr>
		<?php
			endforeach;
		?>
		<?php else:?>
			<tr><td colspan="5">Emprty Followers</td></tr>
		<?php endif;?>
		</tbody> 
	</table>
	
	<footer>
		<?php $this->load->view('admin/common/article_paging', array('model'=>'Follower', 'paged'=>$followers->paged)); ?>
	</footer>
</article>