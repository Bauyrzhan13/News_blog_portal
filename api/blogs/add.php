<?php
include "../../config/db.php";
include "../../config/baseurl.php";

// сначала проверим пришли ли все поля заполненными, для этого делаем
//strlen возвращает длину элемента
//intval get the int value of variables
if (
    isset($_POST["title"], $_POST["description"], $_POST["category_id"]) &&
    strlen($_POST["title"]) > 0 &&
    strlen($_POST["description"]) > 0 &&
    intval($_POST["category_id"])
) {
    $title = $_POST["title"];
    $desc = $_POST["description"];
    $categ_id = $_POST["category_id"];
    session_start();
    $user_id = $_SESSION["id"];
    //нужно проверить пришел ли какой-нибудь файл
    if (isset($_FILES["image"]) && strlen($_FILES["image"]["name"]) > 0) {
        //let arr = str.split('.')
        //картинки переименуются, image.jpeg 
        //split - разделяет на массивы end() возмет последний элемент и затем берется расширение 
        $ext = end(explode('.', $_FILES["image"]["name"]));
        $image_name = time() . '.' . $ext; //2124123.svg точку когнитивили for example
        move_uploaded_file($_FILES["image"]["tmp-name"], "../../images/blogs/$image_name");
        $path = "images/blogs/$image_name"; //это будет хранить к нашей картинке
        //для того чтобы записываться в бд
        $prep = mysqli_prepare($con, "INSERT INTO blogs (title, description, category_id, user_id, image) VALUES(?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($prep, "ssiis", $title, $desc, $categ_id, $user_id, $path); //ssiis типы данных string[0],str, int
        mysqli_stmt_execute($prep); //чтобы запрос выполнен
    } else {
        $prep = mysqli_prepare($con, "INSERT INTO blogs (title, description, category_id, user_id) VALUES(?, ?, ?, ?)");
        mysqli_stmt_bind_param($prep, "ssii", $title, $desc, $categ_id, $user_id);
        mysqli_stmt_execute($prep); //запрос обратно в бд будет сделан
    }
    //после отправки в бд мы делаем->
    $nickname = $_SESSION["nickname"];
    header("Location:$BASE_URL/profile.php?nickname=$nickname");
} else {
    header("Location:$BASE_URL.newblog.php?error=5");
}
