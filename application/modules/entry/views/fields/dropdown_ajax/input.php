<?php

if($config['relation']['table'] ?? null)
  $table = $config['relation']['table'];
else {
  $entry = config_item('entries')[$config['relation']['entry']] ?? null;
  if(!$entry) throw new Exception('Entry not found: '.$config['relation']['entry']);
  $table = $entry['table'];
}

$attributes = 'id="'.$config['field'].'" class="form-control"';
$default_option = [];
if($value){
  if($record = $this->db->select(implode(',',$config['relation']['caption']))
                        ->where('id',$value)
                        ->get($table)
                        ->row_array())
  {
    foreach ($config['relation']['caption'] as $caption)
      $default_option[$value][] = $record[$caption];

    $default_option[$value] = implode(" - ", $default_option[$value]);
  }
}
echo form_dropdown($config['field'], $default_option, $value, $attributes);

if ($config['relation'] ?? null)
  echo ("<script>
  $(function(){
    $('#".$config['field']."').select2({
      placeholder: '".($config['placeholder'] ?? '')."',
      ajax: {
        url: '".site_url('admin/entry/config/getSelect2Dropdown')."',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          var query = {
            table: '".$table."',
            caption_field: ".json_encode($config['relation']['caption']).",
            search_field: ".json_encode($config['relation']['searchby']).",
            keyword: params.term
          }
          return query;
        },
        cache: true
      }
    });
  });</script>");
