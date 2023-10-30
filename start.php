<?php
require_once "vendor/autoload.php";
session_start();

$class = "Controllers\\" .(isset($_GET['c']) ? ucfirst($_GET['c']) . 'Controller' : 'IndexController');
$target = isset($_GET['t']) ? $_GET['t'] : "index";
$getParams = isset($_GET) ? $_GET : null;
$postParams = isset($_POST) ? $_POST : null;
//var_dump($class,$target);die;

$params = array(
    //$getParams,
    //$postParams,
    "https://195.154.118.169/mathea/site/",
    $getParams
);

if ($class == "Controllers\IndexController" && in_array($target, get_class_methods($class)))
{
    $class = new Controllers\IndexController;
    call_user_func_array([$class, $target], $params);
} else
{
    $class = new $class;
    call_user_func_array([$class, $target], $params);
}
