<?php 

// Mutation.
if (isset($config['relation']))
{
	$entry = $config['relation']['entry'];
	$caption = $config['relation']['caption'];
	$value = [];
	foreach ($caption as $val)
		$value[] = '<span>'.($result[$entry][$val] ?? null).'<span>';
	echo implode(' - ', $value);
}
