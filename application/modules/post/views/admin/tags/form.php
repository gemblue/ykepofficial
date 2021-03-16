<h2><?php echo $subject; ?></h2>

<?php echo $this->session->flashdata('message');?>

<form action="<?php echo ($form_type == 'new' ? site_url('admin/tags/insert') : site_url('admin/tags/update')); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo (isset($result->term_id) ? $result->term_id : ''); ?>" />
	<input type="hidden" name="post_type" value="<?php echo $post_type; ?>" />
    
    <div class="form-group">
		<label>Name</label>
	 	<input type="text" name="name" value="<?php echo (isset($result->name) ? $result->name : ''); ?>" class="form-control"/>
	</div>

    <div class="form-group">
		<label>Slug</label>
	 	<input type="text" name="slug" value="<?php echo (isset($result->slug) ? $result->slug : ''); ?>" class="form-control"/>
	</div>

	<button type="submit" class="btn btn-success">Save</button>
</form>