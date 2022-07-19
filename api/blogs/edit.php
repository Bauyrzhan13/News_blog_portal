<?php
include "../../config/db.php";
include "../../config/baseurl.php";
$blog_id = $_POST["blog_id"];

// сначала проверим пришли ли все поля заполненными, для этого делаем
//strlen возвращает длину элемента
//intval get the int value of variables
if (
    isset($_POST["title"], $_POST["description"], $_POST["category_id"], $_POST["blog_id"]) &&
    strlen($_POST["title"]) > 0 &&
    strlen($_POST["description"]) > 0 &&
    intval($_POST["category_id"]) &&
    intval($_POST["blog_id"])
) {
    $title = $_POST["title"];
    $desc = $_POST["description"];
    $categ_id = $_POST["category_id"];
    session_start();
    $user_id = $_SESSION["id"];
    //нужно проверить пришел ли какой-нибудь файл
    if (isset($_FILES["image"]) && strlen($_FILES["image"]["name"]) > 0) {
        $query = mysqli_query($con, "SELECT image FROM blogs where id = '$blog_id'"); //если к нам пришел какая-то картинка с нашей формочки
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $old_path = __DIR__ . "/../../" . $row["image"]; //старый путь к нашей картинке DIR-это место где мы сейчас находимся
            if (file_exists($old_path)) { //есть ли файл с такой директорий
                unlink($old_path); //меняет срарую на новую
            }
        }
        $ext = end(explode('.', $_FILES["image"]["name"]));
        $image_name = time() . '.' . $ext; //2124123.svg точку когнитивили for example
        move_uploaded_file($_FILES["image"]["tmp_name"], "../../images/blogs/$image_name");
        $path = "images/blogs/$image_name"; //это будет хранить к нашей картинке
        //для того чтобы записываться в бд
        $prep = mysqli_prepare($con, "UPDATE blogs SET title = ? , description = ? , category_id = ? , image = ? WHERE id = ?");
        mysqli_stmt_bind_param($prep, "ssiss", $title, $desc, $categ_id, $path, $blog_id); //ssiis типы данных string[0],str, int
        mysqli_stmt_execute($prep); //чтобы запрос выполнен
    } else {
        $prep = mysqli_prepare($con, "UPDATE blogs SET title = ?, description = ?, category_id = ? WHERE id = ?");
        mysqli_stmt_bind_param($prep, "ssii", $title, $desc, $categ_id, $blog_id);
        mysqli_stmt_execute($prep); //запрос обратно в бд будет сделан
    }
    //после отправки в бд мы делаем->
    $nickname = $_SESSION["nickname"];
    header("Location:$BASE_URL/profile.php?nickname=$nickname");
} else {
    header("Location:$BASE_URL/editblog.php?error=6&id=$blog_id");
}
