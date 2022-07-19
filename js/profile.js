//чтобы когда удаляли в базе появилось перерисовка, заново обновлялись
const urlParams = new URLSearchParams(window.location.search); //это возвращает нам ссылку http://localhost:8080/project_132/profile.php?nickname=asd
const nickname = urlParams.get("nickname"); //получаем инкнэйм юсера
const base_url = document.body.dataset.baseurl;
const blogsDiv = document.querySelector(".blogs"); //сохраняем временно блоги сюда
const currentUserId = localStorage.getItem("user_id");

function getBlogs() {
  axios
    .get(`${base_url}/api/blogs/list.php?nickname=${nickname}`)
    .then((res) => {
      //res это ответ с бэка
      showBlogs(res.data); //туда отправляем наш res.data
    });
}

function showBlogs(blogs) {
  let blogsHTML = ``;
  if (blogs.length == 0) blogsDiv.innerHTML = `<h1>0 blogs</h1>`;
  for (let i = 0; i < blogs.length; i++) {
    let dropdown = ``;
    if (currentUserId == blogs[i].user_id) {
      dropdown += `
        <span class="link">
            <img src="images/dots.svg" alt="">
                Еще

            <ul class="dropdown">
                <li> <a href=${base_url}/editblog.php?id=${blogs[i].id}">Редактировать</a> </li>
                <li><a href="" onclick = "deleteBlog(${blogs[i].id})" class="danger">Удалить</a></li>
            </ul>
        </span>
        `;
    }
    blogsHTML += `
    <div class="blog-item">
        <img class="blog-item--img" src="${blogs[i].image}" alt="">
        <div class="blog-header">
            <h3>${blogs[i].title}</h3>
            ${dropdown}
        </div>
        <p class="blog-desc">
            ${blogs[i].description}
        </p>
        <!-- чтобы в портале вышло имена категории типа моб разработка и тд -->
        <p class="blog_desc">
            ${blogs[i].name} 
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
                3
            </span>
            <a class="link">
                <img src="images/person.svg" alt="">
                ${blogs[i].nickname}  
            </a>
        </div>
    </div>
    `;
  }
  if (blogs.length > 0) blogsDiv.innerHTML = blogsHTML;
}
getBlogs();
function deleteBlog(id) {
  axios.get(`${base_url}/api/blogs/delete.php?id=${id}`).then(getBlogs());
}
