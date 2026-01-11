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
    <label for="login">Login:</label>
    <input type="text" id="login" name="login" placeholder="Wprowadź swój login" required>

    <label for="password">Hasło:</label>
    <input type="password" id="password" name="password" placeholder="Wprowadź swoje hasło" required>

    <br><br>
    <button type="submit">Zaloguj</button>
</form>
</body>
</html>