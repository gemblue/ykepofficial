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
            <th>Failed</th>
            <th>Jailed</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($results)): ?>
            <div class="alert alert-danger">There is no results ..</div>
        <?php else: ?>
            <?php foreach ($results as $result): ?>
                
                <tr>
                    <td><?php echo $result->name;?></td>
                    <td><?php echo $result->failed;?></td>
                    <td><span class="badge badge-<?php echo ($result->jailed) ? 'danger' : 'success';?>"><?php echo ($result->jailed) ? 'Jailed' : 'Free';?></span></td>
                    <td class="text-right">
                        <div class="btn-group">
                            <?php if ($result->jailed) :?>
                                <a class="btn btn-sm btn-success" href="<?php echo site_url('admin/comment/comment/set_free/' . $result->id); ?>" title="Free">Set Free</a> 
                            <?php else:?>
                                <a class="btn btn-sm btn-danger" href="<?php echo site_url('admin/comment/comment/jail/' . $result->id); ?>" title="Jail">Jail</a> 
                            <?php endif;?>
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