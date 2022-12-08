<?php
require_once "method.php";
$user = new User();
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        // $motor->get_motors();
        if (!empty($_GET["id"])) {
            $id = $_GET["id"];
            $user->get_user($id);
        } else {
            $user->get_users();
        }
        break;
        // case 'POST':
        //     if (!empty($_GET["id"])) {
        //         $id = intval($_GET["id"]);
        //         $motor->update_motor($id);
        //     } else {
        //         $motor->insert_motor();
        //     }
        //     break;
        // case 'DELETE':
        //     $id = intval($_GET["id"]);
        //     $motor->delete_motor($id);
        //     break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
        break;
}
