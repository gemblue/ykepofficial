<?php
	$attrs = '';
	if(isset($config['attr']))
		foreach ($config['attr'] as $key => $val) {
			$attrs .= $key.'="'.$val.'" ';
		}
?>
<input id="<?php echo $config['field'];?>" type="number" name="<?php echo $config['field'];?>" value="<?php echo $value; ?>" class="form-control" <?= $attrs; ?> />