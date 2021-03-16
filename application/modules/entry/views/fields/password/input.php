<div class="input-group">
	<input type="password" id="<?= $config['field'];?>" 
	name="<?= $config['field'];?>"
	placeholder="<?= $config['placeholder'] ?? '';?>" class="form-control"/>
	
	<div class="input-group-append">
	   <button class="btn py-2 mb-0 btn-secondary" id="show_password_<?= $config['field'];?>" data-toggle="hide" type="button"><span class="fa fa-eye-slash"></span></button>
	</div>
</div>
<script>
	$(function(){
		$('#show_password_<?= $config['field'];?>').on('click', function(){
			if($(this).data('toggle') == 'hide'){
				$(this).data('toggle', 'show');
				$(this).html('<span class="fa fa-eye"></span>');
				$('#<?= $config['field'];?>').attr('type', 'text');
			} else {
				$(this).data('toggle', 'hide');
				$(this).html('<span class="fa fa-eye-slash"></span>');
				$('#<?= $config['field'];?>').attr('type', 'password');
			}
		})
	})
</script>