<div class="mb-4">
    <div class="row">
        <div class="col-6">
            <h2><?php echo $page_title; ?></h2>
        </div>
        <div class="col-6 text-right pt-2">
            <?php if(count($product_types) > 1): ?>
            <div class="dropdown">
              <button class="btn btn-primary-outline mb-0 btn-add-new dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fa fa-plus-circle"></span> New Product
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php foreach ($product_types as $type => $product_type): ?>
                    <a class="dropdown-item" href="<?= site_url('admin/product/add/'.$type) ?>"><?= ucfirst($product_type); ?></a>
                <?php endforeach; ?>
              </div>
            </div>
            <?php else: ?>
                <?php foreach ($product_types as $type => $product_type): ?>
                    <a class="btn btn-primary" href="<?= site_url('admin/product/add/'.$type) ?>">
                        <span class="fa fa-plus-circle"></span> New <?= strtolower($product_type)=='default' ? 'Product' : ucfirst($product_type); ?>    
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php echo $this->session->flashdata('message');?>

<table class="table table-striped table-hover table-responsive table-sm" style="overflow-y:hidden">
    <thead>
        <tr>
            <!-- <th><input class="select-all" type="checkbox"/></th> -->
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Type</th>
            <th>Price</th>
            <th>Expedition (Ongkir)</th>
            <th>Active</th>
            <th>Publish</th>
        </tr>
    </thead>
    <tbody>
        <!-- Form filter -->
        <form>
        <tr>
            <td>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>
                    <a href="<?= site_url('admin/product'); ?>" class="btn btn-secondary"><span class="fa fa-refresh"></span></a>
                </div>
            </td>
            <td><input type="text" class="form-control form-control-sm" name="filter_product_name" value="<?= $this->input->get('filter_product_name', true); ?>"></td>
            <td><input type="text" class="form-control form-control-sm" name="filter_product_slug" value="<?= $this->input->get('filter_product_slug', true); ?>"></td>
            <td>
                <?= form_dropdown('filter_product_type', [''=>'All'] + $product_types, $this->input->get('filter_product_type', true), 'class="form-control form-control-sm"'); ?>
            </td>
            <td>
                Normal price / Real price
            </td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        </form>
        <!-- End form filter -->
        
        <?php if (empty($results)): ?>
            <tr><td colspan="5">No record found ..</td></tr>
        <?php else: ?>

        <?php foreach ($results as $result): ?>
            <tr>
                <td>
                    <?php echo $result['id'];?>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-cog"></span>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button class="dropdown-item" data-toggle="popover" data-content="Order URL: <?= site_url('payment/cart/add/'.$result['product_slug']); ?>" title="Edit"><span class="fa fa-code"></span> Show snippet</button>
                        <a class="dropdown-item text-success" href="<?php echo site_url('admin/product/edit/'. $result['id']); ?>" title="Edit"><span class="fa fa-pencil"></span> Edit Product</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" onclick="return confirm('are you sure?')" href="<?php echo site_url('admin/product/delete/' . $result['id']); ?>" title="Delete"><span class="fa fa-remove"></span> Remove Product</a>
                      </div>
                    </div>
                </td>
                <td><?php echo $result['product_name'];?></td>
                <td><?php echo $result['product_slug'];?></td>
                <td><?php echo $result['product_type'];?></td>
                <td class="text-right">
                    <?php if ($result['retail_price'] > 0) : ?>
                        <?php echo !empty($result['normal_price'])
                            ? '<del class="text-muted">'.number_format($result['normal_price'], 0, ',','.').'</del><br><span class="text-primary">'.number_format($result['retail_price'], 0, ',','.').'</span>'
                            : '<span class="text-primary">'.number_format($result['retail_price'], 0, ',','.').'</span>';
                        ?>
                    <?php else :?>
                        FREE
                    <?php endif;?>
                </td>
                <td><?php echo ($result['count_expedition']) ? '<span class="fa fa-check text-success"></span>' : '<span class="fa fa-times text-danger"></span>';?></td>
                <td><?php echo ($result['active']) ? '<span class="fa fa-check text-success"></span>' : '<span class="fa fa-times text-danger"></span>';?></td>
                <td><?php echo ($result['publish']) ? '<span class="fa fa-check text-success"></span>' : '<span class="fa fa-times text-danger"></span>';?></td>
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

<p><em>NB: normal price is just a label, not used in calculation. Set real/retail price for real calculation.</em></p>

<!-- Modal -->
<div class="modal fade" id="shortcodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Shortcode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<input type="hidden" id="site_url" value="<?php echo site_url()?>" />

<script>
    var site_url = $('#site_url').val();

	$('#shortcodeModal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget);
	  var modal = $(this);
	  modal.find('.modal-title').text(button.data('header'));
	  modal.find('.modal-body').html(button.find('.modal-content').html());
	})
</script>