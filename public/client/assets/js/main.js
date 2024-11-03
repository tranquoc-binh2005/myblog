function menuBar() {
    let btnMenu = document.getElementById('menubar');
    let dialogMenu = document.getElementById('dialogMenu');

    btnMenu.addEventListener('click', () => {
        dialogMenu.showModal();
    });
}
menuBar()


const toggleDropdown = () => {
    const dropdownItems = document.querySelector('.dropdown-content');
    dropdownItems.classList.toggle('show'); 
};

document.getElementById('serviceMenu').addEventListener('click', (event) => {
    event.stopPropagation();
    toggleDropdown();
});

document.addEventListener('click', (event) => {
    const dropdownItems = document.querySelector('.dropdown-content');
    if (dropdownItems.classList.contains('show')) {
      dropdownItems.classList.remove('show');
    }
});


window.addEventListener("scroll", function() {
    const header = document.querySelector("header");
    if (window.scrollY > window.innerHeight / 2) { // 50vh
      header.classList.add("fixed");
    } else {
      header.classList.remove("fixed");
    }
  });

  
  const backToTopButton = document.getElementById("backToTop");

// Hiện nút khi cuộn xuống
window.onscroll = function() {
  if (window.scrollY > window.innerHeight / 2) { // Hiện nút khi cuộn quá 50vh
    backToTopButton.style.display = "block";
  } else {
    backToTopButton.style.display = "none";
  }
};

// Khi nhấp vào nút, cuộn về đầu trang
backToTopButton.onclick = function() {
  window.scrollTo({ top: 0, behavior: "smooth" });
};

  