<?php
include "config/db.php";
// здесь заранее приготовил какой-то запрос, но сохраню временно как текст
$sql = "SELECT b.*, u.nickname, c.name FROM blogs b INNER JOIN users u ON b.user_id=u.id
INNER JOIN categories c ON b.category_id=c.id";

$category = null;
if (isset($_GET["category"]) && intval($_GET["category"])) {
	$category = $_GET["category"];
	$sql .= " WHERE b.category_id=$category"; //это типа после текста добавлю этого через конгатинацию
	$get_categories = mysqli_query($con, "SELECT * FROM categories WHERE id = $category");
	$categ = mysqli_fetch_assoc($get_categories); //для определения точная тема блога когда нажмем на категории
}
$search = null;
if (isset($_GET["search"])) {
	$search = strtolower($_GET["search"]);
	//%% ищет везде вначале или в середине или в конце
	$sql .= " WHERE LOWER(b.title) LIKE '%$search%' OR LOWER(b.description) LIKE '%$search%' OR LOWER(u.nickname) LIKE '%$search%'";
}
$blogs = mysqli_query($con, $sql); //полноценный запрос для дальнейшего пэйдженэйшн
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Главная</title>
	<?php include "views/head.php"; ?>
</head>

<body>
	<?php include "views/header.php"; ?>
	<section class="container page">
		<div class="page-content">
			<?php
			if (isset($_GET["category"])) {
			?>
				<h2 class="page-title">Блоги по <?= $categ["name"] ?></h2>
			<?php } else { ?>
				<h2 class="page-title">Блоги по программированию</h2>
			<?php } ?>
			<p class="page-desc">Популярные и лучшие публикации по программированию для начинающих
				и профессиональных программистов и IT-специалистов.</p>

			<div class="blogs">
				<?php
				//использовали foreign key
				// $blogs = mysqli_query($con, "SELECT b.* , u.nickname , c.name FROM blogs b INNER JOIN users u ON b.user_id = u.id INNER JOIN categories c ON b.category_id = c.id ");
				if (mysqli_num_rows($blogs) > 0) {
					while ($blog = mysqli_fetch_assoc($blogs)) {
				?>
						<div class="blog-item">
							<img class="blog-item--img" src="<?= $blog["image"] ?>" alt="">
							<div class="blog-header">
								<h3> <?= $blog["title"] ?></h3>
							</div>
							<p class="blog-desc">
								<?= $blog["description"] ?>
							</p>
							<p class="blog-desc">
								<?= $blog["name"] ?>
							</p>


							<div class="blog-info">
								<span class="link">
									<img src="images/date.svg" alt="">
									22.12.21
								</span>
								<span class="link">
									<img src="images/visibility.svg" alt="">
									21
								</span>
								<a class="link">
									<img src="images/message.svg" alt="">
									4
								</a>
								<span class="link">
									<img src="images/forums.svg" alt="">
									23
								</span>
								<a class="link" href="<?= $BASE_URL ?>/profile.php?nickname<?= $blog["nickname"] ?>">
									<img src="images/person.svg" alt="">
									<?= $blog["nickname"] ?>
								</a>
							</div>
						</div>
					<?php
					}
				} else {
					?>
					<h3>0 blogs</h3>
				<?php } ?>
			</div>
		</div>
		<div class="page-info">
			<div class="page-header">
				<h2>Категории</h2>
			</div>
			<?php
			$categories = mysqli_query($con, "SELECT * FROM categories");
			if (mysqli_num_rows($categories) > 0) {
				while ($categ = mysqli_fetch_assoc($categories)) {
			?>
					<!-- при нажатии на категорий сверху выйдет типа category1, 2... -->
					<a class="list-item" href="<?= $BASE_URL ?>/?category=<?= $categ["id"] ?>"> <?= $categ["name"] ?> </a>
			<?php
				}
			}
			?>
		</div>
	</section>
</body>

</html>