<button type="button" id="<?= $config['field'];?>Btn" class="btn p-2 btn-info"><?= $value ? 'Pilih File Lain' : 'Pilih File'; ?></button>
<input type="hidden" name="<?= $config['field'];?>" id="<?= $config['field'];?>" value="<?= $value; ?>">
<small class="d-block"><?= $value; ?></small>
<img style="max-width:50%" src="<?= base_url('uploads/'.$value); ?>" id="<?= $config['field'];?>thethumbnail" class="img-fluid my-3" onerror="this.style.display='none'">

<div id="<?= $config['field'];?>progressOuter" class="progress progress-striped active" style="display:none;">
	<div id="<?= $config['field'];?>progressBar" class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
</div>
<small class="d-block" id="<?= $config['field'];?>msgBox"></small>

<script>
$(function() {

  let btn = document.getElementById('<?= $config['field'];?>Btn'),
  progressBar = document.getElementById('<?= $config['field'];?>progressBar'),
  progressOuter = document.getElementById('<?= $config['field'];?>progressOuter'),
  inputText = document.getElementById('<?= $config['field'];?>'),
  thumbnail = document.getElementById('<?= $config['field'];?>thethumbnail'),
  msgBox = document.getElementById('<?= $config['field'];?>msgBox');

  var <?= $config['field'];?>_uploader = new ss.SimpleUpload({
    button: btn,
    url: '<?= site_url('entry/upload'); ?>',
    name: 'uploadfile',
    multipart: true,
    hoverClass: 'hover',
    focusClass: 'focus',
    responseType: 'json',
    startXHR: function() {
        progressOuter.style.display = 'block'; // make progress bar visible
        this.setProgressBar( progressBar );
      },
      onSubmit: function() {
        msgBox.innerHTML = ''; // empty the message box
        btn.innerHTML = 'Mengunggah...'; // change button text to "Uploading..."
      },
      onComplete: function( filename, response ) {
      	console.log(response)
        btn.innerHTML = 'Pilih File Lain';
        progressOuter.style.display = 'none'; // hide progress bar when upload is completed

        if ( !response ) {
          msgBox.innerHTML = '<div class="alert alert-warning">' + response.msg + '</div>';
          return;
        }

        if ( response.success === true ) {
          msgBox.innerHTML = '<strong>' + escapeTags( response.file ) + '</strong>' + ' berhasil diunggah.';
          inputText.value = response.file;
          thumbnail.src = '<?= base_url('uploads'); ?>/' + escapeTags( response.file );
          thumbnail.style.display = 'block';

        } else {
          if ( response.msg )  {
            msgBox.innerHTML = '<div class="alert alert-warning">' + escapeTags( response.msg ) + '</div>';

          } else {
            msgBox.innerHTML = 'Terjadi kesalahan saat proses upload.';
          }
        }
      },
      onError: function(filename, errorType, status, statusText, response, uploadBtn, fileSize) {
      	console.log(filename, errorType, status, statusText, response, uploadBtn, fileSize)
        progressOuter.style.display = 'none';
        msgBox.innerHTML = errorType + ': Error saat mengunggah ke server: ' + status + ' ' + statusText;
      }
    });
});
</script>