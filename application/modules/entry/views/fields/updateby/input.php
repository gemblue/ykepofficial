<?php
if($uid = $this->session->user_id)
	$user = $this->User_model->get($uid);
else
	$user = null;
?>
<input type="hidden" id="<?= $config['field'];?>" name="<?= $config['field'];?>" value="<?= $user['id'] ?? null; ?>"/>
