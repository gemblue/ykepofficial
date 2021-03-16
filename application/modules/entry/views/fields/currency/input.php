<?php
	$attrs = '';
	if(isset($config['attr']))
		foreach ($config['attr'] as $key => $val) {
			$attrs .= $key.'="'.$val.'" ';
		}
?>
<div class="input-group">
    <div class="input-group-prepend">
      <div class="input-group-text">Rp</div>
    </div>
	<input id="<?php echo $config['field'];?>" type="number" name="<?php echo $config['field'];?>" value="<?php echo $value; ?>" class="form-control" <?= $attrs; ?> />
  </div>