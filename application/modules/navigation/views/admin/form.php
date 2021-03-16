<h2 class="mb-3" id="linkModalLabel"><?= ucfirst($mode); ?> link in <?= $area; ?></h2>

<div class="card">
	<form action="<?php echo site_url($form_link); ?>" id="link-form" class="form" data-mode="<?= $mode; ?>" method="POST">
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="area">Link title</label>
						<?= form_input('title', set_value('title', $link['title'] ?? ''), 'class="form-control field-title"'); ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="area">Link slug</label>
						<?= form_input('slug', set_value('slug', $link['slug'] ?? ''), 'class="form-control field-slug"'); ?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="area">Link URL</label>
						<?= form_dropdown('source', ['http://' => 'http://', 'https://' => 'https://', 'uri' => 'URI'], set_value('source', $link['source'] ?? null), 'class="form-control"'); ?>
					</div>
				</div>
				<div class="col-md-9">
					<div class="form-group">
						<label for="">&nbsp;</label>
						<?= form_input('url', set_value('url', $link['url'] ?? ''), 'class="form-control"'); ?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="area">Navigation Area</label>
						<?php
							$area_dropdown = [];
							foreach ($areas as $a) $area_dropdown[$a] = $a;
						?>
						<?= form_dropdown('area', $area_dropdown, set_value('area', $area ?? null), 'class="form-control"'); ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="area">Link Target</label>
						<?= form_dropdown('target', ['_self' => '_self','_blank' => '_blank','_parent' => '_parent','_top' => '_top'], set_value('target', $link['target'] ?? null), 'class="form-control"'); ?>
					</div>
				</div>
			</div>

		</div>

		<div class="modal-footer">
			<a href="<?= site_url('admin/navigation'); ?>" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
			<button type="submit" id="btn-submit-link-form" class="btn btn-primary"><?= ucfirst($mode); ?> Link</button>
		</div>
	</form>
</div>

<script>
	$(function(){
		$('.field-title').on('keyup', function(){
			if($('form').data('mode') == 'add'){
				let title = $(this).val();
				$('.field-slug').val(title.toLowerCase().replace(/ /g,"_"));
			}
		})
	})
</script>