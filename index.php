<?php
require_once("classes/ParallelThread.class");
$test = ["Hello", "World"];
$closure = function($test) {
    return $test;
};
/* make call in background thread */
$future = ParallelThread::of($closure, [$test]);
/* get result of background and foreground call */
var_dump($future->getResult(), $closure($test));

?>