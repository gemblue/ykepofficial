<style>
.navigation_list > li:first-child > .navrow > .pull-right > .option > .sort-scroll-button-up,
.navigation_list > li:last-child > .navrow > .pull-right > .option > .sort-scroll-button-down {visibility: hidden;}
.card.draft {opacity: .3;}
.navlist .option .btn {margin:0; visibility: visible; transition:.1s;}
.navlist ul ul {padding-left: 20px;}
.navlist ul li .navrow {background-color: rgba(200,200,200,.1);}
.navlist ul .navrow:hover {background-color: rgba(180,180,180,.1);}
.navlist li.draft {opacity: .3;background-color: #eee;}
</style>

<div class="row heading">
	<div class="col-md-6">
		<h2>Navigation</h2>
	</div>
	<div class="col-md-6 text-right">
		<div><a href="<?= site_url('admin/navigation/add_area');?>" class="btn btn-primary-outline"><i class="fa fa-plus fa-fw"></i> Create new area</a></div>
	</div>
</div>
<br>

<?php if($areas): ?>
	<?php foreach ($areas as $area): ?>
		<div class="card card-info <?= $area['status']=='draft' ? 'draft' : ''; ?>"  id="navarea-<?= $area['id']; ?>">
			<div class="card-header">
				<div class="header-block">
					<p class="title">
						<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#navlist-<?= $area['id']; ?>" aria-expanded="true" aria-controls="navlist-<?= $area['id']; ?>">
				          <span class="fa fa-caret-down"></span>
				        </button>
						<?php echo $area['area_name']; ?> &nbsp; <em style="font-weight: 300"><?php echo $area['area_slug']; ?></em> &nbsp; 
						<span class="text-danger"><?= $area['status'] == 'draft' ? '(draft)' : ''; ?></span>
					</p>
				</div>
				<div class="header-block pull-right">
					<a href="<?= site_url('admin/navigation/add_link/'.$area['id']); ?>" class="btn btn-xs btn-primary"><span class="fa fa-link"></span> Add link</a>

					<a href="<?= site_url('admin/navigation/edit_area/'.$area['id']); ?>" class="btn btn-xs btn-success" title="Edit Area"><span class="fa fa-pencil"></span></a>

					<a href="<?php echo site_url('admin/navigation/delete_area/'.$area['id'].'/'.$area['area_slug']); ?>" class="btn btn-xs btn-danger remove" title="Delete Area" onclick="return confirm('Yakin akan menghapus area ini?')"><span class="fa fa-times"></span></a>
				</div>
			</div>
			<div class="card-block navlist collapse show" id="navlist-<?= $area['id']; ?>" aria-labelledby="headingOne" data-parent="#navarea-<?= $area['id']; ?>">
				<?php if(isset($area['navigations'])): ?>
					<div id="<?php echo $area['id']; ?>">
						<ul class="list-unstyled navigation_list">
							<?php echo $this->load->view('admin/navigation_list', ['area' => $area['area_slug'], 'links' => $area['navigations'], 'root' => true], true); ?>
						</ul>
					</div>
				<?php else: ?>
					<p class="align-center m-0"><em>No link yet.</em></p>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<p><em>No navigation data yet.</em></p>
<?php endif; ?>

<script>
	$(function(){
		$('.field-title').on('keyup', function(){
			let title = $(this).val();
			$('.field-slug').val(title);
		})
	})
</script>
