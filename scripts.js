/* 

////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
________  .__       .__           __      __      .__   _____ 
\______ \ |__| ____ |__|         /  \    /  \__ __|  |_/ ____\
 |    |  \|  |/ ___\|  |  ______ \   \/\/   /  |  \  |\   __\ 
 |    `   \  / /_/  >  | /_____/  \        /|  |  /  |_|  |   
/_______  /__\___  /|__|           \__/\  / |____/|____/__|   
        \/  /_____/                     \/                    

////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////

*/

function openSlideMenu() {
    document.getElementById('side-menu').style.width = '250px';
    document.getElementById('main').style.marginRight = '250px';
}
function closeSideMenu() {
    document.getElementById('side-menu').style.width = '0px';
    document.getElementById('main').style.marginRight = '0px';
}

// When the user scrolls down 20px from the top of the document, slide down the navbar
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("nav-bar").style.top = "0";
    document.getElementById("nav-bar").style.opacity = "100";
    document.getElementById("nav-bar").style.transition = ".5s";
  } else {
    document.getElementById("nav-bar").style.top = "-63px";
    document.getElementById("nav-bar").style.opacity = "0";
  }
}