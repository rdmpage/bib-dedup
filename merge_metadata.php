<?php

// merge CSL

$json1 = '{ "title":"Notas e descrições de novos táxons em Cerambycinae neotropicais (Coleoptera, Cerambycidae)", "issued":{"date-parts":[[2005]]}, "container-title":"Papéis Avulsos de Zoologia", "volume": "46", "issue": "4", "page": "31-42"    }';
$json2 = '{

    "status": "ok",
    "unstructured": "Dilma Solange Napp & Ubirajara Ribeiro Martins de Souza 2006: Notas e descrições de novos táxons em Cerambycinae neotropicais (Coleoptera, Cerambycidae). Papéis Avulsos de Zoologia 46(4): 31–42. full article (). ,_2006 reference page find all Wikispecies pages which cite this reference",
    "author": [
        {
            "literal": "Napp, D.S.",
            "WIKISPECIES": "Dilma Solange Napp"
        },
        {
            "literal": "Martins, U.R.",
            "WIKISPECIES": "Ubirajara Ribeiro Martins de Souza"
        }
    ],
    "alternative-id": [
        "Napp_%26_Martins,_2006"
    ],
    "volume": "46",
    "issue": "4",
    "page": "31-42",
    "ISSN": [
        "0031-1049"
    ],
    "title": "Notas e descrições de novos táxons em Cerambycinae neotropicais (Coleoptera, Cerambycidae)",
    "PDF": "http://www.scielo.br/pdf/paz/v46n4/04.pdf",
    "WIKISPECIES": "Template:Napp_%26_Martins,_2006",
    "issued": {
        "date-parts": [
            [
                2006
            ]
        ]
    },
    "container-title": "Papéis Avulsos de Zoologia",
    "type": "article-journal"

}';
$json3 = '{"indexed":{"date-parts":[[2017,5,27]],"date-time":"2017-05-27T06:30:29Z","timestamp":1495866629671},"reference-count":0,"publisher":"FapUNIFESP (SciELO)","issue":"4","content-domain":{"domain":[],"crossmark-restriction":false},"short-container-title":["Pap. Avulsos Zool. (S\ufffdo Paulo)"],"published-print":{"date-parts":[[2006,1,1]]},"DOI":"10.1590\/s0031-10492006000400001","type":"journal-article","created":{"date-parts":[[2006,9,21]],"date-time":"2006-09-21T15:04:58Z","timestamp":1158851098000},"source":"Crossref","is-referenced-by-count":0,"title":["<![CDATA[<B>Notas e descri\ufffd\ufffdes de novos t\ufffdxons em Cerambycinae Neotropicais (Coleoptera, Cerambycidae)<\/B>]]>"],"prefix":"10.1590","volume":"47","author":[{"given":"Dilma S.","family":"Napp","affiliation":[]},{"given":"Ubirajara R.","family":"Martins","affiliation":[]}],"member":"530","container-title":["Pap\ufffdis Avulsos de Zoologia (S\ufffdo Paulo)"],"original-title":[],"deposited":{"date-parts":[[2016,12,15]],"date-time":"2016-12-15T09:25:25Z","timestamp":1481793925000},"score":1.0,"subtitle":[],"short-title":[],"issued":{"date-parts":[[2006,1,1]]},"references-count":0,"alternative-id":["S0031-10492006000400001"],"URL":"http:\/\/dx.doi.org\/10.1590\/s0031-10492006000400001","relation":{},"ISSN":["0031-1049"],"issn-type":[{"value":"0031-1049","type":"print"}],"subject":["Animal Science and Zoology"]}';

if (0)
{
	$json1 = '{
		"indexed": {
		  "date-parts": [
			[
			  2022,
			  1,
			  11
			]
		  ],
		  "date-time": "2022-01-11T14:06:56Z",
		  "timestamp": 1641910016793
		},
		"reference-count": 0,
		"publisher": "Naturalis Biodiversity Center",
		"issue": "1",
		"content-domain": {
		  "domain": [],
		  "crossmark-restriction": false
		},
		"short-container-title": [
		  "persoonia"
		],
		"published-print": {
		  "date-parts": [
			[
			  2020,
			  6,
			  29
			]
		  ]
		},
		"abstract": "&lt;jats:p&gt;\n                        &lt;jats:italic&gt; Amauroderma&lt;/jats:italic&gt; s.lat. has been defined mainly by the morphological features of non-truncate and double-walled basidiospores with a distinctly ornamented endospore wall. In this work, taxonomic and phylogenetic studies on species of &lt;jats:italic&gt;Amauroderma&lt;/jats:italic&gt; s.lat. are carried out by morphological\n examination together with ultrastructural observations, and molecular phylogenetic analyses of multiple loci including the internal transcribed spacer regions (ITS), the large subunit of nuclear ribosomal RNA gene (nLSU), the largest subunit of RNA polymerase II (&lt;jats:italic&gt;RPB1&lt;/jats:italic&gt;) and the second\n largest subunit of RNA polymerase II (&lt;jats:italic&gt;RPB2&lt;/jats:italic&gt;), the translation elongation factor 1-α gene (&lt;jats:italic&gt;TEF&lt;/jats:italic&gt;) and the β-tubulin gene (&lt;jats:italic&gt;TUB&lt;/jats:italic&gt;). The results demonstrate that species of &lt;jats:italic&gt;Ganodermataceae&lt;/jats:italic&gt; formed ten clades. Species previously placed in &lt;jats:italic&gt;Amauroderma&lt;/jats:italic&gt; s.lat.\n are divided into four clades: &lt;jats:italic&gt;Amauroderma&lt;/jats:italic&gt; s.str., &lt;jats:italic&gt;Foraminispora&lt;/jats:italic&gt;, &lt;jats:italic&gt;Furtadoa&lt;/jats:italic&gt; and a new genus &lt;jats:italic&gt;Sanguinoderma&lt;/jats:italic&gt;. The classification of &lt;jats:italic&gt;Amauroderma&lt;/jats:italic&gt; s. lat. is thus revised, six new species are described and illustrated, and eight new combinations are proposed. SEM\n micrographs of basidiospores of &lt;jats:italic&gt;Foraminispora&lt;/jats:italic&gt; and&lt;jats:italic&gt; Sanguinoderma&lt;/jats:italic&gt; are provided, and the importance of SEM in delimitation of taxa in this study is briefly discussed. Keys to species of&lt;jats:italic&gt; Amauroderma&lt;/jats:italic&gt; s.str.,&lt;jats:italic&gt; Foraminispora&lt;/jats:italic&gt;,&lt;jats:italic&gt; Furtadoa&lt;/jats:italic&gt;, and&lt;jats:italic&gt; Sanguinoderma&lt;/jats:italic&gt; are\n also provided.&lt;/jats:p&gt;",
		"DOI": "10.3767/persoonia.2020.44.08",
		"type": "journal-article",
		"created": {
		  "date-parts": [
			[
			  2020,
			  5,
			  5
			]
		  ],
		  "date-time": "2020-05-05T01:05:34Z",
		  "timestamp": 1588640734000
		},
		"page": "206-239",
		"source": "Crossref",
		"is-referenced-by-count": 11,
		"title": [
		  "Multi-gene phylogeny and taxonomy of Amauroderma s. lat. (Ganodermataceae)"
		],
		"prefix": "10.3767",
		"volume": "44",
		"author": [
		  {
			"given": "Y.-F.",
			"family": "Sun",
			"sequence": "first",
			"affiliation": []
		  },
		  {
			"given": "D.H.",
			"family": "Costa-Rezende",
			"sequence": "additional",
			"affiliation": []
		  },
		  {
			"given": "J.-H.",
			"family": "Xing",
			"sequence": "additional",
			"affiliation": []
		  },
		  {
			"given": "J.-L.",
			"family": "Zhou",
			"sequence": "additional",
			"affiliation": []
		  },
		  {
			"given": "B.",
			"family": "Zhang",
			"sequence": "additional",
			"affiliation": []
		  },
		  {
			"given": "T.B.",
			"family": "Gibertoni",
			"sequence": "additional",
			"affiliation": []
		  },
		  {
			"given": "G.",
			"family": "Gates",
			"sequence": "additional",
			"affiliation": []
		  },
		  {
			"given": "M.",
			"family": "Glen",
			"sequence": "additional",
			"affiliation": []
		  },
		  {
			"given": "Y.-C.",
			"family": "Dai",
			"sequence": "additional",
			"affiliation": []
		  },
		  {
			"given": "B.-K.",
			"family": "Cui",
			"sequence": "additional",
			"affiliation": []
		  }
		],
		"member": "2084",
		"container-title": [
		  "Persoonia - Molecular Phylogeny and Evolution of Fungi"
		],
		"original-title": [],
		"language": "en",
		"link": [
		  {
			"URL": "https://www.ingentaconnect.com/content/nhn/pimj/2020/00000044/00000001/art00008",
			"content-type": "unspecified",
			"content-version": "vor",
			"intended-application": "similarity-checking"
		  }
		],
		"deposited": {
		  "date-parts": [
			[
			  2020,
			  7,
			  20
			]
		  ],
		  "date-time": "2020-07-20T10:24:56Z",
		  "timestamp": 1595240696000
		},
		"score": 1,
		"subtitle": [],
		"short-title": [],
		"issued": {
		  "date-parts": [
			[
			  2020,
			  6,
			  29
			]
		  ]
		},
		"references-count": 0,
		"journal-issue": {
		  "issue": "1",
		  "published-print": {
			"date-parts": [
			  [
				2020,
				6,
				29
			  ]
			]
		  }
		},
		"alternative-id": [
		  "0031-5850(20200629)44:1L.206;1-"
		],
		"URL": "http://dx.doi.org/10.3767/persoonia.2020.44.08",
		"relation": {},
		"ISSN": [
		  "0031-5850"
		],
		"issn-type": [
		  {
			"value": "0031-5850",
			"type": "print"
		  }
		],
		"subject": [
		  "Ecology, Evolution, Behavior and Systematics"
		],
		"published": {
		  "date-parts": [
			[
			  2020,
			  6,
			  29
			]
		  ]
		}
	  }';
  
	  $json2 = '{
		"type": "article-journal",
		"author": [
		  {
			"family": "Sun",
			"given": "Y. F."
		  },
		  {
			"family": "Costa-Rezende",
			"given": "D. H."
		  },
		  {
			"family": "Xing",
			"given": "J. H."
		  },
		  {
			"family": "Zhou",
			"given": "J. L."
		  },
		  {
			"family": "Zhang",
			"given": "B."
		  },
		  {
			"family": "Gibertoni",
			"given": "T. B."
		  },
		  {
			"family": "Gates",
			"given": "G."
		  },
		  {
			"family": "Glen",
			"given": "M."
		  },
		  {
			"family": "Dai",
			"given": "Y. C."
		  },
		  {
			"family": "Cui",
			"given": "B. K."
		  }
		],
		"title": "Multi-gene phylogeny and taxonomy of Amauroderma s.lat. (Ganodermataceae)",
		"container-title": "Persoonia",
		"volume": "44",
		"page": "206-239",
		"issued": {
		  "date-parts": [
			[
			  2020
			]
		  ]
		},
		"DOI": "10.3767/persoonia.2020.44.08",
		"URL": "https://doi.org/10.3767/persoonia.2020.44.08"
	  }';
  
	  $json3 = '{
		"type": "article-journal",
		"author": [
		  {
			"family": "Sun",
			"given": "Y. F."
		  },
		  {
			"family": "Costa-Rezende",
			"given": "D. H."
		  },
		  {
			"family": "Xing",
			"given": "J. H."
		  },
		  {
			"family": "Zhou",
			"given": "J. L."
		  },
		  {
			"family": "Zhang",
			"given": "B."
		  },
		  {
			"family": "Gibertoni",
			"given": "T. B."
		  },
		  {
			"family": "Gates",
			"given": "G."
		  },
		  {
			"family": "Glen",
			"given": "M."
		  },
		  {
			"family": "Dai",
			"given": "Y. C."
		  },
		  {
			"family": "Cui",
			"given": "B. K."
		  }
		],
		"title": "Multi-gene phylogeny and taxonomy of Amauroderma s.lat. (Ganodermataceae)",
		"container-title": "Persoonia",
		"volume": "44",
		"page": "206-239",
		"issued": {
		  "date-parts": [
			[
			  2020
			]
		  ]
		},
		"DOI": "10.3767/persoonia.2020.44.08"
	  }';
}

/*
$obj1 = json_decode($json1);
$obj2 = json_decode($json2);
$obj3 = json_decode($json3);

print_r($obj1);
print_r($obj2);
print_r($obj3);

$objs = array();

$objs[] = $obj1;
$objs[] = $obj2;
$objs[] = $obj3;
*/

$json = '[
  {
    "type": "article-journal",
    "author": [
      {
        "family": "Pridgeon",
        "given": "A."
      }
    ],
    "title": "A phylogenetic reclassification of Pleurothallidinae (Orchidaceae)",
    "container-title": "Lindleyana",
    "volume": "16",
    "page": "235-271",
    "issued": {
      "date-parts": [
        [
          2001
        ]
      ]
    }
  },
  {
    "type": "article-journal",
    "author": [
      {
        "family": "Pridgeon",
        "given": "A. M."
      },
      {
        "family": "Chase",
        "given": "M. W."
      }
    ],
    "title": "A phylogenetic reclassification of Pleurothallidinae (Orchidaceae)",
    "container-title": "Lindleyana",
    "volume": "16",
    "page": "235-271",
    "issued": {
      "date-parts": [
        [
          2001
        ]
      ]
    }
  },
  {
    "type": "article-journal",
    "author": [
      {
        "family": "Pridgeon",
        "given": "A. M."
      },
      {
        "family": "Chase",
        "given": "M. W."
      }
    ],
    "title": "A phylogenetic reclassification of Pleurothallidinae (Orchidaceae)",
    "container-title": "Lindleyana",
    "volume": "16",
    "page": "235-271",
    "issued": {
      "date-parts": [
        [
          2001
        ]
      ]
    }
  }
]';

$objs = json_decode($json);


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



$keys = array('author', 'title', 'container-title', 'volume', 'issue', 'page', 
	'issued','DOI');

$unique_values = array();
$values = array();


$confidence = array(0.9, 0.8, 0.7);
$confidence = array(0.9, 0.9, 0.9);

//$confidence = array(0.9, 0.9);

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


echo "Unique values\n";
print_r($unique_values);

echo "Values\n";
print_r($values);

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

// print_r($vectors);

echo "Vectors\n\n";
foreach ($vectors as $k => $v)
{
	echo str_pad($k, 20, ' ', STR_PAD_LEFT) . ' ' . json_encode($v) . "\n";
}
echo "\n\n";


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
		
		echo str_pad($k, 20, ' ', STR_PAD_LEFT)  . ' ' . json_encode($belief) . "\n";
		
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
 		
 		echo str_pad($k, 20, ' ', STR_PAD_LEFT)  . ' ' . $best_value . "\n";
 		
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

//----------------------------------------------------------------------------------------

print_r($consensus);

echo json_encode(array($consensus)) . "\n";



?>
