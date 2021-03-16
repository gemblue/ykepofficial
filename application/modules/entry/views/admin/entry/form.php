<div class="title-block">
 	<h3 class="title"><?php echo $page_title; ?>
 		<span class="sparkline bar" data-type="bar"></span>
 	</h3>
</div>

<div class="card card-block">

    <form method="post" action="<?php echo $action_url.'?'.$_SERVER['QUERY_STRING']; ?>" enctype="multipart/form-data">

        <div class="row">
                
            <?php foreach ($fields as $field => $fieldConf) :?>
            
            <div class="col-md-6 <?= $fieldConf['hide_input'] ?? 0 ? 'sr-only' : '' ; ?>">
                <div class="form-group">
                    <?php if(! ($fieldConf['hide_label'] ?? false)): ?>
                        <label><?php echo $fieldConf['label'];?></label>
                    <?php endif; ?>

                    <?php if($fieldConf['description'] ?? null): ?>
                        <small> &bull; <?php echo $fieldConf['description'];?></small>
                    <?php endif; ?>
                    
                    <div class="d-block">
                        <?php echo generate_input($fieldConf, $result[$field] ?? null, $options ?? null);?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <small class="form-text"><?php echo $this->session->flashdata('form_error_' . $field);?></small>
            </div>

            <?php endforeach;?>
        
        </div>

        <hr class="my-4">

        <button type="submit" class="btn btn-success text-white"><span class="fa fa-save"></span> Save Data</button>
        
        <?php if($add_url): ?>
        <a href="<?= $add_url; ?>" class="btn btn-secondary"><span class="fa fa-plus-circle"></span> Add New</a>
        <?php endif; ?>

        <a href="<?php echo site_url('admin/entry/' . $entry).'?'.$_SERVER['QUERY_STRING'];?>" class="btn btn-secondary"><span class="glyphicon glyphicon-menu-left"></span> Back to Entry</a>

    </form>
</div>
