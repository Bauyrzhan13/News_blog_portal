<?php
include "../../config/db.php";
include "../../config/baseurl.php";
$nickname = $_GET["nickname"];

$get_blogs = mysqli_query($con, "SELECT b.*, c.name, u.nickname FROM blogs b INNER JOIN categories c
 ON b.category_id = c.id INNER JOIN users u ON b.user_id = u.id WHERE u.nickname='$nickname'");

$blogs = array();
if (mysqli_num_rows($get_blogs) > 0) {
    while ($row = mysqli_fetch_assoc($get_blogs)) {
        $blogs[] = $row;
    }
}
echo json_encode($blogs); //отправляем  $blogs