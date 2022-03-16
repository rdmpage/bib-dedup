<?php

// Compare a pair of citations

//require_once(dirname(__FILE__) . '/feature.php');
require_once('../feature.php');

//----------------------------------------------------------------------------------------
// Given a feature vector return true if it represents a matching pair, false otherwise
function is_match ($vector)
{

}

//----------------------------------------------------------------------------------------
//
// Input is an array of two CSL-JSON objects (and optionally a third element 
// which is an integer but which we ignore here). Based on a list of keys we 
// create a set of features and return a vector of 1's and 0's.
// 
// This method can be used as part of training (in which case the third array element is a
// flag as to whether the records match), or just as a comparison of two records.
//
// things to handle
// arrays
// fields being either arrays or strings (e.g., titles)
// numbers being roman or arabic, but still the same
// dates having years, months, days
//
function citation_pair_to_feature_vector($obj, $debug = false)
{
	$features = array();

	// fields to compare
	$keys = array('author', 'title', 'container-title', 'volume', 'issue', 'page', 'issued', 'DOI');

	foreach ($keys as $k)
	{
		switch ($k)
		{

			case 'volume':
			case 'issue':
			case 'page':
			case 'DOI':				
				$features[] 
					= feature_exact(
						$k, 
						$k, 
						$obj[0],
						$obj[1]
						);								
				break;
			
			case 'title':
				$features[] 
					= feature_levenstein(
						$k, 
						$k, 
						$obj[0],
						$obj[1]
						);
				break;
			
			case 'container-title':
				$features[] 
					= feature_subsequence(
						$k, 
						$k, 
						$obj[0],
						$obj[1]
						);
				break;	
			
			// date as array
			case 'issued':
				// year
				$features[] 
					= feature_date_array(
						$k, 
						$k, 
						$obj[0],
						$obj[1],
						0
						);
				
				// more precision if we want it
				/*
				// month
				$features[] 
					= feature_date_array(
						$k, 
						$k, 
						$obj[0],
						$obj[1],
						1
						);

				// day
				$features[] 
					= feature_date_array(
						$k, 
						$k, 
						$obj[0],
						$obj[1],
						2
						);
				*/
				break;	
				
			// first author
			case 'author':
				$features[] 
					= feature_author_in_list(
						$k, 
						$k, 
						$obj[0],
						$obj[1],
						0
						);
				break;
								
			default:
				break;
	
	
		}
	}

	if ($debug)
	{
		print_r($features);
	}

	$vector = array();

	foreach ($features as $feature)
	{
		foreach ($feature as $pair)
		{
			$vector[] = $pair;
		}
	}
	
	return $vector;

}

// test
if (1)
{

	$filename = 'csl.json';

	$file = @fopen($filename, "r") or die("couldn't open $filename");
		
	$file_handle = fopen($filename, "r");
	while (!feof($file_handle)) 
	{
		$line = trim(fgets($file_handle));	
	
		$obj = json_decode($line);
	
		if(json_last_error() == JSON_ERROR_NONE)
		{
	
			print_r($obj);
		
			$vector = citation_pair_to_feature_vector($obj, true);
		
			print_r($vector);
	
		

		}
	}
}

// training
if (0)
{

	$filename = 'csl.json';

	$file = @fopen($filename, "r") or die("couldn't open $filename");
		
	$file_handle = fopen($filename, "r");
	while (!feof($file_handle)) 
	{
		$line = trim(fgets($file_handle));	
	
	
		$obj = json_decode($line);
	
		if(json_last_error() == JSON_ERROR_NONE)
		{
	
			//print_r($obj);
		
			$vector = citation_pair_to_feature_vector($obj);
			
			$vector[] = $obj[2]; // flag to indicate match or not
		
			echo join("\t", $vector) . "\n";
	
		

		}
	}
}

?>
