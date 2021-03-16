<?php

/**
 * Navigation module helpers 
 */

if (!function_exists('generate_hierarchy_links'))
{
	function generate_hierarchical_array($array = [])
	{
		$newArray = [];

		if(empty($array)) return [];

		foreach ($array as $arr) {
			if($arr['parent'] !== '0')
				$newArray[$arr['parent']]['children'][$arr['id']] = $arr;
			else if(isset($newArray[$arr['id']]))
				$newArray[$arr['id']] = array_merge($newArray[$arr['id']], $arr);
			else
				$newArray[$arr['id']] = $arr;
		}
		$newArray = sort_array_by($newArray, 'nav_order');
		return $newArray;
	}
}

if (!function_exists('sort_array_by'))
{
	function sort_array_by($array = [], $orderby = 'nav_order')
	{
		$newArray = [];
		foreach ($array as $arr) {
			$newArray[$arr[$orderby]] = $arr;
			if(isset($arr['children']))
				$newArray[$arr[$orderby]]['children'] = sort_array_by($arr['children'], $orderby);
		}
		ksort($newArray);

		return array_values($newArray);
	}
}