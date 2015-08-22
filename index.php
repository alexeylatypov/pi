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
$threads = rand(5,10);
$interation = 100000000;

$closure = function($n) {
	$np=0;
				for ($i=0; $i<=$n; $i++){
					$x=lcg_value()*2-1;
					$y=lcg_value()*2-1;
		
					if(($x**2+$y**2)<=1) {
						$np++;
					}
				}
    return $np;
};


/* make call in background thread */
$argv = [$interation/$threads];

$time_start = microtime(true);
$np_result =0;
// Initialize and start the threads


$worker = new Worker();

$work = array();
$o=0;
while(++$o<$threads) {
	/* items stacked could be using resources available in worker */
	$work[]=new ParallelThread($closure, $argv);
}

foreach($work as $w)
	$worker->stack($w);


	$worker->start();



//$pi = 4 * $np_result / ($argv[0]*($threads));
//echo $np_result."<br>";
//echo $pi."<br>";
echo microtime(true) - $time_start;

$worker->shutdown();

?>