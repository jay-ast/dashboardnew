<script type="text/javascript">
<!--
function change_sort_num(id, value) {
	$.ajax({
	  url: "<?php echo site_url("admin/users/change_featured_sort")?>/"+id+"/"+value,
	}).done(function(data) {
		alert(data);
	});
}
//-->
</script>

<article class="module width_3_quarter">
	<header>
		<h3 class="tabs_involved">Featured Users</h3>
		
		<div class="submit_link">
			<input type="button" value="Search Users" onclick="location.href='<?php echo site_url("admin/users")?>'"/>
		</div>
	</header>
	
	<table cellspacing="0" class="tablesorter"> 
		<?php 
			$fileds = array();
			$fileds[] = array('title'=>'Sort Num');
			$fileds[] = array('align'=>'left');
			$fileds[] = array('title'=>'ID', 'align'=>'left');
			$fileds[] = array('title'=>'Username',);
			$fileds[] = array('title'=>'Profile',);
			$fileds[] = array('title'=>'Location',);
			$fileds[] = array('title'=>'Follow',);
			$fileds[] = array('title'=>'Last Post',);
			$fileds[] = array('title'=>'Last logined?', 'align'=>'left');
			$fileds[] = array('title'=>'When joined?', 'align'=>'left');
			$fileds[] = array('title'=>'Options', 'align'=>'left');
			
			$this->load->view('admin/common/table_header', array('fileds'=>$fileds));
		?>
		<tbody>
		<?php if($users->result_count() > 0): ?>
		<!-- show user list --> 
		<?php
			$base_url = current_url();
		
			$odd = FALSE;
			$u = new User();
			$medias = new Media();
			$following = new Following();
			foreach($users->all as $user):
				$u->get_by_id($user->user_id);
				$odd = !$odd;
			
				$mediacount = $medias->where("user_id", $u->id)->count();
		?>
			<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
				<td>
					<input type="text" value="<?php echo $user->sort_num?>" style="width: 50px;" onchange="change_sort_num(<?php echo $user->id?>, this.value)"/>
				</td>
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
					<a href="<?= site_url("admin/users/unset_featured/".$u->id)?>" title="Unset to Featured User"><?php echo my_icon('remove_user', 'Unset to Featured User'); ?></a>
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

<article class="module width_quarter">
	<header>
		<h3 class="tabs_involved">Add Featured User</h3>
	</header>
	<?php
		$featured_user = new Featured_user(); 
		$featured_user->load_extension('htmlform');
		echo $featured_user->render_form(array(
				'sort_num',
				'user_id'
			)
		);
	?>
</article>
