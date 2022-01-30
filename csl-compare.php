<?php

// Compare pairs of citations using a simple approach



error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('compare.php');
require_once('disjoint.php');


use Seboettg\CiteProc\StyleSheet;
use Seboettg\CiteProc\CiteProc;

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
function csl_to_string($csl, $style = 'apa')
{
	$style_sheet = StyleSheet::loadStyleSheet($style);
	$citeProc = new CiteProc($style_sheet);
	
	$html = $citeProc->render(array($csl), "bibliography");

	$text = strip_tags($html);
	$text = trim(html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
	
	return $text;
}

//----------------------------------------------------------------------------------------
function csl_fix(&$csl)
{
	// values that might be arrays
	
	$keys = array('title', 'container-title');
	foreach ($keys as $k)
	{
		if (isset($csl->{$k}) && is_array($csl->{$k}))
		{
			$csl->{$k} = $csl->{$k}[0];
		}
	}
}


//----------------------------------------------------------------------------------------

$count = 1;

$file = @fopen($filename, "r") or die("couldn't open $filename");
	
$file_handle = fopen($filename, "r");
while (!feof($file_handle)) 
{
	$line = trim(fgets($file_handle));	

	$obj = json_decode($line);

	if(json_last_error() == JSON_ERROR_NONE)
	{
		// do any domain-specific cleaning here...
		//print_r($obj);
		
		// fix any arrays that need to be strings for CiteProc
		csl_fix($obj[0]);
		csl_fix($obj[1]);			
		
		// remove unique identifiers
		if (isset($obj[0]->DOI) && isset($obj[1]->DOI))
		{
		}
		else
		{
			unset($obj[0]->DOI);
			unset($obj[1]->DOI);
		}

		if (isset($obj[0]->URL) && isset($obj[1]->URL))
		{
		}
		else
		{
			unset($obj[0]->URL);
			unset($obj[1]->URL);
		}
	
		$string1 = csl_to_string($obj[0]);
		$string2 = csl_to_string($obj[1]);
		
		//echo $string1 . "\n";
		//echo $string2 . "\n";
		
		makeset($obj[0]->id);
		makeset($obj[1]->id);
		
		$result = compare_levenshtein($string1, $string2);
		
		//print_r($result);
		
		if ($result->normalised > 0.8)
		{
			union($obj[1]->id, $obj[0]->id);
		}
		
		echo ".";
		if ($count++ % 10 == 0)
		{
			echo "\n";
		}

	}
}

echo "\n";


print_r($parents);

$tgf = '';
foreach ($parents as $x => $parent)
{
	$tgf .= $x . ' ' . $x . "\n";
}
$tgf .= "#\n";

foreach ($parents as $x => $parent)
{
	//if ($x != $parent)
	{
		$tgf .= $x . ' ' . $parent . "\n";
	}
}

file_put_contents($graph_filename, $tgf);


?>
