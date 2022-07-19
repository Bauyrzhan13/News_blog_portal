<?php
include "../../config/baseurl.php";
session_start(); //чтобы закончить сессшн нам нужно начать его
session_destroy();
header("Location:$BASE_URL/");
