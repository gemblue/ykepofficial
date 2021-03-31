<div class="mb-4">
    <div class="row">
        <div class="col-6">
            <h2><?php echo $page_title;?></h2>
        </div>
    </div>
</div>

<?php echo $this->session->flashdata('message');?>

<form class="form">
	<div class="form-group">
		<label>Type</label>
	 	<input type="text" class="form-control type" placeholder="News / Events / Etc" />
	</div>

	<button type="button" class="btn btn-success btn-add-type">Start</button>
</form>