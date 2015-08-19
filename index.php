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
		$x=rand(1,999999999)/1000000000*2-1;
		$y=rand(1,999999999)/1000000000*2-1;
		//var_dump($x+''+$y);
		if((pow($x,2)+pow($y,2))<=1) {
			$np++;
		}
	}
	$pi = 4 * $np / $n;
    return $pi;
};


/* make call in background thread */
$argv = [1000000];


// Initialize and start the threads
foreach (range(0, 10) as $i) {
    $workers[$i] = new ParallelThread($closure, $argv );
	$workers[$i]->start();
}
 
// Let the threads come back
foreach (range(0, 10) as $i) {
    $workers[$i]->join();
	var_dump($workers[$i]->getResult());
}


?>