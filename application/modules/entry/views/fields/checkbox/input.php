<?php
$chosen = json_decode($value, true);
if (empty($chosen)) $chosen = [];

foreach ($config['options'] as $key => $value)
{
    if (in_array($value, $chosen))
        $attribute = 'checked';
    else
        $attribute = '';
    ?>

    <div class="form-check">
        <input name="<?php echo $config['field'] ;?>[]" class="form-check-input" type="checkbox" value="<?php echo $value;?>" id="<?php echo $key;?>" <?php echo $attribute;?>>
        <label class="form-check-label" for="<?php echo $key;?>">
            <?php echo $value;?>
        </label>
    </div>

    <?php
}
?>