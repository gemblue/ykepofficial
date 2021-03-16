<div class="mb-2">
	<div class="row">
		<div class="col-6">
			<h2><?php echo $page_title;?></h2>
		</div>
	</div>
</div>

<?php if (empty($results)): ?>
	<div class="alert alert-danger">No record found ..</div>
<?php else: ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Last Login</th>
			</tr>
		</thead>
		<tbody>
            
			<?php
			foreach ($results as $result)
			{
				?>

				<tr>
					<td><a target="_blank" href="<?php echo site_url('coder/' . $result->username)?>"><?php echo $result->name;?></a></td>
					<td><?php echo $result->email?></td>
                    <td><?php echo time_ago($result->last_login);?></td>
				</tr>

				<?php
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