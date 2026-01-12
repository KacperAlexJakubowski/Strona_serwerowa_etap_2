<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Galeria</title>
    <link rel="stylesheet" href="/static/style.css">
</head>
<body>
<?php include 'menu_view.php'; ?>

<h1>Galeria Zdjęć</h1>

<div class="gallery">
    <?php if (!empty($images)): ?>
        <?php foreach ($images as $img): ?>
            <?php
            $is_public = isset($img['access']) && $img['access'] === 'public';
            $is_owner = false;
            if (isset($_SESSION['user_id']) && isset($img['user_id'])) {
                if ((string)$_SESSION['user_id'] === (string)$img['user_id']) {
                    $is_owner = true;
                }
            }
            ?>

            <?php if ($is_public || $is_owner): ?>
                <div class="photo-item">
                    <a href="/static/images/upload/<?= htmlspecialchars($img['name']) ?>" target="_blank">
                        <img src="/static/images/upload/thumbnails/mini_<?= htmlspecialchars($img['name']) ?>"
                             alt="<?= htmlspecialchars($img['title']) ?>">
                    </a>

                    <p><strong><?= htmlspecialchars($img['title']) ?></strong></p>
                    <p>Autor: <?= htmlspecialchars($img['author']) ?></p>

                    <?php if (!$is_public): ?>
                        <p style="color: red; font-size: 0.9em; margin-top: 5px;">
                            (Prywatne - widoczne tylko dla Ciebie)
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
    <?php else: ?>
        <p>Brak zdjęć w galerii.</p>
    <?php endif; ?>
</div>

<div class="paging">
    <?php
    $current_page = isset($page) ? (int)$page : 1;
    ?>

    <?php if ($current_page > 1): ?>
        <a href="/gallery?page=<?= $current_page - 1 ?>">&laquo; Poprzednia</a>
    <?php endif; ?>

    <span style="margin: 0 10px;">Strona <?= $current_page ?></span>

    <a href="/gallery?page=<?= $current_page + 1 ?>">Następna &raquo;</a>
</div>

</body>
</html>