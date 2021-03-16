<div class="title-block">
 	<h3 class="title"><?php echo $page_title; ?>
 		<span class="sparkline bar" data-type="bar"></span>
 	</h3>
</div>

<div class="card card-block">

    <form action="<?php echo ($form_type == 'new' ? site_url('admin/post/category/insert') : site_url('admin/post/category/update')); ?>" method="post">
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
        
        <?php if($form_type == 'edit'): ?>
            <button type="submit" name="btnSaveExit" value="1" class="btn btn-primary">
                Save &amp; Exit
            </button>
        <?php endif; ?>
    </form>
</div>