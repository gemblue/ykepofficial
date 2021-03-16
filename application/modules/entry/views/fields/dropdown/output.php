<?php 
// Mutation.
if (isset($config['relation']))
{
	$field = $config['field'];
	$entry = $config['relation']['entry'];
	$caption = $config['relation']['caption'];
	if(is_array($caption)) $caption = $caption[0];

	echo $result[$entry][$caption] ?? null;
}
else 
{
	$value = $result[$config['field']];
	if($value)
	    echo $config['options'][$value];
	else
	    echo array_values($config['options'])[0];
}
