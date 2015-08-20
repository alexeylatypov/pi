<?php
$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin - канал, из которого дочерний процесс будет читать
   1 => array("pipe", "w"),  // stdout - канал, в который дочерний процесс будет записывать 
   2 => array("file", "/tmp/error-output.txt", "a") // stderr - файл для записи
);

$cwd = '/tmp';
$env = array('some_option' => 'aeiou');

$process = proc_open('php', $descriptorspec, $pipes, $cwd, $env);

if (is_resource($process)) {
    // $pipes теперь выглядит так:
    // 0 => записывающий обработчик, подключенный к дочернему stdin
    // 1 => читающий обработчик, подключенный к дочернему stdout
    // Вывод сообщений об ошибках будет добавляться в /tmp/error-output.txt

	$testscript = '<?php $np=0;
	for ($i=0; $i<=10; $i++){		$x=lcg_value()*2-1;		$y=lcg_value()*2-1;				if(($x**2+$y**2)<=1) { 			$np++; 		} 	} 	echo $np; 	?>';
    fwrite($pipes[0], $testscript);
    fclose($pipes[0]);

    echo stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    // Важно закрывать все каналы перед вызовом
    // proc_close во избежание мертвой блокировки
    $return_value = proc_close($process);

    echo "команда вернула $return_value\n";
}
?>