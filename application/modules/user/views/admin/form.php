<div class="mb-5">
	<div class="row">
		<div class="col-lg-6">
			<h2><?php echo $page_title; ?></h2>
		</div>
    </div>
</div>

<div class="card card-block">

    <?php if ($form_type == 'edit'):?>
        Registered at <?php echo time_ago($result['created_at']); ?>
    <?php endif;?>

    <div style="margin-bottom:30px;"></div>
    
    <form id="post-form" method="post" action="<?php echo ($form_type == 'new' ? site_url('admin/user/insert') : site_url('admin/user/update'));?>" enctype="multipart/form-data">

        <input type="hidden" name="user_id" value="<?php echo (isset($result['id']) ? $result['id'] : ''); ?>"/>

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo (isset($result['name']) ? $result['name'] : $this->session->flashdata('name')); ?>" class="form-control"/>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo (isset($result['username']) ? $result['username'] : $this->session->flashdata('username')); ?>" class="form-control" />
        </div>
        
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="<?php echo (isset($result['email']) ? $result['email'] : $this->session->flashdata('email'));?>" class="form-control" />
        </div>

        <div class="form-group">
            <label>Status</label>
            
            <select name="status" class="form-control">
                <option value="">Select ..</option>
                <option value="active" <?php echo ($form_type == 'edit' && 'active' == $result['status']) ? 'selected' : '';?>>Active</option>
                <option value="inactive" <?php echo ($form_type == 'edit' && 'inactive' == $result['status']) ? 'selected' : '';?>>Inactive/Block</option>
            </select>
        </div>

        <div class="form-group">
            <label>Role</label>
            
            <select name="role_id" class="form-control">
                <option value="">Select ..</option>
                <?php foreach ($roles as $r) :?>
                    <option <?php echo ($form_type == 'edit' && $r->id == $result['role_id']) ? 'selected' : '';?> value="<?php echo $r->id?>"><?php echo $r->role_name?></option>
                <?php endforeach;?>
            </select>
        </div>
        
        <div class="form-group mb-3">
            <label>Avatar</label>
            <div class="input-group mb-3">
                <input type="text" id="avatar" name="avatar" class="form-control" placeholder="Choose file .." value="<?php echo (isset($result['avatar']) ? $result['avatar'] : $this->session->flashdata('avatar'));?>">
                <div class="input-group-append">
                    <a href="#" class="input-group-text btn-file-manager" data-target="avatar">Choose</a>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>URL</label>
            <input type="text" name="url" value="<?php echo (isset($result['url']) ? $result['url'] : $this->session->flashdata('url'));?>" class="form-control" />
        </div>

        <div class="form-group">
            <label>Short Description</label>
            <input type="text" name="short_description" value="<?php echo (isset($result['short_description']) ? $result['short_description'] : $this->session->flashdata('short_description'));?>" class="form-control" />
        </div>


        <div class="mt-4 mb-4">
            <p><u><b>Profile Setting</b></u></p>
        </div>

        <?php foreach ($entry_profile['fields'] as $field => $fieldConfig): ?>
        <div class="form-group">
            <label><?= $fieldConfig['label']; ?></label><br>
            <?= generate_input($fieldConfig, $result[$field] ?? null); ?>
        </div>
        <?php endforeach; ?>

        <div class="mt-4 mb-4">
            <p><u><b>Password Setting</b></u></p>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" autocomplete="new-password" />
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" />
        </div>
        
        <div style="margin-top:30px;"></div>

        <button type="submit" class="btn btn-success">Save</button>

        <?php if ($form_type == 'edit') :?>
            <?php if ($result['status'] == 'inactive'):?>
                <a href="<?php echo site_url('admin/user/user/activate/' . $result['id']);?>" class="btn btn-success">Turn active</a>
            <?php else:?>
                <a href="<?php echo site_url('admin/user/user/block/' . $result['id']);?>" class="btn btn-danger">Block</a>
            <?php endif;?>
            <a href="<?php echo site_url('user/profile/' . $result['username'])?>" class="btn btn-info" target="_blank">View</a>
        <?php endif;?>
    </form>
</div>