document.addEventListener("DOMContentLoaded", () => {

   // profile dropdown
   const toggle = document.getElementById("dropdown-toggle");
   const menu = document.getElementById("dropdown-menu");
   const links = menu.querySelectorAll(".dropdown-item");

   function show() {
      menu.classList.remove("hidden");
      menu.classList.add("block");
      toggle.setAttribute("aria-expanded", "true");
   }

   function hide() {
      menu.classList.add("hidden");
      menu.classList.remove("block");
      toggle.setAttribute("aria-expanded", "false");
   }

   toggle.addEventListener("click", (e) => {
      e.stopPropagation();
      const isExpanded = toggle.getAttribute("aria-expanded") === "true";
      isExpanded ? hide() : show();
   });

   // Close on Escape key (Essential for WCAG)
   document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
         hide();
         toggle.focus();
      }
   });

   // Close when clicking outside
   document.addEventListener("click", (e) => {
      if (!menu.contains(e.target) && e.target !== toggle) hide();
   });

   // Close when a link is clicked
   links.forEach(link => link.addEventListener("click", hide));
   // 

});
