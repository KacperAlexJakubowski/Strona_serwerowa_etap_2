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

<form action="/register" method="post">
    <label>E-mail:</label>
    <input type="email" name="email" required>

    <label>Login:</label>
    <input type="text" name="login" required>

    <label>Hasło:</label>
    <input type="password" name="password" required>

    <label>Powtórz hasło:</label>
    <input type="password" name="repeat_password" required>

    <br><br>
    <button type="submit">Zarejestruj się</button>
</form>
</body>
</html>