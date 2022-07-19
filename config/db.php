<?php
// чтобы бэк выявил ошибку, мы пишем эти ниже 3 строчки
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$con = mysqli_connect("localhost", "root", "", "project_web132"); //если мак то напишем "root"

if (mysqli_connect_errno()) { //если есть ошибка при подкл к базе данных
    echo "Failed to connect to MySQL " . mysqli_connect_error();
    exit(); //остановливаем
}
