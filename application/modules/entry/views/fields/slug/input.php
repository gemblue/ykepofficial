<input type="text" 
	   id="<?php echo $config['field'];?>" 
	   class="form-control <?= $value ? '' : 'slugify'; ?>" 
	   name="<?php echo $config['field'];?>" 
	   value="<?php echo $value;?>" 
	   data-referer="<?php echo $config['referer'];?>" >