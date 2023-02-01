<?php 
$ext_param = my_ext_param($this->_segments, 3);

$this->session->set_userdata("backurl", current_url());
?>

<script type="text/javascript">
<!--
function delete_user(userid, username) {
	if (confirm("Are you sure delete '" + username + "'?")) {
		location.href="<?= site_url("admin/users/delete")?>/" + userid + "<?= $ext_param?>";
	}
}
//-->
</script>

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">User List</h3>
		
		<div class="submit_link">
			<form action="<?= site_url('admin/users/search')?>" calss="formSearch" method="post">
				Show: <select name="actived" onchange="this.form.submit();">
					<option value="">-- ALL -- </option>
					<option value="Y" <?php if ($actived=='Y') echo "selected"?>>Actived</option>
					<option value="N" <?php if ($actived=='N') echo "selected"?>>Blocked</option>
					<option value="O" <?php if ($actived=='O') echo "selected"?>>Online</option>
				</select>&nbsp;&nbsp;&nbsp;
				Search:<input type="text" name="text" value="<?= $text?>" style="width: 200px;"/>
				<input type="submit" value="Search" />
			</form>
		</div>
	</header>
	
	<table cellspacing="0" class="tablelist"> 
		<?php 
			$fileds = array();
 			$fileds[] = array('title'=>'', 'align'=>'left');
			$fileds[] = array('filed'=>'id', 'title'=>'ID', 'align'=>'left');
			$fileds[] = array('filed'=>'firstname', 'title'=>'Name',);
			$fileds[] = array('filed'=>'', 'title'=>'Contact',);
			$fileds[] = array('filed'=>'', 'title'=>'Dog Count',);
			$fileds[] = array('filed'=>'rate', 'title'=>'Rate',);
			$fileds[] = array('filed'=>'', 'title'=>'Location',);
			$fileds[] = array('filed'=>'logined', 'title'=>'Last logined?', 'align'=>'left');
			$fileds[] = array('filed'=>'joined', 'title'=>'When joined?', 'align'=>'left');
			$fileds[] = array('title'=>'Options');
                        $fileds[] = array();
			
			$this->load->view('admin/common/table_header', array('order'=>$order, 'fileds'=>$fileds));
		?>
		<tbody>
		<?php if($users->result_count() > 0): ?>
		<!-- show user list --> 
		<?php
			$base_url = current_url();
		
			$dogs = new Dog();
			
			$odd = FALSE;
			foreach($users as $u):
				$odd = !$odd;
			
				$dogcount = $dogs->where("user_id", $u->id)->count();
		?>
			<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
                            <?php                              
                            $axure= "http://doggybnb.blob.core.windows.net";
                            if (strpos($u->avatar,$axure) !== false) { ?>
                            <td><img src="<?= $u->avatar; ?>" width="50"></td>
                            <? }
                            else{ ?>
                              <td><img src="<?= $u->avatar; ?>" width="50"></td>               
                           <? }                            
                            ?>
				
				<td><?= $u->id?></td>
				<td><?= $u->firstname?> <?= $u->lastname?></td>
				<td>
					E-Mail: <a href="mailto:<?= $u->email?>"><?= $u->email?></a>
					<?php if ( $u->phone ):?>
					<br/>
					Phone: <a href="callto:<?= $u->phone?>"><?= $u->phone?></a>
					<?php endif;?><br/>
					<?php if ( $u->facebook_id ): ?>
						<br/>FB: <a href="<?php echo site_url("admin/users/go_facebook/".$u->id)?>" target="_blank"><?php echo my_icon('facebook', 'Go to facebook page'); ?></a>
					<?php endif;?>
					
					<?php if ( $u->twitter_id ): ?>
						<br/>TW: <a href="<?php echo site_url("admin/users/go_twitter/".$u->id)?>" target="_blank"><?php echo my_icon('twitter', 'Go to twitter page'); ?></a>
					<?php endif;?>
				</td>
				<td>
					<a href="<?php echo site_url("admin/dogs/search/userid/".$u->id."/order/id:desc")?>"><?= $dogcount ?></a>
				</td>
				<td><?= $u->rate ?></td>
				<td>
					Location: <?php echo $u->address?><br/>
					URL: <a href="<?php echo $u->url?>"><?php echo $u->url?></a><br/>
					Timezone: <?php echo $u->timezone?><br/>
				</td>
				<td>
					<?= my_get_after_time($u->logined, "", 'Y-m-d H:i:s')?><br>
					on <b><?php echo ucfirst($u->os) ?></b>
				</td>
				<td><?= my_get_after_time($u->joined, "", 'Y-m-d H:i:s')?></td>
				<td>
					<!-- <a href="<?php echo site_url('admin/users/edit/' . $u->id); ?>" title="Change password"><?php echo my_icon('edit', 'Change password'); ?></a> -->
					<?php if ($u->actived == 'Y'):?>
						<a href="<?= site_url("admin/users/blocked/".$u->id.$ext_param)?>" title="Block this User"><?php echo my_icon('actived', 'Block this User'); ?></a> 
					<?php else:?>
						<a href="<?= site_url("admin/users/actived/".$u->id.$ext_param)?>" title="Activate this User"><?php echo my_icon('blocked', 'Activate this User'); ?></a>
					<?php endif;?>
				</td>
                                <td>
                                    <a href="<?= site_url("admin/users/delete/".$u->id.$ext_param)?>" title="Delete this User"><?php echo my_icon('delete', 'Delete this User'); ?></a>
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
	
	<footer>
		<?php $this->load->view('admin/common/article_paging', array('model'=>'User', 'paged'=>$users->paged)); ?>
	</footer>
</article>