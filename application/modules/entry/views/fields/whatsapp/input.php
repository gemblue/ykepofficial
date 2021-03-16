<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
}
</style>

<?php
	$attrs = '';
	$config['attr']['placeholder'] = '81XXXXXXXX';
	foreach ($config['attr'] as $key => $val) {
		$attrs .= $key.'="'.$val.'" ';
	}
?>
<div class="input-group mb-2">
	<div class="input-group-prepend">
		<div class="input-group-text">+62</div>
	</div>
	<input id="<?php echo $config['field'];?>" type="number" name="<?php echo $config['field'];?>" value="<?php echo $value; ?>" class="form-control" <?= $attrs; ?> />
</div>
