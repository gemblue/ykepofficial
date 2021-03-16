<textarea id="<?php echo $config['field'];?>" class="form-control" name="<?php echo $config['field'];?>"></textarea>
<script>
    var simplemde = new SimpleMDE({ 
    	element: document.getElementById('<?php echo $config['field'];?>'),
    	spellChecker: false,
    	forceSync: true
    });
    simplemde.value("<?php echo htmlspecialchars($value);?>");
</script>