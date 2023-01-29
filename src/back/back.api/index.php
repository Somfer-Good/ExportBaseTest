<?php
header('Content-type: json/application');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers', 'origin, content-type, accept');
require 'Connect.php';
require 'Function.php';
$method = $_SERVER['REQUEST_METHOD'];

$id=$_GET['q'];

if ($method === 'GET') {
    GetComment($connect);

} elseif ($method === 'POST') {
    AddComment($connect, $_POST);

}elseif ($method==='DELETE'){
    if (isset($id)){
        DeleteComment($connect, $id);
    }
}


