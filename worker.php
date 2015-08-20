<?php
class storage extends Threaded {
    public function run(){}
}

class my extends Thread {
    public function __construct($storage) {
        $this->storage = $storage; 
    }

    public function run(){
        $i = 0;
        while(++$i < 10) {
            $this->storage[]=rand(0,1000);
        }

        $this->synchronized(function($thread){
            $thread->notify();
        }, $this);
    } 
}

$storage = new storage();
$my = new my($storage);
$my->start();

$my->synchronized(function($thread){
    $thread->wait();
}, $my);

var_dump($storage);
?>