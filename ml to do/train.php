<?php

error_reporting(E_ALL);

require 'vendor/autoload.php';

$input = array();
$output = array();

$filename = "test.tsv";

$file_handle = fopen($filename, "r");
while (!feof($file_handle)) 
{
	$line = trim(fgets($file_handle));
		
	$row = explode("\t",$line);
	
	$go = is_array($row) && count($row) > 1;
	
	if ($go)
	{
		$output[] = array_pop($row);
		$input[] = $row;
	
	}	
	
}	


$num_rows = count($input);
$num_features = count($input[0]);

//print_r($output);
//print_r($input);
//exit();

$p = new \JTet\Perceptron\Perceptron($num_features, 1);


$i = 0;
while($i < 1000)
{

	for ($j = 0; $j < $num_rows; $j++)
	{
		 $p->train($input[$j], $output[$j]);
	}
	$i++;
	if ($i % 100 == 0) 
	{
		echo $i . " " . $p->getIterationError() . "\n";
	}

   
}

// weights
echo "weight vector:\n";
print_r($p->getWeightVector());

echo "bias=" . $p->getBias() . "\n";

// match
//echo $p->test(array(1,0,1,0,0,0,0,0,1,0,0,0))? "Match\n": "No match\n";
//echo $p->test(array(0,1,0,0,0,0,0,1,0,0,0,0))? "Match\n": "No match\n";

// example of just using results to just do the computation

$bias = -2;

$weights = array(
2.9168568984218,
0.28033097194523,
0.89074749843718,
0.19608117905263,
0.82756928765567,
0.071321246713084,
1.0965460262245,
-0.43895962831516,
1.1799771183543,
-0.25453393336131,
1.8045222125037,
-0.69772981558821,
);

$testResult = array_sum(
            array_map(
                function ($a, $b) {
                    return $a * $b;
                },
                $weights,
                array(1,0,1,0,0,0,0,0,1,0,0,0)
                //array(0,1,0,0,0,0,0,1,0,0,0,0)
            )
        );
$testResult += $bias;


echo $testResult . "\n";

echo $p->test(array(1,0,1,0,0,0,0,0,1,0,0,0))? "Match\n": "No match\n";
echo $p->test(array(0,1,0,0,0,0,0,1,0,0,0,0))? "Match\n": "No match\n";

echo $p->test(array(1,0,1,0,0,0,0,0,1,0,0,0)) . "\n";
echo $p->test(array(0,1,0,0,0,0,0,1,0,0,0,0)) . "\n";



?>
