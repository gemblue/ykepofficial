<form action="<?= site_url('admin/setting/update')?>" method="post">

	<div class="row">
		<div class="col">
			<h2><?= $page_title; ?></h2>
		</div>
		<div class="col text-right">
			<button type="submit" class="btn btn-success text-light"><span class="fa fa-save"></span> Save Settings</button>
		</div>
	</div>

	<div style="margin-bottom:30px;"></div>

	<div class="row">
		<div class="nav col-lg-2 col-md-3 col-5 flex-column nav-pills mb-5" id="v-pills-tab" role="tablist" aria-orientation="vertical">

			<h6 class="font-italic font-weight-bold text-info p-2 mb-0 mt-2 border-top border-bottom">Site Settings</h6>
			<?php foreach($shared_setting as $module_slug => $module) :?>
			<a class="nav-link <?= $module_slug == 'site' ? 'active' : ''; ?>" id="v-pills-<?= $module_slug; ?>-tab" data-toggle="pill" href="#v-pills-<?= $module_slug; ?>" role="tab" aria-controls="v-pills-<?= $module_slug; ?>" aria-selected="false"><?= $module['name']; ?></a>
			<?php endforeach;?>

			<h6 class="font-italic font-weight-bold text-info p-2 mb-0 mt-2 border-top border-bottom">Module Settings</h6>
			<?php foreach($modules_setting as $module_slug => $module) :?>
				<?php if(!$module['enable']) continue; ?>
				<a class="nav-link" id="v-pills-<?= $module_slug; ?>-tab" data-toggle="pill" href="#v-pills-<?= $module_slug; ?>" role="tab" aria-controls="v-pills-<?= $module_slug; ?>" aria-selected="false"><?= $module['name']; ?></a>
			<?php endforeach;?>

			<h6 class="font-italic font-weight-bold text-info p-2 mb-0 mt-2 border-top border-bottom">Entries Settings</h6>
			<?php foreach($entries_setting as $module_slug => $module) :?>
			<a class="nav-link" id="v-pills-<?= $module_slug; ?>-tab" data-toggle="pill" href="#v-pills-<?= $module_slug; ?>" role="tab" aria-controls="v-pills-<?= $module_slug; ?>" aria-selected="false"><?= $module['name']; ?></a>
			<?php endforeach;?>

			<h6 class="font-italic font-weight-bold text-info p-2 mb-0 mt-2 border-top border-bottom">Plugin Settings</h6>
			<?php foreach($plugin_setting as $module_slug => $module) :?>
			<a class="nav-link" id="v-pills-<?= $module_slug; ?>-tab" data-toggle="pill" href="#v-pills-<?= $module_slug; ?>" role="tab" aria-controls="v-pills-<?= $module_slug; ?>" aria-selected="false"><?= $module['name']; ?></a>
			<?php endforeach;?>

		</div>

		<div class="col-lg-10 col-md-9 col-7 tab-content border-left px-3" id="v-pills-tabContent">

			<?php foreach($shared_setting as $module_slug => $module) :?>
				<div class="tab-pane fade <?= $module_slug == 'site' ? 'show active' : ''; ?>" id="v-pills-<?= $module_slug; ?>" role="tabpanel" aria-labelledby="v-pills-<?= $module_slug; ?>-tab">
					<?php foreach($module['setting'] as $setting) :?>
					<div class="form-group">
						<label class="mr-2"><?= $setting['label'] ?? make_label($setting['field']);?></label>
						<code><?= $module_slug.'.'.$setting['field']; ?></code>
						<?php if($setting['desc'] ?? null): ?>
							<p class="small"><?= $setting['desc'] ?? ''; ?></p>
						<?php endif; ?>

						<div class="input-group">	
						<?php
							$config = array_merge($setting, ['field' => $module_slug.'['.$setting['field'].']']);
							echo generate_input($config, setting_item($module_slug.'.'.$setting['field']));
							?>
						</div>
					</div>
					<?php endforeach;?>
				</div>
			<?php endforeach;?>

			<?php foreach($modules_setting as $module_slug => $module) :?>
				<div class="tab-pane fade" id="v-pills-<?= $module_slug; ?>" role="tabpanel" aria-labelledby="v-pills-<?= $module_slug; ?>-tab">
					<?php foreach($module['setting'] as $setting) :?>
					<div class="form-group">
						<label class="mr-2"><?= $setting['label'] ?? make_label($setting['field']);?></label>
						<code><?= $module_slug.'.'.$setting['field']; ?></code>
						<?php if($setting['desc'] ?? null): ?>
							<p class="small"><?= $setting['desc'] ?? ''; ?></p>
						<?php endif; ?>

						<div class="input-group">
						<?php
							$config = array_merge($setting, ['field' => $module_slug.'['.$setting['field'].']']);
							echo generate_input($config, setting_item($module_slug.'.'.$setting['field']));
							?>
						</div>
					</div>
					<?php endforeach;?>
				</div>
			<?php endforeach;?>

			<?php foreach($entries_setting as $module_slug => $module) :?>
				<div class="tab-pane fade" id="v-pills-<?= $module_slug; ?>" role="tabpanel" aria-labelledby="v-pills-<?= $module_slug; ?>-tab">
					<?php foreach($module['setting'] as $setting) :?>
					<div class="form-group">
						<label class="mr-2"><?= $setting['label'] ?? make_label($setting['field']);?></label>
						<code><?= $module_slug.'.'.$setting['field']; ?></code>
						<?php if($setting['desc'] ?? null): ?>
							<p class="small"><?= $setting['desc'] ?? ''; ?></p>
						<?php endif; ?>

						<div class="input-group">
						<?php
							$config = array_merge($setting, ['field' => $module_slug.'['.$setting['field'].']']);
							echo generate_input($config, setting_item($module_slug.'.'.$setting['field']));
							?>
						</div>
					</div>
					<?php endforeach;?>
				</div>
			<?php endforeach;?>	

			<?php foreach($plugin_setting as $module_slug => $module) :?>
				<div class="tab-pane fade" id="v-pills-<?= $module_slug; ?>" role="tabpanel" aria-labelledby="v-pills-<?= $module_slug; ?>-tab">
					<?php foreach($module['setting'] as $setting) :?>
					<div class="form-group">
						<label class="mr-2"><?= $setting['label'] ?? make_label($setting['field']);?></label>
						<code><?= $module_slug.'.'.$setting['field']; ?></code>
						<?php if($setting['desc'] ?? null): ?>
							<p class="small"><?= $setting['desc'] ?? ''; ?></p>
						<?php endif; ?>

						<div class="input-group">
						<?php
							$config = array_merge($setting, ['field' => $module_slug.'['.$setting['field'].']']);
							echo generate_input($config, setting_item($module_slug.'.'.$setting['field']));
							?>
						</div>
					</div>
					<?php endforeach;?>
				</div>
			<?php endforeach;?>	
		</div>

	</div>
</form>
