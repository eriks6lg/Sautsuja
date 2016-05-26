<?php

session_start();

require('Controller.php');
require('Model.php');

$data = array();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['page'])) {
        global $data;

        if (!($_GET['page']== 'profile' || $_GET['page'] == 'register' || $_GET['page'] == 'contacts')) {
            $data = controller_page_load($_GET['page']);
        }
    } else {
        global $data;
        $data = controller_page_load('home');
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = false;

    switch($_POST['posttype']) {
        case 'sauts':
            $result = controller_sauts_add($_POST['sauts']);
            break;
        case 'register':
            if(!controller_user_add($_POST['username'], $_POST['password1'], $_POST['password2'])) {

                header('Location: Sautsuja.php?page=register&inuse=true');
            } else {
                $result = true;
            }
            break;
        case 'login':
            if (controller_user_check($_POST['username'], $_POST['password'])) {
                $_SESSION['user'] = $_POST['username'];
                $result=true;
            } else {
                header('Location: Sautsuja.php?wrongpass=true');
            }
            break;
        case 'logout':
            session_destroy();
            $result = session_start();
            break;
        case 'addpoint':
            if (model_points_increment($_POST['index'])) {
                if (controller_highestsauts_check(model_username_get($_POST['index']), $_POST['index'])) {
                    $result = true;
                };
                break;
            }
    }
    if ($result) {
        header('Location: '.$_SERVER['PHP_SELF']);
    } else {
        header('Content-type: text/plain; charset=utf-8');
        echo 'Päring ebaõnnestus';
    }
} else {
    global $data;
    $data = controller_page_load('home');
}
require('View.php');
