<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wyślij zdjęcie</title>
    <link rel="stylesheet" href="/static/style.css">
</head>
<body>
<?php include 'menu_view.php'; ?>

<h1>Dodaj nowe zdjęcie</h1>

<?php if (isset($error)): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<form action="/upload" method="post" enctype="multipart/form-data">
    <label for="title">Tytuł zdjęcia:</label>
    <input type="text" id="title" name="title" placeholder="Wymyśl coś inspirującego" required>

    <label for="author">Autor:</label>
    <input type="text" id="author" name="author" value="<?= $_SESSION['user_login'] ?? '' ?>"
           placeholder="Wprowadź nazwę autora" <?= isset($_SESSION['user_id']) ? 'readonly' : '' ?> required>

    <?php if (isset($_SESSION['user_id'])): ?>
        <label>
            <input type="radio" name="access" value="public" checked> Publiczne
        </label>
        <label>
            <input type="radio" name="access" value="private"> Prywatne
        </label>
    <?php endif; ?>

    <label>Wybierz plik (JPG/PNG, max 1MB):</label>
    <input type="file" name="file" required>

    <br><br>
    <button type="submit">Wyślij plik</button>
</form>
</body>
</html>