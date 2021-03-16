<div class="mb-4">
    <div class="row">
        <div class="col-lg-6">
            <h2><?php echo $page_title; ?></h2>
        </div>
        <div class="col-lg-6">
            <form id="form-search" method="get" action="<?php echo site_url('admin/post/category/search'); ?>" enctype="application/x-www-form-urlencoded" class="form-search">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" placeholder="Name ...">
                    <div class="input-group-append">
                        <span class="input-group-text">Search</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<a href="<?php echo site_url('admin/post/category/add/' . $post_type);?>" class="btn btn-success pull-right text-white"><span class="fa fa-plus-circle"></span> New Category</a>

<?php if (empty($results)): ?>
	<div class="alert alert-danger" style="margin-top: 20px;">No record found ..</div>
<?php else: ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th><input class="select-all" type="checkbox"/></th>
				<th>Name</th>
				<th>Slug</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

			<?php
			$i = 1;
			foreach ($results as $row)
			{
				?>

				<tr>
					<td><input id="checkbox_<?php echo $i;?>" name="record[]" class="record" type="checkbox"  value="<?php echo $row->term_id?>" /></td>
					<td>
						<?php echo $row->name; ?>
					</td>
					<td><?php echo $row->slug; ?></td>
					<td class="text-right">
                        <div class="btn-group">
                            <a class="btn btn-sm btn-primary" href="<?php echo site_url('admin/post/category/edit/' . $row->term_id); ?>">Edit</a> 
                            <a class="btn btn-sm btn-danger" onclick="return confirm('are you sure?')" href="<?php echo site_url('admin/post/category/delete/' . $row->term_id); ?>">Delete</a>
                            <a class="btn btn-sm btn-info" target="_blank" href="<?php echo site_url('category/' . $row->slug); ?>">Open</a>
                        </div>
                    </td>
				</tr>

				<?php
				$i++;
			}
			?>

		</tbody>
	</table>

	<?php if(isset($pagination)) : ?>
		<div class="pagination">
			<?php echo $pagination; ?>
		</div>
	<?php endif; ?>
	
<?php endif ?>