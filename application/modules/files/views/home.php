<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>File Manager</title>

  	<?php 
  	$themes = ["bootstrap", "cerulean","cosmo","cyborg","darkly","flatly","journal","lumen","paper","readable","sandstone","simplex","slate","spacelab","superhero","united","yeti"];
  	$theme = $this->session->userdata('theme');
	?>

  	<?php if ($theme && isset($themes[$theme])): ?>
    	<link rel="stylesheet" href="https://bootswatch.com/3/<?= $themes[$theme]; ?>/bootstrap.min.css"/>
    <?php else: $theme = 0; ?>
      	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <?php endif; ?>

    <link rel="stylesheet" href="<?= module_asset_url('files','css/style.css'); ?>" />
</head>

<body class="<?= $themes[$theme]; ?>">

<div class="overlay">&nbsp;&nbsp;Uploading, please wait..<br><img src="<?= module_asset_url('files','img/spin.gif'); ?>" alt=""></div>
    
<div class="container-fluid" style="margin-top: 20px;">
	<?= form_open(site_url('files/upload'), 'class="upload-form" enctype="multipart/form-data"'); ?>
      	<div class="row">
       		<div class="col-md-6">
          		<div class="form-group">
            		<label>Upload files.. <small>Only zip, png and jpg are accepted</small></label>
            		<input type="file" name="file" id="upload-file" class="form-control" />
          		</div>
        	</div>
        	<div class="col-md-6">
          		<div class="row action-btn">
            		<div class="col-xs-6">
              			<button type="submit" class="btn btn-primary btn-md btn-block btn-upload"><span class="glyphicon glyphicon-upload"></span> Upload</button>
            		</div>
            		<div class="col-xs-6">
              			<button type="button" class="btn btn-warning btn-refresh btn-block btn-md"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
            		</div>
          		</div>
        	</div>
      	</div>
    </form>

    <div class="files-wrapper">

      	<div class="loading"></div>

      	<?php echo $this->session->flashdata('message');?>

      	<?php if (empty($files)) :?>
        	<p class="text-center">There is no files ..</p>
        <?php else :?>
			
			<?php if(isset($_SESSION['uploaded_key'])) :?>
				<?php $this->load->view('recent');?>
			<?php endif;?>
          	
			<div class="row">
            	<?php foreach ($files as $file) : ?>

					<?php 
					$spec = pathinfo($file['Key']);

					if ($spec['extension']) {
						
						if (in_array(strtolower($spec['extension']), ['png', 'jpg', 'pdf', 'jpeg', 'gif'])) 
						{
							$originalImage = $fileManagerConfig['cdn_base_url'] . $file['Key'];
							$thumbs = [];
							
							foreach ($fileManagerConfig['thumbnail_versions'] as $dimension) {
								$thumbs[$dimension] = $fileManagerConfig['cdn_base_url'] . $dimension.'/'.$file['Filename'];
							}
							
							$thumbsString = implode(';', $thumbs);
							?>
							
							<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
								<div class="files-item text-center">

									<?php if ($spec['extension'] != 'pdf') :?>
									<a href="#" class="btn-detail" data-original="<?php echo $originalImage; ?>" file-name="<?php echo $file['Filename']; ?>" thumbs="<?= $thumbsString; ?>" title="show bigger">
										<div class="overlay"><span class="glyphicon glyphicon-zoom-in"></span></div>
									</a>
									<?php endif; ?>

									<?php if ($spec['extension'] == 'pdf') :?>
										<div class="files-img" style="opacity:0.8;background-image: url(<?php echo base_url('uploads/pdf.png'); ?>);background-size: 60px 60px;"></div>
									<?php else: ?>
										<div class="files-img" style="background-image: url(<?php echo $thumbs[$fileManagerConfig['thumbnail_versions'][0]]; ?>);"></div>
									<?php endif; ?>
									
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
							<?php
						}
					}
					?>
            	<?php endforeach;?>
          	</div>
        <?php endif;?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="RenameFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Rename File</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>File Name</label>
					<input type="text" id="file-name" class="form-control" autofocus/>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success btn-rename-save">Update</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="DetailFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="detail-content text-center" style="margin-bottom:20px;"></div>
				<div class="thumbnail-list"></div>
			</div>
		</div>
	</div>
</div>

<div class="container text-right">
	<hr>
	<div class="change-theme">
		<label>change theme:</label>
		<?= form_dropdown('theme', $themes, $theme, 'id="theme" class="form-control"'); ?>
	</div>
	<br>
</div>

<input type="hidden" id="site_url" value="<?php echo site_url();?>" />
<input type="hidden" id="field" value="<?php echo $this->input->get('field');?>" />

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){

	var site_url = $('#site_url').val();
	var field = $('#field').val();
	var previous_file_name;
	var next_file_name;
        
	/** 
	 * Refresh
	 */
	$('.btn-refresh').click(function(){
		location.reload();
	});

   /** 
	* Choose
	*/
	$('.files-options').on('click', '.btn-choose', function(){
		var file_name = $(this).attr('file-name');
		var to_send = '{"file_name": "'+file_name+'", "field": "'+field+'"}';
		parent.postMessage(to_send, "*");
	});

	/** 
	 * Rename handling
	 */
	$('.btn-rename').click(function(){
		previous_file_name = $(this).attr('file-name');

		$('#file-name').val(previous_file_name);
		$('#RenameFile').modal();
	});

	$('.btn-rename-save').click(function(){
		next_file_name = $('#file-name').val();

		$.post( site_url + 'files/rename', { next_file_name: next_file_name, previous_file_name: previous_file_name })
		.done(function( data ) {
			location.reload();
		});

		return false;
	});

	/** 
	 * Detail zoom..
	 */
	$('.btn-detail').click(function(){
		var original = $(this).data('original');
		var template = `
		<div class="form-inline" style="margin-bottom:3px;">
			<input type="text" class="copyer form-control input-sm" value="${original}" style="width:60%">
			<a href="#" class="btn btn-sm btn-info btn-copy"><span class="glyphicon glyphicon-copy"></span> Copy URL</a>
			<a href="#" class="btn btn-success btn-sm btn-choose" file-name="${original}" title="choose file"><span class="glyphicon glyphicon-ok"></span> Use this file</a>
		</div>
		<h4>Thumbnails</h4>`;
		
		$('.detail-content').html(`<img src="${original}" style="width:100%" />`);

        var thumbs = $(this).attr('thumbs').split(';');
		thumbs.forEach(function(item, index){
		template += `
			<div class="form-inline" style="margin-bottom:3px;">
			<input type="text" class="copyer form-control input-sm" value="${item}" style="width:60%">
			<a href="#" class="btn btn-sm btn-info btn-copy"><span class="glyphicon glyphicon-copy"></span> Copy URL</a>
			<a href="#" class="btn btn-success btn-sm btn-choose" file-name="${item}" title="choose file"><span class="glyphicon glyphicon-ok"></span> Use this file</a>
			</div>`;
		})
         	
		$('.thumbnail-list').html(template);
        $('#DetailFile').modal();
          	
		return false;
    });

   /** 
    * Upload handling
	*/
	$('.btn-upload').click(function(){
		if ($('#upload-file').val() != ''){
			$('body').children('.overlay').show();
			$(this).addClass('disabled').html('<img src="assets/img/spin.gif" alt="" /> Uploading..');
			$('.btn-refresh').prop('disabled', true);
		}
	});

   /** 
	* Copy to clipboard
	*/
	$('.thumbnail-list').on('click', '.btn-copy', function(){
		$(this).prev('.copyer').select();
		document.execCommand("Copy");
		$(this).removeClass('btn-info').addClass('btn-success').html('<span class="glyphicon glyphicon-ok"></span> URL copied!');
		setTimeout(function(){ $('.btn-copy').addClass('btn-info').removeClass('.btn-success').html('<span class="glyphicon glyphicon-copy"></span> Copy URL'); }, 2000);
		
		return false;
	});

	/** 
	 * Change theme
	 */
	$('#theme').change(function(){
		window.location = '<?= site_url('files/changeTheme'); ?>/' + $(this).val();
	})
});
</script>

</body>
</html>