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
		<h3 class="tabs_involved">User Detail</h3>
		
		<div class="submit_link">
			<form action="<?= site_url('admin/users/detail')?>" calss="formSearch" method="post">				
				Search:<input type="text" name="text" value="<?= $text?>" style="width: 200px;"/>
				<input type="submit" value="Search" />
			</form>
		</div>
	</header>
	
	<table cellspacing="0" class="tablelist"> 
		<?php 
			
			$fileds[] = array('filed'=>'username', 'title'=>'Name',);
			$fileds[] = array('filed'=>'', 'title'=>'Contact',);
			$fileds[] = array('filed'=>'', 'title'=>'Dogs',);			
			$fileds[] = array('filed'=>'', 'title'=>'Location',);					
                        $fileds[] = array('filed'=>'version', 'title'=>'Version',);
                        $fileds[] = array('filed'=>'', 'title'=>'Buddies/Invites',);
                        $fileds[] = array('filed'=>'', 'title'=>'Woofs/Value',);
                        $fileds[] = array('filed'=>'', 'title'=>'Open woofs',);
                        $fileds[] = array('filed'=>'', 'title'=>'Fetched/Jobs',);
                        $fileds[] = array('filed'=>'', 'title'=>'Promo',);
			
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
                                $promo = New Promotional_codes();
                                $promo->get_by_userid($u->id);
                                
				$dogcount = $dogs->where("user_id", $u->id)->count();
		?>
			<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
                            
								
				<td> <?= $u->username?></td>
				<td>
					E-Mail: <a href="mailto:<?= $u->email?>"><?= $u->email?></a>
					<?php if ( $u->phone ):?>
					<br/>
					Phone: <a href="callto:<?= $u->phone?>"><?= $u->phone?></a>
					<?php endif;?><br/>					
				</td>
				<td>
					<a href="<?php echo site_url("admin/dogs/search/userid/".$u->id."/order/id:desc")?>"><?= $dogcount ?></a>
				</td>	
                                <td><?= $u->address?></td>				
                                <td><?= $u->version?></td>                                                                
                                <td><?$bcount = my_get_first_degree_result_count($u->id); $icount = my_get_first_degree_result_invited_count($u->id); ?><?= $bcount.'/'.$icount?></td>
                                <td>                                    
                                <?php $woof = New Woof(); $woof->get_by_user_id($u->id); $wcount = $woof->result_count(); $woof =  New Woof(); $woof->select_sum('cost')->where('user_id',$u->id)->get(); echo $wcount."/".$woof->cost;  ?>    
                                </td>
                                <td>
                                    <?php $woof = New Woof(); echo  $woof->where("user_id",$u->id)->where("status",'New')->count(); ?>
                                </td>    
                                <td><?php $fetch_woof = New Fetch_woof(); echo $fetch_woof->where('user_id',$u->id)->where("status")->count('Fetched'); ?>
                                 <?php $fetch_woof = New Fetch_woof(); echo "/".$fetch_woof->where('user_id',$u->id)->where("status")->count('Completed'); ?></td>							
                                <td><?= $promo->unique_code?> <br> <a href="<?= site_url("admin/users/edit_detail/".$u->id.$ext_param)?>" title="Edit"><?php echo my_icon('edit', 'Edit'); ?></a> </td>
			</tr>
		<?php
			endforeach;
		?>
		<?php else:?>
			<tr><td colspan="5">No Users</td></tr>
		<?php endif;?>
		</tbody> 
	</table>
	
	<footer>
		<?php $this->load->view('admin/common/article_paging', array('model'=>'User', 'paged'=>$users->paged)); ?>
	</footer>
</article>