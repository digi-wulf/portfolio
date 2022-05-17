let navbarButton = document.querySelector("#navbar-button");
let responsiveNav = document.querySelector('.responsive-nav');

navbarButton.addEventListener('click', e => {
  responsiveNav.classList.toggle('responsive-nav-active')
});


var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) { slideIndex = 1 }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
  setTimeout(showSlides, 3400);
}


function increaseValue() {
  var value = parseInt(document.getElementById('adult').value, 10);
  value = isNaN(value) ? 0 : value;
  value++;
  document.getElementById('adult').value = value;
}
function decreaseValue() {
  var value = parseInt(document.getElementById('adult').value, 10);
  value = isNaN(value) ? 0 : value;
  value < 1 ? value = 1 : '';
  value--;
  document.getElementById('adult').value = value;
}

function increaseValue2() {
  var value = parseInt(document.getElementById('child').value, 10);
  value = isNaN(value) ? 0 : value;
  value++;
  document.getElementById('child').value = value;
}
function decreaseValue2() {
  var value = parseInt(document.getElementById('child').value, 10);
  value = isNaN(value) ? 0 : value;
  value < 1 ? value = 1 : '';
  value--;
  document.getElementById('child').value = value;
}

function increaseValue3() {
  var value = parseInt(document.getElementById('senior').value, 10);
  value = isNaN(value) ? 0 : value;
  value++;
  document.getElementById('senior').value = value;
}
function decreaseValue3() {
  var value = parseInt(document.getElementById('senior').value, 10);
  value = isNaN(value) ? 0 : value;
  value < 1 ? value = 1 : '';
  value--;
  document.getElementById('senior').value = value;
}