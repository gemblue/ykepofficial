<div class="mb-3">
    <div class="row">
        <div class="col-lg-6">
            <h2><?php echo $page_title; ?></h2>
        </div>
        <!--         
        <div class="col-lg-6">
		    <a href="<?php echo site_url('admin/subscriber/add');?>" class="pull-right input-group-text btn btn-primary-outline mb-0">+ New</a>
        </div>
        -->
    </div>
</div>

<?php echo $this->session->flashdata('message');?>

<table class="table table-striped table-hover table-sm mt-4">
    <thead>
        <tr>
            <th>User</th>
            <th>Email</th>
            <th>Product</th>
            <th>Type</th>
            <th>Expired at</th>
            <th>Created at</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <form>
            <tr>
                <td><input type="text" class="form-control form-control-sm" name="filter_name" value="<?= $this->input->get('filter_name', true); ?>"></td>
                <td><input type="text" class="form-control form-control-sm" name="filter_email" value="<?= $this->input->get('filter_email', true); ?>"></td>
                <td><input type="text" class="form-control form-control-sm" name="filter_product_name" value="<?= $this->input->get('filter_product_name', true); ?>"></td>
                <td><input type="text" class="form-control form-control-sm" name="filter_subscribe_object_type" value="<?= $this->input->get('filter_subscribe_object_type', true); ?>"></td>
                <td></td>
                <td></td>
                <td>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success-outline">Filter</button>
                        <a href="<?= site_url('admin/product/subscribers'); ?>" class="btn btn-danger-outline">Reset</a>
                    </div>
                </td>
            </tr>
        </form>

        <?php if (empty($results)): ?>
            <tr><td colspan="5">No record found ..</td></tr>
        <?php else: ?>

        <?php foreach ($results as $result): ?>
            <tr>
                <td><a href="<?= site_url('admin/user/user/edit/' . $result['user']['id']); ?>"><?php echo $result['user']['name'];?></a></td>
                <td><?php echo $result['user']['email'];?></td>
                <td><?php echo $result['product']['product_name'];?></td>
                <td><?php echo $result['subscribe_object_type'];?></td>
                <td width="140px"><b>Ex: <?php echo date('d M Y', strtotime($result['date_expired']));?></b></td>
                <td width="140px"><?php echo date('d M Y', strtotime($result['created_at']));?></td>
                <td class="text-right">
                    <div class="btn-group">
                        <a class="btn btn-sm btn-success" href="<?php echo site_url('admin/product/subscribers/detail/'. $result['id']); ?>" title="Detail">Detail</a>
                        <a class="btn btn-sm btn-info btn-expiry" data-product-name="<?php echo $result['product']['product_name'];?>" data-user-name="<?php echo $result['user']['name'];?>" data-user-id="<?php echo $result['user']['id'];?>" data-product-id="<?php echo $result['product']['id'];?>" href="#" title="Manage Expiry">
                            <span class="fa fa-flash"></span> Expiry
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php endif ?>

    </tbody>
</table>
    
<?php if(isset($pagination)) : ?>
    <div class="pagination">
        <?php echo $pagination; ?>
    </div>
<?php endif; ?>

<div class="modal" id="Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage Expired Time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo site_url('admin/product/subscribers/expiry');?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="user_id" name="user_id">
                    <input type="hidden" id="product_id" name="product_id">
                    
                    <div class="form-group">
                        <label for="">User</label>
                        <input type="text" class="form-control" id="user_name" readonly />
                    </div>
                    <div class="form-group">
                        <label for="">Product</label>
                        <input type="text" class="form-control" id="product_name" readonly />
                    </div>
                    <div class="form-group">
                        <label for="">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="">Select ..</option>
                            <option value="extend">Extend (Penambahan Waktu)</option>
                            <option value="substract">Substract (Pengurangan Waktu)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Day</label>
                        <input type="number" class="form-control" id="day" name="day" />
                        <small id="emailHelp" class="form-text text-muted">Masukan jumlah hari.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Implement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('.btn-expiry').click(function(){
    $('#Modal').modal('show');

    $('#user_name').val($(this).attr('data-user-name'));
    $('#product_name').val($(this).attr('data-product-name'));
    $('#user_id').val($(this).attr('data-user-id'));
    $('#product_id').val($(this).attr('data-product-id'));
});
</script>