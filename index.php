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
		$x=rand(1,99999999999999)/100000000000000*2-1;
		$y=rand(1,99999999999999)/100000000000000*2-1;
		//var_dump($x+''+$y);
		if((pow($x,2)+pow($y,2))<=1) {
			$np++;
		}
	}
	
    return $np;
};


/* make call in background thread */
$argv = [1000];

$time_start = microtime(true);
$np_result =0;
// Initialize and start the threads
foreach (range(0, 10) as $i) {
    $workers[$i] = ParallelThread::add($closure, $argv );
	//$workers[$i]->start();
	var_dump($workers[$i]->join());
}
 
/* Let the threads come back
foreach (range(0, 10) as $i) {
	echo "Thread #".$i." ";
	echo "<br>";
	$tmp_res = json_decode($workers[$i]->getResult(), true);
	$np_result = $np_result + $tmp_res['results'];
}
$pi = 4 * $np_result / ($argv[0]*11);
echo $np_result."<br>";
echo $pi."<br>";*/
echo microtime(true) - $time_start;

?>