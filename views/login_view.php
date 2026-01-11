<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link rel="stylesheet" href="/static/style.css">
</head>
<body>
<?php include 'menu_view.php'; ?>

<h1>Zaloguj się</h1>

<?php if (isset($error)): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<form action="/login" method="post">
    <label>Login:</label>
    <input type="text" name="login" required>

    <label>Hasło:</label>
    <input type="password" name="password" required>

    <br><br>
    <button type="submit">Zaloguj</button>
</form>
</body>
</html>