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
            <label>Variable Name</label>
            <input type="text" name="variable" value="<?php echo set_value('variable', $result['variable'] ?? ''); ?>" class="form-control"/>
        </div>

        <div class="form-group">
            <label>Variable Value</label>
            <input type="text" name="value" value="<?php echo set_value('value', $result['value'] ?? ''); ?>" class="form-control"/>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>