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
		$x=rand(1,999999999999)/1000000000000*2-1;
		$y=rand(1,999999999999)/1000000000000*2-1;
		//var_dump($x+''+$y);
		if((pow($x,2)+pow($y,2))<=1) {
			$np++;
		}
	}
	
    return $np;
};


/* make call in background thread */
$argv = [999999];

$time_start = microtime(true);
$np_result =0;
// Initialize and start the threads
foreach (range(0, 10) as $i) {
    $workers[$i] = new ParallelThread($closure, $argv );
	$workers[$i]->start();
}
 
// Let the threads come back
foreach (range(0, 10) as $i) {
    $workers[$i]->join();
	var_dump($workers[$i]->getResult());
	echo "<br>";
	$tmp_res = json_decode($workers[$i]->getResult(), true);
	$np_result = $np_result + $tmp_res['results'];
}
$pi = 4 * $np_result / 9999999;
echo $pi."<br>";
echo microtime(true) - $time_start;

?>