<nav>
    <a href="/">Strona Główna</a>
    <a href="/gallery">Galeria Zdjęć</a>
    <a href="/upload">Wyślij zdjęcie</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <span style="color: #aaa; margin-left: 20px;">Witaj, <?= htmlspecialchars($_SESSION['login']) ?></span>
        <a href="/logout" style="float: right; color: #ff9999;">Wyloguj</a>
    <?php else: ?>
        <a href="/login" style="float: right;">Logowanie</a>
        <a href="/register" style="float: right;">Rejestracja</a>
    <?php endif; ?>
</nav>
<hr>