!(function () {
    const e = document.querySelectorAll(".js-menu-btn");
    function t() {
        const e = this.getAttribute("aria-expanded"),
            t = this.querySelector(".js-faq-content"),
            c = t.scrollHeight;
        "false" == e ? (this.setAttribute("aria-expanded", "true"), (t.style.height = `${c}px`)) : (this.setAttribute("aria-expanded", "false"), (t.style.height = 0));
    }
    e &&
        e.forEach((e) => {
            e.addEventListener("click", () => {
                e.nextElementSibling.classList.toggle("active"), e.classList.toggle("active");
            });
        }),
        document.querySelectorAll(".js-faq-item").forEach((e) => e.addEventListener("click", t));
    const c = document.querySelector(".burger");
    c &&
        c.addEventListener("click", () => {
            document.querySelector(".js-menu").classList.toggle("active"), c.classList.toggle("active");
        });
    const n = document.querySelector(".js-copy");
    n &&
        n.addEventListener("click", () => {
            const e = document.querySelector(".js-copy-text").textContent;
            navigator.clipboard
                .writeText(e)
                .then(() => {
                    n.innerHTML = "Copied!";
                })
                .catch((e) => {
                    console.error("Failed to copy: ", e);
                });
        });
})();
