<?php

$attributes = 'id="'.$config['field'].'" class="form-control" multiple';
$default_option = [];
if($value){
  $valueArray = is_array($value) ? $value : json_decode(htmlspecialchars_decode($value));

  // Prepare value caption
  $relData = $this->db->where_in('id', array_keys($valueArray))
                      ->get($config['relation']['table'])
                      ->result_array();
  if($relData){
    foreach ($relData as $data){
      $array_caption = [];
      foreach ($config['relation']['caption'] as $caption)
        $array_caption[] = $data[$caption];
      $default_option[$data['id']] = implode(' - ', $array_caption);
    }
  }

  $value = array_keys($valueArray);
}
echo form_dropdown($config['field'].'[]', $default_option, $value, $attributes);

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
              table: '".$config['relation']['table']."',
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
