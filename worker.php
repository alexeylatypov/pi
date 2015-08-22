<?php

function work() {
	$time_start = microtime(true);
    $np=0;
				for ($i=0; $i<=rand(0,1000); $i++){
					$x=lcg_value()*2-1;
					$y=lcg_value()*2-1;
		
					if(($x**2+$y**2)<=1) {
						$np++;
					}
				}

    return json_encode(array( 'duration' => microtime(true)-$time_start, 'results' => $np, 'start_time' => $this->time_start));
}

$dispatcher = new Amp\Thread\Dispatcher;

// call 2 functions to be executed asynchronously
$promise1 = $dispatcher->call('work');
$promise2 = $dispatcher->call('work');
$promise2 = $dispatcher->call('work');
$promise2 = $dispatcher->call('work');

$comboPromise = Amp\all([$promise1, $promise2, $promise3, $promise4]);
list($result1, $result2) = $comboPromise->wait();
?>