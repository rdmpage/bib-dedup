<?php

// Compare fields of objects and return _same and _diff values
// same [1, 0]
// diff [0, 1]
// miss [0, 0]

error_reporting(E_ALL);

require_once (dirname(__FILE__) . '/compare.php');

//----------------------------------------------------------------------------------------
function feature_exact($name, $key, $obj1, $obj2)
{
	$same_key = $name . '_same';
	$diff_key = $name . '_diff';

	$feature = array(
		$same_key => 0,
		$diff_key => 0	
	);
	
	if (isset($obj1->{$key}) && isset($obj2->{$key}))
	{
	
		$comparison = compare_simple($obj1->{$key}, $obj2->{$key});
		
		($comparison->normalised == 1) ? $feature[$same_key] = 1 : $feature[$diff_key] = 1;
	
	}
	
	return $feature;
}

//----------------------------------------------------------------------------------------
function feature_levenstein($name, $key, $obj1, $obj2)
{
	$same_key = $name . '_same';
	$diff_key = $name . '_diff';

	$feature = array(
		$same_key => 0,
		$diff_key => 0	
	);
	
	if (isset($obj1->{$key}) && isset($obj2->{$key}))
	{
		$text1 = $obj1->{$key};
		$text2 = $obj2->{$key};
		
		// Some sources (e.g., CrossRef) might be an array
		if (is_array($text1))
		{
			$text1 = $text1[0];
		}
		if (is_array($text2))
		{
			$text2 = $text2[0];
		}
	
		$comparison = compare_levenshtein($text1, $text2);
		
		($comparison->normalised > 0.9) ? $feature[$same_key] = 1 : $feature[$diff_key] = 1;
	
	}
	
	return $feature;
}

//----------------------------------------------------------------------------------------
function feature_subsequence($name, $key, $obj1, $obj2)
{
	$same_key = $name . '_same';
	$diff_key = $name . '_diff';

	$feature = array(
		$same_key => 0,
		$diff_key => 0	
	);
	
	if (isset($obj1->{$key}) && isset($obj2->{$key}))
	{
		$text1 = $obj1->{$key};
		$text2 = $obj2->{$key};
		
		// Some sources (e.g., CrossRef) might be an array
		if (is_array($text1))
		{
			$text1 = $text1[0];
		}
		if (is_array($text2))
		{
			$text2 = $text2[0];
		}
	
		$comparison = compare_common_subsequence($text1, $text2);
		
		($comparison->normalised[1] > 0.9) ? $feature[$same_key] = 1 : $feature[$diff_key] = 1;
	
	}
	
	return $feature;
}

//----------------------------------------------------------------------------------------
function feature_date_array($name, $key, $obj1, $obj2, $index = 0)
{
	$same_key = $name . '_' . $index . '_same';
	$diff_key = $name . '_' . $index . '_diff';

	$feature = array(
		$same_key => 0,
		$diff_key => 0	
	);
	
	if (isset($obj1->{$key}) && isset($obj2->{$key}))
	{
		if (isset($obj1->{$key}->{'date-parts'}[0][$index]) && isset($obj2->{$key}->{'date-parts'}[0][$index]))
		{
			$comparison = compare_simple($obj1->{$key}->{'date-parts'}[0][$index], $obj2->{$key}->{'date-parts'}[0][$index]);
		
			($comparison->normalised == 1) ? $feature[$same_key] = 1 : $feature[$diff_key] = 1;

		}
	}
	
	return $feature;
}

//----------------------------------------------------------------------------------------
function feature_author_in_list($name, $key, $obj1, $obj2, $index = 0)
{
	$same_key = $name . '_' . $index . '_same';
	$diff_key = $name . '_' . $index . '_diff';
	
	$feature = array(
		$same_key => 0,
		$diff_key => 0	
	);
	
	if (isset($obj1->{$key}) && isset($obj2->{$key}))
	{
		if (isset($obj1->{$key}[$index]) && isset($obj2->{$key}[$index]))
		{
			$person1 = $obj1->{$key}[$index];
			$person2 = $obj2->{$key}[$index];
			
			// simplest comparison is to match last name (assumes name has been parsed)
			if (isset($person1->family) && isset($person2->family))
			{
				$comparison = compare_simple($person1->family, $person2->family);
		
				($comparison->normalised == 1) ? $feature[$same_key] = 1 : $feature[$diff_key] = 1;
			
			}
				
		
		}
	}
	
	return $feature;
}	
	



?>
