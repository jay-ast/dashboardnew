<article class="module width_full">
	<header>
		<h3 class="tabs_involved">Online Users</h3>
	</header>
	
	<table cellspacing="0" class="tablelist"> 
		<?php 
		$fileds = array();
		$fileds[] = array('filed'=>'logined', 'title'=>'Date', 'width'=>'160');
		$fileds[] = array('title'=>'User', 'width'=>'150');
		$fileds[] = array('title'=>'IP');
		$fileds[] = array('title'=>'Agent');
		
		$this->load->view('admin/common/table_header', array('order'=>$order, 'fileds'=>$fileds));
		?>
		<tbody>
		<?php if($users->result_count() > 0): ?>
		<!-- show user list --> 
		<?php
			$odd = FALSE;
			foreach($users as $u):
			
				$odd = !$odd;
		?>
			<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
				<td>
					<?= $u->logined?>
				</td>
				<td>
					<a href="<?= site_url("admin/users/edit/".$u->id)?>" title="Edit this User"><?= $u?></a>
				</td>
				<td>
					<?= $u->ip?>
				</td>
				<td>
					<?= $u->agent?>
				</td>
			</tr>
		<?php
			endforeach;
		?>
		<?php else:?>
			<tr><td colspan="5">Emprty Online Users</td></tr>
		<?php endif;?>
		</tbody> 
	</table>
	
	<footer>
		<?php $this->load->view('admin/common/article_paging', array('model'=>'User', 'paged'=>$users->paged)); ?>
	</footer>
</article>