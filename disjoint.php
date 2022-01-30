<?php

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
