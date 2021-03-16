<input type="text" disabled name="<?= $config['field'];?>" value="<?= !empty($value) ? $value : $_GET['filter'][$config['field']]; ?>" class="form-control"/>

<input type="hidden" id="<?= $config['field'];?>" 
name="<?= $config['field'];?>" value="<?= !empty($value) ? $value : $_GET['filter'][$config['field']]; ?>"/>