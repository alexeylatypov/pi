<?php
class ChildThread extends Thread {
    public $data;
	public $id;

    public function run() {
      /* Do some work */

      $this->data = microtime(true);
	  $this->id = $this->getCurrentThreadId();
	  
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
	var_dump($thread);
    // we can now even access $thread->data
}
if ($thread1->start()) {
    /*
     * Do some work here, while already doing other
     * work in the child thread.
     */

    // wait until thread is finished
    $thread1->join();
	var_dump($thread1);
    // we can now even access $thread->data
}

?>