<!DOCTYPE html>
<html lang="en">

<head>
    <title>Войти в систему</title>
    <?php include "views/head.php"; ?>
</head>

<body>
    <?php include "views/header.php"; ?>
    <section class="container page">
        <div class="auth-form">
            <h1>Вход</h1>
            <form class="form" action="api/users/signin.php" method="POST">
                <fieldset class="fieldset">
                    <input class="input" type="text" name="email" placeholder="Введите email">
                </fieldset>
                <fieldset class="fieldset">
                    <input class="input" type="password" name="password" placeholder="Введите пароль">
                </fieldset>

                <fieldset class="fieldset">
                    <button class="button" type="submit">Войти</button>
                </fieldset>
            </form>
            <?php
            if (isset($_GET["error"]) && $_GET["error"] == 3) {
            ?>
                <p style="color:red;">Заполните все поля</p>
            <?php
            } else if (isset($_GET["error"]) && $_GET["error"] == 4) {
            ?>
                <p style="color:red;">Неправильный логин или пароль</p>
            <?php } ?>
        </div>
    </section>
</body>

</html>