<?php

// Given a text file listing references, one per row,  create a CSL data for each row, 
// and output all unique pairs
// of CSL objects for a specific window size. That is, we move down the rows and only
// make comparisons for records within a window of each other. This minimises the 
// number of comparisons we need to make.
//

// We output these pairs as JSONL rows, which we can then process using a separate program.

//----------------------------------------------------------------------------------------
function get($url, $format = '')
{
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	
	if ($format != '')
	{
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: " . $format));	
	}
	
	$response = curl_exec($ch);
	if($response == FALSE) 
	{
		$errorText = curl_error($ch);
		curl_close($ch);
		die($errorText);
	}
	
	$info = curl_getinfo($ch);
	$http_code = $info['http_code'];
	
	curl_close($ch);
	
	return $response;
}

//----------------------------------------------------------------------------------------

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
	
	$full_filename 	 = realpath($filename);
	$path_parts		 = pathinfo($full_filename);
	
	$working_dir 	 = $path_parts['dirname'];
	$output_filename = $working_dir . '/' . $path_parts['filename'] . '.json';
}

file_put_contents($output_filename, "");

// Read a text file with bibliographic records and export as pairs for comparison


$row_count = 0;

$window_size 	= 5;
$window 		= array();

$first_time 	= true;

$file = @fopen($filename, "r") or die("couldn't open $filename");
		
$file_handle = fopen($filename, "r");
while (!feof($file_handle)) 
{
	$line = trim(fgets($file_handle));
	
	// convert to CSL	
	
	$url = 'http://localhost/~rpage/citation-parsing/api.php?text=' . urlencode($line);
	
	$json = get($url);
		
	$csl = json_decode($json);
	

	if(json_last_error() == JSON_ERROR_NONE)
	{
		if (!isset($csl[0]->id))
		{
			$csl[0]->id = $row_count;
		}
	
	
		$window[] = $csl[0];
		
		// print_r($window);

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
					
						$output = array();
						$output[] = $window[$j];
						$output[] = $window[$k];
						
						$json =  json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
						
						// echo $json;
						
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
	$row_count++;
	
	echo ".";
	if ($row_count % 10 == 0)
	{
		echo "\n";
	}
	
}

?>
