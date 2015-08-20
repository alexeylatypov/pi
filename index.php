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
$threads = 10;
$interation = 100000;

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
$argv = [$interation];

$time_start = microtime(true);
$np_result =0;
// Initialize and start the threads

$my = new Worker();

foreach (range(0, $threads) as $i) {
    $workers[$i] = new ParallelThread($closure, $argv);
	$my->stack($workers[$i]);

}
 $my->start();
 
 $my->shutdown();
foreach (range(0, $threads) as $i) {
//	echo $workers[$i]->result."<BR>"; 
	$np_result = $np_result + $workers[$i]->result;
}


$pi = 4 * $np_result / ($argv[0]*($threads+1));
//echo $np_result."<br>";
echo $pi."<br>";
echo microtime(true) - $time_start;

?>