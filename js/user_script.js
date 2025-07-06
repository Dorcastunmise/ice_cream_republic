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

//Testimonial
const btn = document.getElementsByClassName('btn1');
const slide = document.getElementById('slide');

for (let i = 0; i < btn.length; i++) {
  btn[i].onclick = function () {
    slide.style.transform = `translateX(-${800 * i}px)`;

    for (let j = 0; j < btn.length; j++) {
      btn[j].classList.remove('active');
    }

    this.classList.add('active');
  };
}



