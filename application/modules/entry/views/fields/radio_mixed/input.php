<?php
$choosen = $value;
foreach ($config['options'] as $key => $val)
{
    if ($choosen == $val)
        $attribute = 'checked';
    else
        $attribute = '';
    ?>
    <div class="form-check">
        <input name="<?php echo $config['field'];?>" class="form-check-input" type="radio" id="<?php echo $key;?>" value="<?php echo $val;?>" <?php echo $attribute;?>>
        <label class="form-check-label" for="<?php echo $key;?>">
            <?php echo $val;?>
        </label>
    </div>
    
    <?php
}
?>
<div class="form-check">
    <input name="<?php echo $config['field'];?>" class="form-check-input" type="radio" id="<?php echo $config['field'];?>_other" name="<?php echo $config['field'];?>" <?php echo $attribute;?> <?= in_array($value, array_keys($config['options'])) ? '' : 'checked'; ?> value="<?= $value; ?>">
    <label class="form-check-label" for="<?php echo $config['field'];?>_other">
        <input type="text" placeholder="lainnya.." class="form-control" id="input_<?php echo $config['field'];?>_other" autocomplete="mati" value="<?= in_array($value, array_keys($config['options'])) ? '' : $value; ?>">
    </label>
</div>
<script>
    $(function(){
        $('#input_<?php echo $config['field'];?>_other').on('focus', function(){
            $('#<?php echo $config['field'];?>_other').prop('checked', true);
        });
        $('#input_<?php echo $config['field'];?>_other').on('keyup', function(){
            $('#<?php echo $config['field'];?>_other').val($(this).val());
        });
    });
</script>