# Deduplicate bibliographic data

Deduplicating bibliographic and related data, focussing on CSL-JSON files.

## CSL-JSON

Input data to be matched is an array of 2-3 elements. The first two are bibliographic records (e.g., articles) in CSL-JSON . The optional third element is an integer flagging whether the two records are a match (1) or not (0). The array is stored as JSON in a file with one JSON record per row (JSONL).

A program to train a method or model would read pairs of CSL-JSON records and match flag. 

A program to merge duplicate records would read pairs of CSL-JSON records, decide whether they matched, and output a clustering.

### CSL sources

#### BioStor
https://biostor.org/api.php?id=biostor-272360&format=citeproc

#### BioNames
http://bionames.org/api/api_citeproc.php?id=a96549adca38c2e1ee7adbd65ef6d20c&style=csljson

#### Wikidata
https://wikicite-search.herokuapp.com/api.php?id=Q96108337


## Workflow

- Input is a file of CSL-JSON pairs to be compared. Ways to get this file:
	- `php tsv-to-window.php` take a TSV file and generates pairs based on a fixed window size. Each pair is a JSON array, one array per line (i.e., `.jsonl` format).

- Take CSL-JSON pairs and compare them, outputting a graph showing the putative clusters: 
	- `php csl-compare.php <CSL-JSON pairs as arrays>`
	- output TGF file with clusters

- Take graph file (`.tgf`) and original CSL-JSON pairs and output arrays of CSL-JSON records in each cluster: 
	- `php merge.php <CSL-JSON pairs as arrays>` (will assume`.tgf` file exists)
	- output is set of files, one per cluster, each file is an array of one or more CSL-JSON records.

- Take one cluster of CSL-JSON records and compute a ”consensus” for the bibliographic item those records represent
	- `php merge_metadata.php <cluster id.json>`

- If storing data in a database can generate SQL to update clusters:
	- `php tgf_to_sql.php <.tgf file>

## Machine learning

A ML approach was explored using `features.php` based on ideas in Wilson. We take a pair of CSL-JSON records and use a binary vector to represent `match`, `non-match`, or `missing` states for fields in those records. This vector can be used in a single layer perception (see `train.php` for some initial attempts to understand the vectors). This approach would be a more sophisticated matching technique.

## Reading

Andrew McCallum, Kamal Nigam, and Lyle H. Ungar. 2000. Efficient clustering of high-dimensional data sets with application to reference matching. In Proceedings of the sixth ACM SIGKDD international conference on Knowledge discovery and data mining (KDD '00). Association for Computing Machinery, New York, NY, USA, 169–178. DOI:https://doi.org/10.1145/347090.347123

Wilson DR. 2011. Beyond probabilistic record linkage: Using neural networks and complex features to improve genealogical record linkage. In: The 2011 International Joint Conference on Neural Networks. 9–14. DOI: 10.1109/IJCNN.2011.6033192.






