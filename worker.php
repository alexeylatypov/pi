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

?>