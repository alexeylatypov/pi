<?php

function __autoload($class_name) {
  if (file_exists('classes/'.$class_name . '.class')) { 
  require_once 'classes/'.$class_name . '.class';
          return true; 
      } 
      return false; 
}


/* 
* Get 'pi' by MonteCarlo method.
* $n parameters - iteration count (integer)
*
*
*/

$closure = function($n) {
	$np=0;
	for ($i=0; $i<=$n; $i++){
		$x=mt_rand(0,1)*2-1;
		$y=mt_rand(0,1)*2-1;
		if((pow($x,2)+pow($y,2))<=1) {
			$np++;
		}
	}
	$pi = 4 * $np / $n;
    return $pi;
};


/* make call in background thread */
$argv = [1000];
$getpi = ParallelThread::add($closure, $argv );
/* get result of background and foreground call */
var_dump($getpi->getResult());

?>