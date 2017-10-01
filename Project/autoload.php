<?php
ini_set('post_max_size', '1000M');
ini_set('max_input_vars', '100000');
ini_set('max_execution_time', '1000');
ini_set('date.timezone', 'Asia/Dubai');
function class_loader($class) {
    require('../classes/' . $class . '.php');
}
spl_autoload_register('class_loader');
?>