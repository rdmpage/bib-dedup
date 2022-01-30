<?php

// Given a CSL-JSON list and a TGF file we extract arrays of CSL-JSON records that
// we think belong to the same cluster

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
	
	$graph_filename = basename($filename, '.json') . '.tgf';
}

//----------------------------------------------------------------------------------------
// read TGF file to get clusters

$clusters = array();

$skip = true;

$sql = '';

$file = @fopen($graph_filename, "r") or die("couldn't open $graph_filename");
		
$file_handle = fopen($graph_filename, "r");
while (!feof($file_handle)) 
{
	$line = trim(fgets($file_handle));
	
	echo $line . "\n";
	
	if ($skip)
	{
		if (substr($line, 0, 1) == '#')
		{
			$skip = false;
		}
	}
	else
	{
		if ($line != "")
		{
			list($source, $target) = explode(' ', $line);
			
			if (!isset($clusters[$target]))
			{
				$clusters[$target] = array();
				$clusters[$target][] = $target;
			}
			if (!in_array($source, $clusters[$target]))
			{				
				$clusters[$target][] = $source;
			}
		}
	}
}


print_r($clusters);

//----------------------------------------------------------------------------------------


// Get records from CSL JSON file for each cluster and output as separate CSL-JSON
// arrays so we can process them to get merged references

// this is ugly but can't assume that members of the same cluster are adjacent in the file

$file = @fopen($filename, "r") or die("couldn't open $filename");


foreach ($clusters as $target => $sources)
{
	$cluster_file_name = $target . '.json';
	file_put_contents($cluster_file_name, "[\n");
	
	echo "Sources\n";
	print_r($sources);
	
	$n = 0;
	
	$file_handle = fopen($filename, "r");
	while (!feof($file_handle) && (count($sources) > 0)) 
	{
		$line = trim(fgets($file_handle));	

		$obj = json_decode($line);

		if(json_last_error() == JSON_ERROR_NONE)
		{
			if (in_array($obj[0]->id, $sources))
			{
				$n++;
				
				if ($n > 1)
				{
					file_put_contents($cluster_file_name, ",\n", FILE_APPEND);
				}
				
				file_put_contents($cluster_file_name, json_encode($obj[1], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), FILE_APPEND);
				
				unset($sources[array_search($obj[0]->id, $sources)]);	
				
			}
			
			if (in_array($obj[1]->id, $sources))
			{
				$n++;
				
				if ($n > 1)
				{
					file_put_contents($cluster_file_name, ",\n", FILE_APPEND);
				}
				
				file_put_contents($cluster_file_name, json_encode($obj[1], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), FILE_APPEND);
				
				unset($sources[array_search($obj[1]->id, $sources)]);			
			}
			
		}
	}
	fclose($file_handle);
	
	file_put_contents($cluster_file_name, "\n]\n", FILE_APPEND);


}


?>
