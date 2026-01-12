<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="/static/style.css">
</head>
<body>
<?php include 'menu_view.php'; ?>

<h1>Rejestracja</h1>

<?php if (isset($error)): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<form action="/register" method="post" enctype="multipart/form-data">
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" placeholder="Wprowadź E-mail" minlength="6" required>

    <label for="login">Login:</label>
    <input type="text" id="login" name="login" placeholder="Wprowadź login" pattern="^[a-zA-Z0-9_]{3,15}$"
           title="Login musi mieć od 3 do 15 znaków i nie może zawierać znaków specjalnych (poza podkreśleniem)."
           required>

    <label for="password">Hasło:</label>
    <input type="password" id="password" name="password" placeholder="Wprowadź silne hasło"
           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
           title="Hasło musi zawierać co najmniej jedną cyfrę, jedną wielką i jedną małą literę oraz składać się z przynajmniej 8 znaków"
           required>

    <label for="repassword">Powtórz hasło:</label>
    <input type="password" id="repassword" name="repassword" placeholder="Powtórz hasło" required>

    <label>Zdjęcie profilowe (JPG/PNG):</label>
    <input type="file" name="profile_photo" required>

    <br><br>
    <button type="submit">Zarejestruj się</button>
</form>
</body>
</html>