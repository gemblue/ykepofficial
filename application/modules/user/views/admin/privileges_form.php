<div class="title-block">
 	<h3 class="title"><?php echo $page_title; ?>
 		<span class="sparkline bar" data-type="bar"></span>
 	</h3>
</div>

<div class="card card-block">
    
    <form id="post-form" method="post" action="<?php echo ($form_type == 'new' ? site_url('admin/user/privilege/insert') : site_url('admin/user/privilege/update/'.$result['id']));?>" enctype="multipart/form-data">
        
        <div class="form-group">
            <label>Module</label>
            <input type="text" name="module" value="<?php echo (isset($result['module']) ? $result['module'] : $this->session->flashdata('module')); ?>" class="form-control" required/>
        </div>
        
        <div class="form-group">
            <label>Permission</label>
            <input type="text" name="permission" value="<?php echo (isset($result['permission']) ? $result['permission'] : $this->session->flashdata('permission')); ?>" class="form-control" required/>
        </div>

        <div style="margin-top:30px;"></div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>