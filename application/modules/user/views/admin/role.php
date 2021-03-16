<div class="mb-3">
	<div class="row">
		<div class="col-lg-6">
			<h2><?php echo $page_title; ?></h2>
		</div>
		<div class="col-lg-6">
			<a href="<?php echo site_url('admin/user/role/add'); ?>" class="btn btn-primary-outline pull-right">
				<span class="fa fa-plus"></span> New Role
			</a>
		</div>
	</div>
</div>

<?php echo $this->session->flashdata('message');?>

<table class="table table-striped table-sm">
	<thead>
		<tr>
			<th width="60px">id</th>
			<?php foreach ($fields as $field): ?>
				<?php if($field['datalist'] ?? null): ?>
					<th><?= $field['label']; ?></th>
				<?php endif; ?>
			<?php endforeach; ?>
			<th>Created at</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<!-- Form filter -->
		<form>
			<tr>
				<td>
					<input type="text" class="form-control form-control-sm" name="filter[id]" value="<?= $this->input->get("filter[id]", true); ?>">
				</td>

				<?php foreach ($fields as $field): ?>
					<?php if($field['datalist'] ?? null): ?>
						<td><input type="text" class="form-control form-control-sm" name="filter[<?= $field['field']; ?>]" value="<?= $this->input->get("filter[{$field['field']}]", true); ?>" placeholder="filter by <?= $field['field']; ?>"></td>
					<?php endif; ?>
				<?php endforeach; ?>

				<td></td>
				<td class="text-right">
					<div class="btn-group">
						<button type="submit" class="btn btn-primary">Filter</button>
						<a href="<?= site_url('admin/user/role'); ?>" class="btn btn-secondary">Reset</a>
					</div>
				</td>
			</tr>
		</form>
		<!-- End form filter -->

		<?php if (empty($results)): ?>

			<tr><td colspan="5">No record found ..</td></tr>

		<?php else: ?>

			<?php foreach ($results as $result): ?>
				<tr>
					<td><?= $result['id']; ?></td>

					<?php foreach ($fields as $field): ?>
						<?php if($field['datalist'] ?? null): ?>
							<td><?php echo $result[$field['field']];?></td>
						<?php endif; ?>
					<?php endforeach; ?>

					<td title="<?php echo strftime("%A, %d %B", strtotime($result['created_at']));?>">
						<?php echo strftime("%d-%m-%Y, %H:%I", strtotime($result['created_at']));?>
					</td>
					<td class="text-right">
						<?php if($result['role_name'] == 'Super'): ?>

						<em>Super admin has all permissions.</em>

						<?php else: ?>

						<a class="btn btn-sm btn-info" href="<?php echo site_url('admin/user/role/privileges/' . $result['id']); ?>" title="Set Privilege"><span class="fa fa-key"></span> Set Privileges</a>
						
						<div class="btn-group">
							<a class="btn btn-sm btn-success" href="<?php echo site_url('admin/user/role/edit/'. $result['id']); ?>" title="Edit"><span class="fa fa-pencil"></span></a> 
							<a class="btn btn-sm btn-danger" onclick="return confirm('are you sure?')" href="<?php echo site_url('admin/user/role/delete/' . $result['id']); ?>" title="Delete"><span class="fa fa-remove"></span></a>
						</div>

						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>

		<?php endif ?>

	</tbody>
</table>

<?php if(isset($pagination)) : ?>
	<div class="pagination">
		<?php echo $pagination; ?>
	</div>
<?php endif; ?>