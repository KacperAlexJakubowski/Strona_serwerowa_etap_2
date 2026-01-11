<?php
// funkcje obsługujące żądania

require_once 'business.php';

function index(&$model)
{
    return 'main_view';
}

function gallery(&$model)
{
//    $model['images'] = get_images(); // Funkcja z business.php
//    return 'gallery_view';
    return 'main_view';
}

function upload(&$model)
{
//    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//        // Logika uploadu
//        $result = upload_image($_FILES['file'], $_POST);
//        if ($result === 'OK') {
//            return 'redirect:/gallery';
//        } else {
//            $model['error'] = $result;
//        }
//    }
//    return 'upload_view';
    return 'main_view';
}

function register(&$model)
{
//    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//        // Logika rejestracji
//        if (register_user($_POST)) {
//            return 'redirect:/login';
//        }
//        $model['error'] = 'Błąd rejestracji';
//    }
//    return 'register_view';
    return 'main_view';
}

function login(&$model)
{
//    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//        if (login_user($_POST['login'], $_POST['password'])) {
//            return 'redirect:/';
//        }
//        $model['error'] = 'Błędny login lub hasło';
//    }
//    return 'login_view';
    return 'main_view';
}

function logout(&$model)
{
//    logout_user();
//    return 'redirect:/';
    return 'main_view';
}

