<?php

class job extends Worker  {
  public $val;
  public $result;

  public function __construct(Closure $closure, $val){
    // init some properties
	$this->newjob = $closure;
    $this->val = $val;
	$this->time_start = microtime(true);
  }
  public function run(){
    // do some work
     $newjob = $this->newjob;
        $this->synchronized(function() use($newjob) {
            $this->result = json_encode(array( 'duration' => microtime(true)-$this->time_start, 'results' => $newjob($this->val)));
       });
  }
  
  protected $newjob;
  protected $time_start;
}

// At most 3 threads will work at once

$time_start = microtime(true);
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
$p = new Pool(3,job::class,[$closure,100]);


// shutdown will wait for current queue to be completed
$p->shutdown();
// garbage collection check / read results
$np_result=0;

$p->collect(function($checkingTask){
	echo $checkingTask->result."<BR>";
	$tmp_res = json_decode($checkingTask->result, true);
  return $checkingTask->result;
});
var_dump($p);
$pi = 4 * $np_result / (10*100);
echo "PI = ".$pi."<br>";
echo "Timer is ".microtime(true) - $time_start;


?>