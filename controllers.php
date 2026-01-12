<?php

require_once 'business.php';

function index(&$model)
{
    return 'main_view';
}

function gallery(&$model)
{
    $page = $_GET['page'] ?? 1;
    $model['page'] = (int)$page;
    $model['images'] = get_images($model['page']);
    return 'gallery_view';
}

function upload(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = upload_image($_FILES['file'], $_POST, $model);
        if ($result) {
            return 'redirect:/gallery';
        }
    }

    return 'upload_view';
}

function register(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = register_user($_POST, $model, $_FILES['profile_photo']);
        if ($result) {
            return 'redirect:/login';
        }
        $model['error'] = "Błąd rejestracji: " . ($model['error_message'] ?? '');
    }

    return 'register_view';
}

function login(&$model)
{
    if (isset($_SESSION['user_id'])) {
        return 'redirect:/';
    }

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
