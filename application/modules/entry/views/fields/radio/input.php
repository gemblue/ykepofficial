<?php
$choosen = $value;
foreach ($config['options'] as $key => $value)
{
    if ($choosen == $value || $choosen == $key)
        $attribute = 'checked';
    else
        $attribute = '';
    ?>
    <div class="form-check">
        <input name="<?php echo $config['field'];?>" class="form-check-input" type="radio" id="<?php echo $key;?>" value="<?php echo $key;?>" <?php echo $attribute;?>>
        <label class="form-check-label" for="<?php echo $key;?>">
            <?php echo $value;?>
        </label>
    </div>
    
    <?php
}
?>
