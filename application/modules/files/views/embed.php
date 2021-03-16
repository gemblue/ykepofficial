<?php
if (config_item('file_manager_url') == 'local')
    $title = 'Local';
else
    $title = 'CDN';
?>
<!-- The Modal -->
<div class="modal" id="fileManagerModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">File Manager (<?php echo $title?>)</h4>
                <button type="button" class="close btnClose" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9 file-manager-body"></div>
            </div>

        </div>
    </div>
</div>

<input type="hidden" id="file_manager_url" value="<?php echo site_url('files');?>">

<script>
$('.btn-file-manager').click(function(){
    
    $('#fileManagerModal').toggle('show');

    var target = $(this).attr('data-target');
    var file_manager_url = $('#file_manager_url').val() + '?field=' + target;
    var iframe = `<iframe class="embed-responsive-item" src="${file_manager_url}"></iframe>`;
    
    $('.file-manager-body').html(iframe);
});

function bindEvent(element, eventName, eventHandler) {
    if (element.addEventListener){
        element.addEventListener(eventName, eventHandler, false);
    } else if (element.attachEvent) {
        element.attachEvent('on' + eventName, eventHandler);
    }
}

 // Listen to message from child window
 bindEvent(window, 'message', function (e) {
    var result = JSON.parse(e.data);
    $('#fileManagerModal').hide();
    $('#' + result.field).val(result.file_name);
});

$('.btnClose').click(function(){
    $('#fileManagerModal').hide();
})
</script>