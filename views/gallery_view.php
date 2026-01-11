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
            <?php if (!isset($img['private']) && !$img['private']): ?>
                <div class="photo-item">
                    <a href="/static/images/<?= $img['name'] ?>" target="_blank">
                        <img src="/static/images/mini_<?= $img['name'] ?>" alt="<?= htmlspecialchars($img['title']) ?>">
                    </a>
                    <p><strong><?= htmlspecialchars($img['title']) ?></strong></p>
                    <p>Autor: <?= htmlspecialchars($img['author']) ?></p>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Brak zdjęć w galerii.</p>
    <?php endif; ?>
</div>

<div class="paging">
    <?php if (isset($page) && $page > 1): ?>
        <a href="/gallery?page=<?= $page - 1 ?>">&laquo; Poprzednia</a>
    <?php endif; ?>

    <span>Strona <?= $page ?? 1 ?></span>

    <a href="/gallery?page=<?= ($page ?? 1) + 1 ?>">Następna &raquo;</a>
</div>

</body>
</html>