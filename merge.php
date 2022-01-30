<?php

// Given a CSL-JSON list and a TGF file extract unique exemplars for each cluster
// More sophisticated approach would be to merge data but for now keep it simple



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
			$clusters[$target][] = $source;
		}
	}
}


print_r($clusters);

//----------------------------------------------------------------------------------------

// get records

$merged = array();

$file = @fopen($filename, "r") or die("couldn't open $filename");
	
$file_handle = fopen($filename, "r");
while (!feof($file_handle)) 
{
	$line = trim(fgets($file_handle));	

	$obj = json_decode($line);

	if(json_last_error() == JSON_ERROR_NONE)
	{
		// could do various things but for now just grab one example
		
		if (isset($clusters[$obj[0]->id]) && !isset($merged[$obj[0]->id]))
		{
			$merged[$obj[0]->id] = $obj[0];
		}
		

	}
}

print_r($merged);

?>
