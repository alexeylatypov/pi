<?php

function __autoload($class_name) {
  require_once 'classes/'.$class_name . '.php';
}


$test = ["Hello", "World"];
$closure = function($test) {
    return $test;
};
/* make call in background thread */
$future = ParallelThread::of($closure, [$test]);
/* get result of background and foreground call */
var_dump($future->getResult(), $closure($test));

?>