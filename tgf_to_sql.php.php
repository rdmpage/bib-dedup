<?php

// Export TGF as SQL so we can update a database



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
	
	$output_filename = basename($filename, '.tgf') . '.sql';
}

// Read a TGF file 

$skip = true;

$sql = '';

$file = @fopen($filename, "r") or die("couldn't open $filename");
		
$file_handle = fopen($filename, "r");
while (!feof($file_handle)) 
{
	$line = trim(fgets($file_handle));
	
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
		
			$sql .= "UPDATE <table> SET cluster_id=$target WHERE id=$source;\n"; 
		}
	}
}

file_put_contents($output_filename, $sql);


?>
