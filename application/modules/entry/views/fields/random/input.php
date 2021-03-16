<?php
$random = random_string($config['mode'] ?? 'alnum', $config['digit'] ?? 8);
if($config['uppercase'] ?? null) $random = strtoupper($random);
if($config['time_prefix'] ?? null) $random = date($config['time_prefix']).$random;
if($config['date_prefix'] ?? null) $random = date($config['date_prefix']).$random;
$value = $value ? $value : $random;
?>

<?php if($config['writable'] ?? null): ?>
<input type="text" id="<?= $config['field'];?>" name="<?= $config['field'];?>" value="<?= $value; ?>" class="form-control"/>
<?php else: ?>
<input type="hidden" id="<?= $config['field'];?>" name="<?= $config['field'];?>" value="<?= $value; ?>"/>
<?php endif; ?>
