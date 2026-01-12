//Hamburgermenu

document.getElementById('mainnav').addEventListener('click', (e) => {
  document.getElementById('mainnav').classList.toggle('active')

});

//add active class 
//Makieren, auf welcher Seite sich User befindet 
const navLinkEls = document.querySelectorAll('.nav-item');
const windowPathname = window.location.pathname;

navLinkEls.forEach(navLinkEl => {
  const navLinkPathname = new URL(navLinkEl.href).pathname;

  if ((windowPathname == navLinkPathname) || (windowPathname === '/index.html' && navLinkPathname === '/')) {
    navLinkEl.classList.add('active-nav');
  }
});

//Header -> Shrink on Scroll
const mediaQuery = window.matchMedia('(min-width: 600px)')

window.onscroll = function () { scrollFunction() };

function scrollFunction() {
  if (mediaQuery.matches && (document.body.scrollTop > 35 || document.documentElement.scrollTop > 35)) {
    document.getElementById("header").style.paddingTop = "7px";

    document.querySelector(".top-right").style.fontSize = "12px"
    document.querySelector(".top-right").style.gap = "5px"

    document.getElementById("reservieren-link").style.fontSize = "11px";
    document.getElementById("reservieren-link").style.padding = "4px 15px";
    document.getElementById("reservieren-link").style.fontWeight = "normal";

    document.querySelector(".logo").style.margin = "0 auto 0px";
    document.querySelector(".logo").style.height = "80px";

    document.getElementById("logo-img").style.height = "140%";

    document.getElementById("nav").style.gap = "5px";

    document.getElementById("home-nav").style.padding = "5px 15px";
    document.getElementById("menu-nav").style.padding = "5px 15px";
    document.getElementById("events-nav").style.padding = "5px 15px";
    document.getElementById("about-nav").style.padding = "5px 15px";
    document.getElementById("contact-nav").style.padding = "5px 15px";
    document.getElementById("guest-nav").style.padding = "5px 15px";

    document.getElementById("home-nav").style.fontSize = "12px";
    document.getElementById("menu-nav").style.fontSize = "12px";
    document.getElementById("events-nav").style.fontSize = "12px";
    document.getElementById("about-nav").style.fontSize = "12px";
    document.getElementById("contact-nav").style.fontSize = "12px";
    document.getElementById("guest-nav").style.fontSize = "12px";

    document.getElementById("home-nav").style.fontWeight = "normal";
    document.getElementById("menu-nav").style.fontWeight = "normal";
    document.getElementById("events-nav").style.fontWeight = "normal";
    document.getElementById("about-nav").style.fontWeight = "normal";
    document.getElementById("contact-nav").style.fontWeight = "normal";
    document.getElementById("guest-nav").style.fontWeight = "normal";

  } else if (mediaQuery.matches) {
    document.getElementById("header").style.paddingTop = "15px";

    document.querySelector(".top-right").style.fontSize = "14px"
    document.querySelector(".top-right").style.gap = "10px"

    document.getElementById("reservieren-link").style.fontSize = "14px";
    document.getElementById("reservieren-link").style.padding = "6px 25px";
    document.getElementById("reservieren-link").style.fontWeight = "600";

    document.querySelector(".logo").style.margin = "0 auto 10px";
    document.querySelector(".logo").style.height = "130px";

    document.getElementById("logo-img").style.height = "100%";

    document.getElementById("nav").style.gap = "10px";

    document.getElementById("home-nav").style.padding = "12px 15px";
    document.getElementById("menu-nav").style.padding = "12px 15px";
    document.getElementById("events-nav").style.padding = "12px 15px";
    document.getElementById("about-nav").style.padding = "12px 15px";
    document.getElementById("contact-nav").style.padding = "12px 15px";
    document.getElementById("guest-nav").style.padding = "12px 15px";

    document.getElementById("home-nav").style.fontSize = "14px";
    document.getElementById("menu-nav").style.fontSize = "14px";
    document.getElementById("events-nav").style.fontSize = "14px";
    document.getElementById("about-nav").style.fontSize = "14px";
    document.getElementById("contact-nav").style.fontSize = "14px";
    document.getElementById("guest-nav").style.fontSize = "14px";

    document.getElementById("home-nav").style.fontWeight = "bold";
    document.getElementById("menu-nav").style.fontWeight = "bold";
    document.getElementById("events-nav").style.fontWeight = "bold";
    document.getElementById("about-nav").style.fontWeight = "bold";
    document.getElementById("contact-nav").style.fontWeight = "bold";
    document.getElementById("guest-nav").style.fontWeight = "bold";

  }
};