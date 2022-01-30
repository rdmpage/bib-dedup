<?php

// Merge an array of CSL-JSON record sinto a single record


error_reporting(E_ALL);



//----------------------------------------------------------------------------------------
function add_unique_value(&$unique_values, $key, $value)
{
	if (!isset($unique_values[$key]))
	{
		$unique_values[$key] = array();
	}
	if (!in_array($value, $unique_values[$key]))
	{
		$unique_values[$key][] = $value;
	}	
	
}

//----------------------------------------------------------------------------------------
function add_value(&$values, $key, $value, $index)
{
	if (!isset($values[$key]))
	{
		$values[$key] = array();
	}
	$values[$key][$index] = $value;
}

//----------------------------------------------------------------------------------------
// Merge an array of CSL-JSON records
function merge ($objs, $confidence = array(), $debug = false)
{

	$keys = array('author', 'title', 'container-title', 'volume', 'issue', 'page', 
		'issued','DOI');

	$unique_values = array();
	$values = array();
	

	if (count($confidence) == 0)
	{
		foreach ($objs as $index => $obj)
		{
			$confidence[] = 0.8;
		}
		
	}

	//----------------------------------------------------------------------------------------
	// clean and simplify object, make sure title and container-title are strings, and
	// replace author array by a string
	foreach ($objs as $index => $obj)
	{
		foreach ($keys as $k)
		{
			if (isset($obj->$k))
			{
				// echo "k=$k\n";
		
				switch ($k)
				{
			
					case 'author':
						$authors = array();
						foreach ($obj->$k as $author)
						{
							if (isset($author->literal))
							{
								if (preg_match('/(.*),\s+(.*)/', $author->literal, $m))
								{
									$authors[] = $m[2] . ' ' . $m[1];
								}
								else
								{						
									$authors[] = $author->literal;
								}
							}
							else
							{
								$name_parts = array();
								if (isset($author->given))
								{
									$name_parts[] = $author->given;
								}
								if (isset($author->family))
								{
									$name_parts[] = $author->family;
								}
								$name = trim(join(' ', $name_parts));
								if ($name != '')
								{
									$authors[] = $name;
								}
							}
						}
					
						if (count($authors) > 0)
						{
							$value = join(';', $authors);
							$objs[$index]->{$k} = $value;				
						}
						break;
			
					case 'title':
					case 'container-title':
						$value = $obj->{$k};
						if (is_array($value))
						{
							$value = $value[0];
							$objs[$index]->{$k} = $value;
						}
						break;
					
					case 'DOI':
						$value = strtolower($obj->{$k});
						$objs[$index]->{$k} = $value;
						break;
					
					
					default:
						break;
				}
			}
		}


	}

	foreach ($objs as $index => $obj)
	{

		// echo "index=$index\n";
	
		foreach ($keys as $k)
		{
			if (isset($obj->$k))
			{
				// echo "k=$k\n";
		
				switch ($k)
				{			
					case 'author':
					case 'title':
					case 'container-title':
					case 'volume':
					case 'issue':
					case 'page':
					case 'DOI':
						$value = $obj->{$k};
					
						add_unique_value($unique_values, $k, $value);
						add_value($values, $k, $value, $index);
						break;
					
						// complicated data structure so extract year, month and day, and
						// add them to the CSL-JSON as extra fields so we can still build 
						// our consensus object.
					case 'issued':					
						$n = count($obj->{$k}->{'date-parts'}[0]);
					
						if ($n >= 1)
						{
							$value = $obj->{$k}->{'date-parts'}[0][0];
						
							add_unique_value($unique_values, 'issued-year', $value);
							add_value($values, 'issued-year', $value, $index);
						
							$objs[$index]->{'issued-year'} = $value; // hack
						}

						if ($n >= 2)
						{
							$value = $obj->{$k}->{'date-parts'}[0][1];
						
							add_unique_value($unique_values, 'issued-month', $value);
							add_value($values, 'issued-month', $value, $index);
						
							$objs[$index]->{'issued-month'} = $value; // hack
						}

						if ($n >=3)
						{
							$value = $obj->{$k}->{'date-parts'}[0][2];
						
							add_unique_value($unique_values, 'issued-day', $value);
							add_value($values, 'issued-day', $value, $index);
						
							$objs[$index]->{'issued-day'} = $value; // hack
						}

						break;


					default:
						break;
				}
			}
		}
	
	
	
	}

	if ($debug)
	{

		echo "Unique values\n";
		print_r($unique_values);

		echo "Values\n";
		print_r($values);
	}
	
	$vectors = array();

	$keys = array_keys($values);

	foreach ($keys as $k)
	{
		$num_records = count($objs);
		for ($i = 0; $i < $num_records; $i++)
		{
			$n = count($unique_values[$k]);
		
			if ($n > 0)
			{
				$vector = array();
				for ($j = 0; $j < $n; $j++)
				{
					$vector[$j] = 0;
				}
			
				if (isset($objs[$i]->{$k}))
				{
					$pos = array_search($objs[$i]->{$k}, $unique_values[$k]);
					$vector[$pos] = 1;
					$vectors[$k][$i] = $vector;
				}
				else
				{
					$vectors[$k][$i] = null;
				}
		
			}
		

	
		}
	}

	if ($debug)
	{
		echo "Vectors\n\n";
		foreach ($vectors as $k => $v)
		{
			echo str_pad($k, 20, ' ', STR_PAD_LEFT) . ' ' . json_encode($v) . "\n";
		}
		echo "\n\n";
	}

	//----------------------------------------------------------------------------------------

	$consensus = new stdclass;

	foreach ($keys as $k)
	{
		if (isset($vectors[$k]))
		{
	
			$belief = array();
		
			$num_records = count($objs);
			for ($i = 0; $i < $num_records; $i++)
			{
				if (isset($vectors[$k][$i]))
				{
					$b = array();
				
					$n = count($vectors[$k][$i]);
				
					for ($j = 0; $j < $n; $j++)
					{
						if ($vectors[$k][$i][$j] == 1)
						{
							$b[$j] = $confidence[$i];
						}
						else
						{
							$b[$j] = (1 - $confidence[$i]) / ($n - 1);
						}
					}
				
					//echo json_encode($b) . "\n";
				
					$num_beliefs = count($belief);
					if ($num_beliefs == 0)
					{
						$belief = $b;
					}
					else
					{
						$sum = 0;
						for ($m = 0; $m < $num_beliefs; $m++)
						{
							$belief[$m] = $belief[$m] * $b[$m];
							$sum += $belief[$m];
						}
						for ($m = 0; $m < $num_beliefs; $m++)
						{
							$belief[$m] = round($belief[$m] / $sum, 2);
						}
					
					}
				}
		
			}
		
			if ($debug)
			{
				echo str_pad($k, 20, ' ', STR_PAD_LEFT)  . ' ' . json_encode($belief) . "\n";
			}
		
			$best_value = $best_value  = $unique_values[$k][0];
			$max_belief = 0;
		
			foreach ($belief as $pos => $belief_value)
			{
				if ($belief_value > $max_belief)
				{
					$max_belief = $belief_value;
					$best_value  = $unique_values[$k][$pos];
				}
			}
		
			if ($debug)
			{
				echo str_pad($k, 20, ' ', STR_PAD_LEFT)  . ' ' . $best_value . "\n";
			}
		
			switch ($k)
			{
				case 'issued-year':
				case 'issued-month':
				case 'issued-day':
					if (!isset($consensus->issued))
					{
						$consensus->issued = new stdclass;
						$consensus->issued->{'date-parts'} = array(); 	
						$consensus->issued->{'date-parts'}[] = array();
					}
					switch ($k)
					{
						case 'issued-year':
							$consensus->issued->{'date-parts'}[0][0] = $best_value;
							break;

						case 'issued-month':
							$consensus->issued->{'date-parts'}[0][1] = $best_value;
							break;

						case 'issued-day':
							$consensus->issued->{'date-parts'}[0][2] = $best_value;
							break;
						
						default:
							break;
				
				
					}
					break;
				
				case 'author':
					$names = explode(';', $best_value);
				
					$consensus->author = array();
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
					
						$consensus->author[] = $author;
					}
					break;
		
				default:
					$consensus->{$k} = $best_value;
					break;
			
		
			}
		
	
		}
	}
	
	return $consensus;
}

//----------------------------------------------------------------------------------------


$filename = '';
$merged_filename = '';

if ($argc < 2)
{
	echo "Usage: " . $argv[0] . " <input file>\n";
	exit(1);
}
else
{
	$filename = $argv[1];
	
	$merged_filename = basename($filename, '.json') . '.merged.json';
}

$file = @fopen($filename, "r") or die("couldn't open $filename");


$json = file_get_contents($filename);
$objs = json_decode($json);

$consensus = merge($objs);

$merged_json =  json_encode(array($consensus), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

echo $merged_json . "\n";

file_put_contents($merged_filename, $merged_json);


?>
