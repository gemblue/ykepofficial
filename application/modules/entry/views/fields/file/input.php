<div class="input-group">
	<input type="text" name="<?= $config['field'];?>" id="<?= $config['field'];?>" class="form-control" placeholder="<?php echo $config['placeholder'] ?? '';?>" value="<?= $value; ?>">
	<div class="input-group-append">
		<a href="#" class="input-group-text btn btn-file-manager btn btn-primary-outline mb-0" data-target="<?= $config['field'];?>">Choose</a>
	</div>
</div>