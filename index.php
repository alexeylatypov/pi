<?php

function __autoload($class_name) {
  if (file_exists('classes/'.$class_name . '.class')) { 
  require_once 'classes/'.$class_name . '.class';
          return true; 
      } 
      return false; 
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