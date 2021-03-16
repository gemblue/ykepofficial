<div class="title-block">
 	<h3 class="title"><?php echo $page_title; ?>
 		<span class="sparkline bar" data-type="bar"></span>
 	</h3>
</div>

<div class="card card-block">

    <?php if ($form_type == 'edit'):?>
        Created at <?php echo time_ago($result['created_at']); ?>
    <?php endif;?>

    <div style="margin-bottom:30px;"></div>
    
    <form id="post-form" method="post" action="<?php echo $action_url;?>" enctype="multipart/form-data">
        
        <input type="hidden" name="id" value="<?php echo (isset($result['id']) ? $result['id'] : ''); ?>"/>
        <input type="hidden" name="product_type" value="<?php echo $choosen_product_type; ?>" />

        <h3>Basic</h3>

        <hr />

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="product_name" value="<?php echo (isset($result['product_name']) ? $result['product_name'] : $this->session->flashdata('name')); ?>" class="form-control"/>
        </div>

        <div class="form-group">
            <label>Slug</label>
            <input type="text" name="product_slug" value="<?php echo (isset($result['product_slug']) ? $result['product_slug'] : $this->session->flashdata('slug')); ?>" class="form-control"/>
        </div>

        <div class="form-group">
            <label>Desc</label>
            <input type="text" name="product_desc" value="<?php echo (isset($result['product_desc']) ? $result['product_desc'] : $this->session->flashdata('desc')); ?>" class="form-control"/>
        </div>

        <div class="form-group">
            <label>Normal Price</label>
            <input type="text" name="normal_price" value="<?php echo (isset($result['normal_price']) ? $result['normal_price'] : $this->session->flashdata('normal_price')); ?>" class="form-control"/>
        </div>

        <div class="form-group">
            <label>Retail Price</label>
            <input type="text" name="retail_price" value="<?php echo (isset($result['retail_price']) ? $result['retail_price'] : $this->session->flashdata('retail_price')); ?>" class="form-control"/>
        </div>

        <h3>Custom</h3>

        <hr />
        
        <?php if (!empty($product_types[$choosen_product_type]['custom_fields'])) :?>
            <div class="custom-data-form">
                
                <?php foreach($product_types[$choosen_product_type]['custom_fields'] as $field) :?>
                    <div class="form-group">
                        <label><?php echo make_label($field['name']);?></label>
                        <input type="text" name="custom_data[<?php echo $field['name'];?>]" class="form-control" value="<?php echo (isset($result)) ? $result['custom_data'][$field['name']] : '';?>"/>
                    </div>
                <?php endforeach;?>
            
            </div>
        <?php else:?>
            No custom fields ..<br/><br/>
        <?php endif;?>
        
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>  