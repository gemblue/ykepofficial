<div class="mb-4">
	<div class="row">
		<div class="col-6">
			<h2 class="mt-1"><?php echo $page_title;?></h2>
		</div>
	</div>
</div>

<div class="card card-block">

    <?php if ($form_type == 'edit'):?>
        Created at <?php echo time_ago($product->created_at); ?>
    <?php endif;?>
    
    <form id="post-form" class="slugify" method="post" action="<?php echo $action_url;?>" enctype="multipart/form-data">
        
        <input type="hidden" name="id" value="<?php echo (isset($product->id) ? $product->id : ''); ?>"/>
        <input type="hidden" name="product_type" value="<?php echo $choosen_product_type; ?>" />
        <input type="hidden" name="object_type" value="<?php echo $choosen_product_type; ?>"/>
        
        <h3 class="border-bottom mb-3 py-3">Data Dasar</h3>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="product_name" value="<?php echo (isset($product->product_name) ? $product->product_name : $this->session->flashdata('product_name')); ?>" class="form-control title"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="product_slug" value="<?php echo (isset($product->product_slug) ? $product->product_slug : $this->session->flashdata('product_slug')); ?>" class="form-control slug"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi Produk</label>
            <textarea name="product_desc" class="form-control"><?php echo (isset($product->product_desc) ? $product->product_desc : $this->session->flashdata('desc')); ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Harga Coret</label><br>
                    <small>Tidak digunakan pada perhitungan</small>
                    <input type="text" name="normal_price" value="<?php echo (isset($product->normal_price) ? $product->normal_price : $this->session->flashdata('normal_price')); ?>" class="form-control"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Harga Asli</label><br>
                    <small>0: gratis, -1: tidak dijual satuan</small>
                    <input type="text" name="retail_price" value="<?php echo (isset($product->retail_price) ? $product->retail_price : $this->session->flashdata('retail_price')); ?>" class="form-control"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Gambar Produk</label>
                    <div class="input-group mb-3">
                        <input type="text" name="product_image" id="product_image" class="form-control" placeholder="Gambar produk" value="<?php echo (isset($product->product_image)) ? $product->product_image : $this->session->flashdata('product_image');?>">
                        <div class="input-group-append">
                            <a href="#" class="input-group-text btn btn-file-manager btn btn-primary-outline mb-0" data-target="product_image">Choose</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Gunakan Ongkir</label>
                    <select name="count_expedition" class="form-control">
                        <option value="">Pilih ..</option>
                        <option value="1" <?php echo (isset($product->count_expedition) && $product->count_expedition == true) ? 'selected' : '';?>>Yes</option>
                        <option value="0" <?php echo (isset($product->count_expedition) && $product->count_expedition == false) ? 'selected' : '';?>>No</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Status</label>
                    <select name="publish" class="form-control">
                        <option value="1" <?php echo ($product->publish) ? 'selected' : '';?>>Publish</option>
                        <option value="0" <?php echo (!$product->publish) ? 'selected' : '';?>>Draft</option>
                    </select>
                </div>
            </div>
        </div>
        
        <?php if($product->productType->options): ?>

            <h3 class="border-bottom mt-5 mb-3 py-3">Data Spesifik</h3>

            <?php foreach($product->productType->options as $field => $option): ?>
            
            <div class="form-group">
                <label><?= $option['label']; ?></label><br>
                <small><?= $option['description'] ?? ''; ?></small>
                <?= generate_input($option, $product->{$field} ?? null); ?>
            </div>

            <?php endforeach; ?>
            
        <?php endif; ?>

        <hr class="mt-5 mb-4">
        <button type="submit" class="btn btn-lg btn-success text-light"><span class="fa fa-save"></span> Simpan Produk</button>
    </form>
</div>  
