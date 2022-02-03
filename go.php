<?php

// Do a complete analysis

$filename 		= '';
$working_path 	= '';
$basename 		= '';

if ($argc < 2)
{
	echo "Usage: " . $argv[0] . " <input file>\n";
	exit(1);
}
else
{
	$filename = $argv[1];
	
	$full_filename = realpath($filename);
	$path_parts = pathinfo($full_filename);
	
	$working_dir 	= $path_parts['dirname'];
	$basename 		= $working_dir . '/' . $path_parts['filename'];
}

$force = false;
//$force = true;


if (!file_exists($basename . '.json') || $force)
{
	echo "Generate pairs of references...\n";

	// Generate pairs of references for comparison
	$command = "php text_to_window.php $full_filename ";

	echo $command . "\n";
	system ($command);
}

if (!file_exists($basename . '.tgf') || $force)
{
	echo "Compare pairs of references...\n";

	// Compare pairs and generate TGF graph of clusters
	$command = "php csl-compare.php $basename.json";

	echo $command . "\n";
	system ($command);

}

// Create sets of references (one file per cluster)

echo "Extract sets of references...\n";

$command = "php merge.php $basename.json";

echo $command . "\n";
system ($command);


// Merge sets of references to output consensus reference

echo "Merge to create consensus references...\n";

// clear log file
file_put_contents($working_dir . '/log.html', '');

$files = scandir($working_dir);
foreach ($files as $fname)
{
	if (preg_match('/\d+\.json$/', $fname))
	{	
		// do stuff on $basedir . '/' . $filename
		$command = "php merge_metadata.php $working_dir/$fname";
		echo $command . "\n";
		system ($command);
	}
}

echo "Export as RIS...\n";

// RIS
$files = scandir($working_dir);
foreach ($files as $filename)
{
	if (preg_match('/\d+\.merged\.json$/', $filename))
	{	
		$command = "php csl_to_ris.php $working_dir/$filename";
		echo $command . "\n";
		system ($command);
	}
}


echo "Done\n";


?>

