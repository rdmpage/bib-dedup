<?php

// Given a CSL-JSON file output references in RIS

require_once (dirname(__FILE__) . '/csl_utils.php');

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
	$ris_filename = $working_dir . '/' . $path_parts['filename'] . '.ris';
}


file_put_contents($ris_filename, '');

$json = file_get_contents($filename);

$obj = json_decode($json);

if(json_last_error() == JSON_ERROR_NONE)
{
	foreach ($obj as $csl)
	{
		$ris = csl_to_ris($csl);
	
		file_put_contents($ris_filename, $ris, FILE_APPEND);
	}
}


?>
