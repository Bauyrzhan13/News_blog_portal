<?php
include "../../config/db.php";

$id = $_GET["id"];

mysqli_query($con, "DELETE FROM blogs WHERE id = $id");
echo json_encode(true);
