<?php

// simple clustering of strings with optional identifier, do everything in one script

// assumes a TSV file with a header row. By default one column called "string"
// can have other columns, such as "identifier" for an external identifer

require_once(dirname(__FILE__) . '/compare.php');
require_once(dirname(__FILE__) . '/disjoint.php');



$filename = '';
$output_filename = '';

if ($argc < 2)
{
	echo "Usage: " . $argv[0] . " <input file>\n";
	exit(1);
}
else
{
	$filename = $argv[1];
	
	//$working_dir 	 = $path_parts['dirname'];
	//$output_filename  = $working_dir . '/' . $path_parts['filename'] . '.tgf';
}

//----------------------------------------------------------------------------------------


$rows = array();

$row_count = 0;

$count = 0;

$file = @fopen($filename, "r") or die("couldn't open $filename");
$file_handle = fopen($filename, "r");
while (!feof($file_handle)) 
{
	$row = fgetcsv(
		$file_handle, 
		0, 
		"\t" 
		);
		
	$go = is_array($row);
	
	if ($go)
	{
		if ($row_count == 0)
		{
			$headings = $row;		
		}
		else
		{
			// read row of data 
			$obj = new stdclass;
		
			foreach ($row as $k => $v)
			{
				if ($v != '')
				{
					$obj->{$headings[$k]} = $v;
				}
			}
			
			print_r($obj);
		
			if (isset($obj->string))
			{
				$obj->text = normalise_text($obj->string);
				$obj->text = removeCommonWords($obj->text);
			
				makeset($count);
		
				$rows[] = $obj;
		
				$count++;
			}
	
		}
		
	}
	$row_count++;
	

}

//----------------------------------------------------------------------------------------

// Make sure data is sorted by cleaned strings

function cmp($a, $b) {
    return strcmp($a->text, $b->text);
}

usort($rows, "cmp");

//print_r($rows);

//----------------------------------------------------------------------------------------

// Move window along strings and compare

$n = count($rows);

$window 		= 5;

for ($i = 0; $i < $n; $i++)
{
	$behind = max(0, $i - $window);
	$ahead  = min($i + $window, $n - 1);
	$chunk 	= $ahead - $behind + 1;
	
	$subset = array_slice($rows, $behind, $chunk, true);
	
	$keys = array_keys($subset);
	
	//print_r($keys);
	
	for ($j = 0; $j < $chunk - 1; $j++)
	{
		for ($k = $j + 1; $k < $chunk; $k++)
		{
		
			if (0)
			{
				$result = compare_levenshtein($rows[$keys[$j]]->text, $rows[$keys[$k]]->text);
				if ($result->normalised > 0.8)
				{
					union($keys[$k], $keys[$j]);
				}
			}
			else
			{
				$result = compare_common_subsequence($rows[$keys[$j]]->text, $rows[$keys[$k]]->text, false);

				//print_r($result);
				
				$matched = false;
				
				if ($result->normalised[1] > 0.95)
				{
					// one string is almost an exact substring of the other
					if ($result->normalised[0] > 0.6)
					{
						// and the shorter string matches a good chunk of the bigger string
						$matched = true;					
					}
					
					if ($matched)
					{
						union($keys[$k], $keys[$j]);
					}
				}
			
			}
	
		}
	}

}


//----------------------------------------------------------------------------------------
// Extract clusters from sets
$blocks = array();

for ($i = 0; $i < $n; $i++)
{
	$p = find($i);

	if (!isset($blocks[$p]))
	{
		$blocks[$p] = array();
	}
	$blocks[$p][] = $i;
}

if (0)
{
	echo "Blocks\n";
	print_r($blocks);
}

//----------------------------------------------------------------------------------------
// This is where we double check and merge results
$clusters = array();
foreach ($blocks as $k => $block)
{
	$clusters[$k] = array();
	
	foreach ($block as $i)
	{
		$clusters[$k][] = $rows[$i];
	}
}


print_r($clusters);

//----------------------------------------------------------------------------------------

print_r($parents);

$tgf = '';
foreach ($parents as $x => $parent)
{
	//$tgf .= $x . ' ' . $x . "\n";
	$tgf .= $x . ' ' . $rows[$x]->string . "\n";
}
$tgf .= "#\n";

foreach ($parents as $x => $parent)
{
	//if ($x != $parent)
	{
		$tgf .= $x . ' ' . $parent . "\n";
	}
}

file_put_contents('simple.tgf', $tgf);




?>
