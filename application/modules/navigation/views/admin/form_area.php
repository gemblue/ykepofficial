<div class="title-block">
	<h3 class="title"><?php echo $page_title; ?>
	<span class="sparkline bar" data-type="bar"></span>
</h3>
</div>

<div class="card card-block">

	<?php if ($form_type == 'edit'):?>
		Created at <?php echo time_ago($result['created_at']); ?>
	<?php endif;?>

	<form id="post-form" method="post" action="<?php echo $action_url;?>" enctype="multipart/form-data">

		<div class="card-body <?= $form_type == 'new' ?'slugify' : ''; ?>">
			
			<div class="form-group">
				<label for="area">Area Name</label>
				<?php echo form_input('area_name', set_value('area_name', $result['area_name'] ?? ''), 'class="title form-control"'); ?>
			</div>
			<div class="form-group">
				<label for="area">Area slug</label>
				<?php echo form_input('area_slug', set_value('area_slug', $result['area_slug'] ?? ''), 'class="slug form-control"'); ?>
				<?php echo form_hidden('old_area_slug', $result['area_slug'] ?? ''); ?>
			</div>
			<div class="form-group">
				<label for="area">Status</label>
				<?php echo form_dropdown('status', ['draft'=>'Draft','publish'=>'Publish'], set_value('status', $result['status'] ?? 'publish'), 'class="slug form-control"'); ?>
			</div>
			
		</div>

		<div class="modal-footer">
			<a href="<?= site_url('admin/navigation');?>" class="btn btn-secondary">Cancel</a>
			<button type="submit" id="btn-submit-link-form" class="btn btn-primary">Save Area</button>
		</div>
	</form>
</div>