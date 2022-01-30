<?php

error_reporting(E_ALL);

// Use https://en.wikipedia.org/wiki/Disjoint-set_data_structure to find components of
// a graph, these are the clusters.

//----------------------------------------------------------------------------------------
// Disjoint-set data structure

$parents = array();

function makeset($x) {
	global $parents;
	
	if (!isset($parents[$x]))
	{
		$parents[$x] = $x;
	}
	
}

function find($x) {
	global $parents;
	
	if ($x == $parents[$x]) {
		return $x;
	} else {
		return find($parents[$x]);
	}
}

function union($x, $y) {
	global $parents;
	
	$x_root = find($x);
	$y_root = find($y);
	$parents[$x_root] = $y_root;
	
}


?>
