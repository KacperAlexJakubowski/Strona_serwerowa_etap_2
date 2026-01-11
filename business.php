<?php

use MongoDB\Database;

function get_db(): Database
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b'
        ]
    );

    return $mongo->wai;
}

function register_user(array $form_data, array &$model): bool
{
    $email = $form_data['email'];
    $login = $form_data['login'];
    $password = $form_data['password'];
    $repassword = $form_data['repassword'];

    if (!empty($email) && !empty($login) && !empty($password) && !empty($repassword)) {
        $db = get_db();
        $query = ['login' => $login];
        $existing_user = $db->users->findOne($query);

        if (!$existing_user) {
            if ($password === $repassword) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $new_user = [
                    'email' => $email,
                    'login' => $login,
                    'hashed_password' => $hashed_password,
                ];

                $db->users->insertOne($new_user);

                return true;
            } else {
                $model['error_message'] = 'wprowadzone hasła się różnią';
            }
        } else {
            $model['error_message'] = 'użytkownik o takiej nazwie użytkownika już istnieje.';
        }

        return false;
    }

    $model['error_message'] = 'nie uzupełniono wszystkich pól formularza.';
    return false;
}

function login_user(string $login, string $password): bool
{
    if (!empty($login) && !empty($password)) {
        $db = get_db();
        $query = ['login' => $login];
        $user = $db->users->findOne($query);

        if ($user !== null && password_verify($password, $user['hashed_password'])) {
            session_regenerate_id();
            $_SESSION['user_id'] = $user['_id'];
            $_SESSION['user_login'] = $user['login'];
            return true;
        }
    }

    return false;
}

function logout_user()
{
    session_unset();
    session_destroy();
}