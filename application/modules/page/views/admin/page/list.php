<?php if(! empty($pages)):
	foreach($pages as $slug => $content): ?>
    <li data-title="<?php echo $content['title']; ?>" data-slug="<?php echo $slug; ?>" data-url="<?php echo $content['url']; ?>">
        <div class="list-content">
            <?php echo $content['title']; ?> <br>
            <small><a href="<?php echo site_url($content['url']); ?>" target="_blank" class="page-url"><?php echo $content['url']; ?></a></small>
            <div class="align-right pull-right">
                <div class="option">
                    <a href="<?php echo site_url('admin/page/edit/'.$content['url']); ?>" class="edit" title="Edit"><span class="fa fa-edit"></span></a>
					<a href="<?php echo site_url('admin/page/delete/?page='.$content['url']); ?>" class="remove" title="Delete"><span class="fa fa-times"></span></a>
                </div>
            </div>
        </div>

        <?php if(isset($content['children'])): ?>
            <ul class="list-unstyled">
    		  <?= $this->load->view('admin/page/list', ['pages'=> $content['children']], true); ?>
            </ul>
        <?php endif; ?>
    </li>
<?php endforeach; endif; ?>
