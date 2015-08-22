<?php
function __autoload($class_name) {
  if (file_exists('classes/'.$class_name . '.class')) { 
  require_once 'classes/'.$class_name . '.class';
          return true; 
      } 
      return false; 
}

$phpscrit='<?php phpinfo(); ?>';
$cmd = Command::factory('php');
$cmd->setCallback(function($pipe, $data){
        if ($pipe === Command::STDOUT) echo 'STDOUT: ';
        if ($pipe === Command::STDERR) echo 'STDERR: ';
        echo $data === NULL ? "EOF\n" : "$data\n";
        // If we return "false" all pipes will be closed
        // return false;
    })
    ->setDirectory('/tmp')
    ->option('$phpscrit')
	->argument()
    ->run();
if ($cmd->getExitCode() === 0) {
    echo $cmd->getStdOut();
} else {
    echo $cmd->getStdErr();
}
?>