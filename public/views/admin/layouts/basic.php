<?php if ($this->uri->segment(4) == 'print') :?>
	
	<?php 
	/**
	 * Why? $this->load->view is not working. In several case we don't need layout. Just plain text.
	 */
	echo $content; ?>

<?php else :?>

	<!doctype html>
	<html class="no-js" lang="en">
	<head>
		<?php $this->load->view('admin/partials/header'); ?>
	</head>
	<body>

	<!-- Bridge to Js -->
	<input type="hidden" id="base_url" value="<?php echo base_url()?>">

	<div class="main-wrapper sidebar-fixed">
		<div class="app" id="app">
			<div class="bgtop"></div>

			<?php $this->load->view('admin/partials/navbar'); ?>

			<?php $this->load->view('admin/partials/sidebar'); ?>

			<article class="content dashboard-page">
				
				<?php echo $this->session->flashdata('message');?>

				<?php echo $content; ?>
			</article>

	<?php $this->load->view('admin/partials/footer'); ?>

	</body>
	</html>

<?php endif;?>