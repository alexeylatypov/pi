<?php
error_reporting(E_ALL);
<?php
class AsyncOperation extends Thread {
  public function __construct($arg){
    $this->arg = $arg;
  }

  public function run(){
    if($this->arg){
      printf("Hello %s\n", $this->arg);
    }
  }
}
$thread = new AsyncOperation("World");
if($thread->start())
  $thread->join();
?>
phpinfo();

?>