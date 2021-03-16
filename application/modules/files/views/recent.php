<?php
$file['Filename'] = $_SESSION['uploaded_filename'];
$file['Key'] = $_SESSION['uploaded_key'];

$spec = pathinfo($file['Key']);

if ($spec['extension']) {
	
	if (in_array(strtolower($spec['extension']), ['png', 'jpg', 'jpeg', 'gif'])) 
	{
		$originalImage = $fileManagerConfig['cdn_base_url'] . $file['Key'];
		$thumbs = [];
		
		foreach ($fileManagerConfig['thumbnail_versions'] as $dimension) {
			$thumbs[$dimension] = $fileManagerConfig['cdn_base_url'] . $dimension.'/'.$file['Filename'];
		}
		
		$thumbsString = implode(';', $thumbs);
		?>
		<h3>Recently :</h3>

		<div class="row">
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
				<div class="files-item text-center">

					<a href="#" class="btn-detail" data-original="<?php echo $originalImage; ?>" file-name="<?php echo $file['Filename']; ?>" thumbs="<?= $thumbsString; ?>" title="show bigger">
						<div class="overlay"><span class="glyphicon glyphicon-zoom-in"></span></div>
					</a>

					<div class="files-img" style="background-image: url(<?php echo $thumbs[$fileManagerConfig['thumbnail_versions'][0]]; ?>);"></div>

					<h5><?php echo $file['Key'];?></h5>

					<div class="files-options">
						<?php if ($this->config->item('rename')): ?>
							<a href="#" class="btn-warning btn-xs btn-rename" file-name="" title="Rename file"><span class="glyphicon glyphicon-pencil"></span></a>
						<?php endif;?>

						<?php if ($this->config->item('delete')): ?>
							<a href="<?php echo site_url('files/delete?file_name=' . $file['Key'])?>" class="btn-danger btn-xs" title="Delete file"><span class="glyphicon glyphicon-trash"></span></a>
						<?php endif; ?>

						<a href="<?php echo $originalImage;?>" class="btn-info btn-xs btn-download" title="Download file" target="_blank"><span class="glyphicon glyphicon-download"></span></a>
						<a href="#" class="btn-success btn-xs btn-choose" file-name="<?php echo $originalImage;?>" title="Choose file"><span class="glyphicon glyphicon-ok"></span></a>
					</div>

				</div>
			</div>
		</div>

		<hr />
		<?php
	}
}
?>