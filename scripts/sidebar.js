"use strict";

function sidebarInteract() {
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
            sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    };
}

function addActiveMenu() {
    var menuItems = document.querySelectorAll(".menu-item");
    for (let i = 0; i < menuItems.length; i++) {
        var hrefValue = menuItems[i].getAttribute("href");
        if (location.pathname.includes(hrefValue)) {
            menuItems[i].classList.add("active-menu");
        }
    }
}

function init2() {
    sidebarInteract();
    addActiveMenu();
}

window.addEventListener("load", init2);