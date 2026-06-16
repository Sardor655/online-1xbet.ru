const links = document.querySelectorAll('a[href="#"]');
links.forEach(link => {
  link.href = "/go/";
  link.setAttribute('target', '_blank');
});