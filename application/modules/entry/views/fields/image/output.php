<?php 
$this->config->load('files/config'); 
$driver = config_item('fileManagerDriver');
$cdn_base_url = config_item('fileManagerConfig')[$driver]['cdn_base_url'];
?>
<a data-toggle="popover-image" class="btn btn-secondary" href="<?= $cdn_base_url.'original/'.$result[$config['field']]; ?>" data-thumbnail="<?= $cdn_base_url.'250x150/'.$result[$config['field']]; ?>" title="<?php echo $result[$config['field']]; ?>" target="_blank">
	<span class="fa fa-image"></span>
</a>

<script>
	$(function(){
		$('[data-toggle="popover-image"]').popover({
			trigger: 'hover',
			html: true,
			content: function () {
				return '<img class="img-fluid" src="'+$(this).data('thumbnail') + '" />';
			}
		}) 
	});
</script>