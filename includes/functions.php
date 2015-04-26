<?php

function getItemsFromCSV()
{
	ini_set('auto_detect_line_endings', true);
	
	$filename 	= 'includes/data/items.csv';
	$delimiter	= ',';
	
	if(!file_exists($filename) || !is_readable($filename))
		return FALSE;
	
	$content = file_get_contents($filename);

	$header 	= NULL;
	$data 		= array();

	if(($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else
				$data[] = array_combine($header, $row);
		}
		fclose($handle);
	}

	return $data;
}