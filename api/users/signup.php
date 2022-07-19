<?php
include "../../config/db.php"; // чтобы использовать BASE_URL или DB нам нужно подключить базу данных
include "../../config/baseurl.php";
if ( //здесь проверим все ли данные пришли
    isset($_POST["email"]) && strlen($_POST["email"]) > 0 && //isset проверит пришел ли данные методом POST
    isset($_POST["full_name"]) && strlen($_POST["full_name"]) > 0 && //srtlen длина чтобы была больше 0
    isset($_POST["nickname"]) && strlen($_POST["nickname"]) > 0 &&
    isset($_POST["password"]) && strlen($_POST["password"]) > 0 &&
    isset($_POST["password2"]) && strlen($_POST["password2"]) > 0
) { // если все данные пришли, мы все это сохраняем в переменную
    $email = $_POST["email"];
    $full_name = $_POST["full_name"];
    $nickname = $_POST["nickname"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];

    if ($password !== $password2) { //пароли совпадают ли
        header("Location:$BASE_URL/register.php?error=2"); //если нет, вывести error2
        exit();
    }
    $check_user = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check_user) == 1) { //проверяем такой пользователь зарегистрирован ли
        header("Location:$BASE_URL/register.php?error = 3"); //если есть то он не может заново зарегистрироваться
        exit();
    }

    // хэширование пароля
    $hash = sha1($password);
    mysqli_query($con, "INSERT INTO users (email , full_name , nickname , password) VALUES ('$email' , '$full_name' , '$nickname' , '$hash')");
    header("Location:$BASE_URL/login.php");
} else {
    header("Location:$BASE_URL/register.php?error=1");
    exit();
}
