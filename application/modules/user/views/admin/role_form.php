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
        
        <div class="form-group">
            <label>Role Name</label>
            <input type="text" name="role_name" value="<?php echo set_value('role_name', $result['role_name'] ?? ''); ?>" class="form-control"/>
        </div>
    
        <div class="form-group">
            <label>Status</label>
            <?= form_dropdown('status', ['active'=>'Active', 'inactive'=>'Inactive'], set_value('status', $result['status'] ?? ''), 'class="form-control"'); ?>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>