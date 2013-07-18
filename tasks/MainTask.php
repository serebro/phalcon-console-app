<?php

class MainTask extends \Phalcon\CLI\Task {

    public function mainAction() {
    	echo 'usage: console.php taskName/actionName param1=value1 param2=value2' . PHP_EOL;
    }

}