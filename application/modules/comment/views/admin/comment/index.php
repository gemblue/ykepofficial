<div class="mb-3">
    <div class="row">
        <div class="col-lg-6">
            <h2><?php echo $page_title; ?></h2>
        </div>
    </div>
</div>

<?php echo $this->session->flashdata('message');?>

<p>Total: <b><?php echo $total;?></b></p>
<table class="table table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>User</th>
            <th>Content</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <form>
            <tr>
                <td>-</td>
                <td><input type="text" class="form-control form-control-sm" name="filter[reply_content]" value="<?= $this->input->get("filter[reply_content]", true); ?>" placeholder="filter by reply content"></td>
                <td><input type="text" class="form-control form-control-sm" name="filter[reply_status]" value="<?= $this->input->get("filter[reply_status]", true); ?>" placeholder="filter by reply status"></td>
                <td>
					<div class="btn-group">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="<?= site_url('admin/comment/comment'); ?>" class="btn btn-secondary">Reset</a>
					</div>
				</td>
            </tr>
        </form>
        
        <?php if (empty($results)): ?>
            <div class="alert alert-danger">There is no results ..</div>
        <?php else: ?>
            <?php foreach ($results as $result): ?>
                
                <?php
                $post = $this->Post_model->getPost(null, 'id', $result['identity']);
                ?>
                
                <tr>
                    <td><?php echo $result['user']['name']?></td>
                    <td><?php echo xss_clean(word_limiter($result['reply_content'], 50));?></td>
                    <td><?php echo $result['reply_status']?></td>
                    <td class="text-right">
                        <div class="btn-group">
                            <a class="btn btn-sm btn-success" href="<?php echo site_url('admin/comment/comment/edit/'. $result['id']); ?>" title="Edit"><span class="fa fa-pencil"></span></a> 
                            <a class="btn btn-sm btn-danger" onclick="return confirm('are you sure?')" href="<?php echo site_url('admin/comment/comment/delete/' . $result['id']); ?>" title="Delete"><span class="fa fa-remove"></span></a>
                            <a class="btn btn-sm btn-info" href="<?php echo site_url($post->slug); ?>" target="_blank" title="Link"><span class="fa fa-link"></span></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif;?>

    </tbody>
</table>

<?php if(isset($pagination)) : ?>
    <div class="pagination">
        <?php echo $pagination; ?>
    </div>
<?php endif; ?>