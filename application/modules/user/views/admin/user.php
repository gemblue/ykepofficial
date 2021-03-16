<div class="mb-5">
	<div class="row">
		<div class="col-lg-6">
			<h2><?php echo $page_title; ?></h2>
		</div>
        <div class="col-lg-6">
            <a href="<?php echo site_url('admin/user/export?'.$_SERVER['QUERY_STRING'])?>" class="btn btn-primary-outline pull-right"><span class="fa fa-download"></span> Export</a>
            <a href="<?php echo site_url('admin/user/add')?>" class="btn btn-primary-outline pull-right"><span class="fa fa-user-plus"></span> New User</a>
        </div>
    </div>
</div>

<?php echo $this->session->flashdata('message');?>

<div class="mb-4">
    <table class="table table-bordered text-center">
        <tr>
            <td><strong>Total Users</strong>
                <br><?php echo $stat['all'];?> orang</td>
            <td><strong>Active Users</strong>
                <br><?php echo $stat['active'];?> orang</td>
            <td><strong>Pending/Blocked</strong>
                <br><?php echo $stat['inactive'];?> orang</td>
        </tr>
    </table>
</div>

<table class="table table-striped table-responsive">
    <thead>
        <tr>
            <th>UseID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Role</th>
            <th>Email</th>
            <th>Source</th>
            <th>Status</th>
            <th>Created</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <form>
            <tr>
                <td><input type="text" class="form-control form-control-sm" name="filter_name" value="<?= $this->input->get('id', true); ?>" placeholder="id"></td>
                <td><input type="text" class="form-control form-control-sm" name="filter_name" value="<?= $this->input->get('filter_name', true); ?>" placeholder="Name"></td>
                <td><input type="text" class="form-control form-control-sm" name="filter_username" value="<?= $this->input->get('filter_username', true); ?>" placeholder="Username"></td>
                <td>
                    <?= form_dropdown('filter_role_id', $roles, $this->input->get('filter_role_id', true), 'class="form-control form-control-sm"'); ?>
                </td>
                <td><input type="text" class="form-control form-control-sm" name="filter_email" value="<?= $this->input->get('filter_email', true); ?>" placeholder="Email"></td>
                <td></td>
                <td>
                    <?= form_dropdown('filter_status', $status, $this->input->get('filter_status', true), 'class="form-control form-control-sm"'); ?>
                </td>
                <td></td>
                <td>
                    <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?= site_url('admin/user'); ?>" class="btn btn-secondary">Reset</a>
                    </div>
                </td>
            </tr>
        </form>

        <?php if (empty($results)): ?>
            <tr><td colspan="5">No record found ..</td></tr>
        <?php else: ?>

            <?php $i = 1; foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <a href="<?php echo site_url('user/profile/' . $row['username']); ?>" target="_blank">
                            <?php echo $row['name']; ?>
                        </a>
                    </td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['role']['role_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo ($row['source_id'] != null) ? 'Codepolitan' : '-'; ?></td>
                    <td>
                        <?php if ($row['status'] == 'active'):?>
                            <span class="badge badge-success"><?php echo $row['status'];?></span>
                        <?php else:?>
                            <span class="badge badge-danger"><?php echo $row['status'];?></span>
                        <?php endif;?>
                    </td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td class="text-right">
                        <div class="btn-group">
                            <?php if($row['status'] == 'inactive'): ?>
                                <a class="btn btn-sm btn-success" href="<?php echo site_url('admin/user/activate/' . $row['id']); ?>" onclick="return confirm('Email belum tervalidasi. Lanjutkan aktivasi?')">Activate</a> 
                                <a class="btn btn-sm btn-info" href="<?php echo site_url('admin/user/edit/' . $row['id']); ?>">Edit</a>
                                <a class="btn btn-sm btn-danger" onclick="return confirm('are you sure?')" href="<?php echo site_url('admin/user/delete/' . $row['id']); ?>">Delete</a>
                            <?php elseif($row['status'] == 'deleted'): ?>
                                <a class="btn btn-sm btn-info" href="<?php echo site_url('admin/user/edit/' . $row['id']); ?>">Edit</a>
                                <a class="btn btn-sm btn-warning" onclick="return confirm('are you sure?')" href="<?php echo site_url('admin/user/block/' . $row['id']); ?>">Undelete</a>
                                <a class="btn btn-sm btn-danger" onclick="return confirm('Purge data will hard delete and cannot be restored. Continue?')" href="<?php echo site_url('admin/user/purge/' . $row['id']); ?>">Purge</a>
                            <?php else: ?>
                                <a class="btn btn-sm btn-info" href="<?php echo site_url('admin/user/edit/' . $row['id']); ?>">Edit</a>
                                <a class="btn btn-sm btn-danger" onclick="return confirm('are you sure?')" href="<?php echo site_url('admin/user/block/' . $row['id']); ?>">Block</a>
                            <?php endif ?>
                        </div>
                    </td>
                </tr>

            <?php $i++; endforeach; ?>

        <?php endif; ?>

    </tbody>
</table>

<?php if(isset($pagination)) : ?>
    <div class="pagination">
        <?php echo $pagination; ?>
    </div>
<?php endif; ?>
