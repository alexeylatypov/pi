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
            $this->result = $newjob($this->val);
       });
  }
  
  protected $newjob;
  protected $time_start;
}

// At most 3 threads will work at once
$p = new Pool(3);

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
$p->collect(function($checkingTask){
  echo $checkingTask->result;
  return $checkingTask->result;
});

?>