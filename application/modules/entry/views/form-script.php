<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url('views/'.config_item('template.admin_theme').'/assets/chosen/chosen.jquery.js'); ?>"></script>
<script src="<?= base_url('views/'.config_item('template.admin_theme').'/assets/select2/select2.min.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script>
$(function(){
	$('[data-toggle="datepicker"]').datepicker({format: 'yyyy-mm-dd'});
    $('[data-toggle="chosen"]').chosen();

    var form = $('form');
    // form.get(0).reset();
    form.find('[data-toggle="chosen"]').trigger('chosen:updated');

    $(".slugify input.title").keyup(function() {
        var title = $(this).val();
        $("input.slug").val(convertToSlug(title));
    });

    var to_reffer = $('.slugify').data('referer');

    $("#" + to_reffer).keyup(function() {
        var content = $(this).val();
        $('.slugify').val(convertToSlug(content));
    });

    $('.btn-connect-relation').click(function(){
        var id = $('#id').val();
        var entry = $('#entry').val();
        var relation = $('#relation').val();
        var choosen = $('#choice input:checked').map(function(){
            return $(this).val();
        });
        
        $.post( base_url + 'admin/entry/entry/update_relation', { id: id, entry: entry, relation: relation, choosen: choosen.get() })
        .done(function( data ) {
            if(data = 'done')
            {
                location.reload();
            }
        }); 
    });

    $('.ajaxupload').on('change', function(e){
        console.log(e.target.files);
        $.ajax({
            url: "<?= site_url('entry/upload'); ?>",
            type: "POST",            
            data: e.target.files,
            contentType: false,      
            cache: false,            
            processData:false,       
            success: function(data)  
            {
                console.log(data)
            }
        });
    })
});

function convertToSlug(Text)
{
    return Text
    .toLowerCase()
    .replace(/[^\w ]+/g,'')
    .replace(/ +/g,'-');
}

// Simple Ajax Uploader helper
function escapeTags( str ) {
  return String( str )
  .replace( /&/g, '&amp;' )
  .replace( /"/g, '&quot;' )
  .replace( /'/g, '&#39;' )
  .replace( /</g, '&lt;' )
  .replace( />/g, '&gt;' );
}
</script>