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
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="area">Navigation Area</label>
						<input type="text" value="<?= $areas[$area] ?? $areas[$result['area_id']]; ?>" class="form-control disable" disabled>
						<?= form_hidden('area_id', $area ?? $result['area_id']); ?>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="nav_order">Link Order</label>
						<input type="text" value="<?= $nav_order ?? 0; ?>" class="form-control disable" disabled>
						<?= form_hidden('nav_order', $nav_order ?? 0); ?>
					</div>
				</div>
			</div>

			<hr>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="area">Link title</label>
						<?= form_input('caption', set_value('caption', $result['caption'] ?? ''), 'class="title form-control"'); ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="area">Parent</label>
						<?= form_dropdown('parent', $parents, set_value('parent', $result['parent'] ?? '0'), 'class="form-control"'); ?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="area">Link Type</label>
						<?= form_dropdown('url_type', ['uri'=>'URI','external'=>'External'], set_value('url_type', $result['url_type'] ?? 'uri'), 'class="form-control"'); ?>
					</div>
				</div>
				<div class="col-md-9">
					<div class="form-group">
						<label for="">URL <small>http://domain.com/abc or about/us</small></label>
						<?= form_input('url', set_value('url', $result['url'] ?? ''), 'class="title form-control"'); ?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="area">Link Target</label>
						<?= form_dropdown('target', ["_self"=>"_self","_blank"=>"_blank","_parent"=>"_parent","_top"=>"_top"], set_value('target', $result['target'] ?? '_self'), 'class="form-control"'); ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="area">Status</label>
						<?= form_dropdown('status', ['draft'=>'Draft','publish'=>'Publish'], set_value('status', $result['status'] ?? 'publish'), 'class="form-control"'); ?>
					</div>
				</div>
			</div>

			<div class="row mt-3 border-top pt-3">
				<div class="col-12">
					<button type="submit" class="btn btn-primary btn-lg">Submit Link</button>
					<a href="<?= site_url('admin/navigation'); ?>" class="btn btn-secondary btn-lg">Cancel</a>
				</div>
			</div>
		</div>
	</form>
</div>

<?php
	$current = $this->uri->segment_array();
	array_pop($current);
	$current_uri = implode('/', $current);
?>
<script>
	$(function(){
		$('#area_id').on('change', function(){
			window.location.href = '<?= site_url($current_uri); ?>/' + $(this).val();
		});
	})
</script>
