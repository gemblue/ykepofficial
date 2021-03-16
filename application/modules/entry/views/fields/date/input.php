<?php if($value ?? null): ?>
<input type="text" data-toggle="datepicker" id="<?= $config['field'];?>" name="<?= $config['field'];?>" value="<?= date('Y-m-d', strtotime($value)); ?>" class="form-control"/>
<?php else: ?>
<input type="text" data-toggle="datepicker" id="<?= $config['field'];?>" name="<?= $config['field'];?>" value="<?= date('Y-m-d'); ?>" class="form-control"/>
<?php endif; ?>
