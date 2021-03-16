<style>
	input.title {
		font-size: 1.45em !important;
	}
	#editor { 
		width: 100%; 
		min-height: 300px; 
		font-size: 18px;
		border-right: 1px solid #eee;
	}
</style>
<form action="<?= site_url('panel/pages/'.$form_type.'/'.$url); ?>" method="POST" data-page="<?= $url; ?>" data-mode="<?= $form_type; ?>" class="panel-form">
	<div class="row heading">
		<div class="col-md-6">
			<h2><a href="<?= site_url('panel/pages'); ?>">Pages</a> &bull; <?= ucfirst($form_type); ?> Page</h2>
		</div>
	</div>

	<ul class="nav nav-tabs mt-4" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" href="#main" role="tab" data-toggle="tab">Main</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#optional" role="tab" data-toggle="tab">Optional</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="card card-block tab-content border-left <?= $form_type != 'edit'? 'slugify': ''; ?>">
		<div class="tab-pane active mt-4" id="main">
			<div class="form-group">
				<input type="text" class="form-control form-control-lg title" placeholder="Page title" name="title" id="title" value="<?= set_value('title', $page['page_title']); ?>">
			</div>		
			<div class="form-group">
				<label for="slug">Page Slug</label>
				<input type="text" class="form-control slug" name="slug" id="slug" value="<?= set_value('slug', $page['slug']); ?>">
			</div>		

			<div class="form-group">
				<label for="content" class="pull-left">Content</label>
				<!-- <div class="btn-group pull-right" role="group">
					<button type="button" data-editor="ckeditor" class="btn btn-editor btn-xs btn-success">CKEditor</button>
					<button type="button" data-editor="codemirror" class="btn btn-editor btn-xs">Code</button>
				</div> -->
				<div id="editor" style="width:100%"><?= set_value('content', $page['content']); ?></div>
			</div>
		</div>

		<div class="tab-pane mt-4" id="optional">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="require_login">Require Login</label>
						<input name="require_login" id="require_login" class="form-control" placeholder="i.e. admin, user, leave blank for no restriction" value="<?= set_value('require_login'); ?>">
						<small class="form-text text-muted">Only loggedin user can access</small>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="meta_description">Meta Description <small>optional</small></label>
						<textarea name="meta_description" id="meta_description" class="form-control" rows="3"><?= set_value('meta_description'); ?></textarea>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="row">
		<div class="col-md-6 align-right">
			<button type="submit" name="btnSave" class="btn btn-save btn-info"><span class="fa fa-save"></span> Save</button>
			<button type="submit" name="btnSaveExit" value="1" class="btn btn-save btn-success"><span class="fa fa-save"></span> Save and exit</button>
		</div>
	</div>

</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.1/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
	var editor = ace.edit("editor", {
		theme: "ace/theme/tomorrow",
		mode: "ace/mode/twig",
		autoScrollEditorIntoView: true,
		maxLines: 200,
		minLines: 20,
		cursorStyle: "smooth",
		tabSize: 2
	});
	editor.getSession().setUseWrapMode(true);

	var beautify = ace.require("ace/ext/beautify");
	beautify.beautify(editor.session);
</script>