"use strict";

document.addEventListener("DOMContentLoaded", () => {
  const dropdown = document.getElementById("categoryDropdown");

  dropdown.addEventListener("change", function () {
    const selected = this.value;
    const sections = document.querySelectorAll("main section[data-category]");

    sections.forEach(section => {
      const cat = section.dataset.category;
      section.style.display = (selected === "all" || selected === cat) ? "" : "none";
    });
  });
});