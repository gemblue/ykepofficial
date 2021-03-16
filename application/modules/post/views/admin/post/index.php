<div class="mb-4">
	<div class="row">
		<div class="col-6">
			<h2 class="mt-1"><?php echo $page_title;?></h2>
		</div>
		<div class="col-6 text-right">
			<form method="get" action="<?php echo site_url('admin/post/search'); ?>" enctype="application/x-www-form-urlencoded">
                <input type="hidden" name="status" value="<?php echo $status; ?>"/>
                <input type="hidden" name="type" value="<?php echo $type; ?>"/>
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" placeholder="Title ...">
                    <div class="input-group-append">
                        <span class="input-group-text">Search</span>
                    </div>
                </div>
            </form>
		</div>
	</div>
</div>

<div class="btn-group mb-3">
	<a class="btn btn-success" href="<?php echo site_url('admin/post/index/all/' . $type);?>">all</a>
	<a class="btn btn-warning" href="<?php echo site_url('admin/post/index/review/' . $type);?>">review</a>
	<a class="btn btn-success" href="<?php echo site_url('admin/post/index/publish/' . $type);?>">publish</a>
	<a class="btn btn-danger" href="<?php echo site_url('admin/post/index/draft/'. $type); ?>">draft</a>
</div>

<a href="<?php echo site_url('admin/post/add/' . $type)?>" class="btn btn-success text-white pull-right"><span class="fa fa-plus-circle"></span> New <?= ucfirst($type); ?></a>

<?php if (empty($results)): ?>
	<div class="alert alert-danger">No record found ..</div>
<?php else: ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Title</th>
				<th>Category</th>
				<th>Status</th>
				
				<?php if($type == 'all'): ?>
				<th>Created</th>
				<?php endif; ?>

				<th>Created</th>
				<th>Published</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
            
			<?php
			$i = 1;
            
            foreach ($results as $row)
			{
				$category = $this->Taxonomy_model->get_category($row->id);
				?>

				<tr>
					<td>
						<?php if (isset($search_mode) && $search_mode == true):?>

							<div>
								<?php echo str_replace($keyword, '<b>'.$keyword.'</b>', $row->title); ?>
							</div>

						<?php else: ?>

							<div><a href="<?php echo site_url($row->slug); ?>" target="_blank"><?php echo $row->title; ?></a></div>

						<?php endif; ?>

					</td>

					<td><?php echo (isset($category->name)) ? $category->name : '-';?></td>
					<td>
						<div>
							<?php
							if ($row->status == 'publish')
								echo '<span class="badge badge-success">Published</span>';
							else if ($row->status == 'draft')
								echo '<span class="badge badge-danger">Draft</span>';
                            else if ($row->status == 'review')
								echo '<span class="badge badge-warning">On Review</span>';
							else
								echo '<span class="badge badge-info">' . ucfirst($row->status) . '</span>';
							?>
						</div>
					</td>

					<?php if($type == 'all'): ?>
					<td><a href="<?php echo base_url('admin/post/index/all/' . $row->type);?>"><?php echo ucfirst(str_replace('_',' ',$row->type));?></a></td>
					<?php endif; ?>

					<td><div><?php echo time_ago($row->created_at); ?></div></td>
					<td><div><?php echo ($row->published_at == NULL) ? '-' : time_ago($row->published_at); ?></div></td>
                    
					<td class="text-right">
						<div class="btn-group">
							<?php if($row->status == 'trash'): ?>
								<a class="btn btn-sm btn-warning" onclick="return confirm('Sure?')" href="<?php echo site_url('admin/post/restore/' . $row->id . '?callback=' . current_url()); ?>"><i class="fa fa-check"></i> Restore</a> 
								<a class="btn btn-sm btn-danger" onclick="return confirm('Sure?')" href="<?php echo site_url('admin/post/delete/' . $row->id . '?callback=' . current_url()); ?>"><i class="fa fa-remove"></i> Delete</a>
							<?php else: ?>
								<a class="btn btn-sm btn-primary" href="<?php echo site_url('admin/post/edit/' . $row->id); ?>">
									<i class="fa fa-pencil"></i> Edit
								</a>
								<a class="btn btn-sm btn-danger" onclick="return confirm('Sure?')" href="<?php echo site_url('admin/post/trash/' . $row->id . '?callback=' . current_url()); ?>">
									<i class="fa fa-trash"></i> Trash
								</a>
							<?php endif ?>
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
