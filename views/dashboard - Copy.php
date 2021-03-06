<div class="nav-bar">
	<a class="btn btn-add" href="<?= BASE_URL.'index.php?action=show_servers' ?>">Show all servers</a>
	<a class="btn btn-start" href="<?= BASE_URL.'index.php?action=backup_dir' ?>">Backup Path(s)</a>
	<a class="btn btn-success" href="<?= BASE_URL.'index.php?action=import_from_txt' ?>">Import Script Logs</a>
	<a class="btn btn-light-red" href="<?= BASE_URL.'do_action.php?action=do_logout' ?>">Log out</a>
</div>


<div class="status-msg-block">
	<?php show_status();?>
</div>

<form method="post" action="<?= BASE_URL.'do_action.php' ?>">
	<h3 class="add-server-label">Add Server</h3>
	<div class="add-server-form-input-table">
	<table>
		<tr>
			<td>
				<label>Server/Directory Name:</label>
			</td>
			<td>
				<input type="text" name="server_name">
			</td>
		</tr>

		<tr>
			<td>
				<label>Server/Directory Path:</label>
			</td>
			<td>
				<input type="text" name="server_path">
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="action" value="add_server">
			</td>
		</tr>
		<tr>
			<td>
				<input class="btn btn-add" type="submit" name="add" value="Add">
			</td>
		</tr>
	</table>
	</div>
</form>

<form method="post" action="<?= BASE_URL.'do_action.php' ?>">
	<h3 class="add-script-label">Add Script</h3>
	<div class="add-script-form-input-table">
		<table>
			<tr>
				<td>
					<label>Script Name:</label>
				</td>
				<td>
					<input type="text" name="script_name">
				</td>
			</tr>		

			<tr>
				<td>
					<label>Source Server/Directory:</label>
				</td>
				<td>
					<select name="source_id">
						<option value="null">Not Set</option>
						
						<?php foreach ($servers as $server):?>
						<option value="<?= $server['id']?>"><?= $server['name'] ?></option>
						<?php endforeach;?>

					</select>
				</td>
			</tr>

			<tr>
				<td>
					<label>Destination Server/Directory:</label>
				</td>
				<td>
					<select name="destination_id">
						<option value="null">Not Set</option>

						<?php foreach ($servers as $server):?>
						<option value="<?= $server['id']?>"><?= $server['name'] ?></option>
						<?php endforeach;?>

					</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type="hidden" name="action" value="add_script">
				</td>
			</tr>
			<tr>
				<td>
					<input class="btn btn-add" type="submit" name="add" value="Add">
				</td>
			</tr>
		</table>
	</div>	
</form>
<section>
	<form action="<?= BASE_URL ?>" method="get">
		<label>Show Script Logs:</label>
		<select name="script_id">
			<?php foreach ($scripts as $script):?>
			<option value="<?= $script['script_id']?>"><?= $script['script_name'] ?></option>
			<?php endforeach;?>

		</select>
		<input type="hidden" value="show_script_log" name="action">
		<input class="btn btn-success" type="submit" name="show" value="Show">
	</form>
	
</section>
<section class="script-list-block">
	
	<?php if($scripts == true):?>
		<h2 style="text-align: center;">Script(s) for Copy</h2>
		<div>
			<table>
				<tr>
					<th>Script Name</th>
					<th>Source Server</th>
					<th>Source Path</th>
					<th>Destination Server</th>
					<th>Destination Path</th>
					<th>Daily Backup</th>
					<th>Action</th>
				</tr>

				<?php $i=1; ?>
				<?php foreach($scripts as $script):?>
				<tr>
					<div>
						<td>
							<span><?= $script['script_name']?></span>
							<a href="<?= BASE_URL.'index.php?action=edit_script_name&script_id='.$script['script_id'] ?>"><span style="margin-left: 10px;color:limegreen;"><i class="fas fa-edit"></i></span></a>

							<span class="shift-up" onclick="shiftup(<?= $i ?>)" style="cursor: pointer;"><i class="fas fa-chevron-up"></i></span>	
							<span class="shift-down" onclick="shiftdown(<?= $i ?>)" style="cursor: pointer;"><i class="fas fa-chevron-down"></i></span>
						</td>
						<td>
							<?= $script['source_server']?>		
						</td>	
						<td>
							<?= $script['source_path']?>		
						</td>
						<td>
							<?= $script['destination_server']?>		
						</td>
						<td>
							<?= $script['destination_path']?>		
						</td>
						
						<td>
							<?php if(isset($daily_backup[$script['script_id']])): ?>
								<form method="post" action="<?= BASE_URL.'do_action.php' ?>">
									
									<input type="hidden" name="action" value="toggle_daily_backup">
									<input type="hidden" name="script_id" value="<?= $script['script_id'] ?>">
									<?php?>
									<input class="backup_checkbox" type="checkbox" name="backup" value="1" <?php echo $daily_backup[$script['script_id']] == 1? "checked":"" ?>>
								</form>
								<?php else:?>
									<a class="btn btn-add" href="<?= BASE_URL.'index.php?action=backup_dir' ?>">Set Backup Path</a>
							<?php endif;?>
						</td>
						
						<td>
							<?php if($script['process_id'] < 1):?>
								<a href="<?= BASE_URL.'do_action.php?action=run_script&script_id='.$script['script_id'] ?>"><button class="btn-start">Run</button></a>
							<?php else:?>
								<a href="<?= BASE_URL.'do_action.php?action=stop_script&script_id='.$script['script_id'] ?>"><button class="btn-stop">Stop</button></a>
							<?php endif;?>
						</td>
						<td>
							<a><button onclick="confirmDeleteScript(<?php echo $script['script_id']?>)" class="btn-stop">Delete</button></a>
						</td>
					</div>	
				</tr>
				<?php $i++;?>
				<?php endforeach;?>
			</table>
		</div>

	<?php else:?>
		<h3>No Script found!</h3>
	<?php endif;?>
</section>


<script type="text/javascript">

let addServerFormToggle = true
let addScriptFormToggle = true


function confirmDeleteScript(id){
	let i = confirm("Are you sure ?")
	if(i) window.location.assign("<?= BASE_URL.'do_action.php?action=delete_script&script_id=' ?>" + id)
	return true;	
}

$('.add-server-label').on('click',function(event){
	
	if(addServerFormToggle){
		$('.add-server-form-input-table').css({
			
			
			height:'200px',
			transform:'scaleY(1)',
		})
		addServerFormToggle=false
	}

	else{
		$('.add-server-form-input-table').css({
			
			
			height:'0px',
			transform:'scaleY(0)',
		})
		addServerFormToggle=true
	}
})

$('.add-script-label').on('click',function(event){
	
	if(addScriptFormToggle){
		$('.add-script-form-input-table').css({
			
			height:'270px',
			transform:'scaleY(1)',
		})
		addScriptFormToggle=false
	}

	else{
		$('.add-script-form-input-table').css({
			
			height:'0px',
			transform:'scaleY(0)',
		})
		addScriptFormToggle=true
	}
})

$('.backup_checkbox').on('input',function(event){

	console.log(event.target.parentElement)
	event.target.parentElement.submit()
})

let scriptsRows = document.querySelectorAll('.script-list-block table tr')
// scriptsRows.shift();

let shiftUp = document.querySelectorAll('.shift-up')
let shiftDown = document.querySelectorAll('.shift-down')
// console.log(shiftUp)
// console.log(scriptsRows)
// $('.shift-up').on('click',function(event){

// 	console.dir(event.target.parentElement.parentElement.parentElement)
// })

console.log($('.shift-up'))
let shiftup = function(i){

	if(i == 1) return

	let tmp = scriptsRows[i-1].innerHTML
	scriptsRows[i-1].innerHTML = scriptsRows[i].innerHTML
	scriptsRows[i].innerHTML = tmp

}
// for(let i=0;i<shiftUp.length;i++){

// 	// console.log(shiftUp[i])
// 	shiftUp[i].addEventListener('click', function(event){

// 		if(i == 0) return

// 		let tmp = scriptsRows[i].innerHTML
// 		scriptsRows[i].innerHTML = scriptsRows[i+1].innerHTML
// 		scriptsRows[i+1].innerHTML = tmp

// 		shiftUp = document.querySelectorAll('.shift-up')
		


// 	})
// }
</script>