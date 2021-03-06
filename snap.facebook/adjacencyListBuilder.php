<?php

	if ($argc < 2) {
		echo "You must insert a dataset name\n";
		die();
	}

	for ($file=1; $file<$argc; $file++) {

		$DATASET = fopen(getcwd()."/".$argv[$file].".edges", "r") or die("bad dataset file selected");
		$TARGET = fopen(getcwd()."/".$argv[$file].".adjacency", "w+") or die("could not open new dataset");

		$MATRIX;
		$MAX_VALUE = 0;

		while (($line = fgets($DATASET)) !== false ) {
			$edge = explode(" ", $line);		
		
			$MATRIX[intval($edge[0])][intval($edge[1])] = 1;

			$MAX_VALUE = max($MAX_VALUE,intval($edge[0]),intval($edge[1]));
		}
		if (!feof($DATASET)) {
			echo "Error: unexpected fgets() fail\n";
			die();
		} else {
			fclose($DATASET);
		}

		for ($i=0; $i<=$MAX_VALUE; $i++) {
			$output = "";
			if ( (gettype($MATRIX[$i]) != "NULL") && (in_array(1, $MATRIX[$i])) ) {
				$output .= $i."@";
				for ($j=0; $j<=$MAX_VALUE; $j++) {
					if ( isset($MATRIX[$i][$j]) && ($MATRIX[$i][$j] == 1)) {			
						$output .= $j."#";
					}		
				}
			}
			if ($output != "") fwrite($TARGET, $output."\n");
		}
	
		fclose($TARGET);
	}
?>
