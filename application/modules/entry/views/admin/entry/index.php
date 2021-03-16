<style>
  th {color: #eee !important; font-weight: 600;}
  th.sorted {color: #ffbf4a !important;font-weight: 700;}
</style>
<div class="mb-3">
  <div class="row">
    <div class="col-6">
      <h2>
        <?php if($entryConf['parent_module'] ?? null):?>
          <a href="<?= site_url('admin/entry/'.$entryConf['parent_module']); ?>"><?= config_item('entries')[$entryConf['parent_module']]['name']; ?></a> &raquo;
        <?php endif; ?>
        <?php echo $page_title; ?>
      </h2>
    </div>
    <div class="col-6 text-right mt-1">
      <div class="btn-group">
        <?php if(isset($action_buttons['top'])): ?>
          <?php foreach($action_buttons['top'] as $key => $button): ?>
            <?php if(!isset($button['menu_permission']) || isPermitted($button['menu_permission'], $entry)): ?>
                <a href="<?php echo site_url("admin/entry/$entry/action/top/".$key); ?>" class="btn btn-primary-outline pull-right <?= $key; ?>" title="<?= $button['caption']; ?>">
                  <span class="fa fa-<?= $button['icon'] ?? 'heart'; ?>"></span> 
                  <span class="d-none d-sm-inline"><?= $button['caption']; ?></span>
                </a>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>

        <?php if(isPermitted('entry/'.$entry.'/export_csv', $entry)): ?>
          <a href="<?php echo site_url("admin/entry/$entry/export_csv?".$_SERVER['QUERY_STRING']); ?>" class="btn btn--secondary-outline pull-right">
            <span class="fa fa-download"></span>
            <span class="d-none d-sm-inline">Export CSV</span>
          </a>
        <?php endif; ?>

        <?php if(isPermitted('entry/'.$entry.'/add', $entry)): ?>
          <a href="<?php echo site_url("admin/entry/$entry/add?".$_SERVER['QUERY_STRING']); ?>" class="btn btn-success pull-right text-white">
            <span class="fa fa-plus"></span> 
            <span class="d-none d-sm-inline">Tambah <?php echo $page_title; ?></span>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php echo $this->session->flashdata('message');?>

<?php if(isset($parent_data)): ?>
<table class="table table-responsive table-sm mt-4">
  <?php foreach ($parent_data as $parent_title => $parent_value): ?>
  <tr>
    <th class="text-secondary"><?= $parent_title; ?></th>
    <td class="px-3">: &nbsp; <?= $parent_value; ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>

<form>
<section class="pt-3">
  <div class="row">
    <div class="col-12">
      <div class="form-inline">
        <div class="mb-2 mr-3 text-white bg-info px-3 py-2"><strong>Total row: <?= $total; ?></strong></div>
        <div class="mb-2 mr-sm-2"><label>Sort by: </label></div>
        <?php 
          $sort_fields['created_at'] = 'Tanggal submit'; 
          // $sort_fields['id'] = 'id';
          if($show_on_table ?? null){
            foreach ($show_on_table as $sotfield) {
              $sort_fields[$sotfield] = $fields[$sotfield]['label'];
            }
          }
        ?>
        <?= form_dropdown('sort', $sort_fields, $this->input->get('sort'), 'class="form-control mb-2 mr-sm-2"'); ?>
        <?= form_dropdown('sortdir', ['desc' => 'descending','asc' => 'ascending'], $this->input->get('sortdir'), 'class="form-control mb-2 mr-sm-2"'); ?>
        
        <div class="mb-2 mr-sm-2"><label>Row per page: </label></div>
        <?php $perpage_fields = array_combine([10,20,30,40,50,80,100], [10,20,30,40,50,80,100]); ?>
        <?= form_dropdown('perpage', $perpage_fields, ($this->input->get('perpage') ?? $entryConf['row_per_page'] ?? 10), 'class="form-control mb-2 mr-sm-2"'); ?>

        <div class="btn-group mb-1">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="<?= site_url("admin/entry/$entry/"); ?>" class="btn btn-secondary">Reset</a>
        </div>
      </div>
    </div>
  </div>
</section>

<table class="table table-striped table-sm table-responsive">
  <thead>
    <tr class="bg-info text-white">
      <th width="60px">
        No.
      </th>
      <?php if($show_on_table ?? null): ?>
        <?php foreach ($show_on_table as $tableField): ?>
          <th class="<?= $this->input->get('sort') == $tableField ? 'sorted' : ''; ?>">
            <?php if(($sortdir = $this->input->get('sortdir')) && $this->input->get('sort') == $tableField): ?>
            <span class="fa fa-caret-<?= $sortdir == 'desc' ? 'down' : 'up'; ?> text-white"></span>
            <?php endif; ?>
            <?= $fields[$tableField]['label']; ?>
          </th>
        <?php endforeach; ?>
      <?php endif; ?>

      <?php if($show_timestamps ?? null): ?>
        <?php foreach ($show_timestamps as $timestamp): ?>
          <th class="<?= ($this->input->get('sort') ?? 'created_at') == $timestamp ? 'sorted' : ''; ?>">
            <label>  
            <?php if(($sortdir = $this->input->get('sortdir') ?? 'desc') && ($this->input->get('sort') ?? 'created_at') == $timestamp): ?>
              <span class="fa fa-caret-<?= $sortdir == 'desc' ? 'down' : 'up'; ?> text-white"></span>
            <?php endif; ?>
            <span class="text-nowrap"><?= $timestamp; ?></span>
            </label>
          </th>
        <?php endforeach;?>
      <?php endif;?>

      <th></th>
    </tr>
  </thead>
  <tbody>
      <tr>
        <td></td>

        <?php if($show_on_table ?? null): ?>
          <?php foreach ($show_on_table as $tableField): ?>
            <td><?= form_filter($fields[$tableField]); ?></td>
          <?php endforeach; ?>
        <?php endif; ?>

        <?php if($show_timestamps ?? null): ?>
          <?php foreach ($show_timestamps as $timestamp): ?>
            <td></td>
          <?php endforeach; ?>
        <?php endif; ?>

        <td class="text-right">
          <div class="btn-group">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="<?= site_url("admin/entry/$entry/"); ?>" class="btn btn-secondary">Reset</a>
          </div>
        </td>
      </tr>

    <?php if (empty($results)): ?>

      <tr><td colspan="5">No record found ..</td></tr>

    <?php else: ?>
      <?php
        $page = $_GET['page'] ?? 1;
        $perpage = $_GET['perpage'] ?? 10;
        $i = (($page-1) * $perpage)+1;
        foreach ($results as $result): ?>
        <tr>
          <td><?= $i; ?></td>

          <?php if($show_on_table ?? null): ?>
            <?php foreach ($show_on_table as $tableField): ?>
              <td>
                <?= generate_output($fields[$tableField], $result);?>
              </td>
            <?php endforeach; ?>
          <?php endif; ?>

          <?php if($show_timestamps ?? null): ?>
            <?php foreach ($show_timestamps as $timestamp): ?>
            <td title="<?php echo strftime("%A, %d %B", strtotime($result[$timestamp]));?>">
              <?php echo strftime("%d-%m-%Y, %H:%I", strtotime($result[$timestamp]));?>
            </td>
            <?php endforeach; ?>
          <?php endif; ?>

            <td class="text-right">
              <div class="btn-group">

                <?php if(isset($action_buttons['row'])): ?>
                  <?php foreach($action_buttons['row'] as $key => $button): ?>
                    <?php if(!isset($button['menu_permission']) || isPermitted($button['menu_permission'] ?? null, $entry)): ?>

                    <?php if(!isset($button['condition']) || compare_with_symbol($result[$button['condition'][0]], $button['condition'][1], $button['condition'][2] ?? '==')): ?>

                      <?php if(($button['confirm'] ?? null) && is_array($button['confirm'])): ?>
                      <a target="<?= $button['target'] ?? null ? $button['target'] : '_self'; ?>" href="<?php echo site_url("admin/entry/$entry/confirm/row/$key/".$result['id']); ?>" class="btn btn-sm btn-secondary <?= $key; ?>" title="<?= $button['caption']; ?>">
                        <span class="fa fa-<?= $button['icon'] ?? 'heart'; ?>"></span>
                      </a>

                      <?php elseif($button['confirm'] ?? null): ?>
                        <a target="<?= $button['target'] ?? null ? $button['target'] : '_self'; ?>" href="<?php echo site_url("admin/entry/$entry/action/row/$key/".$result['id']); ?>" class="btn btn-sm btn-secondary <?= $key; ?>" title="<?= $button['caption']; ?>" onclick="<?= is_string($button['confirm']) ? "return confirm('".$button['confirm']."');" : "return confirm('Jalankan aksi ini?');" ?>">
                          <span class="fa fa-<?= $button['icon'] ?? 'heart'; ?>"></span>
                        </a>
                        
                        <?php else: ?>
                         <a target="<?= $button['target'] ?? null ? $button['target'] : '_self'; ?>" href="<?php echo site_url("admin/entry/$entry/action/row/$key/".$result['id']); ?>" class="btn btn-sm btn-secondary <?= $key; ?>" title="<?= $button['caption']; ?>">
                          <span class="fa fa-<?= $button['icon'] ?? 'heart'; ?>"></span>
                        </a>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>

            <div class="btn-group">
              <?php if(isPermitted('entry/'.$entry.'/edit/:num', $entry)): ?>
                <a class="btn btn-sm btn-success" href="<?php echo site_url("admin/entry/$entry/edit/" . $result['id']).'?'.$_SERVER['QUERY_STRING']; ?>" title="Edit"><span class="fa fa-pencil"></span></a> 
              <?php endif; ?>

              <?php if(isPermitted('entry/'.$entry.'/delete/:num', $entry)): ?>
                <a class="btn btn-sm btn-danger" onclick="return confirm('are you sure?')" href="<?php echo site_url("admin/entry/$entry/delete/" . $result['id']).'?'.$_SERVER['QUERY_STRING']; ?>" title="Delete"><span class="fa fa-remove"></span></a>
              <?php endif; ?>
            </div>
          </td>
        </tr>
      <?php $i++; endforeach; ?>

    <?php endif; ?>

  </tbody>
</table>

</form>

<?php if(isset($pagination)) : ?>
  <div class="pagination">
    <?php echo $pagination; ?>
  </div>
<?php endif; ?>
