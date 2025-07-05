let profile = document.querySelector('.header .flex .profile-detail');
document.querySelector('#user-btn').onclick = () => {
  profile.classList.toggle('active');
  searchForm.classList.remove('active');
}

let searchForm = document.querySelector('.header .flex .search-form');
document.querySelector('#user-btn').onclick = () => {
  searchForm.classList.toggle('active');
  profile.classList.remove('active');
}

let navbar = document.querySelector('.navbar');
document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
}

