# Deduplicate bibliographic data

Deduplicating bibliographic and related data, focussing on CSL-JSON files.

## CSL-JSON

Input data to be matched is an array of 2-3 elements. The first two are bibliographic records (e.g., articles) in CSL-JSON . The optional third element is an integer flagging whether the two records are a match (1) or not (0). The array is stored as JSON in a file with one JSON record per row (JSONL).

A program to train a method or model would read pairs of CSL-JSON records and match flag. 

A program to merge duplicate records would read pairs of CSL-JSON records, decide whether they matched, and output a clustering.





