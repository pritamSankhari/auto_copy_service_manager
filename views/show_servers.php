<div class="nav-bar">
	<a class="btn btn-start" href="<?= BASE_URL ?>">Back To Control Panel</a>
	<a class="btn btn-light-red" href="<?= BASE_URL.'do_action.php?action=do_logout' ?>">Log out</a>
</div>

<div class="status-msg-block">
	<?php show_status();?>
</div>

<section class="script-list-block">
	
	<?php if($servers):?>
		<h2 style="text-align: center;">Server(s)</h2>
		<div>
			<table id="show_servers_table">
				<tr>
					<th>Server Name</th>
					<th>Path</th>
					<th>Status</th>
					<!-- <th>Action</th> -->
				</tr>

				<?php foreach($servers as $server):?>
				<tr>
					<td>
						<?= $server['name']?>		
					</td>	
					<td>
						<?= $server['path']?>		
					</td>
					<td>
						<?php if($server['in_use']):?>
							<a href="<?= BASE_URL ?>" class="btn btn-success">Directory in Use ...</a>

						<?php else:?>
							<a href="<?= BASE_URL ?>" class="btn btn-start">Directory is Ideal</a>
						<?php endif;?>
					</td>
					
					<td>
						<?php if( !$server['in_use']):?>
							<a href="<?= BASE_URL.'index.php?action=edit_server&server_id='.$server['id'] ?>"><button class="btn-success" onclick="">Edit</button></a>
						<?php endif;?>
						<?php if( !$server['in_use']):?>
							<a><button class="btn-stop" onclick="confirmDelete(<?php echo $server['id']?>)">Delete</button></a>
						<?php endif;?>	
					</td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>

	<?php else:?>
		<h3>No Server registered !</h3>
	<?php endif;?>
</section>

<script type="text/javascript">
	function confirmDelete(id){
		let i = confirm("Are you sure ?")
		if(i) window.location.assign("<?= BASE_URL.'do_action.php?action=remove_server&server_id=' ?>" + id)
		return true;	
	}
</script>
