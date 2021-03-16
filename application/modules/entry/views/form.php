
<form method="post" action="#" enctype="multipart/form-data">
    
    <input type="hidden" name="entry" id="entry" value="<?php echo $entry;?>">

    <?php foreach ($fields as $field => $value) :?>
        <div class="form-group">
            <label><?php echo make_label($value['name']);?></label>
            <?php if($value['description'] ?? null): ?>
                <small><?php echo $value['description'];?></small>
            <?php endif; ?>
            <?php echo generate_input($entry, $id, $field, $value['type'], $value['referrer']);?>
            <small class="form-text"><?php echo $this->session->flashdata('form_error_' . $field);?></small>
        </div>
    <?php endforeach;?>
    
    <div style="margin-top:30px;"></div>

    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-flash"></span> Save</button>

</form>
