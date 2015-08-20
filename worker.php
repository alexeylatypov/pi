<?php

class job extends Collectable {
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
$p = new Pool(3);
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

$tasks = array(
	new job($closure,100),
	new job($closure,100),
	new job($closure,100),
	new job($closure,100),
	new job($closure,100),
	new job($closure,100),
	new job($closure,100),
	new job($closure,100),
	new job($closure,100),
	new job($closure,100),
);
// Add tasks to pool queue
foreach ($tasks as $task) {
  $p->submit($task);
}

// shutdown will wait for current queue to be completed
$p->shutdown();
// garbage collection check / read results

$p->collect($testnp = function($checkingTask){
	$np_result=0;
	echo $checkingTask->result."<BR>";
	$tmp_res = json_decode($checkingTask->result, true);
	$np_result = $np_result + $tmp_res['results'];
	echo $np_result."<BR>";

  return $checkingTask->result;
});
var_dump($testnp);

$pi = 4 * $p / (10*100);
echo "PI = ".$pi."<br>";
echo "Timer is ".microtime(true) - $time_start;


?>