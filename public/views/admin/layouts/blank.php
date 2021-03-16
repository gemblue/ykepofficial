<!doctype html>
<html class="no-js" lang="en">
<head>
	<?php $this->load->view('admin/partials/header.php'); ?>
</head>
<body>

<!-- Bridge to Js -->
<input type="hidden" id="base_url" value="<?php echo base_url()?>">

<article class="content dashboard-page">
	<?php echo $this->session->flashdata('message');?>

	<?php echo $content; ?>
</article>

</body>
</html>