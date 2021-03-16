<div class="mb-3">
    <div class="row">
        <div class="col-lg-6">
            <h2><?php echo $page_title; ?></h2>
        </div>
        <div class="col-lg-6 text-right">
            <button class="btn btn-primary-outline" data-toggle="modal" data-target="#createEntryModal"><span class="fa fa-plus"></span> Create New Entry</button>
        </div>
    </div>
</div>

<?php if (empty($results)): ?>
	<p>No record found ..</p>
<?php else: ?>

	<?php echo $this->session->flashdata('message');?>

	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th>Entry Name</th>
				<th>Count Data</th>
        <th>Table Exist</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

			<?php
			$i = 1;
			foreach ($results as $result):
        if($result):
			?>
			<tr>
				<td><?= $result['filename']; ?></td>
				<td><?= 0; ?></td>
        <td><?= $this->db->table_exists($result['table']) 
                ? '<span class="fa fa-check text-success"></span>' 
                : '<span class="fa fa-times text-danger"></span>'; ?>          
        </td>
				<td>
					<a href="<?= site_url("admin/entry/{$result['filename']}/index/"); ?>" class="btn btn-sm btn-secondary" target="_blank"><span class="fa fa-list"></span> Show Data</a>

          <a href="<?= site_url('admin/entry/config/form/'.$result['filename']); ?>" class="btn btn-sm btn-warning text-light"><span class="fa fa-cog"></span> Edit Config</a>

          <?php if(! $this->db->table_exists($result['table'])): ?>
            <a href="<?= site_url('admin/entry/config/sync/'.$result['filename']); ?>" class="btn btn-sm btn-secondary"><span class="fa fa-refresh"></span> Build Table</a>
          <?php else: ?>
            <a href="<?= site_url('admin/entry/config/sync/'.$result['filename']); ?>" class="btn btn-sm btn-secondary"><span class="fa fa-refresh"></span> Sync</a>
          <?php endif; ?>
				</td>
			</tr>

			<?php $i++; endif; endforeach; ?>

		</tbody>
	</table>

<?php endif ?>

<div class="modal fade" id="createEntryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('admin/entry/config/init_entry/');?>" method="post">
      	<div class="modal-body">
      		<label>Entry Name</label>
      		<input type="text" name="entry_name" required class="form-control">
      	</div>
      	<div class="modal-footer">
      		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      		<button type="submit" class="btn btn-primary">Create Entry</button>
      	</div>
      </form>
    </div>
  </div>
</div>
