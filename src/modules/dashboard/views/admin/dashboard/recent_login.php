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
	<div class="mt-5">
		<div class="row">
		
		<?php
		$i=0;
		foreach ($results as $result)
		{
			$profile = $this->ci_auth->getProfilePicture($result->avatar, $result->email);

			?>
			
			<div class="col-md-2">
				<div class="text-center mr-3 mb-3">
					<img src="<?php echo $profile?>" width="60" class="img-responsive avatar medium" />
					<div class="m-3" style="font-size:13px;">
						<a target="_blank" href="<?php echo site_url('coder/' . $result->username)?>"><?php echo $result->name;?></a>
						<br/>
						<?php echo time_ago($result->last_login);?>
					</div>
				</div>
			</div>

			<?php
			$i++;

			if (($i % 6) == 0) {
				?></div><div class="row"><?php
			}

		}
		?>

		</div>

		
	</div>

	<div class="text-center">

		<?php if(isset($pagination)) : ?>
			<div class="pagination">
				<?php echo $pagination; ?>
			</div>
		<?php endif; ?>
		
	</div>

<?php endif ?>