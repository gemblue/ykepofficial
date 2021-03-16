<label class="align-middle pr-2"><?= $config['options'][0]; ?></label>
<label class="align-middle switch" id="<?= $config['field'];?>">
		<input type="checkbox" <?= $value == '1' ? 'checked':''; ?>>
		<span class="slider round d-inline-block"></span>
		<input type="hidden" name="<?= $config['field'];?>" value="<?= $value; ?>">
</label>
<label class="align-middle pl-2"><?= $config['options'][1]; ?></label>

<script>
	$(function(){
		let swParent = $('#<?= $config['field'];?>');
		swParent.children('input[type=checkbox]').on('change', function(){
			let checked = $(this).prop('checked');
			swParent.children('input[type=hidden]').val(Number(checked));
		})
	})
</script>
