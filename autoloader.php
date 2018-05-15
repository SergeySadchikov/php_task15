<?php 
function myAutoload($className)
{
    $pathToFile = __DIR__ . '/classes/' . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    include "$pathToFile";
}
spl_autoload_register('myAutoload');
 ?>