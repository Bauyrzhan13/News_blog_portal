<?php
include "../../config/db.php";
include "../../config/baseurl.php";
if (
    isset($_POST["email"]) && strlen($_POST["email"]) > 0 &&
    isset($_POST["password"]) && strlen($_POST["password"]) > 0
) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $check_user = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'"); //взяли user с бд
    if (mysqli_num_rows($check_user) == 0) {
        header("Location:$BASE_URL/login.php?error=4 ");
        exit();
    }
    $hash = sha1($password); //чтобы сравнивать 2 пароля, мы должны захэшировать
    $user = mysqli_fetch_assoc($check_user);
    if ($hash != $user["password"]) {
        header("Location:$BASE_URL/login.php?error=5 ");
        exit();
    } //если паролья совпадают мы вернем ошибку а если все ок ->
    session_start(); // у нас есть параметр которые хранять какие-то данные это сессия или $coockie
    $_SESSION["nickname"] = $user["nickname"]; //узнаем через какого юсера сидит наш пользователь
    $_SESSION["id"] = $user["id"]; //например в сайте у нас есть users вот и можно эту сессию прервать или дальше использовать
    header("Location:$BASE_URL/profile.php?nickname");
} else {
    header("Location:$BASE_URL/login.php?error=3"); // если логин прав, пароль не прав выведит
    exit();
}
