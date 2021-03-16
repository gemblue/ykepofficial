<style>
	a.list-group-item {color: #333;}
	a.list-group-item.disable {background: #f3f3f3; color: #aaa;}
</style>
<?php 
	$migration_menu = $has_migration;
	$core = array_shift($migration_menu); 
	ksort($migration_menu);
	ksort($all_modules);
	$segment_5 = $this->uri->segment(5);
	$moduleDetail = $all_modules[$segment_5] ?? null;
?>

<div class="row">
	<div class="col-md-6">
		<h2>Module Management</h2>
	</div>
	<div class="col-md-6 text-right">
		<a href="<?= site_url('admin/development/migration/migrateAll'); ?>" class="btn btn-primary-outline" onclick="return confirm('Yakin akan migrate semua modul? Ini akan migrate ke versi terakhir dari setiap modulnya.')"><span class="fa fa-cogs"></span> Migrate All Modules</a>
	</div>
</div>

<div class="row mt-4">
	<div class="col-md-4">
		<div class="modules-list" style="max-height: 500px;overflow-y:auto;background:#eee">
			<div class="list-group">
				<a href="<?= site_url('admin/development/migration'); ?>" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between <?php echo current_url() == site_url('admin/development/migration') ? 'active ': ' '; ?>">
					Core <span class="badge badge-primary badge-pill"><?= $current[$core[1]]; ?></span>
				</a>
				<?php foreach ($all_modules as $module_menu): ?>
					<?php 
					$moduleUrl = site_url('admin/development/migration/index/'.$module_menu[1]); 
					?>
					<a href="<?= $moduleUrl; ?>" class="list-group-item d-flex align-items-center justify-content-between list-group-item-action <?php echo current_url() == $moduleUrl ? 'active ': ' '; echo $module_menu['enable'] ? '' : 'disable' ?>">
						<?= $module_menu[1]; ?> 
						<?= $module_menu['enable'] ? '' : '<small><em>disabled</em></small>'; ?>
						<?php if(isset($migrations[$module_menu[1]])): ?>
						<span class="badge <?=$module_menu['enable'] ? 'badge-primary':'';?> badge-pill"><?= $current[$module_menu[1]].'/'.count($migrations[$module_menu[1]]); ?></span>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<?php if($module != 'CI_core'): ?>
		<h3>Module Details</h3>
		<table class="table table-sm mt-3 mb-5">
			<tr>
				<th width="20%">Module Name</th>
				<td><?= $moduleDetail['name']; ?></td>
			</tr>
			<tr>
				<th>Description</th>
				<td><?= $moduleDetail['description']; ?></td>
			</tr>
			<tr>
				<th>Path</th>
				<td><?= $moduleDetail['path']; ?></td>
			</tr>
			<tr>
				<th>Author</th>
				<td><a href="<?= $moduleDetail['author_url']; ?>"><?= $moduleDetail['author']; ?></a></td>
			</tr>
			<tr>
				<th>Status</th>
				<td class="d-flex justify-content-between">
					<?php if($moduleDetail['enable']): ?>
						<span class="text-success">enabled</span>
						<a href="<?= site_url('admin/development/migration/disable/'.$module); ?>" class="btn btn-sm btn-oval btn-warning">Disable</a>
					<?php else: ?>
						<span class="text-danger">disabled</span>
						<a href="<?= site_url('admin/development/migration/enable/'.$module); ?>" class="btn btn-sm btn-oval btn-info">Enable</a>
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<?php endif; ?>

		<?php if(($seed ?? null) && $_ENV['CI_ENV'] != 'production'): ?>
		<h3>Seeder</h3>
		<div class="mt-3 mb-5">
			<p class="d-flex justify-content-between">
				<?php if(! $seed['exists']): ?>
					<span class="text-muted"><span class="fa fa-ban"></span> <?= $seed['file']; ?></span>
					<a href="<?= site_url('admin/development/migration/generateSeeder/'.$module); ?>" class="btn btn-primary btn-sm"><span class="fa fa-pencil-square-o"></span> Create seeder</a>
				<?php else: ?>
					<span class="text-success"><?= $seed['file']; ?></span>
					<a href="<?= site_url('admin/development/migration/runSeeder/'.$module); ?>" class="btn btn-primary btn-sm"><span class="fa fa-cog"></span> Run seeder</a>
				<?php endif; ?>
			</p>
		</div>
		<?php endif; ?>

		<?php if($migrations[$module] ?? false): ?>

		<h3>Migrations</h3>
		<div class="card p-2" id="myTabContent">
			<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
				<table class="table table-bordered table-striped m-0">
					<tr>
						<td width="10%">Version</td>
						<td>File</td>
					</tr>

					<?php if($current[$module] > 0): ?>
					<tr>
						<td colspan='3' class="pt-2 pb-1">
							<a class="btn btn-primary <?= (ENVIRONMENT=='production')?'disabled':'' ?>" href='<?= site_url('admin/development/migration/migrate/'.$module); ?>'>Reset</a>
						</td>
					</tr>
					<?php endif; ?>

					<?php foreach ($migrations[$module] as $migration): ?>
						<?php 
						$filename = basename($migration);
						list($key, $migration_name) = explode('_', $filename, 2); 
						?>
						<tr>
							<?php if(intval($key) == $current[$module]): ?>
								<td><span class="fa fa-check-circle"></span> <?= $key; ?></td>
							<?php else: ?>
								<td>
									<a href='<?= site_url('admin/development/migration/migrate/'.$module.'/'.intval($key)); ?>' 
										class="btn btn-sm btn-primary <?= (ENVIRONMENT=='production')?'disabled':'' ?>" 
										<?php if(intval($key) < count($migrations[$module])): ?> 
										onclick="return confirm('Proses rollback akan menghapus data yang sudah ada!\nSerius ini mau dirollback ke versi sebelumnya??')"
										<?php endif; ?>
										>
										<?= $key; ?>
									</a>
								</td>
							<?php endif; ?>

							<td><?= $filename; ?></td>
						<tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>

		<?php endif; ?>

		<?php if(ENVIRONMENT != 'production'): ?>
		<h4 class="py-2">Create new migration</h4>
		<div class="form-inline mb-5">
			<input type="text" id="migration_name" placeholder="migration_name" class="form-control"> &nbsp;
			<button class="btn btn-primary" onclick="createMigration()" class="p-1">Create</button>
		</div>
		<?php endif; ?>
	</div>
</div>

<script>
	function createMigration(){	
		let name=document.getElementById('migration_name').value;
		if(name.trim() !== "")
			window.location = '<?= site_url('admin/development/migration/generateMigration'); ?>/' + name + '/<?= $segment_5; ?>';
	}
	$('#modules').change(function(){
		window.location = $(this).val();
	})
	$(function(){
		var scrtop = $(".list-group-item.active").position().top;
		$('.modules-list').animate({
			scrollTop: scrtop
		}, 800);
	})
</script>
