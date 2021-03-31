<?php

$attributes = 'id="'.$config['field'].'" class="form-control"';

if ($config['relation'] ?? null)
{
    $options[] = 'Pilih opsi ..';
    
    if(! ($config['load_after'] ?? null) || $value)
    {
        $relEntry = $config['relation']['entry'];
        if(isset($config['relation']['model'])){
            $modelName = $config['relation']['model'];
            if(! isset($this->{$config['relation']['model']}))
                $this->load->model($config['relation']['model_path']);
        }
        else {
            $modelName = ucfirst($relEntry);
            $modelName .= isset($this->{$modelName.'_model'}) ? '_model' : 'Model';
        }

        $caption = $config['relation']['caption'];
        $data = $this->$modelName->getAll();

        if(is_array($caption)){
        	foreach ($data as $row){
        		$options[$row['id']] = "";
    	    	foreach ($caption as $capt)
        			$options[$row['id']] .= $row[$capt]." - ";
    	    	$options[$row['id']] = rtrim($options[$row['id']], " - ");
        	}
        } elseif($data) {
        	foreach ($data as $row){
    			$options[$row['id']] = $row[$caption] ?? null;
        	}
        }
    }
}
else 
{
    $options = $config['options']; 
}
?>

<?php if($config['load_after'] ?? null): ?>

<?php if(!$value): ?>
    <p id="loading_<?= $config['field']; ?>" class="text-muted"><em>Pilih opsi di atas</em></p>
<?php endif; ?>

<div id="dropdown_<?= $config['field']; ?>" class="<?= $value ? '' : 'sr-only'; ?>">
<?= form_dropdown($config['field'], $options, $value, $attributes); ?>
</div>

<script>
  $(function(){
    $('#<?= $config['load_after']; ?>').on('change', function(){
        $('#loading_<?= $config['field']; ?>').addClass('sr-only');
        $('#dropdown_<?= $config['field']; ?>').removeClass('sr-only');
        let caption = '<?= $config['relation']['caption'];?>';
        let filterField = '<?= $config['load_after'];?>';
        let filterVal = $(this).val();
        $.getJSON(`<?= site_url('api/entry/'.$config['relation']['entry'].'/dropdown');?>?caption=${caption}&filter[${filterField}]=${filterVal}`, function(data){
            $('#<?= $config['field']; ?>').empty();
            $('#<?= $config['field']; ?>').append(`<option value="">-pilih opsi-</option>`);
            console.log(data);
            if (typeof data !== 'undefined' && data.length > 0 && data[0] != false) {
                data.forEach(function(item,idx){
                    $('#<?= $config['field']; ?>').append(`<option value="${item.id}">${item[caption]}</option>`);
                })
            }
        })
        $('#<?= $config['field']; ?>').select2();
    });
  });
</script>

<?php else: ?>

<?= form_dropdown($config['field'], $options, $value, $attributes); ?>

<script>
  $(function(){
    $('#loading_<?= $config['field']; ?>').addClass('sr-only');
    $('#dropdown_<?= $config['field']; ?>').removeClass('sr-only');
    $('#<?= $config['field']; ?>').select2();
  });
</script>

<?php endif; ?>

<script>
  $(function(){
    $('#<?= $config['field']; ?>').select2();
  });
</script>
