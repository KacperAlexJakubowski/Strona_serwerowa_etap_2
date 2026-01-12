<?php

use MongoDB\Database;

const MIME_TYPES_TO_ASSERT = [
    'image/png',
    'image/jpeg',
];

const KB = 1024;
const MB = 1024 * KB;
const MAX_FILE_SIZE = 1 * MB;

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

function register_user(array $form_data, array &$model, array $file): bool
{
    $email = $form_data['email'];
    $login = $form_data['login'];
    $password = $form_data['password'];
    $repassword = $form_data['repassword'];

    if (!empty($email) && !empty($login) && !empty($password) && !empty($repassword) && !empty($file)) {
        $db = get_db();
        $query = ['login' => $login];
        $existing_user = $db->users->findOne($query);

        if (!$existing_user) {
            if ($password === $repassword) {
                if ($file['error'] === UPLOAD_ERR_OK) {
                    $file_errors = validate_file($file);
                    if (empty($file_errors)) {
                        $tmp_path = $file['tmp_name'];

                        $upload_dir = __DIR__ . "/web/static/images/ProfilesPhoto/";

                        $file_ext = (get_mime_type($tmp_path) === 'image/jpeg') ? 'jpg' : 'png';
                        $base_name = uniqid('img_') . '.' . $file_ext;

                        $target_path = $upload_dir . $base_name;

                        create_thumbnail($tmp_path, $file_ext, $target_path, 100, 100);
                    } else {
                        $model['error_message'] = implode("<br>", $file_errors);
                        return false;
                    }

                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $new_user = [
                        'email' => $email,
                        'login' => $login,
                        'hashed_password' => $hashed_password,
                        'profile_photo' => $base_name,
                    ];

                    $db->users->insertOne($new_user);


                    return true;
                } else {
                    $model['error_message'] = "wystąpił błąd w trakcie przesyłania pliku";
                }
            } else {
                $model['error_message'] = 'podane hasła różnią się';
            }
        }

        $model['error_message'] = 'użytkownik o takiej nazwie użytkownika już istnieje.';
        return false;
    }

    $model['error_message'] = 'nie uzupełniono wszystkich pól formularza.';
    return false;
}

function validate_file(array $file): array
{
    $errors = [];

    $tmp_path = $file['tmp_name'];

    if (!check_file_signature($tmp_path)) {
        $errors[] = 'Próbujesz wysłać zdjęcie w innym formacie niż dopuszczalny';
    }

    if ($file['size'] > MAX_FILE_SIZE) {
        $errors[] = 'Przesyłane pliki nie mogą przekraczać rozmiaru 1 MB';
    }

    return $errors;
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
            $_SESSION['profile_photo'] = $user['profile_photo'];

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

function upload_image(array $file, array $form_data, array &$model): bool
{
    $errors = [];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $tmp_path = $file['tmp_name'];

        if (!check_file_signature($tmp_path)) {
            $errors[] = 'Próbujesz wysłać zdjęcie w innym formacie niż dopuszczalny';
        }

        if ($file['size'] > MAX_FILE_SIZE) {
            $errors[] = 'Przesyłane pliki nie mogą przekraczać rozmiaru 1 MB';
        }

        $upload_dir = __DIR__ . "/web/static/images/upload/";
        $file_ext = (get_mime_type($tmp_path) === 'image/jpeg') ? 'jpg' : 'png';
        $base_name = uniqid('img_') . '.' . $file_ext;
        $target_path = $upload_dir . $base_name;

        if (empty($errors)) {
            if (move_uploaded_file($tmp_path, $target_path)) {
                $thumbnail_target_path = $upload_dir . '/thumbnails/mini_' . $base_name;
                create_thumbnail($target_path, $file_ext, $thumbnail_target_path, 200, 125);

                $db = get_db();
                $file_meta_data = [
                    'name' => $base_name,
                    'title' => $form_data['title'],
                    'author' => $form_data['author'],
                    'access' => $form_data['access'] ?? 'public',
                    'user_id' => (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : null,
                ];
                $db->images->insertOne($file_meta_data);

                return true;
            } else {
                $errors[] = "Nie udało się przenieść pliku (błąd serwera).";
            }
        }

        $model['error'] = implode("<br>", $errors);
        return false;
    }

    $model['error'] = "Wystąpił błąd w trakcie przesyłania pliku (kod błędu: " . $file['error'] . ")";
    return false;
}

function check_file_signature(string $tmp_path): bool
{
    $mime_type = get_mime_type($tmp_path);

    if (in_array($mime_type, MIME_TYPES_TO_ASSERT, true)) {
        return true;
    }

    return false;
}

function get_mime_type(string $tmp_path): string
{
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $tmp_path);
    finfo_close($finfo);

    return $mime_type;
}

function create_thumbnail(string $source_file_path, string $source_file_ext, string $target_path, int $new_width, int $new_height): bool
{
    switch ($source_file_ext) {
        case 'jpg':
            $source_img = imagecreatefromjpeg($source_file_path);
            break;
        case 'png':
            $source_img = imagecreatefrompng($source_file_path);
            break;
        default:
            return false;
    }

    if (!$source_img) return false;

    $source_width = imagesx($source_img);
    $source_height = imagesy($source_img);

    $dest_img = imagecreatetruecolor($new_width, $new_height);

    if ($source_file_ext === 'png') {
        imagealphablending($dest_img, false);
        imagesavealpha($dest_img, true);
    }

    imagecopyresampled(
        $dest_img, $source_img,
        0, 0, 0, 0,
        $new_width, $new_height,
        $source_width, $source_height
    );

    if ($source_file_ext === 'jpg') {
        imagejpeg($dest_img, $target_path, 90);
    } elseif ($source_file_ext === 'png') {
        imagepng($dest_img, $target_path);
    }

    imagedestroy($source_img);
    imagedestroy($dest_img);

    return true;
}

function get_images($page = 1)
{
    $db = get_db();
    $limit = 5;
    $skip = ($page - 1) * $limit;
    
    $images = $db->images->find(
        [],
        [
            'limit' => $limit,
            'skip' => $skip,
            'sort' => ['_id' => -1]
        ]
    );

    return $images->toArray();
}