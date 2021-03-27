<!-- Dependency -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css">
<style>
div.tagsinput {
    background: #FFF;
    padding: 5px;
    overflow-y: auto;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    width: 100% !important;
}
div.tagsinput span.tag {
    border: 1px solid #444;
    background: #444;
    color:#FFF;
}
.editor-toolbar.fullscreen,
.CodeMirror-fullscreen,
.editor-preview-side {
    z-index: 50;
}
input.title {
    font-size: 1.45em !important;
}
.desc {margin: -8px 0 10px;display: block;}
</style>

<div class="mb-4">
    <div class="row">
        <div class="col-6">
            <h2><a href="<?= site_url('admin/post/index/all/'.$post_type); ?>"><?php echo $page_title;?></a> &middot; Edit</h2>
        </div>
    </div>
</div>

<div class="card card-block <?= $form_type != 'edit'? 'slugify': ''; ?>">
    
    <?php if ($form_type == 'edit'):?>
    <div class="row">
        <div class="col-sm">
                Created by <?php echo $result->username;?> at <?php echo time_ago($result->created_at); ?>
        </div>
        <div class="col-sm">
                <a href="<?php echo site_url($result->slug)?>" class="btn btn-info btn-sm pull-right" target="<?php echo $result->id;?>">Open article &nbsp;&nbsp;<span class="fa fa-external-link"></span></a>
        </div>
    </div>
    <?php endif;?>

 	<form id="post-form" method="post" class="mt-4" action="<?php echo ($form_type == 'new' ? site_url('admin/post/insert') : site_url('admin/post/update'));?>" enctype="multipart/form-data">

 		<input type="hidden" name="post_type" id="post_type" value="<?php echo $result->type ?? $post_type; ?>">
 		<input type="hidden" name="post_id" id="post_id" value="<?php echo $result->id ?? ''; ?>"/>
 		<input type="hidden" name="mode" id="mode" value="<?php echo (isset($result->id)) ? 'update' : 'insert'; ?>"/>
 		
 		<div class="form-group">
 			<input type="text" placeholder="Post Title" name="title" id="title" value="<?php echo (isset($result->title)) ? $result->title : $this->session->flashdata('title'); ?>" class="form-control form-control-lg title" autofocus />
 		</div>
        
 		<div class="form-group">
 			<label>Slug (Seo Friendly Url)</label>
 			<input type="text" name="slug" id="slug" value="<?php echo (isset($result->slug)) ? $result->slug : $this->session->flashdata('slug'); ?>" class="form-control slug"/>
 		</div>
        
        <div class="form-group">
            <label>Content</label>
            <textarea name="content" id="content" class="form-control"><?php echo (!empty($result->content) ? $result->content : $this->session->flashdata('content'));?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?php if ($post_type != 'page'):?>
                    <div class="form-group-inline">
                        <label>Category</label>
                        <div class="input-group">
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="0" selected="selected">Choose ..</option>
                                <?php
                                if (isset($category->term_id))
                                    $current = $category->term_id;
                                else
                                    $current = null;

                                foreach ($categories as $c)
                                {
                                    ?>
                                    <option value="<?php echo $c->term_id;?>" <?php echo ($c->term_id == $current) ? 'selected' : '';?> ><?php echo $c->name;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="input-group-append">
                                <a href="#" data-toggle="modal" data-target="#categoryModal" class="input-group-text btn btn-primary-outline mb-0">+ New Category</a>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <div class="form-group">
                    <label>Tags</label>
                    <input type="text" id="tags" name="tags" value="<?php echo (isset($tags)) ? $tags : $this->session->flashdata('tags');?>" class="form-control" placeholder="Ex: This, Is, Tag"/>
                </div>

                <div class="form-group">
                    <label>Is this featured?</label>
                    <select id="featured" name="featured" class="form-control">
                        <option value="">Select ..</option>
                        <option value="Yes" <?php echo (isset($result->featured) && !empty($result->featured)) ? 'selected' : '';?>>Yes</option>
                        <option value="No" <?php echo (isset($result->featured) && $result->featured == null) ? 'selected' : '';?>>No</option>
                    </select>
                </div>

             </div>
        
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label>Featured Image</label>
                    <div class="input-group mb-3">
                        <input type="text" id="featured_image" name="featured_image" class="form-control" placeholder="Featured image .." value="<?php echo (isset($result->featured_image)) ? $result->featured_image : $this->session->flashdata('featured_image');?>">
                        <div class="input-group-append">
                            <a href="#" class="input-group-text btn btn-file-manager btn btn-primary-outline mb-0" data-target="featured_image">Choose</a>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>PDF</label>
                    <div class="input-group mb-3">
                        <input type="text" id="pdf" name="pdf" class="form-control" placeholder="Link to PDF" value="<?php echo (isset($result->pdf)) ? $result->pdf : $this->session->flashdata('pdf');?>">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>Redirect Link</label>
                    <div class="input-group mb-3">
                        <input type="text" id="redirect_link" name="redirect_link" class="form-control" placeholder="Redirect Link" value="<?php echo (isset($result->redirect_link)) ? $result->redirect_link : $this->session->flashdata('redirect_link');?>">
                    </div>
                </div>
         		<div class="form-group">
         			<label>Template</label>
         			<select id="template" name="template" class="form-control">
         				<option value="default">Default</option>
         				<?php if(!empty($templates))
         				foreach ($templates as $template)
         				{
         					?><option value="<?php echo $template; ?>" <?php echo (isset($result->template) && $result->template == $template ? 'selected="selected"' : ''); ?> ><?php echo $template; ?></option><?php
         				}
         				?>
         			</select>
         			<div style="margin-top:10px;">
         				<small>Template active: <span class="label label-success"><?php echo (!empty($result->template)) ? $result->template : 'Default';?></span></small>
         			</div>
                </div>
        
         		<!-- <div class="form-group">
         			<label>Status</label>
         			<select id="status" class="form-control">
         				<option value="draft" <?php echo (isset($result->status) && $result->status == 'draft') ? 'selected' : '';?>>Draft</option>
                        <option value="publish" <?php echo (isset($result->status) && $result->status == 'publish') ? 'selected' : '';?>>Published</option>
         			</select>
         		</div> -->
            </div>
        </div>

        <?php if($posttypes[$post_type]['table'] ?? null): ?>
        <div class="row border-top pt-4 mt-4">
            <div class="col-md-12 mb-3">
                <h3>Meta Fields</h3>    
            </div>

            <?php foreach($posttypes[$post_type]['fields'] as $field => $fieldConf): ?>
            <?php if($field == 'post_id') continue; ?>
            <div class="col-md-6 mb-3">
                <?php 
                    $fieldname = "meta[$field]"; 
                    $fieldConf['field'] = $fieldname;
                ?>
                <label for="<?= $field; ?>"><?= $fieldConf['label']; ?></label>
                <?php if($fieldConf['description'] ?? null): ?>
                <br><small class="desc"><?= $fieldConf['description']; ?></small>
                <?php endif; ?>
                <?= generate_input($fieldConf, $meta[$field] ?? null); ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

 		<div style="margin-top:30px;"></div>
        
 		<?php if ($form_type == 'edit') :?>
                 
 			<?php if ($result->status == 'draft' || $result->status == 'review'):?>
 				<a href="<?php echo site_url('admin/post/publish/' . $result->id . '?callback=' . current_url());?>" class="btn btn-success">Publish</a>
 			<?php else:?>
 				<a href="<?php echo site_url('admin/post/draft/' . $result->id . '?callback=' . current_url());?>" class="btn btn-warning">Draft</a>
 			<?php endif;?>
            
 		<?php endif;?>

 		<?php if (!isset($result->status)): ?>
 			<button type="button" class="btn btn-info">Live Preview</button>
 		<?php endif;?>

        <button type="submit" class="btn btn-success btn-save">Save</button>
 	</form>

</div>

<!-- Modal -->
<div id="categoryModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body slugify">
                <input type="hidden" id="category_post_type" value="<?php echo $result->type ?? $post_type; ?>" />
                
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="category_name" class="form-control title" required /> 
                </div>
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" id="category_slug" class="form-control slug" required /> 
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-save-category">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="base_url" value="<?php echo base_url();?>" />

<!-- Dependency -->
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js"></script>

<script>
var base_url = $('#base_url').val();
var post_id = $('#post_id').val();

var simplemde = new SimpleMDE({ 
    element: document.getElementById("content"),
    spellChecker: false,
    autosave: {
        enabled: false,
        uniqueId: 'save-' + post_id,
        delay: 1000,
    },
    toolbar: [
        "bold", 
        "italic", 
        "heading", 
        "|", 
        "quote",
        "unordered-list",
        "ordered-list", 
        "|", 
        "link", 
        "image", 
        "|", 
        "preview", 
        "side-by-side", 
        "fullscreen", 
        "|", 
        "guide",
        "|", 
        {
			name: "File Manager",
			action: function customFunction(editor){
                $('.btn-file-manager').click();
			},
			className: "fa fa-folder",
			title: "File Manager",
		}
    ]
});

// Before close browser or change page send alert.
var alertCloseMessage = "You didn't save changes.";
let formChanged = false;
window.onbeforeunload = function() {
    if (formChanged) {
        return alertCloseMessage;
    }
}

$(function() {
    $('#tags').tagsInput();
    
    // Check if form changed
    $("form :input").change(function() {
        formChanged = true;
    });
    simplemde.codemirror.on("change", function(){
        formChanged = true;
    });
    $("form").submit(function() {
        window.onbeforeunload = null;
    });
});

// Save post
$('#post-form').submit(function(e){
    e.preventDefault();
    var post = $(this).serialize();
    var postArray = $(this).serializeArray();

    $('.btn-save').html('Please wait ..');
    
    let mode = $('#mode').val();
    $.post( base_url + 'admin/post/' + mode, postArray)
    .done(function( response ) { 

        console.log(response);
        
        $('.btn-save').html('Save');
        
        if (response.status == 'success') {   
            formChanged = false;

            if (mode == 'insert') {
                window.location.replace(base_url + 'admin/post/edit/' + response.id);
            } else {
                toastr.success(response.message);
            }
        } else {
            toastr.info(response.message);
        }

    });
});

// Save category
$('.btn-save-category').click(function(){
    var post_type = $('#category_post_type').val();
    var name = $('#category_name').val();
    var slug = $('#category_slug').val();
    var option;

    $('.btn-save-category').html('Please wait ..');

    $.post( base_url + 'admin/post/category/insert', { post_type: post_type, name: name, slug: slug })
    .done(function( response ) {
        
        $('.btn-save-category').html('Save');
        
        $('#category_name').val('');
        $('#category_slug').val('');

        if (response.status == 'failed') {
            toastr.warning(response.message);
        } else {
            option = '<option value="'+ response.term_id +'" selected>'+ name +'</option>';
            $('#category_id').append(option);
            
            $('#categoryModal').modal('hide');
            
            toastr.success('Successfully added ..');
        }
    });
    
});
</script>
