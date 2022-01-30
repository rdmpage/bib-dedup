<?php

// Given a TSV file we create CSL data for each row, and output all unique pairs
// of CSL objects for a specific window size. That is, we move down the rows and only
// make comparisons for records within a window of each other. This minimises the 
// number of comparisons we need to make.
//

// We output these pairs as JSONL rows, which we can then process using a separate program.

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
	
	$output_filename = basename($filename, '.csv') . '.json';
}

file_put_contents($output_filename, "");

// Read a TSV file with bibliographic records and export as pairs for comparison

$headings = array();

$records = array();

$row_count = 0;

$window_size 	= 5;
$window 		= array();

$first_time 	= true;

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
			
			// $obj = raw data
		
			// convert to CSL
			$csl = new stdclass;
			
			foreach ($obj as $k => $v)
			{
				switch ($k)
				{
					case 'id':
					case 'type':
					case 'title':
					case 'container-title':
					case 'volume':
					case 'issue':
					case 'page':
						$csl->{$k} = $v;
						break;
						
					case 'issued':
						$csl->issued = new stdclass;
						$csl->issued->{'date-parts'} = array();
						$csl->issued->{'date-parts'}[0] = array((Integer)$v);
						break;
										
					case 'doi':
						$csl->DOI = $v;
						break;
				
					case 'author':
						$names = explode(';', $v);
						
						$csl->author = array();
						foreach ($names as $name)
						{
							$author = new stdclass;
							if (preg_match('/(.*),\s+(.*)/', $name, $m))
							{
								$author->family = $m[1];
								$author->given = $m[2];
							}
							else
							{
								$parts = explode(' ', $name);
								$n = count($parts);
								if ($n == 1)
								{
									$author->family = $name;
								}
								else
								{
									$author->family = $parts[$n - 1];
									array_pop($parts);
									$author->given = join(' ', $parts);								
								}
								
							}
							
							$csl->author[] = $author;
						}
						break;
				
					default:
						break;
				
				}
			
			
			}

			$window[] = $csl;

			if (count($window) == $window_size)
			{
				// compare records
				
				if ($first_time)
				{
					// do all pairwise comparisons
					
					for ($j = 0; $j < $window_size - 1; $j++)
					{
						for ($k = $j + 1; $k < $window_size; $k++)
						{
							// echo $window[$j] . ' ' . $window[$k] . "\n";

							$output = array();
							$output[] = $window[$j];
							$output[] = $window[$k];
							
							$json =  json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
							
							file_put_contents($output_filename, $json, FILE_APPEND);

						
			
						}
					}
				
					$first_time = false;
				}
				else
				{
					$k = $window_size - 1;
					for ($j = 0; $j < $window_size - 1; $j++)
					{
						//echo $window[$j] . ' ' . $window[$k] . "\n";
						
						$output = array();
						$output[] = $window[$j];
						$output[] = $window[$k];

						$json =  json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
						
						file_put_contents($output_filename, $json, FILE_APPEND);
						
					}
				
				}
								
				// remove oldest record (so window moves one record along)
				array_shift($window);
			}
			
		}
	}	
	$row_count++;
}

?>
