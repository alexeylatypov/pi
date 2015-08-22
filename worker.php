<?php
function __autoload($class_name) {
  if (file_exists('classes/'.$class_name . '.class')) { 
  require_once 'classes/'.$class_name . '.class';
          return true; 
      } 
      return false; 
}

$phpscrit="
$n = 10;
$closure = function($n) {
	$np=0;
	for ($i=0; $i<=$n; $i++){
		$x=lcg_value()*2-1;
		$y=lcg_value()*2-1;
		//var_dump($x+''+$y);
		if(($x**2+$y**2)<=1) {
			$np++;
		}
	}
	
    return $np;
};
echo $closure;
";




$cmd = Command::factory('php');
$cmd->setCallback(function($pipe, $data){
        if ($pipe === Command::STDOUT) echo 'STDOUT: ';
        if ($pipe === Command::STDERR) echo 'STDERR: ';
        echo $data === NULL ? "EOF\n" : "$data\n";
        // If we return "false" all pipes will be closed
        // return false;
    })
    ->setDirectory('/tmp')
    ->option('-r')
	->argument($phpscrit)
    ->run();
if ($cmd->getExitCode() === 0) {
    echo $cmd->getStdOut();
} else {
    echo $cmd->getStdErr();
}
?>