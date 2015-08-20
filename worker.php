<?php
class ChildThread extends Thread {
    public $data;
	public $id;
	public $parent_id;
public $rnd;
    public function run() {
      /* Do some work */
	$this->rnd = rand (0,20);
	
    $this->data = microtime(true);
	$this->id = $this->getCurrentThreadId();
	$this->parent_id = $this->getCreatorId();
	
	sleep($this->rnd);
	  
    }
}

$thread = new ChildThread();
$thread1 = new ChildThread();

if ($thread->start()) {
    /*
     * Do some work here, while already doing other
     * work in the child thread.
     */
	
    // wait until thread is finished
    $thread->join();
	echo "Thread #1 (must be)";
	var_dump($thread);
	echo "<BR>";
    // we can now even access $thread->data
}
if ($thread1->start()) {
    /*
     * Do some work here, while already doing other
     * work in the child thread.
     */

    // wait until thread is finished
    $thread1->join();
	echo "Thread #2 (must be)";
	var_dump($thread1);
	echo "<BR>";
    // we can now even access $thread->data
}

?>