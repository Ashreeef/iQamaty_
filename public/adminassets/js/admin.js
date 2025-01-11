const sidebarLinks = document.querySelectorAll(".sidebar ul li a");

const currentPage = window.location.pathname;

sidebarLinks.forEach((link) => {
  const linkHref = link.getAttribute("href");

  if (currentPage === linkHref) {
    link.classList.add("active");
  } else {
    link.classList.remove("active");
  }

  link.addEventListener("click", () => {
    sidebarLinks.forEach((link) => {
      link.classList.remove("active");
    });
    link.classList.add("active");
  });
});
