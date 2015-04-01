<?php
// script to open a config file and read keyvalue pairs out of it
// takes one argument, the file to be opened
// file can contain arbitrary pairs, returns them as list
// pairs are split by a single space
// neither keys nor values can contain spaces

function readConfig($fileName)
{
	// open config file
	$confFile = fopen($fileName, 'r') or die('unable to read configuration file');

	$directives = [];

	// so long as there are lines to read
	while(($line = fgets($confFile)) !== false)
	{
		// split the line into key, value
		$lineSplit = explode(' ', $line);

		$key = $lineSplit[0];
		$value = $lineSplit[1];
		// put the keyvalue pair in a list 
		$directives[$key] = $value;
		
		// diagnostics
		//echo $key;
		//echo $directives[$key];
	};
	//cleanup
	fclose($confFile);

	return $directives;
}
?>
