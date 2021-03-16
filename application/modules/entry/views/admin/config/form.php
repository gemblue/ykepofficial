<style type="text/css" media="screen">
#editor { width: 100%; min-height: 300px; font-size: 18px; border-color:#fff; border-width: 10px 0; border-style: solid;}
</style>

<div class="title-block">
    <h3 class="mb-3"><?php echo $page_title; ?></h3>
</div>

<div class="message"></div>

<div class="form-group">
    <label>Entry Name</label>
    <?= form_input('entry_name', set_value('entry_name', $entry_name ?? ''), 'class="form-control" id="entry_name"'); ?>
</div>

<div class="form-group">
	<label>Entry Config</label> 
    <div id="editor"><?php echo $content;?></div>
</div>

<a href="<?= site_url('admin/entry/config'); ?>" class="btn btn-secondary pull-left"><span class="fa fa-angle-left"></span> Back to list</a> &nbsp;

<div class="form-group pull-right">
    <button type="button" id="save" class="btn btn-primary"><span class="fa fa-save"></span> Save</button> &nbsp;

    <button type="button" id="sync" class="btn btn-info btn-xs pull-right"><span class="fa fa-refresh"></span> Sync</button>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.1/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
var editor = ace.edit("editor", {
    theme: "ace/theme/tomorrow",
    mode: "ace/mode/yaml",
    autoScrollEditorIntoView: true,
    maxLines: 200,
    minLines: 20,
    cursorStyle: "smooth",
    tabSize: 4
});

$(function(){
    var oldname = '<?= $entry_name ?? 'null'; ?>';

    $('#save').on('click', function(){
        var btn = $(this);
        btn.prop('disabled', true);
        var name = $('#entry_name').val();
        var entry = editor.getValue();
        $.ajax({
            url: '<?= site_url(); ?>admin/entry/config/save',
            method: 'post',
            data: {oldname:oldname,name:name,entry:entry}
        })
        .done(function(response) {
            console.log(response);
            var data = JSON.parse(response);
            btn.prop('disabled', false);
            if(data.status == 'success')
                $('.message').html('<div class="alert alert-success">'+data.message+'</div>');
            else
                $('.message').html('<div class="alert alert-danger">'+data.message+'</div>');
            if(oldname != name){
                oldname = name;
                window.history.replaceState('Object', 'Title', '<?= site_url('admin/entry/config/form'); ?>/' + name);
            }
        });
    })

    $('#sync').on('click', function(){
        var btn = $(this);
        btn.prop('disabled', true);
        if(confirm('Database table structure will be updated. Continue?')){
            window.location.href = '<?= site_url(); ?>admin/entry/config/sync/'+oldname;
        }
    })
})
</script>