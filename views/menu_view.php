<nav>
    <a href="/">Strona Główna</a>
    <a href="/gallery">Galeria Zdjęć</a>
    <a href="/upload">Wyślij zdjęcie</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div style="float: right; display: flex; align-items: center; gap: 10px;">
            <?php if (isset($_SESSION['profile_photo'])): ?>
                <img src="/static/images/ProfilesPhoto/<?= htmlspecialchars($_SESSION['profile_photo']) ?>"
                     alt="Zdjęcie profilowe"
                     style="width: 40px; height: auto; border-radius: 50%;">
            <?php endif; ?>

            <span style="color: #aaa;">Witaj, <?= htmlspecialchars($_SESSION['user_login']) ?></span>
            <a href="/logout" style="color: #ff9999; margin-left: 10px;">Wyloguj</a>
        </div>
    <?php else: ?>
        <a href="/login" style="float: right;">Logowanie</a>
        <a href="/register" style="float: right;">Rejestracja</a>
    <?php endif; ?>
    <div style="clear: both;"></div>
</nav>
<hr>