<?php
include "config/baseurl.php";
include "config/db.php";
session_start();
?>
<header class="header container">
    <div class="header-logo">
        <!-- link to home page -->
        <a href="<?= $BASE_URL ?>/">News Blog</a>
    </div>
    <form class="header-search" action="<?= $BASE_URL ?>/" method="GET">
        <input type="text" class="input-search" placeholder="Поиск по блогам" name="search">
        <button class="button button-search">
            <img src="images/search.svg" alt="">
            Найти
        </button>
    </form>
    <div>
        <?php
        if (isset($_SESSION["nickname"])) {
        ?>
            <script>
                localStorage.setItem('nickname', '<?= $_SESSION["nickname"] ?>'); //setItem добавляет какие-то данные в наши временное хранилище 1ое знач-ключ, 2ое знач-что будет хранить
                localStorage.setItem('user_id', '<?= $_SESSION["id"] ?>');
            </script>
            <a href="<?= $BASE_URL ?>/profile.php?nickname=<?= $_SESSION["nickname"] ?>">
                <img class="avatar" src="images/avatar.png" alt="Avatar">
            </a>
        <?php
        } else {
        ?>
            <script>
                localStorage.removeItem('nickname'); //если в сессии никого нету то тогда удаляет пользователя
                localStorage.removeItem('user_id');
            </script>
            <div class="button-group">
                <a href="<?= $BASE_URL ?>/register.php" class="button">Регистрация</a>
                <a href="<?= $BASE_URL ?>/login.php" class="button">Вход</a>
            </div>
        <?php } ?>
    </div>

</header>