<?php

$attributes = 'id="'.$config['field'].'" class="form-control" multiple ';

if ($config['relation'] ?? null)
{
    $relEntry = $config['relation']['entry'];
    $modelName = $config['relation']['model'] ?? ucfirst($relEntry).'Model';
    $caption = $config['relation']['caption'];
    $options = $this->$modelName->as_dropdown($caption)->getAll();

    if(($config['relation']['pivot_table'] ?? null) && isset($result[$config['relation']['local_key']])){
    	$values = $this->db
    				  ->select($config['relation']['pivot_foreign_key'])
    				  ->from($config['relation']['pivot_table'])
    				  ->where($config['relation']['pivot_local_key'], $result[$config['relation']['local_key']])
    				  ->get()->result_array();
		$value = array_column($values,$config['relation']['pivot_foreign_key']);
    }
}
else 
{
    $options = $config['options']; 
}

echo form_dropdown($config['field'].'[]', $options, $value, $attributes);
echo ("<script>
  $(function(){
    $('#".$config['field']."').select2();
  });
</script>");
