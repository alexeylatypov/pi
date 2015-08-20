<?php
class data extends Stackable{
    //private $name;
    public function __construct($_name) {
        //$this->name = $_name;//if you set any variable, workers will get the variable, so do not set any variable
        echo __FILE__.'-'.__LINE__.'<br/>'.chr(10);
    }
    public function run(){
        echo __FILE__.'-'.__LINE__.'<br/>'.chr(10);
    }
}
class readWorker extends Worker {
    public function __construct(&$_data) {
        $this->data = $_data;//
    }
    public function run(){
        while(1){
            if($arr=$this->data->shift())//receiving datas
            {
                echo 'Received data:'.print_r($arr,1).chr(10);
            }else usleep(50000);
        }
    }
}
class writeWorker extends Worker {
    public function __construct(&$_data) {
        $this->data = $_data;//
    }
    public function run(){
        while(1){
            $this->data[] = array(time(),rand());//writting datas
            usleep(rand(50000, 1000000));
        }
    }

}
$data = new data('');
$reader = new readWorker($data);
$writer = new writeWorker($data);
$reader->start();
$writer->start();
?>