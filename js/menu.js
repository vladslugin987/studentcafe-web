document.getElementById("categoryDropdown").addEventListener("change", function () {
    const selected = this.value;
    const sections = document.querySelectorAll(".section-subtitle, .img-container");

    sections.forEach(sec => {
        const cat = sec.getAttribute("data-category");

        if (selected === "all" || selected === cat) {
            sec.style.display = "";
        } else {
            sec.style.display = "none";
        }
    });
});
