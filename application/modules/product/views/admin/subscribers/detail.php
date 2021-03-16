<div class="title-block">
    <div class="row">
        <div class="col-lg-6">
            <h2><?php echo $page_title; ?></h2>
        </div>
        <div class="col-lg-6 text-right">
            <a href="<?php echo site_url('admin/product/path_subscriber'); ?>" class="btn btn-info-outline">
                <span class="fa fa-arrow-left"></span> Back to subscriptions
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class=" card card-block">
            <h4 class="mb-4">Product Details</h4>
            <table class="table table-sm">
                <tr><th>Name</th><td><?= $result['product_name']; ?></td></tr>
                <tr><th>Desc</th><td><?= $result['product_desc']; ?></td></tr>
                <tr><th>Type</th><td><?= $result['product_type']; ?></td></tr>
                <tr><th>Path</th><td><?= $result['path_name'] . '('. $result['description'] .')'; ?></td></tr>
            </table>
        </div>
        <div class=" card card-block">
            <h4 class="mb-4">Subscription Detail</h4>
            <table class="table table-sm">
                <tr><th>Subscribed at</th><td><?= date('D, d M Y H:i:s', strtotime($result['created_at'])); ?></td></tr>
                <tr><th>Expired at</th><td><?= date('D, d M Y H:i:s', strtotime($result['date_expired'])); ?></td></tr>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class=" card card-block">
            <h4 class="mb-4">Order Details</h4>
            <table class="table table-sm">
                <tr><th width="40%">Order Code</th><td><?= $result['order_code']; ?></td></tr>
                <tr><th>Coupon</th><td><?= (!empty($result['coupon_code'])) ? $result['coupon_code'] : '-'; ?></td></tr>
                <tr><th>Gross Amount</th><td>Rp. <?= number_format($result['gross_amount'], 0, ',','.'); ?></td></tr>
                <tr><th>After Discount</th><td>Rp. <?= number_format($result['gross_amount_discount'], 0, ',','.'); ?></td></tr>
                <tr><th>Product Type</th><td><?= $result['product_type']; ?></td></tr>
                <tr><th>Order Status</th><td><?= $result['status_code'] .' ('. $result['transaction_status'] .')'; ?></td></tr>
                <tr><th>Payment Type</th><td><?= $result['payment_type']; ?></td></tr>
            </table>
        </div>
        <div class=" card card-block">
            <h4 class="mb-4">Customer Detail</h4>
            <table class="table table-sm">
                <tr><th width="30%">Name</th><td><?= $result['name']; ?></td></tr>
                <tr><th>Email</th><td><?= $result['email']; ?></td></tr>
                <tr><th>Username</th><td><?= $result['username']; ?></td></tr>
                <tr><th>Last Login</th><td><?= $result['last_login']; ?></td></tr>
            </table>
        </div>

        <div class="mt-3">
            <?php if ($result['subscribe_status'] == 'publish') :?>
                <a href="<?php echo base_url('admin/product/subscribers/remove/' . $result['id'])?>" onclick="return confirm('Sure?');" class="btn btn-danger">Remove Subscription</a>
            <?php else:?>
                <a href="<?php echo base_url('admin/product/subscribers/publish/' . $result['id'])?>" onclick="return confirm('Sure?');" class="btn btn-success">Publish Subscription</a>
            <?php endif;?>
        </div>
    </div>
</div>