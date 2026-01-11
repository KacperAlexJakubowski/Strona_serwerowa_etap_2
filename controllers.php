<?php
// funkcje obsługujące żądania

require_once 'business.php';

function index(&$model)
{
    try {
        $db = get_db();
        $db->listCollections();

        $model['db_message'] = "Połączenie z MongoDB udane!";
    } catch (Exception $e) {
        $model['db_message'] = "Połączenie z MongoDB nieudane. Kod błędu: " . $e->getMessage();
    }
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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Logika rejestracji
        $result = register_user($_POST, $model);
        if ($result) {
            return 'redirect:/login';
        }
        $model['error'] = "Błąd rejestracji: " . ($model['error_message'] ?? '');
    }

    return 'register_view';
}

function login(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = login_user($_POST['login'], $_POST['password']);
        if ($result) {
            return 'redirect:/';
        }
        $model['error'] = 'Błędny login lub hasło.';
    }

    return 'login_view';
}

function logout(&$model)
{
    logout_user();
    return 'redirect:/';
}
